<?php

namespace App\Http\Controllers\Petugas;

use App\Http\Controllers\Controller;
use App\Models\Peminjaman;
use App\Support\SimpleXlsx;
use Illuminate\Http\Request;

/**
 * Rekap barang: dipisah antara BARANG DIKEMBALIKAN dan BARANG RUSAK.
 * Bisa difilter (tanggal & jenis peminjam), diekspor ke Excel, dan dicetak.
 */
class RekapController extends Controller
{
    private const JUDUL = [
        'dikembalikan' => 'Barang Dikembalikan',
        'rusak' => 'Barang Rusak',
    ];

    public function index(Request $request)
    {
        $filter = $this->filter($request);
        $dikembalikan = $this->query($filter, 'dikembalikan')->get();
        $rusak = $this->query($filter, 'rusak')->get();
        $tab = $request->get('tab') === 'rusak' ? 'rusak' : 'dikembalikan';

        return view('petugas.rekap', compact('filter', 'dikembalikan', 'rusak', 'tab'));
    }

    public function cetak(Request $request)
    {
        $filter = $this->filter($request);
        $jenis = $this->jenis($request);

        $dikembalikan = in_array($jenis, ['semua', 'dikembalikan'], true) ? $this->query($filter, 'dikembalikan')->get() : collect();
        $rusak = in_array($jenis, ['semua', 'rusak'], true) ? $this->query($filter, 'rusak')->get() : collect();
        $auto = $request->boolean('auto', true);

        return view('petugas.rekap-cetak', compact('filter', 'jenis', 'dikembalikan', 'rusak', 'auto'));
    }

    public function export(Request $request)
    {
        $filter = $this->filter($request);
        $jenis = $this->jenis($request);

        $sheets = [];
        if (in_array($jenis, ['semua', 'dikembalikan'], true)) {
            $sheets['Barang Dikembalikan'] = $this->rows($this->query($filter, 'dikembalikan')->get(), 'dikembalikan');
        }
        if (in_array($jenis, ['semua', 'rusak'], true)) {
            $sheets['Barang Rusak'] = $this->rows($this->query($filter, 'rusak')->get(), 'rusak');
        }

        $nama = 'rekap-barang-'.($jenis === 'semua' ? 'semua' : $jenis).'-'.now()->format('Ymd-His');

        if (SimpleXlsx::available()) {
            $xlsx = new SimpleXlsx();
            $widths = [5, 14, 26, 10, 20, 14, 24, 8, 14, 16, 18, 36];
            foreach ($sheets as $nm => $rows) {
                $xlsx->addSheet($nm, $rows, $widths);
            }

            return response()->download($xlsx->save(), $nama.'.xlsx', [
                'Content-Type' => 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet',
            ])->deleteFileAfterSend(true);
        }

        // Cadangan bila ekstensi zip PHP tidak aktif: file .xls (HTML) yang tetap bisa dibuka di Excel
        $html = '<html xmlns:x="urn:schemas-microsoft-com:office:excel"><head><meta charset="UTF-8"></head><body>';
        foreach ($sheets as $nm => $rows) {
            $html .= '<h3>'.e($nm).'</h3><table border="1">';
            foreach ($rows as $i => $row) {
                $html .= '<tr>';
                foreach ($row as $cell) {
                    $tag = $i === 0 ? 'th' : 'td';
                    $html .= '<'.$tag.' style="mso-number-format:\'\\@\'">'.e((string) $cell).'</'.$tag.'>';
                }
                $html .= '</tr>';
            }
            $html .= '</table><br>';
        }
        $html .= '</body></html>';

        return response($html, 200, [
            'Content-Type' => 'application/vnd.ms-excel; charset=UTF-8',
            'Content-Disposition' => 'attachment; filename="'.$nama.'.xls"',
        ]);
    }

    /* ------------------------------------------------------------------ */

    private function jenis(Request $request): string
    {
        $jenis = $request->get('jenis', 'semua');

        return in_array($jenis, ['semua', 'dikembalikan', 'rusak'], true) ? $jenis : 'semua';
    }

    private function filter(Request $request): array
    {
        $peminjam = $request->get('peminjam');

        return [
            'dari' => $request->get('dari'),
            'sampai' => $request->get('sampai'),
            'peminjam' => in_array($peminjam, ['siswa', 'guru'], true) ? $peminjam : null,
        ];
    }

    private function query(array $filter, string $status)
    {
        $q = Peminjaman::with('peminjam')->where('status', $status);

        if (!empty($filter['dari'])) {
            $q->whereRaw('DATE(COALESCE(selesai_at, updated_at)) >= ?', [$filter['dari']]);
        }
        if (!empty($filter['sampai'])) {
            $q->whereRaw('DATE(COALESCE(selesai_at, updated_at)) <= ?', [$filter['sampai']]);
        }
        if (!empty($filter['peminjam'])) {
            $q->whereHas('peminjam', fn ($p) => $p->where('role', $filter['peminjam']));
        }

        return $q->orderByRaw('COALESCE(selesai_at, updated_at) DESC');
    }

    /** Susun baris untuk Excel (baris pertama = header). */
    private function rows($items, string $status): array
    {
        $tglHeader = $status === 'rusak' ? 'Tgl Dilaporkan Rusak' : 'Tgl Dikembalikan';
        $rows = [[
            'No', 'Kode', 'Nama Peminjam', 'Jenis', 'NIS / NIP', 'Kelas', 'Nama Barang',
            'Jumlah', 'Tgl Pinjam', 'Batas Kembali', $tglHeader, 'Keterangan',
        ]];

        foreach ($items as $i => $p) {
            $u = $p->peminjam;
            $tanggalSelesai = ($p->selesai_at ?? $p->updated_at);

            $rows[] = [
                $i + 1,
                $p->kode_peminjaman,
                $u->nama_lengkap ?? '-',
                $u->jenis_label ?? '-',
                (string) ($u->nomor_induk ?? '-'),
                ($u && $u->role === 'siswa') ? ($u->kelas ?? '-') : '-',
                $p->nama_barang,
                (int) $p->jumlah,
                $p->tanggal_pinjam->format('d/m/Y'),
                $p->tanggal_kembali->format('d/m/Y'),
                $tanggalSelesai ? $tanggalSelesai->format('d/m/Y') : '-',
                $p->catatan_selesai ?: '-',
            ];
        }

        $rows[] = [];
        $rows[] = ['', '', '', '', '', '', 'Total jumlah barang', (int) $items->sum('jumlah')];

        return $rows;
    }
}
