<x-layouts.app title="Edit Jadwal Periksa">

    {{-- ================= HEADER ================= --}}
    <div class="flex items-center gap-3 mb-6">

        <a href="{{ route('jadwal-periksa.index') }}"
            class="flex items-center justify-center
                   w-10 h-10
                   rounded-lg
                   bg-slate-100
                   hover:bg-slate-200
                   text-slate-600
                   transition">

            <i class="fas fa-arrow-left text-sm"></i>

        </a>


        <div>

            <h2 class="text-2xl font-bold text-slate-800">
                Edit Jadwal Periksa
            </h2>

            <p class="text-sm text-slate-500 mt-1">
                Perbarui hari atau jam praktik Anda.
            </p>

        </div>

    </div>


    {{-- ================= FORM CARD ================= --}}
    <div
        class="card bg-base-100
               shadow-md
               rounded-2xl
               border border-slate-200">

        <div class="card-body p-6 md:p-8">

            <form action="{{ route('jadwal-periksa.update', $jadwal_periksa->id) }}" method="POST">

                @csrf
                @method('PUT')


                <div
                    class="grid grid-cols-1
                           md:grid-cols-2
                           gap-6">

                    {{-- ================= HARI ================= --}}
                    <div class="md:col-span-2">

                        <label for="hari"
                            class="block
                                   text-sm
                                   font-semibold
                                   text-slate-700
                                   mb-2">

                            Hari

                            <span class="text-red-500">
                                *
                            </span>

                        </label>


                        <select name="hari" id="hari"
                            class="w-full
                                   px-4 py-2.5
                                   rounded-lg
                                   border-2
                                   bg-white
                                   focus:border-primary
                                   focus:outline-none
                                   @error('hari')
                                       border-red-500
                                   @else
                                       border-slate-300
                                   @enderror"
                            required>

                            <option value="">
                                -- Pilih Hari --
                            </option>


                            <option value="Senin"
                                {{ old('hari', $jadwal_periksa->hari) === 'Senin' ? 'selected' : '' }}>
                                Senin
                            </option>


                            <option value="Selasa"
                                {{ old('hari', $jadwal_periksa->hari) === 'Selasa' ? 'selected' : '' }}>
                                Selasa
                            </option>


                            <option value="Rabu"
                                {{ old('hari', $jadwal_periksa->hari) === 'Rabu' ? 'selected' : '' }}>
                                Rabu
                            </option>


                            <option value="Kamis"
                                {{ old('hari', $jadwal_periksa->hari) === 'Kamis' ? 'selected' : '' }}>
                                Kamis
                            </option>


                            <option value="Jumat"
                                {{ old('hari', $jadwal_periksa->hari) === 'Jumat' ? 'selected' : '' }}>
                                Jumat
                            </option>


                            <option value="Sabtu"
                                {{ old('hari', $jadwal_periksa->hari) === 'Sabtu' ? 'selected' : '' }}>
                                Sabtu
                            </option>


                            <option value="Minggu"
                                {{ old('hari', $jadwal_periksa->hari) === 'Minggu' ? 'selected' : '' }}>
                                Minggu
                            </option>

                        </select>


                        @error('hari')
                            <p class="text-sm text-red-500 mt-1">
                                {{ $message }}
                            </p>
                        @enderror

                    </div>


                    {{-- ================= JAM MULAI ================= --}}
                    <div>

                        <label for="jam_mulai"
                            class="block
                                   text-sm
                                   font-semibold
                                   text-slate-700
                                   mb-2">

                            Jam Mulai

                            <span class="text-red-500">
                                *
                            </span>

                        </label>


                        <input type="time" name="jam_mulai" id="jam_mulai"
                            value="{{ old('jam_mulai', substr($jadwal_periksa->jam_mulai, 0, 5)) }}"
                            class="w-full
                                   px-4 py-2.5
                                   rounded-lg
                                   border-2
                                   focus:border-primary
                                   focus:outline-none
                                   @error('jam_mulai')
                                       border-red-500
                                   @else
                                       border-slate-300
                                   @enderror"
                            required>


                        @error('jam_mulai')
                            <p class="text-sm text-red-500 mt-1">
                                {{ $message }}
                            </p>
                        @enderror

                    </div>


                    {{-- ================= JAM SELESAI ================= --}}
                    <div>

                        <label for="jam_selesai"
                            class="block
                                   text-sm
                                   font-semibold
                                   text-slate-700
                                   mb-2">

                            Jam Selesai

                            <span class="text-red-500">
                                *
                            </span>

                        </label>


                        <input type="time" name="jam_selesai" id="jam_selesai"
                            value="{{ old('jam_selesai', substr($jadwal_periksa->jam_selesai, 0, 5)) }}"
                            class="w-full
                                   px-4 py-2.5
                                   rounded-lg
                                   border-2
                                   focus:border-primary
                                   focus:outline-none
                                   @error('jam_selesai')
                                       border-red-500
                                   @else
                                       border-slate-300
                                   @enderror"
                            required>


                        @error('jam_selesai')
                            <p class="text-sm text-red-500 mt-1">
                                {{ $message }}
                            </p>
                        @enderror

                    </div>

                </div>


                {{-- ================= INFO ================= --}}
                <div
                    class="flex items-start gap-3
                           bg-amber-50
                           border border-amber-100
                           rounded-xl
                           p-4
                           mt-6">

                    <i
                        class="fas fa-triangle-exclamation
                               text-amber-500
                               mt-0.5">
                    </i>

                    <p class="text-sm text-amber-700">

                        Perubahan jadwal akan langsung tersimpan setelah Anda menekan tombol update.

                    </p>

                </div>


                {{-- ================= BUTTON ================= --}}
                <div
                    class="flex flex-col-reverse
                           sm:flex-row
                           gap-3
                           mt-8">

                    <a href="{{ route('jadwal-periksa.index') }}"
                        class="inline-flex
                               items-center
                               justify-center
                               px-6 py-2.5
                               rounded-lg
                               bg-slate-100
                               hover:bg-slate-200
                               text-slate-600
                               font-semibold
                               text-sm
                               transition">

                        Batal

                    </a>


                    <button type="submit"
                        class="inline-flex
                               items-center
                               justify-center
                               gap-2
                               px-6 py-2.5
                               rounded-lg
                               bg-primary
                               hover:bg-primary/90
                               text-white
                               font-semibold
                               text-sm
                               transition">

                        <i class="fas fa-save"></i>

                        Update Jadwal

                    </button>

                </div>

            </form>

        </div>

    </div>

</x-layouts.app>
