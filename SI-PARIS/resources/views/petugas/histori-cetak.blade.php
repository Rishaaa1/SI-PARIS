<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Histori Peminjaman - {{ now()->timezone('Asia/Jakarta')->format('d-m-Y') }}</title>
    <style>
        * { box-sizing: border-box; }
        body { font-family: Arial, Helvetica, sans-serif; font-size: 12px; color: #111; margin: 24px; }
        .kop { text-align: center; border-bottom: 2px solid #111; padding-bottom: 8px; margin-bottom: 14px; }
        .kop h1 { font-size: 16px; margin: 0; }
        .kop p { margin: 2px 0 0; font-size: 12px; }
        .meta { margin: 0 0 8px; font-size: 11px; color: #444; }
        table { width: 100%; border-collapse: collapse; margin-bottom: 8px; }
        th, td { border: 1px solid #333; padding: 5px 6px; text-align: left; vertical-align: top; }
        th { background: #e8e8e8; }
        td.c, th.c { text-align: center; }
        tr { page-break-inside: avoid; }
        .ttd { margin-top: 36px; width: 100%; }
        .ttd td { border: none; text-align: center; width: 50%; }
        .aksi { margin-bottom: 14px; }
        .aksi button, .aksi a { font-size: 12px; padding: 6px 12px; margin-right: 6px; cursor: pointer; }
        @media print { .aksi { display: none; } body { margin: 10mm; } }
    </style>
</head>
<body @if($auto) onload="window.print()" @endif>
    <div class="aksi">
        <button onclick="window.print()">Cetak</button>
        <a href="javascript:window.close()">Tutup</a>
    </div>

    <div class="kop">
        <h1>HISTORI PEMINJAMAN ALAT / INVENTARIS</h1>
        <p>SMK Negeri 5 Surakarta</p>
    </div>

    <p class="meta">
        Peminjam: {{ $jenis ? ucfirst($jenis) : 'Siswa & Guru' }}
        &nbsp;|&nbsp; Kelas: {{ $kelas ?: 'Semua' }}
        &nbsp;|&nbsp; Status: {{ $status ? $statusLabel[$status] : 'Semua' }}
        &nbsp;|&nbsp; Jumlah data: {{ $histori->count() }}
        &nbsp;|&nbsp; Dicetak: {{ now()->timezone('Asia/Jakarta')->format('d/m/Y H:i') }} WIB
    </p>

    <table>
        <thead>
            <tr>
                <th class="c" style="width:30px">No</th>
                <th>Kode</th>
                <th>Nama Peminjam</th>
                <th>Jenis / Kelas</th>
                <th>Nama Barang</th>
                <th class="c">Jml</th>
                <th>Waktu Pengajuan</th>
                <th>Tgl Kembali</th>
                <th>Status</th>
            </tr>
        </thead>
        <tbody>
            @forelse($histori as $i => $h)
                @php $u = $h->peminjam; @endphp
                <tr>
                    <td class="c">{{ $i + 1 }}</td>
                    <td>{{ $h->kode_peminjaman }}</td>
                    <td>{{ $u->nama_lengkap ?? '-' }}<br><small>{{ $u->nomor_induk ?? '' }}</small></td>
                    <td>{{ $u->jenis_label ?? '-' }}@if(($u->role ?? null) === 'siswa')<br><small>{{ $u->kelas }}</small>@endif</td>
                    <td>{{ $h->nama_barang }}</td>
                    <td class="c">{{ $h->jumlah }}</td>
                    <td>{{ $h->created_at->copy()->timezone('Asia/Jakarta')->format('d/m/Y') }}<br><small>{{ $h->created_at->copy()->timezone('Asia/Jakarta')->format('H:i:s') }} WIB</small></td>
                    <td>{{ $h->tanggal_kembali->format('d/m/Y') }}</td>
                    <td>{{ $statusLabel[$h->status] ?? ucfirst($h->status) }}</td>
                </tr>
            @empty
                <tr><td colspan="9" class="c">Tidak ada data.</td></tr>
            @endforelse
        </tbody>
    </table>

    <table class="ttd">
        <tr>
            <td></td>
            <td>
                Surakarta, {{ now()->timezone('Asia/Jakarta')->format('d/m/Y') }}<br>Petugas,<br><br><br><br>
                <strong>{{ auth()->user()->nama_lengkap }}</strong>
            </td>
        </tr>
    </table>
</body>
</html>