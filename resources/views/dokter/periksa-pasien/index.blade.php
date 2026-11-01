<x-layouts.app title="Periksa Pasien">

    {{-- ================= HEADER ================= --}}
    <div class="flex items-center justify-between mb-6">

        <div>
            <h2 class="text-2xl font-bold text-slate-800">
                Periksa Pasien
            </h2>

            <p class="text-sm text-slate-500 mt-1">
                Daftar pasien yang terdaftar pada jadwal pemeriksaan Anda.
            </p>
        </div>

    </div>


    {{-- ================= ALERT SUCCESS ================= --}}
    @if (session('success'))
        <div class="alert alert-success mb-4 rounded-xl shadow-sm">

            <i class="fas fa-circle-check"></i>

            <span>
                {{ session('success') }}
            </span>

        </div>
    @endif


    {{-- ================= ALERT ERROR ================= --}}
    @if (session('error'))
        <div class="alert alert-error mb-4 rounded-xl shadow-sm">

            <i class="fas fa-circle-xmark"></i>

            <span>
                {{ session('error') }}
            </span>

        </div>
    @endif


    {{-- ================= CARD ================= --}}
    <div
        class="card bg-base-100
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
                                ID
                            </th>

                            <th class="px-6 py-4">
                                Pasien
                            </th>

                            <th class="px-6 py-4">
                                Keluhan
                            </th>

                            <th class="px-6 py-4">
                                No. Antrian
                            </th>

                            <th class="px-6 py-4 text-right">
                                Aksi
                            </th>

                        </tr>

                    </thead>


                    {{-- ================= TABLE BODY ================= --}}
                    <tbody class="text-sm text-slate-700">

                        @forelse ($daftarPasien as $daftar)
                            <tr
                                class="border-t border-slate-100
                                       hover:bg-slate-50
                                       transition">

                                {{-- ID --}}
                                <td class="px-6 py-4 text-slate-600">

                                    {{ $daftar->id }}

                                </td>


                                {{-- PASIEN --}}
                                <td class="px-6 py-4">

                                    <div class="flex items-center gap-3">

                                        <div
                                            class="flex items-center justify-center
                                                   w-9 h-9
                                                   shrink-0
                                                   rounded-full
                                                   bg-indigo-50
                                                   text-indigo-600">

                                            <i class="fas fa-user"></i>

                                        </div>


                                        <div>

                                            <p class="font-semibold text-slate-800">

                                                {{ $daftar->pasien->nama ?? '-' }}

                                            </p>


                                            @if ($daftar->pasien && $daftar->pasien->no_rm)
                                                <p class="text-xs text-slate-400 mt-0.5">

                                                    RM:
                                                    {{ $daftar->pasien->no_rm }}

                                                </p>
                                            @endif

                                        </div>

                                    </div>

                                </td>


                                {{-- KELUHAN --}}
                                <td class="px-6 py-4 text-slate-600">

                                    <div class="max-w-md">

                                        {{ $daftar->keluhan ?? '-' }}

                                    </div>

                                </td>


                                {{-- NOMOR ANTRIAN --}}
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

                                        {{ $daftar->no_antrian }}

                                    </span>

                                </td>


                                {{-- AKSI --}}
                                <td class="px-6 py-4">

                                    <div class="flex justify-end">

                                        @if ($daftar->periksas->isNotEmpty())
                                            <span
                                                class="inline-flex
                                                       items-center
                                                       gap-2
                                                       px-3 py-2
                                                       rounded-lg
                                                       bg-emerald-100
                                                       text-emerald-700
                                                       text-xs
                                                       font-semibold">

                                                <i class="fas fa-circle-check"></i>

                                                Sudah Diperiksa

                                            </span>
                                        @else
                                            <a href="{{ route('periksa-pasien.create', $daftar->id) }}"
                                                class="inline-flex
                                                       items-center
                                                       gap-2
                                                       px-3 py-2
                                                       rounded-lg
                                                       bg-amber-500
                                                       hover:bg-amber-600
                                                       text-white
                                                       text-xs
                                                       font-semibold
                                                       transition">

                                                <i class="fas fa-stethoscope"></i>

                                                Periksa

                                            </a>
                                        @endif

                                    </div>

                                </td>

                            </tr>

                        @empty

                            <tr>

                                <td colspan="5"
                                    class="text-center
                                           py-14
                                           text-slate-400">

                                    <div
                                        class="flex flex-col
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
                                                class="fas fa-user-doctor
                                                       text-2xl
                                                       text-slate-400">
                                            </i>

                                        </div>

                                        <p class="font-semibold text-slate-500">
                                            Belum ada pasien
                                        </p>

                                        <p class="text-sm text-slate-400 mt-1">
                                            Belum ada pasien yang terdaftar untuk diperiksa.
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
