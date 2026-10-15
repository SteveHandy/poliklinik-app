<x-layouts.app title="Jadwal Periksa">

    {{-- Header --}}
    <div class="flex items-center justify-between mb-6">

        <h2 class="text-2xl font-bold text-slate-800">
            Jadwal Periksa
        </h2>

        <a href="{{ route('jadwal-periksa.create') }}"
            class="inline-flex items-center gap-2 px-5 py-2.5
                   bg-primary hover:bg-primary/90
                   text-white text-sm font-semibold
                   rounded-xl transition">

            <i class="fas fa-plus text-xs"></i>

            Tambah Jadwal

        </a>

    </div>


    {{-- Alert Error --}}
    @if (session('error'))
        <div class="alert alert-error mb-4 rounded-xl shadow-sm">

            <i class="fas fa-circle-xmark"></i>

            <span>
                {{ session('error') }}
            </span>

        </div>
    @endif


    {{-- Card --}}
    <div class="card bg-base-100 shadow-md rounded-2 border">

        <div class="card-body p-0">

            <div class="overflow-x-auto">

                <table class="table w-full">

                    {{-- Table Head --}}
                    <thead
                        class="bg-slate-50
                               text-slate-500
                               uppercase
                               text-xs
                               tracking-wider">

                        <tr>

                            <th class="px-6 py-4">
                                Hari
                            </th>

                            <th class="px-6 py-4">
                                Jam Mulai
                            </th>

                            <th class="px-6 py-4">
                                Jam Selesai
                            </th>

                            <th class="px-6 py-4">
                                Status
                            </th>

                            <th class="px-6 py-4 text-right">
                                Aksi
                            </th>

                        </tr>

                    </thead>


                    {{-- Table Body --}}
                    <tbody class="text-sm text-slate-700">

                        @forelse ($jadwals as $jadwal)
                            @php
                                /*
                                |--------------------------------------------------------------------------
                                | Status Jadwal
                                |--------------------------------------------------------------------------
                                */

                                $sekarang = \Carbon\Carbon::now();

                                $daftarHari = [
                                    0 => 'Minggu',
                                    1 => 'Senin',
                                    2 => 'Selasa',
                                    3 => 'Rabu',
                                    4 => 'Kamis',
                                    5 => 'Jumat',
                                    6 => 'Sabtu',
                                ];

                                $hariSekarang = $daftarHari[$sekarang->dayOfWeek];

                                /*
                                 * Membuat waktu mulai dan selesai
                                 * berdasarkan tanggal hari ini.
                                 */
                                $jamMulai = \Carbon\Carbon::today()->setTimeFromTimeString($jadwal->jam_mulai);

                                $jamSelesai = \Carbon\Carbon::today()->setTimeFromTimeString($jadwal->jam_selesai);

                                $status = 'Tidak Aktif';

                                $statusClass = '
                                    bg-slate-100
                                    text-slate-600
                                ';

                                $statusIcon = 'fa-circle-xmark';

                                if ($hariSekarang === $jadwal->hari) {
                                    if ($sekarang->lt($jamMulai)) {
                                        $status = 'Belum Mulai';

                                        $statusClass = '
                                            bg-amber-100
                                            text-amber-700
                                        ';

                                        $statusIcon = 'fa-clock';
                                    } elseif ($sekarang->betweenIncluded($jamMulai, $jamSelesai)) {
                                        $status = 'Aktif';

                                        $statusClass = '
                                            bg-emerald-100
                                            text-emerald-700
                                        ';

                                        $statusIcon = 'fa-circle-check';
                                    } else {
                                        $status = 'Selesai';

                                        $statusClass = '
                                            bg-blue-100
                                            text-blue-700
                                        ';

                                        $statusIcon = 'fa-check';
                                    }
                                }
                            @endphp


                            <tr
                                class="border-t border-slate-100
                                       hover:bg-slate-50
                                       transition">

                                {{-- Hari --}}
                                <td
                                    class="px-6 py-4
                                           font-semibold
                                           text-slate-800">

                                    {{ $jadwal->hari }}

                                </td>


                                {{-- Jam Mulai --}}
                                <td class="px-6 py-4 text-slate-600">

                                    {{ \Carbon\Carbon::parse($jadwal->jam_mulai)->format('H:i') }}

                                </td>


                                {{-- Jam Selesai --}}
                                <td class="px-6 py-4 text-slate-600">

                                    {{ \Carbon\Carbon::parse($jadwal->jam_selesai)->format('H:i') }}

                                </td>


                                {{-- Status --}}
                                <td class="px-6 py-4">

                                    <span
                                        class="inline-flex items-center gap-1.5
                                               px-3 py-1
                                               text-xs
                                               font-semibold
                                               rounded-full
                                               {{ $statusClass }}">

                                        <i class="fas {{ $statusIcon }} text-xs"></i>

                                        {{ $status }}

                                    </span>

                                </td>


                                {{-- Aksi --}}
                                <td class="px-6 py-4 text-right">

                                    <div class="flex justify-end gap-2">

                                        {{-- Edit --}}
                                        <a href="{{ route('jadwal-periksa.edit', $jadwal->id) }}"
                                            class="inline-flex items-center gap-1 px-4 py-2
                                                   bg-amber-500 hover:bg-amber-600
                                                   text-white text-xs font-semibold
                                                   rounded-lg transition">

                                            <i class="fas fa-pen text-xs"></i>

                                            Edit

                                        </a>


                                        {{-- Delete --}}
                                        <form action="{{ route('jadwal-periksa.destroy', $jadwal->id) }}"
                                            method="POST">

                                            @csrf
                                            @method('DELETE')

                                            <button type="submit"
                                                onclick="return confirm('Yakin ingin menghapus jadwal periksa ini?')"
                                                class="inline-flex items-center gap-1 px-4 py-2
                                                       bg-red-500 hover:bg-red-600
                                                       text-white text-xs font-semibold
                                                       rounded-lg transition">

                                                <i class="fas fa-trash text-xs"></i>

                                                Hapus

                                            </button>

                                        </form>

                                    </div>

                                </td>

                            </tr>

                        @empty

                            <tr>

                                <td colspan="5" class="text-center py-12 text-slate-400">

                                    <i
                                        class="fas fa-inbox
                                               text-3xl
                                               mb-3
                                               block">
                                    </i>

                                    Belum ada jadwal periksa

                                </td>

                            </tr>
                        @endforelse

                    </tbody>

                </table>

            </div>

        </div>

    </div>

</x-layouts.app>
