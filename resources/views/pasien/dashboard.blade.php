<x-layouts.app title="Dashboard Pasien">

    {{-- =========================================================
        BANNER ANTRIAN AKTIF
    ========================================================== --}}
    @if ($antrianAktif)

        <div
            class="relative overflow-hidden
                   rounded-xl
                   bg-gradient-to-r
                   from-blue-500
                   to-indigo-600
                   text-white
                   shadow-md
                   mb-6">

            {{-- Decoration --}}
            <div
                class="absolute
                       -top-10 -right-10
                       w-32 h-32
                       rounded-full
                       border-[18px]
                       border-white/10">
            </div>


            <div
                class="relative
                       flex flex-col
                       lg:flex-row
                       lg:items-center
                       lg:justify-between
                       gap-6
                       px-6 py-5">


                {{-- ================= KIRI ================= --}}
                <div>

                    <p
                        class="text-xs
                               font-bold
                               tracking-wide
                               uppercase
                               text-blue-100
                               mb-3">

                        Antrian Aktif Anda

                    </p>


                    {{-- Poli --}}
                    <div class="mb-2">

                        <p class="text-xs
                                   text-blue-200">

                            Poliklinik

                        </p>

                        <p
                            class="text-lg
                                   font-bold
                                   text-white">

                            {{ $antrianAktif->jadwalPeriksa?->dokter?->poli?->nama_poli ?? '-' }}

                        </p>

                    </div>


                    {{-- Dokter --}}
                    <div class="mb-2">

                        <p class="text-xs
                                   text-blue-200">

                            Dokter

                        </p>

                        <p
                            class="text-sm
                                   font-semibold
                                   text-white">

                            {{ $antrianAktif->jadwalPeriksa?->dokter?->name ?? '-' }}

                        </p>

                    </div>


                    {{-- Jadwal --}}
                    <div>

                        <p class="text-xs
                                   text-blue-200">

                            Jadwal Periksa

                        </p>

                        <p
                            class="text-sm
                                   font-semibold
                                   text-white">

                            {{ $antrianAktif->jadwalPeriksa?->hari ?? '-' }}

                            @if ($antrianAktif->jadwalPeriksa)
                                (
                                {{ \Carbon\Carbon::parse($antrianAktif->jadwalPeriksa->jam_mulai)->format('H:i') }}

                                -

                                {{ \Carbon\Carbon::parse($antrianAktif->jadwalPeriksa->jam_selesai)->format('H:i') }}
                                )
                            @endif

                        </p>

                    </div>

                </div>


                {{-- ================= KANAN ================= --}}
                <div class="flex
                           items-stretch
                           gap-3">


                    {{-- Nomor Anda --}}
                    <div
                        class="min-w-28
                               bg-white/15
                               backdrop-blur-sm
                               border border-white/20
                               rounded-xl
                               px-5 py-4
                               text-center">

                        <p class="text-xs
                                   text-blue-100">

                            Nomor Anda

                        </p>

                        <p
                            class="text-3xl
                                   font-bold
                                   text-white
                                   mt-1">

                            {{ $antrianAktif->no_antrian }}

                        </p>

                    </div>


                    {{-- Sedang Dilayani --}}
                    <div
                        class="min-w-32
                               bg-white
                               rounded-xl
                               px-5 py-4
                               text-center
                               shadow-sm">

                        <p
                            class="text-xs
                                   font-bold
                                   uppercase
                                   text-slate-500">

                            Sedang Dilayani

                        </p>

                        <p id="nomor-sedang-dilayani"
                            class="text-3xl
                                   font-bold
                                   text-indigo-600
                                   mt-1">

                            {{ $nomorSedangDilayani ?? '-' }}

                        </p>


                        <div
                            class="flex
                                   items-center
                                   justify-center
                                   gap-1.5
                                   mt-1">

                            <span
                                class="w-2 h-2
                                       bg-emerald-500
                                       rounded-full">
                            </span>

                            <span class="text-[11px]
                                       text-slate-400">

                                Live Update

                            </span>

                        </div>

                    </div>

                </div>

            </div>

        </div>

    @endif


    {{-- =========================================================
        JUDUL TABEL
    ========================================================== --}}
    <div class="mb-4">

        <h2 class="text-xl
                   font-bold
                   text-slate-800">

            Jadwal Poliklinik

        </h2>

        <p class="text-sm
                   text-slate-500
                   mt-1">

            Daftar jadwal poliklinik dan dokter.

        </p>

    </div>


    {{-- =========================================================
        TABLE
    ========================================================== --}}
    <div
        class="card
               bg-base-100
               shadow-md
               rounded-2xl
               border border-slate-200">

        <div class="card-body p-0">

            <div class="overflow-x-auto">

                <table class="table w-full">

                    {{-- ================= HEADER ================= --}}
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
                                Hari
                            </th>

                            <th class="px-6 py-4">
                                Jam Periksa
                            </th>

                            <th class="px-6 py-4
                                       text-center">

                                Sedang Dilayani

                            </th>

                        </tr>

                    </thead>


                    {{-- ================= BODY ================= --}}
                    <tbody class="text-sm text-slate-700">

                        @forelse ($jadwals as $index => $jadwal)
                            <tr
                                class="border-t
                                       border-slate-100
                                       hover:bg-slate-50
                                       transition">

                                {{-- No --}}
                                <td class="px-6 py-4">

                                    {{ $index + 1 }}

                                </td>


                                {{-- Poli --}}
                                <td
                                    class="px-6 py-4
                                           font-semibold
                                           text-slate-800">

                                    {{ $jadwal->dokter?->poli?->nama_poli ?? '-' }}

                                </td>


                                {{-- Dokter --}}
                                <td class="px-6 py-4">

                                    {{ $jadwal->dokter?->name ?? '-' }}

                                </td>


                                {{-- Hari --}}
                                <td class="px-6 py-4">

                                    {{ $jadwal->hari }}

                                </td>


                                {{-- Jam --}}
                                <td class="px-6 py-4">

                                    {{ \Carbon\Carbon::parse($jadwal->jam_mulai)->format('H:i') }}

                                    -

                                    {{ \Carbon\Carbon::parse($jadwal->jam_selesai)->format('H:i') }}

                                </td>


                                {{-- Sedang Dilayani --}}
                                <td class="px-6 py-4
                                           text-center">

                                    @if ($jadwal->nomor_sedang_dilayani)
                                        <span id="jadwal-antrian-{{ $jadwal->id }}"
                                            class="inline-flex
                                                   items-center
                                                   justify-center
                                                   min-w-9 h-9
                                                   px-3
                                                   rounded-lg
                                                   bg-indigo-50
                                                   text-indigo-700
                                                   font-bold">

                                            {{ $jadwal->nomor_sedang_dilayani }}

                                        </span>
                                    @else
                                        <span id="jadwal-antrian-{{ $jadwal->id }}" class="text-slate-400">

                                            -

                                        </span>
                                    @endif

                                </td>

                            </tr>

                        @empty

                            <tr>

                                <td colspan="6"
                                    class="text-center
                                           py-12
                                           text-slate-400">

                                    Belum ada jadwal poliklinik.

                                </td>

                            </tr>
                        @endforelse

                    </tbody>

                </table>

            </div>

        </div>

    </div>

</x-layouts.app>
<script>
    document.addEventListener('DOMContentLoaded', function() {

        @if ($antrianAktif)
            const jadwalAktifId = {{ (int) $antrianAktif->id_jadwal }};
        @else
            const jadwalAktifId = null;
        @endif

        if (!window.Echo) {
            console.error('Laravel Echo belum tersedia.');
            return;
        }

        window.Echo
            .channel('antrian')
            .listen('.antrian.updated', function(event) {

                console.log('Antrian updated:', event);

                const nomor =
                    event.nomor_sedang_dilayani ?? '-';

                // Update tabel jadwal
                const tabelElement =
                    document.getElementById(
                        'jadwal-antrian-' + event.jadwal_id
                    );

                if (tabelElement) {
                    tabelElement.textContent = nomor;
                }

                // Update banner antrean aktif pasien
                if (
                    jadwalAktifId !== null &&
                    parseInt(event.jadwal_id) === jadwalAktifId
                ) {
                    const bannerElement =
                        document.getElementById(
                            'nomor-sedang-dilayani'
                        );

                    if (bannerElement) {
                        bannerElement.textContent = nomor;
                    }
                }
            });
    });
</script>
