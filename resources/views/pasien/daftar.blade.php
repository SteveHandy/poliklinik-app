<x-layouts.app title="Pendaftaran Poli">

    <div class="max-w-3xl mx-auto">

        {{-- ================= HEADER ================= --}}
        <div class="text-center mb-6">

            <div
                class="inline-flex items-center justify-center
                       w-12 h-12
                       rounded-xl
                       bg-indigo-50
                       text-indigo-600
                       mb-3">

                <i class="fas fa-hospital-user text-xl"></i>

            </div>

            <h2 class="text-2xl font-bold text-slate-800">
                Pendaftaran Poli
            </h2>

            <p class="text-sm text-slate-500 mt-1">
                Pilih poli dan jadwal pemeriksaan yang tersedia.
            </p>

        </div>

        {{-- ================= ALERT ERROR ================= --}}
        @if (session('error'))
            <div
                class="alert alert-error
                       mb-5
                       rounded-xl
                       shadow-sm">

                <i class="fas fa-circle-xmark"></i>

                <span>
                    {{ session('error') }}
                </span>

            </div>
        @endif


        {{-- ================= VALIDATION ERROR ================= --}}
        @if ($errors->any())

            <div
                class="alert alert-error
                       mb-5
                       rounded-xl
                       shadow-sm">

                <i class="fas fa-circle-exclamation"></i>

                <div>

                    <p class="font-semibold">
                        Terdapat data yang belum benar.
                    </p>

                    <ul class="text-sm list-disc list-inside mt-1">

                        @foreach ($errors->all() as $error)
                            <li>
                                {{ $error }}
                            </li>
                        @endforeach

                    </ul>

                </div>

            </div>

        @endif


        {{-- ================= CARD FORM ================= --}}
        <div
            class="card
                   bg-base-100
                   shadow-md
                   rounded-2xl
                   border border-slate-200">

            <div class="card-body p-6 md:p-8">

                <form action="{{ route('pasien.daftar.submit') }}" method="POST" id="form-daftar-poli">

                    @csrf
                    <input type="hidden" name="id_pasien" value="{{ Auth::user()->id }}">
                    {{-- ================= NO RM ================= --}}
                    <div class="mb-5">

                        <label for="no_rm"
                            class="block
                                   text-sm
                                   font-semibold
                                   text-slate-700
                                   mb-2">

                            Nomor Rekam Medis

                        </label>


                        <div class="relative">

                            <span
                                class="absolute
                                       left-4
                                       top-1/2
                                       -translate-y-1/2
                                       text-slate-400">

                                <i class="fas fa-id-card"></i>

                            </span>


                            <input type="text" id="no_rm" value="{{ Auth::user()->no_rm ?? '-' }}" readonly
                                class="w-full
                                       pl-11 pr-4 py-2.5
                                       rounded-lg
                                       border-2
                                       border-slate-200
                                       bg-slate-50
                                       text-slate-600
                                       text-sm
                                       cursor-not-allowed">

                        </div>

                    </div>


                    {{-- ================= PILIH POLI ================= --}}
                    <div class="mb-5">

                        <label for="poli"
                            class="block
                                   text-sm
                                   font-semibold
                                   text-slate-700
                                   mb-2">

                            Pilih Poli

                            <span class="text-red-500">
                                *
                            </span>

                        </label>


                        <select name="id_poli" id="poli"
                            class="w-full
                                   px-4 py-2.5
                                   rounded-lg
                                   border-2
                                   bg-white
                                   text-sm
                                   focus:outline-none
                                   focus:border-primary
                                   @error('id_poli')
                                       border-red-500
                                   @else
                                       border-slate-300
                                   @enderror"
                            required>

                            <option value="">
                                -- Pilih Poli --
                            </option>


                            @foreach ($polis as $poli)
                                <option value="{{ $poli->id }}" {{ old('id_poli') == $poli->id ? 'selected' : '' }}>

                                    {{ $poli->nama_poli }}

                                </option>
                            @endforeach

                        </select>


                        @error('id_poli')
                            <p class="text-sm text-red-500 mt-1">
                                {{ $message }}
                            </p>
                        @enderror

                    </div>


                    {{-- ================= PILIH JADWAL ================= --}}
                    <div class="mb-5">

                        <label for="id_jadwal"
                            class="block
                                   text-sm
                                   font-semibold
                                   text-slate-700
                                   mb-2">

                            Pilih Jadwal Periksa

                            <span class="text-red-500">
                                *
                            </span>

                        </label>


                        <select name="id_jadwal" id="id_jadwal"
                            class="w-full
                                   px-4 py-2.5
                                   rounded-lg
                                   border-2
                                   bg-white
                                   text-sm
                                   focus:outline-none
                                   focus:border-primary
                                   disabled:bg-slate-100
                                   disabled:text-slate-400
                                   disabled:cursor-not-allowed
                                   @error('id_jadwal')
                                       border-red-500
                                   @else
                                       border-slate-300
                                   @enderror"
                            disabled required>

                            <option value="">
                                -- Pilih Poli Terlebih Dahulu --
                            </option>


                            @foreach ($jadwals as $jadwal)
                                <option value="{{ $jadwal->id }}" data-poli="{{ $jadwal->dokter->id_poli ?? '' }}"
                                    data-hari="{{ $jadwal->hari }}" data-jam-mulai="{{ $jadwal->jam_mulai }}"
                                    data-jam-selesai="{{ $jadwal->jam_selesai }}"
                                    data-dokter="{{ $jadwal->dokter->nama ?? '-' }}"
                                    {{ old('id_jadwal') == $jadwal->id ? 'selected' : '' }}>

                                    {{ $jadwal->hari }}
                                    |
                                    {{ \Carbon\Carbon::parse($jadwal->jam_mulai)->format('H:i') }}
                                    -
                                    {{ \Carbon\Carbon::parse($jadwal->jam_selesai)->format('H:i') }}
                                    |
                                    dr. {{ $jadwal->dokter->nama ?? '-' }}

                                </option>
                            @endforeach

                        </select>


                        @error('id_jadwal')
                            <p class="text-sm text-red-500 mt-1">
                                {{ $message }}
                            </p>
                        @enderror


                        {{-- Info jadwal --}}
                        <div id="jadwal-info"
                            class="hidden
                                   mt-3
                                   p-4
                                   rounded-xl
                                   bg-indigo-50
                                   border border-indigo-100">

                            <div class="flex items-start gap-3">

                                <div
                                    class="flex
                                           items-center
                                           justify-center
                                           w-9 h-9
                                           shrink-0
                                           rounded-lg
                                           bg-white
                                           text-indigo-600">

                                    <i class="fas fa-calendar-check"></i>

                                </div>


                                <div>

                                    <p id="jadwal-info-dokter"
                                        class="text-sm
                                               font-semibold
                                               text-slate-800">
                                    </p>

                                    <p id="jadwal-info-waktu"
                                        class="text-sm
                                               text-slate-500
                                               mt-1">
                                    </p>

                                </div>

                            </div>

                        </div>

                    </div>


                    {{-- ================= KELUHAN ================= --}}
                    <div class="mb-6">

                        <label for="keluhan"
                            class="block
                                   text-sm
                                   font-semibold
                                   text-slate-700
                                   mb-2">

                            Keluhan

                            <span class="text-red-500">
                                *
                            </span>

                        </label>


                        <textarea name="keluhan" id="keluhan" rows="4" placeholder="Tulis keluhan anda..."
                            class="w-full
                                   px-4 py-3
                                   rounded-lg
                                   border-2
                                   text-sm
                                   resize-none
                                   focus:outline-none
                                   focus:border-primary
                                   @error('keluhan')
                                       border-red-500
                                   @else
                                       border-slate-300
                                   @enderror"
                            required>{{ old('keluhan') }}</textarea>


                        @error('keluhan')
                            <p class="text-sm text-red-500 mt-1">
                                {{ $message }}
                            </p>
                        @enderror

                    </div>


                    {{-- ================= BUTTON ================= --}}
                    <div class="flex justify-end">

                        <button type="submit"
                            class="inline-flex
                                   items-center
                                   justify-center
                                   gap-2
                                   px-5 py-2.5
                                   rounded-lg
                                   bg-primary
                                   hover:bg-primary/90
                                   text-white
                                   text-sm
                                   font-semibold
                                   transition">

                            <i class="fas fa-file-circle-plus"></i>

                            Daftar Poli

                        </button>

                    </div>

                </form>

            </div>

        </div>

    </div>


    {{-- ================= JAVASCRIPT ================= --}}
    <script>
        document.addEventListener('DOMContentLoaded', function() {

            const poliSelect = document.getElementById('poli');
            const jadwalSelect = document.getElementById('id_jadwal');

            const jadwalInfo = document.getElementById('jadwal-info');
            const jadwalInfoDokter =
                document.getElementById('jadwal-info-dokter');

            const jadwalInfoWaktu =
                document.getElementById('jadwal-info-waktu');


            /*
            |--------------------------------------------------------------------------
            | Simpan seluruh option jadwal
            |--------------------------------------------------------------------------
            */

            const semuaJadwal = Array.from(
                jadwalSelect.querySelectorAll('option')
            ).filter(option => option.value !== '');

            function formatJam(jam) {
                if (!jam) {
                    return '';
                }
                return jam.substring(0, 5);
            }

            function filterJadwal() {

                const poliId = poliSelect.value;

                const oldJadwal =
                    "{{ old('id_jadwal') }}";


                jadwalSelect.innerHTML = '';

                jadwalInfo.classList.add('hidden');

                if (!poliId) {

                    jadwalSelect.disabled = true;


                    const option = document.createElement('option');

                    option.value = '';

                    option.textContent =
                        '-- Pilih Poli Terlebih Dahulu --';


                    jadwalSelect.appendChild(option);

                    return;

                }

                jadwalSelect.disabled = false;


                const placeholder =
                    document.createElement('option');

                placeholder.value = '';

                placeholder.textContent =
                    '-- Pilih Jadwal --';

                jadwalSelect.appendChild(placeholder);

                const jadwalSesuaiPoli =
                    semuaJadwal.filter(function(option) {

                        return option.dataset.poli === poliId;

                    });

                if (jadwalSesuaiPoli.length === 0) {

                    jadwalSelect.disabled = true;

                    placeholder.textContent =
                        '-- Tidak Ada Jadwal Tersedia --';

                    return;

                }
                jadwalSesuaiPoli.forEach(function(option) {

                    const clonedOption =
                        option.cloneNode(true);


                    if (
                        oldJadwal &&
                        clonedOption.value === oldJadwal
                    ) {

                        clonedOption.selected = true;

                    }


                    jadwalSelect.appendChild(clonedOption);

                });

                if (oldJadwal) {

                    tampilkanInfoJadwal();

                }

            }


            function tampilkanInfoJadwal() {

                const selectedOption =
                    jadwalSelect.options[
                        jadwalSelect.selectedIndex
                    ];


                if (
                    !selectedOption ||
                    !selectedOption.value
                ) {

                    jadwalInfo.classList.add('hidden');

                    return;

                }


                const dokter =
                    selectedOption.dataset.dokter;

                const hari =
                    selectedOption.dataset.hari;

                const jamMulai =
                    formatJam(
                        selectedOption.dataset.jamMulai
                    );

                const jamSelesai =
                    formatJam(
                        selectedOption.dataset.jamSelesai
                    );


                jadwalInfoDokter.textContent =
                    'dr. ' + dokter;


                jadwalInfoWaktu.textContent =
                    hari +
                    ', ' +
                    jamMulai +
                    ' - ' +
                    jamSelesai;


                jadwalInfo.classList.remove('hidden');

            }


            /*
            |--------------------------------------------------------------------------
            | Event Poli
            |--------------------------------------------------------------------------
            */

            poliSelect.addEventListener(
                'change',
                function() {

                    filterJadwal();

                }
            );


            /*
            |--------------------------------------------------------------------------
            | Event Jadwal
            |--------------------------------------------------------------------------
            */

            jadwalSelect.addEventListener(
                'change',
                function() {

                    tampilkanInfoJadwal();

                }
            );


            /*
            |--------------------------------------------------------------------------
            | Initial
            |--------------------------------------------------------------------------
            */

            filterJadwal();

        });
    </script>

</x-layouts.app>
