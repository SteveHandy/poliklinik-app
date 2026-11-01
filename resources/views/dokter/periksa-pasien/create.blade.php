<x-layouts.app title="Periksa Pasien">

    {{-- ================= HEADER ================= --}}
    <div class="flex items-center gap-3 mb-6">

        <a href="{{ route('periksa-pasien.index') }}"
            class="flex items-center justify-center
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
                Periksa Pasien
            </h2>

            <p class="text-sm text-slate-500 mt-1">
                Tambahkan obat dan catatan hasil pemeriksaan pasien.
            </p>
        </div>

    </div>


    {{-- ================= VALIDATION ERROR ================= --}}
    @if ($errors->any())

        <div class="alert alert-error mb-5 rounded-xl shadow-sm">

            <i class="fas fa-circle-exclamation"></i>

            <div>
                <p class="font-semibold">
                    Terdapat data yang belum benar.
                </p>

                <ul class="list-disc list-inside text-sm mt-1">

                    @foreach ($errors->all() as $error)
                        <li>
                            {{ $error }}
                        </li>
                    @endforeach

                </ul>
            </div>

        </div>

    @endif


    {{-- ================= INFORMASI PASIEN ================= --}}
    <div
        class="card bg-base-100
               shadow-md
               rounded-2xl
               border border-slate-200
               mb-5">

        <div class="card-body p-6">

            <div
                class="grid
                       grid-cols-1
                       md:grid-cols-3
                       gap-5">

                {{-- Pasien --}}
                <div>

                    <p
                        class="text-xs
                               uppercase
                               tracking-wider
                               font-semibold
                               text-slate-400">

                        Pasien

                    </p>

                    <p
                        class="text-sm
                               font-semibold
                               text-slate-800
                               mt-1">

                        {{ $id->pasien->nama ?? '-' }}

                    </p>

                    @if ($id->pasien && $id->pasien->no_rm)
                        <p class="text-xs text-slate-400 mt-1">
                            RM: {{ $id->pasien->no_rm }}
                        </p>
                    @endif

                </div>


                {{-- Keluhan --}}
                <div>

                    <p
                        class="text-xs
                               uppercase
                               tracking-wider
                               font-semibold
                               text-slate-400">

                        Keluhan

                    </p>

                    <p
                        class="text-sm
                               text-slate-700
                               mt-1">

                        {{ $id->keluhan ?? '-' }}

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

                    <p
                        class="text-sm
                               font-semibold
                               text-slate-800
                               mt-1">

                        {{ $id->no_antrian }}

                    </p>

                </div>

            </div>

        </div>

    </div>


    {{-- ================= FORM PEMERIKSAAN ================= --}}
    <div
        class="card bg-base-100
               shadow-md
               rounded-2xl
               border border-slate-200">

        <div class="card-body p-6">

            <form action="{{ route('periksa-pasien.store') }}" method="POST" id="form-periksa">

                @csrf


                {{-- ================= HIDDEN INPUT ================= --}}

                <input type="hidden" name="id_daftar_poli" value="{{ $id->id }}">

                <input type="hidden" name="obat_json" id="obat_json" value="[]">

                <input type="hidden" name="biaya_periksa" id="biaya_periksa" value="0">


                {{-- ================= PILIH OBAT ================= --}}
                <div class="mb-5">

                    <label for="pilih-obat"
                        class="block
                               text-sm
                               font-semibold
                               text-slate-700
                               mb-2">

                        Pilih Obat

                        <span class="text-red-500">
                            *
                        </span>

                    </label>


                    <select id="pilih-obat"
                        class="w-full
                               px-4 py-2.5
                               rounded-lg
                               border
                               border-slate-300
                               bg-white
                               text-sm
                               focus:outline-none
                               focus:border-primary">

                        <option value="">
                            -- Pilih Obat --
                        </option>

                        @foreach ($obats as $obat)
                            <option value="{{ $obat->id }}" data-nama="{{ $obat->nama_obat }}"
                                data-kemasan="{{ $obat->kemasan }}" data-harga="{{ $obat->harga }}">

                                {{ $obat->nama_obat }}
                                - {{ $obat->kemasan }}
                                - Rp {{ number_format($obat->harga, 0, ',', '.') }}

                            </option>
                        @endforeach

                    </select>


                    @error('obat_json')
                        <p class="text-sm text-red-500 mt-1">
                            {{ $message }}
                        </p>
                    @enderror

                </div>


                {{-- ================= OBAT TERPILIH ================= --}}
                <div class="mb-5">

                    <label
                        class="block
                               text-sm
                               font-semibold
                               text-slate-700
                               mb-2">

                        Obat Terpilih

                    </label>


                    <div id="daftar-obat" class="flex flex-wrap gap-2">

                        <span id="obat-kosong" class="text-sm text-slate-400">

                            Belum ada obat yang dipilih.

                        </span>

                    </div>

                </div>


                {{-- ================= TOTAL HARGA ================= --}}
                <div class="mb-5">

                    <label
                        class="block
                               text-sm
                               font-semibold
                               text-slate-700
                               mb-2">

                        Total Harga

                    </label>


                    <div
                        class="w-full
                               px-4 py-2.5
                               rounded-lg
                               bg-slate-50
                               border border-slate-100">

                        <span id="total-harga"
                            class="text-sm
                                   font-semibold
                                   text-slate-800">

                            Rp 0

                        </span>

                    </div>

                </div>


                {{-- ================= CATATAN ================= --}}
                <div class="mb-5">

                    <label for="catatan"
                        class="block
                               text-sm
                               font-semibold
                               text-slate-700
                               mb-2">

                        Catatan

                        <span class="font-normal
                                   text-slate-400">

                            (Opsional)

                        </span>

                    </label>


                    <textarea name="catatan" id="catatan" rows="4" placeholder="Masukkan catatan..."
                        class="w-full
                               px-4 py-3
                               rounded-lg
                               border
                               resize-none
                               text-sm
                               focus:outline-none
                               focus:border-primary
                               @error('catatan')
                                   border-red-500
                               @else
                                   border-slate-300
                               @enderror">{{ old('catatan') }}</textarea>


                    @error('catatan')
                        <p class="text-sm text-red-500 mt-1">
                            {{ $message }}
                        </p>
                    @enderror

                </div>


                {{-- ================= BUTTON ================= --}}
                <div class="flex items-center gap-2">

                    <button type="submit"
                        class="inline-flex
                               items-center
                               gap-2
                               px-4 py-2
                               rounded-lg
                               bg-primary
                               hover:bg-primary/90
                               text-white
                               text-sm
                               font-semibold
                               transition">

                        <i class="fas fa-save text-xs"></i>

                        Simpan

                    </button>


                    <a href="{{ route('periksa-pasien.index') }}"
                        class="inline-flex
                               items-center
                               px-4 py-2
                               rounded-lg
                               bg-slate-100
                               hover:bg-slate-200
                               text-slate-600
                               text-sm
                               font-semibold
                               transition">

                        Batal

                    </a>

                </div>

            </form>

        </div>

    </div>


    {{-- ================= SCRIPT ================= --}}
    <script>
        document.addEventListener('DOMContentLoaded', function() {

            const selectObat =
                document.getElementById('pilih-obat');

            const daftarObat =
                document.getElementById('daftar-obat');

            const obatKosong =
                document.getElementById('obat-kosong');

            const totalHarga =
                document.getElementById('total-harga');

            const obatJson =
                document.getElementById('obat_json');

            const biayaPeriksa =
                document.getElementById('biaya_periksa');

            const formPeriksa =
                document.getElementById('form-periksa');


            let obatTerpilih = {};


            /*
            |--------------------------------------------------------------------------
            | Format Rupiah
            |--------------------------------------------------------------------------
            */

            function formatRupiah(value) {

                return 'Rp ' + new Intl.NumberFormat('id-ID').format(value);

            }


            /*
            |--------------------------------------------------------------------------
            | Update Data
            |--------------------------------------------------------------------------
            */

            function updateData() {

                const ids = Object.keys(obatTerpilih);

                let total = 0;


                Object.values(obatTerpilih).forEach(function(obat) {

                    total += Number(obat.harga);

                });


                /*
                 * Controller meminta JSON ID obat.
                 */
                obatJson.value = JSON.stringify(ids);


                /*
                 * Controller menambahkan Rp 150.000 sendiri.
                 * Jadi yang dikirim di sini hanya total obat.
                 */
                biayaPeriksa.value = total;


                totalHarga.textContent =
                    formatRupiah(total);

            }


            /*
            |--------------------------------------------------------------------------
            | Render Obat
            |--------------------------------------------------------------------------
            */

            function renderObat() {

                daftarObat.innerHTML = '';


                const ids = Object.keys(obatTerpilih);


                if (ids.length === 0) {

                    daftarObat.innerHTML = `

                        <span
                            id="obat-kosong"
                            class="text-sm text-slate-400">

                            Belum ada obat yang dipilih.

                        </span>

                    `;

                    updateData();

                    return;
                }


                ids.forEach(function(id) {

                    const obat =
                        obatTerpilih[id];


                    const item =
                        document.createElement('div');


                    item.className =
                        'inline-flex items-center gap-2 ' +
                        'px-3 py-2 ' +
                        'bg-indigo-50 ' +
                        'border border-indigo-100 ' +
                        'rounded-lg ' +
                        'text-sm text-indigo-700';


                    item.innerHTML = `

                        <span>

                            ${obat.nama}

                            <span class="text-indigo-400">

                                -
                                ${formatRupiah(obat.harga)}

                            </span>

                        </span>


                        <button
                            type="button"
                            data-id="${id}"
                            class="hapus-obat
                                   flex items-center
                                   justify-center
                                   w-5 h-5
                                   rounded
                                   text-red-500
                                   hover:bg-red-100">

                            <i class="fas fa-xmark text-xs"></i>

                        </button>

                    `;


                    daftarObat.appendChild(item);

                });


                document
                    .querySelectorAll('.hapus-obat')
                    .forEach(function(button) {

                        button.addEventListener(
                            'click',
                            function() {

                                const id =
                                    this.dataset.id;


                                delete obatTerpilih[id];


                                renderObat();

                            }
                        );

                    });


                updateData();

            }


            /*
            |--------------------------------------------------------------------------
            | Pilih Obat
            |--------------------------------------------------------------------------
            */

            selectObat.addEventListener(
                'change',
                function() {

                    const option =
                        this.options[
                            this.selectedIndex
                        ];


                    const id =
                        option.value;


                    if (!id) {
                        return;
                    }


                    /*
                     * Cegah obat sama ditambahkan dua kali.
                     */
                    if (obatTerpilih[id]) {

                        this.value = '';

                        return;

                    }


                    obatTerpilih[id] = {

                        id: id,

                        nama: option.dataset.nama,

                        kemasan: option.dataset.kemasan,

                        harga: Number(
                            option.dataset.harga
                        )

                    };


                    /*
                     * Reset dropdown setelah dipilih.
                     */
                    this.value = '';


                    renderObat();

                }
            );


            /*
            |--------------------------------------------------------------------------
            | Validasi sebelum submit
            |--------------------------------------------------------------------------
            */

            formPeriksa.addEventListener(
                'submit',
                function(event) {

                    const ids =
                        Object.keys(obatTerpilih);


                    if (ids.length === 0) {

                        event.preventDefault();

                        alert(
                            'Pilih minimal satu obat terlebih dahulu.'
                        );

                        return;
                    }


                    updateData();

                }
            );


            /*
            |--------------------------------------------------------------------------
            | Initial
            |--------------------------------------------------------------------------
            */

            updateData();

        });
    </script>

</x-layouts.app>
