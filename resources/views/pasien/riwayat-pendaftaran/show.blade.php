<x-layouts.app title="Detail Pemeriksaan">

    @php

        $periksa = $riwayat->periksas->first();

    @endphp


    {{-- ================= HEADER ================= --}}
    <div class="flex items-center gap-3 mb-6">

        <a href="{{ route('riwayat-pendaftaran.index') }}"
            class="flex
                   items-center
                   justify-center
                   w-9 h-9
                   rounded-lg
                   bg-slate-100
                   hover:bg-slate-200
                   text-slate-600
                   transition">

            <i class="fas fa-arrow-left text-sm"></i>

        </a>


        <div>

            <h2 class="text-2xl font-bold text-slate-800">
                Detail Pemeriksaan
            </h2>

            <p class="text-sm text-slate-500 mt-1">
                Informasi hasil pemeriksaan dan obat yang diberikan.
            </p>

        </div>

    </div>


    {{-- ================= INFORMASI PENDAFTARAN ================= --}}
    <div
        class="card
               bg-base-100
               shadow-md
               rounded-2xl
               border border-slate-200
               mb-5">

        <div class="card-body p-6">

            <h3
                class="text-lg
                       font-bold
                       text-slate-800
                       mb-5">

                Informasi Pendaftaran

            </h3>


            <div
                class="grid
                       grid-cols-1
                       sm:grid-cols-2
                       lg:grid-cols-4
                       gap-5">

                {{-- Poli --}}
                <div>

                    <p
                        class="text-xs
                               uppercase
                               tracking-wider
                               font-semibold
                               text-slate-400">

                        Poli

                    </p>

                    <p class="text-sm font-semibold text-slate-800 mt-1">

                        {{ $riwayat->jadwalPeriksa?->dokter?->poli?->nama_poli ?? '-' }}

                    </p>

                </div>


                {{-- Dokter --}}
                <div>

                    <p
                        class="text-xs
                               uppercase
                               tracking-wider
                               font-semibold
                               text-slate-400">

                        Dokter

                    </p>

                    <p class="text-sm font-semibold text-slate-800 mt-1">

                        {{ $riwayat->jadwalPeriksa?->dokter?->nama ?? '-' }}

                    </p>

                </div>


                {{-- Jadwal --}}
                <div>

                    <p
                        class="text-xs
                               uppercase
                               tracking-wider
                               font-semibold
                               text-slate-400">

                        Jadwal

                    </p>

                    <p class="text-sm font-semibold text-slate-800 mt-1">

                        {{ $riwayat->jadwalPeriksa?->hari ?? '-' }}

                        @if ($riwayat->jadwalPeriksa)
                            ,

                            {{ \Carbon\Carbon::parse($riwayat->jadwalPeriksa->jam_mulai)->format('H:i') }}

                            -

                            {{ \Carbon\Carbon::parse($riwayat->jadwalPeriksa->jam_selesai)->format('H:i') }}
                        @endif

                    </p>

                </div>


                {{-- Nomor Antrian --}}
                <div>

                    <p
                        class="text-xs
                               uppercase
                               tracking-wider
                               font-semibold
                               text-slate-400">

                        No. Antrian

                    </p>

                    <p class="text-sm font-semibold text-slate-800 mt-1">

                        {{ $riwayat->no_antrian }}

                    </p>

                </div>

            </div>


            {{-- Keluhan --}}
            <div class="mt-6">

                <p
                    class="text-xs
                           uppercase
                           tracking-wider
                           font-semibold
                           text-slate-400">

                    Keluhan

                </p>

                <p class="text-sm
                           text-slate-700
                           mt-2">

                    {{ $riwayat->keluhan ?: '-' }}

                </p>

            </div>

        </div>

    </div>


    {{-- ================= HASIL PEMERIKSAAN ================= --}}
    <div
        class="card
               bg-base-100
               shadow-md
               rounded-2xl
               border border-slate-200
               mb-5">

        <div class="card-body p-6">

            <div
                class="flex
                       items-center
                       justify-between
                       gap-4
                       mb-5">

                <h3 class="text-lg
                           font-bold
                           text-slate-800">

                    Hasil Pemeriksaan

                </h3>


                <span
                    class="inline-flex
                           items-center
                           gap-1.5
                           px-3 py-1.5
                           rounded-full
                           bg-emerald-100
                           text-emerald-700
                           text-xs
                           font-semibold">

                    <i class="fas fa-circle-check"></i>

                    Sudah Diperiksa

                </span>

            </div>


            <div
                class="grid
                       grid-cols-1
                       md:grid-cols-2
                       gap-5">

                {{-- Tanggal Pemeriksaan --}}
                <div>

                    <p
                        class="text-xs
                               uppercase
                               tracking-wider
                               font-semibold
                               text-slate-400">

                        Tanggal Pemeriksaan

                    </p>

                    <p
                        class="text-sm
                               font-semibold
                               text-slate-800
                               mt-1">

                        {{ $periksa && $periksa->tgl_periksa ? \Carbon\Carbon::parse($periksa->tgl_periksa)->format('d M Y, H:i') : '-' }}

                    </p>

                </div>


                {{-- Total Biaya --}}
                <div>

                    <p
                        class="text-xs
                               uppercase
                               tracking-wider
                               font-semibold
                               text-slate-400">

                        Total Biaya

                    </p>

                    <p
                        class="text-lg
                               font-bold
                               text-primary
                               mt-1">

                        Rp
                        {{ number_format($periksa->biaya_periksa ?? 0, 0, ',', '.') }}

                    </p>

                </div>

            </div>


            {{-- Catatan --}}
            <div class="mt-6">

                <p
                    class="text-xs
                           uppercase
                           tracking-wider
                           font-semibold
                           text-slate-400">

                    Catatan Dokter

                </p>


                <div
                    class="mt-2
                           p-4
                           rounded-xl
                           bg-slate-50
                           border border-slate-200">

                    <p
                        class="text-sm
                               leading-relaxed
                               text-slate-700">

                        {{ $periksa->catatan ?: 'Tidak ada catatan.' }}

                    </p>

                </div>

            </div>

        </div>

    </div>


    {{-- ================= DAFTAR OBAT ================= --}}
    <div
        class="card
               bg-base-100
               shadow-md
               rounded-2xl
               border border-slate-200">

        <div class="card-body p-6">

            <h3
                class="text-lg
                       font-bold
                       text-slate-800
                       mb-5">

                Obat yang Diberikan

            </h3>


            <div class="overflow-x-auto">

                <table class="table w-full">

                    <thead
                        class="bg-slate-50
                               text-slate-500
                               uppercase
                               text-xs
                               tracking-wider">

                        <tr>

                            <th class="px-5 py-3">
                                No
                            </th>

                            <th class="px-5 py-3">
                                Nama Obat
                            </th>

                            <th class="px-5 py-3">
                                Kemasan
                            </th>

                            <th class="px-5 py-3 text-right">
                                Harga
                            </th>

                        </tr>

                    </thead>


                    <tbody class="text-sm text-slate-700">

                        @forelse ($periksa->detailPeriksas as $index => $detail)
                            <tr class="border-t
                                       border-slate-100">

                                <td class="px-5 py-4">

                                    {{ $index + 1 }}

                                </td>


                                <td
                                    class="px-5 py-4
                                           font-semibold
                                           text-slate-800">

                                    {{ $detail->obat?->nama_obat ?? '-' }}

                                </td>


                                <td class="px-5 py-4">

                                    {{ $detail->obat?->kemasan ?? '-' }}

                                </td>


                                <td
                                    class="px-5 py-4
                                           text-right
                                           font-semibold">

                                    Rp
                                    {{ number_format($detail->obat?->harga ?? 0, 0, ',', '.') }}

                                </td>

                            </tr>

                        @empty

                            <tr>

                                <td colspan="4"
                                    class="text-center
                                           py-10
                                           text-slate-400">

                                    Tidak ada obat yang diberikan.

                                </td>

                            </tr>
                        @endforelse

                    </tbody>

                </table>

            </div>

        </div>

    </div>

</x-layouts.app>
