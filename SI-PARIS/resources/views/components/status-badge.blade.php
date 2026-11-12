@props(['status'])

@php
    $map = [
        'menunggu' => ['Menunggu ACC', 'bg-orange-100 text-orange-600'],
        'disetujui' => ['Disetujui', 'bg-sky-100 text-sky-700'],
        'ditolak' => ['Ditolak', 'bg-red-100 text-red-600'],
        'diambil' => ['Barang Diambil', 'bg-indigo-100 text-indigo-600'],
        'dikembalikan' => ['Dikembalikan', 'bg-emerald-100 text-emerald-600'],
        'rusak' => ['Barang Rusak', 'bg-red-100 text-red-600'],
        'selesai' => ['Selesai', 'bg-emerald-100 text-emerald-600'],
        'diproses' => ['Diproses', 'bg-sky-100 text-sky-700'],
    ];
    [$label, $class] = $map[$status] ?? [ucfirst($status), 'bg-gray-100 text-gray-600'];
@endphp

<span class="inline-block whitespace-nowrap text-xs font-semibold px-2.5 py-1 rounded-full {{ $class }}">{{ $label }}</span>