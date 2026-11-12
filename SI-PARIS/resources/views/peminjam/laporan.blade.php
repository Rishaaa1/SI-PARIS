
@extends('layouts.dashboard')
@section('title', 'Laporan')
@section('page-title', 'Laporan')

@section('content')
@php
    // Barang yang sedang dipinjam
    $dataPinjam = $peminjamanAktif->mapWithKeys(fn ($p) => [
        $p->id => [
            'nama' => $p->nama_barang,
            'jumlah' => $p->jumlah,
            'kode' => $p->kode_peminjaman,
            'gambar' => !empty($gambarBarang[$p->barang_id])
                ? asset('storage/'.$gambarBarang[$p->barang_id])
                : null,
        ]
    ]);
@endphp

<div class="w-full">
    <div
        class="grid grid-cols-1 lg:grid-cols-3 gap-6 items-start"
        x-data="{
            jenis: {{ \Illuminate\Support\Js::from(old('jenis', $jenisTersedia[0] ?? 'kendala')) }},
            pilih: {{ \Illuminate\Support\Js::from(old('peminjaman_id', '')) }},
            jumlah: {{ \Illuminate\Support\Js::from(old('jumlah', '')) }},
            data: {{ \Illuminate\Support\Js::from($dataPinjam) }}
        }"
    >

        <!-- FORM LAPORAN -->
        <div class="lg:col-span-2 min-w-0 bg-white rounded-xl shadow-sm p-4 sm:p-6 md:p-8">

            <h3 class="font-semibold text-gray-800 mb-1">
                Laporan Kendala / Perpanjangan / Pengembalian
            </h3>

            <p class="text-xs text-gray-400 mb-5">
                Isi form sesuai kebutuhan Anda.
            </p>

            <!-- PILIH JENIS LAPORAN -->
            <div class="flex gap-1 bg-blue-100 rounded-xl p-1 mb-5 text-xs sm:text-sm">

                @if(in_array('kendala', $jenisTersedia))
                    <button
                        type="button"
                        @click="jenis = 'kendala'"
                        :class="jenis === 'kendala'
                            ? 'bg-blue-600 text-white shadow'
                            : 'text-blue-700'"
                        class="flex-1 px-2 py-2.5 rounded-lg font-semibold leading-tight text-center transition"
                    >
                        Laporan Kendala
                    </button>
                @endif

                @if(in_array('perpanjangan', $jenisTersedia))
                    <button
                        type="button"
                        @click="jenis = 'perpanjangan'"
                        :class="jenis === 'perpanjangan'
                            ? 'bg-blue-600 text-white shadow'
                            : 'text-blue-700'"
                        class="flex-1 px-2 py-2.5 rounded-lg font-semibold leading-tight text-center transition"
                    >
                        Perpanjang
                    </button>
                @endif

                @if(in_array('pengembalian', $jenisTersedia))
                    <button
                        type="button"
                        @click="jenis = 'pengembalian'"
                        :class="jenis === 'pengembalian'
                            ? 'bg-blue-600 text-white shadow'
                            : 'text-blue-700'"
                        class="flex-1 px-2 py-2.5 rounded-lg font-semibold leading-tight text-center transition"
                    >
                        Pengembalian
                    </button>
                @endif

            </div>

            <!-- PESAN ERROR -->
            @if ($errors->any())
                <div class="mb-4 p-3 rounded-lg bg-red-50 text-red-600 text-sm">
                    {{ $errors->first() }}
                </div>
            @endif

            <!-- FORM -->
            <form
                method="POST"
                action="{{ route('peminjam.laporan.store') }}"
                enctype="multipart/form-data"
                class="space-y-4"
            >
                @csrf

                <input type="hidden" name="jenis" :value="jenis">

                <!-- PILIH BARANG -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">
                        Pilih Barang
                    </label>

                    <select
                        name="peminjaman_id"
                        x-model="pilih"
                        @change="jumlah = data[pilih] ? data[pilih].jumlah : ''"
                        class="w-full border border-gray-200 rounded-lg px-3 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500"
                        required
                    >
                        <option value="">Pilih barang</option>

                        @foreach($peminjamanAktif as $p)
                            <option value="{{ $p->id }}">
                                {{ $p->nama_barang }} &times;
                                {{ $p->jumlah }}
                                ({{ $p->kode_peminjaman }})
                            </option>
                        @endforeach

                    </select>

                    <p class="text-xs text-gray-400 mt-1">
                        Hanya barang yang sedang Anda pinjam
                        (sudah disetujui petugas) yang bisa dilaporkan.
                    </p>

                    @if($peminjamanAktif->isEmpty())
                        <p class="mt-2 text-xs text-orange-600 bg-orange-50 rounded-lg p-3">
                            Anda belum punya barang yang sedang dipinjam,
                            jadi belum ada yang bisa dilaporkan.
                        </p>
                    @endif

                    <!-- DETAIL BARANG -->
                    <div
                        x-show="pilih && data[pilih]"
                        style="display:none"
                        class="mt-3 flex items-center gap-3 bg-blue-50 rounded-lg p-3"
                    >
                        <template x-if="data[pilih] && data[pilih].gambar">
                            <img
                                :src="data[pilih].gambar"
                                :alt="data[pilih].nama"
                                class="w-16 h-16 rounded-lg object-cover"
                            >
                        </template>

                        <div class="text-sm">
                            <p
                                class="font-semibold text-gray-800"
                                x-text="data[pilih] ? data[pilih].nama : ''"
                            ></p>

                            <p
                                class="text-xs text-gray-500"
                                x-text="data[pilih]
                                    ? 'Kode ' + data[pilih].kode + ' · dipinjam ' + data[pilih].jumlah + ' unit'
                                    : ''"
                            ></p>
                        </div>
                    </div>
                </div>

                <!-- JUMLAH -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">
                        Jumlah
                    </label>

                    <input
                        type="number"
                        min="1"
                        name="jumlah"
                        x-model="jumlah"
                        :max="data[pilih] ? data[pilih].jumlah : null"
                        placeholder="Masukkan jumlah"
                        class="w-full border border-gray-200 rounded-lg px-3 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500"
                        required
                    >
                </div>

                <!-- DESKRIPSI KENDALA -->
                <div x-show="jenis === 'kendala'">
                    <label class="block text-sm font-medium text-gray-700 mb-1">
                        Deskripsi Kendala
                    </label>

                    <textarea
                        name="deskripsi_kendala"
                        rows="3"
                        placeholder="Jelaskan kendala yang terjadi..."
                        class="w-full border border-gray-200 rounded-lg px-3 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500"
                    >{{ old('deskripsi_kendala') }}</textarea>
                </div>

                <!-- TANGGAL PERPANJANGAN / PENGEMBALIAN -->
                <div x-show="jenis !== 'kendala'">

                    <label
                        class="block text-sm font-medium text-gray-700 mb-1"
                        x-text="jenis === 'perpanjangan'
                            ? 'Tanggal Perpanjangan'
                            : 'Tanggal Pengembalian'"
                    >
                    </label>

                    <input
                        type="date"
                        name="tanggal_pengembalian_baru"
                        value="{{ old('tanggal_pengembalian_baru') }}"
                        class="w-full border border-gray-200 rounded-lg px-3 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500"
                    >

                </div>

                <!-- UPLOAD FOTO KENDALA -->
                <div x-show="jenis === 'kendala'">
                    <label class="block text-sm font-medium text-gray-700 mb-1">
                        Upload Foto (jika ada kendala)
                    </label>

                    <input
                        type="file"
                        name="foto"
                        accept="image/*"
                        class="w-full min-w-0 border border-gray-200 rounded-lg px-3 py-2.5 text-sm bg-white"
                    >
                </div>

                <!-- TOMBOL KIRIM -->
                <button
                    type="submit"
                    {{ $peminjamanAktif->isEmpty() ? 'disabled' : '' }}
                    class="w-full bg-blue-600 hover:bg-blue-700 disabled:opacity-50 text-white font-semibold py-2.5 rounded-lg transition"
                >
                    Kirim Laporan
                </button>

            </form>
        </div>

        <!-- RIWAYAT LAPORAN -->
        <div class="min-w-0 bg-white rounded-xl shadow-sm p-4 sm:p-6 md:p-8">

            <h3 class="font-semibold text-gray-800 mb-4">
                Riwayat Laporan
            </h3>

            <div class="space-y-3">

                @forelse($riwayatLaporan as $l)

                    <div class="border border-blue-100 bg-blue-50 rounded-lg p-3">

                        <div class="flex items-center justify-between mb-1">

                            <p class="text-sm font-semibold">
                                {{ $l->nama_barang }}
                            </p>

                            <x-status-badge :status="$l->status" />

                        </div>

                        <p class="text-xs text-gray-400">
                            {{ $l->jenisLabel() }}
                            &middot;
                            {{ $l->created_at->format('d M Y') }}
                        </p>

                    </div>

                @empty

                    <p class="text-sm text-gray-400">
                        Belum ada laporan.
                    </p>

                @endforelse

            </div>
        </div>

    </div>
</div>
@endsection
