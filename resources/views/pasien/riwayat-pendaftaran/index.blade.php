<x-layouts.app title="Riwayat Pendaftaran">

    {{-- ================= HEADER ================= --}}
    <div class="mb-6">

        <h2 class="text-2xl font-bold text-slate-800">
            Riwayat Pendaftaran
        </h2>

        <p class="text-sm text-slate-500 mt-1">
            Riwayat pendaftaran dan pemeriksaan poli Anda.
        </p>

    </div>


    {{-- ================= ALERT ================= --}}
    @if (session('success'))
        <div class="alert alert-success mb-4 rounded-xl shadow-sm">

            <i class="fas fa-circle-check"></i>

            <span>
                {{ session('success') }}
            </span>

        </div>
    @endif


    @if (session('error'))
        <div class="alert alert-error mb-4 rounded-xl shadow-sm">

            <i class="fas fa-circle-exclamation"></i>

            <span>
                {{ session('error') }}
            </span>

        </div>
    @endif


    {{-- ================= CARD ================= --}}
    <div
        class="card
               bg-base-100
               shadow-md
               rounded-2xl
               border border-slate-200">

        <div class="card-body p-0">

            <div class="overflow-x-auto">

                <table class="table w-full">

                    {{-- ================= TABLE HEADER ================= --}}
                    <thead
                        class="bg-slate-50
                               text-slate-500
                               uppercase
                               text-xs
                               tracking-wider">

                        <tr>

                            <th class="px-6 py-4">
                                No
                            </th>

                            <th class="px-6 py-4">
                                Poli
                            </th>

                            <th class="px-6 py-4">
                                Dokter
                            </th>

                            <th class="px-6 py-4">
                                Jadwal
                            </th>

                            <th class="px-6 py-4">
                                No. Antrian
                            </th>

                            <th class="px-6 py-4">
                                Status
                            </th>

                            <th class="px-6 py-4 text-right">
                                Aksi
                            </th>

                        </tr>

                    </thead>


                    {{-- ================= TABLE BODY ================= --}}
                    <tbody class="text-sm text-slate-700">

                        @forelse ($riwayats as $index => $riwayat)
                            @php

                                $sudahDiperiksa = $riwayat->periksas->isNotEmpty();

                            @endphp


                            <tr
                                class="border-t border-slate-100
                                       hover:bg-slate-50
                                       transition">

                                {{-- NO --}}
                                <td class="px-6 py-4">

                                    {{ $index + 1 }}

                                </td>


                                {{-- POLI --}}
                                <td class="px-6 py-4">

                                    <div class="flex items-center gap-3">

                                        <div
                                            class="flex items-center justify-center
                                                   w-9 h-9
                                                   rounded-lg
                                                   bg-indigo-50
                                                   text-indigo-600">

                                            <i class="fas fa-hospital"></i>

                                        </div>


                                        <span class="font-semibold text-slate-800">

                                            {{ $riwayat->jadwalPeriksa?->dokter?->poli?->nama_poli ?? '-' }}

                                        </span>

                                    </div>

                                </td>


                                {{-- DOKTER --}}
                                <td class="px-6 py-4">

                                    {{ $riwayat->jadwalPeriksa?->dokter?->nama ?? '-' }}

                                </td>


                                {{-- JADWAL --}}
                                <td class="px-6 py-4">

                                    <div>

                                        <p class="font-medium text-slate-700">

                                            {{ $riwayat->jadwalPeriksa?->hari ?? '-' }}

                                        </p>

                                        @if ($riwayat->jadwalPeriksa)
                                            <p class="text-xs text-slate-400 mt-1">

                                                {{ \Carbon\Carbon::parse($riwayat->jadwalPeriksa->jam_mulai)->format('H:i') }}

                                                -

                                                {{ \Carbon\Carbon::parse($riwayat->jadwalPeriksa->jam_selesai)->format('H:i') }}

                                            </p>
                                        @endif

                                    </div>

                                </td>


                                {{-- NO ANTRIAN --}}
                                <td class="px-6 py-4">

                                    <span
                                        class="inline-flex
                                               items-center
                                               justify-center
                                               min-w-9 h-9
                                               px-3
                                               rounded-lg
                                               bg-slate-100
                                               text-slate-700
                                               font-bold">

                                        {{ $riwayat->no_antrian }}

                                    </span>

                                </td>


                                {{-- STATUS --}}
                                <td class="px-6 py-4">

                                    @if ($sudahDiperiksa)
                                        <span
                                            class="inline-flex items-center gap-1.5
                                                   px-3 py-1.5
                                                   rounded-full
                                                   bg-emerald-100
                                                   text-emerald-700
                                                   text-xs
                                                   font-semibold">

                                            <i class="fas fa-circle-check"></i>

                                            Sudah Diperiksa

                                        </span>
                                    @else
                                        <span
                                            class="inline-flex items-center gap-1.5
                                                   px-3 py-1.5
                                                   rounded-full
                                                   bg-amber-100
                                                   text-amber-700
                                                   text-xs
                                                   font-semibold">

                                            <i class="fas fa-clock"></i>

                                            Menunggu

                                        </span>
                                    @endif

                                </td>


                                {{-- AKSI --}}
                                <td class="px-6 py-4">

                                    <div class="flex justify-end">

                                        @if ($sudahDiperiksa)
                                            <a href="{{ route('riwayat-pendaftaran.show', $riwayat) }}"
                                                class="inline-flex
                                                       items-center
                                                       gap-2
                                                       px-3 py-2
                                                       rounded-lg
                                                       bg-primary
                                                       hover:bg-primary/90
                                                       text-white
                                                       text-xs
                                                       font-semibold
                                                       transition">

                                                <i class="fas fa-eye"></i>

                                                Detail

                                            </a>
                                        @else
                                            <span
                                                class="inline-flex
                                                       items-center
                                                       gap-2
                                                       px-3 py-2
                                                       rounded-lg
                                                       bg-slate-100
                                                       text-slate-400
                                                       text-xs
                                                       font-semibold">

                                                <i class="fas fa-hourglass-half"></i>

                                                Menunggu

                                            </span>
                                        @endif

                                    </div>

                                </td>

                            </tr>

                        @empty

                            <tr>

                                <td colspan="7"
                                    class="text-center
                                           py-14
                                           text-slate-400">

                                    <div
                                        class="flex
                                               flex-col
                                               items-center
                                               justify-center">

                                        <div
                                            class="flex
                                                   items-center
                                                   justify-center
                                                   w-14 h-14
                                                   rounded-full
                                                   bg-slate-100
                                                   mb-3">

                                            <i
                                                class="fas
                                                       fa-clock-rotate-left
                                                       text-2xl
                                                       text-slate-400">
                                            </i>

                                        </div>

                                        <p
                                            class="font-semibold
                                                   text-slate-500">

                                            Belum ada riwayat pendaftaran

                                        </p>

                                        <p
                                            class="text-sm
                                                   text-slate-400
                                                   mt-1">

                                            Riwayat pendaftaran poli Anda akan tampil di sini.

                                        </p>

                                    </div>

                                </td>

                            </tr>
                        @endforelse

                    </tbody>

                </table>

            </div>

        </div>

    </div>

</x-layouts.app>
