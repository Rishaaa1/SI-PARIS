<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Rekap Barang - {{ now()->format('d-m-Y') }}</title>
    <style>
        * { box-sizing: border-box; }
        body { font-family: Arial, Helvetica, sans-serif; font-size: 12px; color: #111; margin: 24px; }
        .kop { text-align: center; border-bottom: 2px solid #111; padding-bottom: 8px; margin-bottom: 14px; }
        .kop h1 { font-size: 16px; margin: 0; }
        .kop p { margin: 2px 0 0; font-size: 12px; }
        h2 { font-size: 14px; margin: 18px 0 6px; }
        .meta { margin: 0 0 8px; font-size: 11px; color: #444; }
        table { width: 100%; border-collapse: collapse; margin-bottom: 8px; }
        th, td { border: 1px solid #333; padding: 5px 6px; text-align: left; vertical-align: top; }
        th { background: #e8e8e8; }
        td.c, th.c { text-align: center; }
        tfoot td { font-weight: bold; }
        .ttd { margin-top: 36px; width: 100%; }
        .ttd td { border: none; text-align: center; width: 50%; }
        .aksi { margin-bottom: 14px; }
        .aksi button, .aksi a { font-size: 12px; padding: 6px 12px; margin-right: 6px; cursor: pointer; }
        .section { page-break-inside: auto; }
        tr { page-break-inside: avoid; }
        @media print { .aksi { display: none; } body { margin: 10mm; } }
    </style>
</head>
<body @if($auto) onload="window.print()" @endif>
    <div class="aksi">
        <button onclick="window.print()">Cetak</button>
        <a href="javascript:window.close()">Tutup</a>
    </div>

    <div class="kop">
        <h1>REKAP BARANG PEMINJAMAN ALAT / INVENTARIS</h1>
        <p>SMK Negeri 5 Surakarta</p>
    </div>

    <p class="meta">
        Periode:
        @if($filter['dari'] || $filter['sampai'])
            {{ $filter['dari'] ? \Carbon\Carbon::parse($filter['dari'])->format('d/m/Y') : 'awal' }}
            s/d
            {{ $filter['sampai'] ? \Carbon\Carbon::parse($filter['sampai'])->format('d/m/Y') : 'sekarang' }}
        @else
            Semua tanggal
        @endif
        &nbsp;|&nbsp; Peminjam: {{ $filter['peminjam'] ? ucfirst($filter['peminjam']) : 'Siswa & Guru' }}
        &nbsp;|&nbsp; Dicetak: {{ now()->format('d/m/Y H:i') }}
    </p>

    @foreach(['dikembalikan' => [$dikembalikan, 'A. Barang Dikembalikan', 'Tgl Dikembalikan'], 'rusak' => [$rusak, 'B. Barang Rusak', 'Tgl Dilaporkan Rusak']] as $key => [$items, $judul, $hTgl])
        @if(in_array($jenis, ['semua', $key]))
            <div class="section">
                <h2>{{ $jenis === 'semua' ? $judul : substr($judul, 3) }}</h2>
                <table>
                    <thead>
                        <tr>
                            <th class="c" style="width:30px">No</th>
                            <th>Kode</th>
                            <th>Nama Peminjam</th>
                            <th>Jenis</th>
                            <th>Nama Barang</th>
                            <th class="c">Jml</th>
                            <th>Tgl Pinjam</th>
                            <th>{{ $hTgl }}</th>
                            <th>Keterangan</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($items as $i => $p)
                            @php $u = $p->peminjam; $tgl = $p->selesai_at ?? $p->updated_at; @endphp
                            <tr>
                                <td class="c">{{ $i + 1 }}</td>
                                <td>{{ $p->kode_peminjaman }}</td>
                                <td>{{ $u->nama_lengkap ?? '-' }}<br><small>{{ $u->nomor_induk ?? '' }}</small></td>
                                <td>{{ $u->jenis_label ?? '-' }}@if(($u->role ?? null) === 'siswa')<br><small>{{ $u->kelas }}</small>@endif</td>
                                <td>{{ $p->nama_barang }}</td>
                                <td class="c">{{ $p->jumlah }}</td>
                                <td>{{ $p->tanggal_pinjam->format('d/m/Y') }}</td>
                                <td>{{ $tgl ? $tgl->format('d/m/Y') : '-' }}</td>
                                <td>{{ $p->catatan_selesai ?: '-' }}</td>
                            </tr>
                        @empty
                            <tr><td colspan="9" class="c">Tidak ada data.</td></tr>
                        @endforelse
                    </tbody>
                    @if($items->count())
                        <tfoot>
                            <tr>
                                <td colspan="5" style="text-align:right">Total jumlah barang</td>
                                <td class="c">{{ $items->sum('jumlah') }}</td>
                                <td colspan="3"></td>
                            </tr>
                        </tfoot>
                    @endif
                </table>
            </div>
        @endif
    @endforeach

    <table class="ttd">
        <tr>
            <td></td>
            <td>
                Surakarta, {{ now()->format('d/m/Y') }}<br>Petugas,<br><br><br><br>
                <strong>{{ auth()->user()->nama_lengkap }}</strong>
            </td>
        </tr>
    </table>
</body>
</html>
