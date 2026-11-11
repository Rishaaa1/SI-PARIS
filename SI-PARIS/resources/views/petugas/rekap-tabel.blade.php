{{-- Tabel rekap (dipakai di halaman rekap). Variabel: $items, $status --}}
<div class="overflow-x-auto">
<table class="w-full text-sm">
    <thead>
        <tr class="text-left text-gray-400 border-b border-gray-100">
            <th class="py-2 font-medium">No</th>
            <th class="py-2 font-medium">Kode</th>
            <th class="py-2 font-medium">Nama Peminjam</th>
            <th class="py-2 font-medium">Jenis</th>
            <th class="py-2 font-medium">Nama Barang</th>
            <th class="py-2 font-medium">Jumlah</th>
            <th class="py-2 font-medium">Tgl Pinjam</th>
            <th class="py-2 font-medium">{{ $status === 'rusak' ? 'Tgl Dilaporkan Rusak' : 'Tgl Dikembalikan' }}</th>
            <th class="py-2 font-medium">Keterangan</th>
        </tr>
    </thead>
    <tbody>
        @forelse($items as $i => $p)
            @php $u = $p->peminjam; $tgl = $p->selesai_at ?? $p->updated_at; @endphp
            <tr class="border-b border-gray-50 align-top">
                <td class="py-3">{{ $i + 1 }}</td>
                <td class="py-3 whitespace-nowrap">{{ $p->kode_peminjaman }}</td>
                <td class="py-3">{{ $u->nama_lengkap ?? '-' }}<br><span class="text-xs text-gray-400">{{ $u->nomor_induk ?? '' }}</span></td>
                <td class="py-3">{{ $u->jenis_label ?? '-' }}@if(($u->role ?? null) === 'siswa')<br><span class="text-xs text-gray-400">{{ $u->kelas }}</span>@endif</td>
                <td class="py-3">{{ $p->nama_barang }}</td>
                <td class="py-3">{{ $p->jumlah }}</td>
                <td class="py-3 whitespace-nowrap">{{ $p->tanggal_pinjam->format('d/m/Y') }}</td>
                <td class="py-3 whitespace-nowrap">{{ $tgl ? $tgl->format('d/m/Y') : '-' }}</td>
                <td class="py-3 max-w-xs">
                    {{ $p->catatan_selesai ?: '-' }}
                    @if($status === 'rusak' && $p->foto_kendala)
                        <br><a href="{{ asset('storage/'.$p->foto_kendala) }}" target="_blank" class="text-xs text-blue-600 hover:underline">Lihat foto</a>
                    @endif
                </td>
            </tr>
        @empty
            <tr><td colspan="9" class="py-8 text-center text-gray-400">Belum ada data {{ $status === 'rusak' ? 'barang rusak' : 'barang dikembalikan' }}.</td></tr>
        @endforelse
    </tbody>
    @if($items->count())
    <tfoot>
        <tr class="border-t border-gray-200 font-semibold">
            <td colspan="5" class="py-3 text-right">Total jumlah barang</td>
            <td class="py-3">{{ $items->sum('jumlah') }}</td>
            <td colspan="3"></td>
        </tr>
    </tfoot>
    @endif
</table>
</div>
