<?= $this->extend('layout/layout') ?>

<?= $this->section('content') ?>

<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
<script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>

<style>
    /* CSS Kustom Select2 untuk tampilan yang responsif dan simetris */
    .select2-container .select2-selection--single {
        height: 48px !important;
        display: flex !important;
        align-items: center !important;
        border: 1px solid #D1D5DB;
        /* border-gray-300 */
        border-radius: 0.5rem;
        /* rounded-lg */
        width: 100% !important;
        /* Memastikan lebar 100% di semua layar */
    }

    .select2-container--default.select2-container--focus .select2-selection--single {
        border-color: #FBBF24;
        /* focus:border-amber-500 */
        box-shadow: 0 0 0 2px rgba(251, 191, 36, 0.5);
        /* focus:ring-2 */
    }

    .select2-container--default .select2-selection--single .select2-selection__rendered {
        line-height: 46px;
        /* Tinggi baris untuk sentralisasi vertikal */
        padding-left: 1rem;
        /* px-4 */
        padding-right: 1rem;
        /* px-4 */
        color: #4B5563;
        /* text-gray-700 */
    }

    /* Mengatur tampilan panah dropdown */
    .select2-container--default .select2-selection--single .select2-selection__arrow {
        height: 46px;
        width: 20px;
        right: 8px;
    }

    /* Mengatur tampilan tombol "x" */
    .select2-container--default .select2-selection--single .select2-selection__clear {
        color: #F59E0B;
        /* Warna oranye */
        font-size: 1.25rem;
        position: absolute;
        right: 32px;
        line-height: 46px;
    }

    .select2-container--default .select2-selection--single .select2-selection__clear:hover {
        color: #D97706;
        /* Warna oranye gelap saat hover */
    }

    /* Styling dropdown pencarian */
    .select2-dropdown {
        border-color: #D1D5DB;
        border-radius: 0.5rem;
        box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1), 0 2px 4px -1px rgba(0, 0, 0, 0.06);
    }

    .select2-results__option {
        padding: 0.75rem 1rem;
        font-size: 0.875rem;
    }

    .select2-results__option--highlighted {
        background-color: #FEF3C7 !important;
        /* bg-amber-100 */
        color: #92400E !important;
        /* text-amber-800 */
    }

    .select2-search__field {
        border-radius: 0.5rem !important;
        border: 1px solid #D1D5DB !important;
        padding: 0.5rem 1rem !important;
        font-size: 0.875rem;
    }
</style>

<div class="container mx-auto px-4 py-8 sm:px-6 lg:px-8">
    <div class="bg-white shadow-xl rounded-xl p-6 md:p-8 lg:p-10">
        <h2 class="text-3xl font-extrabold text-amber-600 tracking-tight mb-8 text-center">
            <?= $title ?>
        </h2>

        <?php if (session()->getFlashdata('errors')): ?>
            <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative mb-4" role="alert">
                <strong class="font-bold">Validasi Gagal!</strong>
                <span class="block sm:inline">Harap perbaiki kesalahan berikut:</span>
                <ul class="mt-2 list-disc list-inside">
                    <?php foreach (session()->getFlashdata('errors') as $error): ?>
                        <li><?= esc($error) ?></li>
                    <?php endforeach; ?>
                </ul>
            </div>
        <?php endif; ?>

        <form action="<?= base_url('tickets/update/' . $ticket['id']) ?>" method="post" class="space-y-6">
            <?= csrf_field() ?>
            <input type="hidden" name="_method" value="PUT">

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <label for="code_ticket" class="block text-gray-700 text-sm font-bold mb-2">Kode Tiket:</label>
                    <input type="text" name="code_ticket" id="code_ticket" readonly
                        value="<?= old('code_ticket', $ticket['code_ticket']) ?>"
                        class="shadow appearance-none border rounded-lg w-full py-3 px-4 text-gray-700 leading-tight focus:outline-none focus:ring-2 focus:ring-amber-500 focus:border-transparent bg-gray-100 cursor-not-allowed">
                </div>
                <div>
                    <label for="tanggal_buat" class="block text-gray-700 text-sm font-bold mb-2">Tanggal Buat:</label>
                    <input type="datetime-local" name="tanggal_buat" id="tanggal_buat" readonly
                        value="<?= old('tanggal_buat', date('Y-m-d\TH:i', strtotime($ticket['tanggal_buat']))) ?>"
                        class="shadow appearance-none border rounded-lg w-full py-3 px-4 text-gray-700 leading-tight focus:outline-none focus:ring-2 focus:ring-amber-500 focus:border-transparent bg-gray-100 cursor-not-allowed">
                </div>
            </div>

            <hr class="border-gray-200 my-6">
            <h3 class="text-xl font-semibold text-gray-800 mb-4">Informasi Customer</h3>

            <div class="mb-4">
                <label for="customer_id" class="block text-gray-700 text-sm font-bold mb-2">Pilih Customer:</label>
                <select name="customer_id" id="customer_id"
                    class="shadow appearance-none border rounded-lg w-full py-3 px-4 text-gray-800 leading-tight focus:outline-none focus:ring-2 focus:ring-amber-500 focus:border-transparent
                    <?= $validation->hasError('customer_id') ? 'border-red-500' : '' ?>">
                    <option value="">-- Custom Input Customer --</option>
                    <?php foreach ($customers as $customer): ?>
                        <option value="<?= $customer['id'] ?>"
                            <?= (old('customer_id', $ticket['customer_id']) == $customer['id']) ? 'selected' : '' ?>>
                            <?= esc($customer['id_customer']) ?> - <?= esc($customer['nama_customer']) ?>
                        </option>
                    <?php endforeach; ?>
                </select>
                <?php if ($validation->hasError('customer_id')): ?>
                    <p class="text-red-500 text-xs italic mt-1"><?= $validation->getError('customer_id') ?></p>
                <?php endif; ?>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <label for="nama_customer_ticket" class="block text-gray-700 text-sm font-bold mb-2">Nama Customer:</label>
                    <input type="text" name="nama_customer_ticket" id="nama_customer_ticket"
                        value="<?= old('nama_customer_ticket', $ticket['nama_customer_ticket']) ?>"
                        class="shadow appearance-none border rounded-lg w-full py-3 px-4 text-gray-700 leading-tight focus:outline-none focus:ring-2 focus:ring-amber-500 focus:border-transparent
                        <?= $validation->hasError('nama_customer_ticket') ? 'border-red-500' : '' ?>"
                        placeholder="Nama customer">
                    <?php if ($validation->hasError('nama_customer_ticket')): ?>
                        <p class="text-red-500 text-xs italic mt-1"><?= $validation->getError('nama_customer_ticket') ?></p>
                    <?php endif; ?>
                </div>
                <div>
                    <label for="no_hp_customer_ticket" class="block text-gray-700 text-sm font-bold mb-2">No. HP Customer:</label>
                    <input type="text" name="no_hp_customer_ticket" id="no_hp_customer_ticket"
                        value="<?= old('no_hp_customer_ticket', $ticket['no_hp_customer_ticket']) ?>"
                        class="shadow appearance-none border rounded-lg w-full py-3 px-4 text-gray-700 leading-tight focus:outline-none focus:ring-2 focus:ring-amber-500 focus:border-transparent
                        <?= $validation->hasError('no_hp_customer_ticket') ? 'border-red-500' : '' ?>"
                        placeholder="Nomor HP customer">
                    <?php if ($validation->hasError('no_hp_customer_ticket')): ?>
                        <p class="text-red-500 text-xs italic mt-1"><?= $validation->getError('no_hp_customer_ticket') ?></p>
                    <?php endif; ?>
                </div>
            </div>
            <div class="mb-4">
                <label for="alamat_customer_ticket" class="block text-gray-700 text-sm font-bold mb-2">Alamat Customer:</label>
                <textarea name="alamat_customer_ticket" id="alamat_customer_ticket" rows="3"
                    class="shadow appearance-none border rounded-lg w-full py-3 px-4 text-gray-700 leading-tight focus:outline-none focus:ring-2 focus:ring-amber-500 focus:border-transparent
                    <?= $validation->hasError('alamat_customer_ticket') ? 'border-red-500' : '' ?>"
                    placeholder="Alamat customer"><?= old('alamat_customer_ticket', $ticket['alamat_customer_ticket']) ?></textarea>
                <?php if ($validation->hasError('alamat_customer_ticket')): ?>
                    <p class="text-red-500 text-xs italic mt-1"><?= $validation->getError('alamat_customer_ticket') ?></p>
                <?php endif; ?>
            </div>

            <hr class="border-gray-200 my-6">
            <h3 class="text-xl font-semibold text-gray-800 mb-4">Detail Tiket</h3>

            <div class="mb-4">
                <label for="keluhan" class="block text-gray-700 text-sm font-bold mb-2">Kategori Tiket:</label>
                <select name="keluhan" id="keluhan"
                    class="shadow appearance-none border rounded-lg w-full py-3 px-4 text-gray-700 leading-tight focus:outline-none focus:ring-2 focus:ring-amber-500 focus:border-transparent
                                <?= $validation->hasError('keluhan') ? 'border-red-500' : '' ?>" required>
                    <option value="">-- Pilih Kategori --</option>
                    <?php
                    $kategori_options = [
                        'Pemasangan Pelanggan Baru',
                        'Penarikan Kabel',
                        'Penambahan Perangkat',
                        'Pergantian Perangkat',
                        'Pengecekan Perangkat',
                        'Pengambilan Perangkat',
                        'Perbaikan Koneksi',
                        'Pengecekan Koneksi'
                    ];
                    foreach ($kategori_options as $option):
                    ?>
                        <option value="<?= esc($option) ?>" <?= old('keluhan', $ticket['keluhan']) == $option ? 'selected' : '' ?>>
                            <?= esc($option) ?>
                        </option>
                    <?php endforeach; ?>
                </select>
                <?php if ($validation->hasError('keluhan')): ?>
                    <p class="text-red-500 text-xs italic mt-1"><?= $validation->getError('keluhan') ?></p>
                <?php endif; ?>
            </div>

            <div class="mb-4">
                <label for="deskripsi" class="block text-gray-700 text-sm font-bold mb-2">Deskripsi Detail (Opsional):</label>
                <textarea name="deskripsi" id="deskripsi" rows="4"
                    class="shadow appearance-none border rounded-lg w-full py-3 px-4 text-gray-700 leading-tight focus:outline-none focus:ring-2 focus:ring-amber-500 focus:border-transparent
                                <?= $validation->hasError('deskripsi') ? 'border-red-500' : '' ?>"
                    placeholder="Jelaskan masalah secara lebih detail"><?= old('deskripsi', $ticket['deskripsi']) ?></textarea>
                <?php if ($validation->hasError('deskripsi')): ?>
                    <p class="text-red-500 text-xs italic mt-1"><?= $validation->getError('deskripsi') ?></p>
                <?php endif; ?>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <label for="status" class="block text-gray-700 text-sm font-bold mb-2">Status:</label>
                    <select name="status" id="status"
                        class="shadow appearance-none border rounded-lg w-full py-3 px-4 text-gray-700 leading-tight focus:outline-none focus:ring-2 focus:ring-amber-500 focus:border-transparent
                                <?= $validation->hasError('status') ? 'border-red-500' : '' ?>" required>
                        <option value="open" <?= (old('status', $ticket['status']) == 'open') ? 'selected' : '' ?>>Open</option>
                        <option value="progress" <?= (old('status', $ticket['status']) == 'progress') ? 'selected' : '' ?>>Progress</option>
                        <option value="closed" <?= (old('status', $ticket['status']) == 'closed') ? 'selected' : '' ?>>Closed</option>
                    </select>
                    <?php if ($validation->hasError('status')): ?>
                        <p class="text-red-500 text-xs italic mt-1"><?= $validation->getError('status') ?></p>
                    <?php endif; ?>
                </div>
                <div>
                    <label for="prioritas" class="block text-gray-700 text-sm font-bold mb-2">Prioritas:</label>
                    <select name="prioritas" id="prioritas"
                        class="shadow appearance-none border rounded-lg w-full py-3 px-4 text-gray-700 leading-tight focus:outline-none focus:ring-2 focus:ring-amber-500 focus:border-transparent
                                <?= $validation->hasError('prioritas') ? 'border-red-500' : '' ?>" required>
                        <option value="low" <?= (old('prioritas', $ticket['prioritas']) == 'low') ? 'selected' : '' ?>>Low</option>
                        <option value="medium" <?= (old('prioritas', $ticket['prioritas']) == 'medium') ? 'selected' : '' ?>>Medium</option>
                        <option value="high" <?= (old('prioritas', $ticket['prioritas']) == 'high') ? 'selected' : '' ?>>High</option>
                        <option value="urgent" <?= (old('prioritas', $ticket['prioritas']) == 'urgent') ? 'selected' : '' ?>>Urgent</option>
                    </select>
                    <?php if ($validation->hasError('prioritas')): ?>
                        <p class="text-red-500 text-xs italic mt-1"><?= $validation->getError('prioritas') ?></p>
                    <?php endif; ?>
                </div>
            </div>

            <hr class="border-gray-200 my-6">
            <h3 class="text-xl font-semibold text-gray-800 mb-4">Informasi Petugas</h3>

            <div class="mb-4">
                <label for="petugas_id" class="block text-gray-700 text-sm font-bold mb-2">Pilih Petugas:</label>
                <select name="petugas_id" id="petugas_id"
                    class="shadow appearance-none border rounded-lg w-full py-3 px-4 text-gray-700 leading-tight focus:outline-none focus:ring-2 focus:ring-amber-500 focus:border-transparent
                                <?= $validation->hasError('petugas_id') ? 'border-red-500' : '' ?>" required>
                    <option value="">-- Pilih Petugas --</option>
                    <?php foreach ($petugas as $p): ?>
                        <option value="<?= $p['id_petugas'] ?>"
                            <?= (old('petugas_id', $ticket['petugas_id']) == $p['id_petugas']) ? 'selected' : '' ?>>
                            <?= esc($p['nama_petugas']) ?> (<?= esc($p['role']) ?>)
                        </option>
                    <?php endforeach; ?>
                </select>
                <?php if ($validation->hasError('petugas_id')): ?>
                    <p class="text-red-500 text-xs italic mt-1"><?= $validation->getError('petugas_id') ?></p>
                <?php endif; ?>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <label for="nama_petugas_ticket" class="block text-gray-700 text-sm font-bold mb-2">Nama Petugas:</label>
                    <input type="text" name="nama_petugas_ticket" id="nama_petugas_ticket"
                        value="<?= old('nama_petugas_ticket', $ticket['nama_petugas_ticket']) ?>"
                        class="shadow appearance-none border rounded-lg w-full py-3 px-4 text-gray-700 leading-tight focus:outline-none focus:ring-2 focus:ring-amber-500 focus:border-transparent
                        <?= $validation->hasError('nama_petugas_ticket') ? 'border-red-500' : '' ?>"
                        placeholder="Nama petugas">
                    <?php if ($validation->hasError('nama_petugas_ticket')): ?>
                        <p class="text-red-500 text-xs italic mt-1"><?= $validation->getError('nama_petugas_ticket') ?></p>
                    <?php endif; ?>
                </div>
                <div>
                    <label for="no_hp_petugas_ticket" class="block text-gray-700 text-sm font-bold mb-2">No. HP Petugas:</label>
                    <input type="text" name="no_hp_petugas_ticket" id="no_hp_petugas_ticket"
                        value="<?= old('no_hp_petugas_ticket', $ticket['no_hp_petugas_ticket']) ?>"
                        class="shadow appearance-none border rounded-lg w-full py-3 px-4 text-gray-700 leading-tight focus:outline-none focus:ring-2 focus:ring-amber-500 focus:border-transparent
                        <?= $validation->hasError('no_hp_petugas_ticket') ? 'border-red-500' : '' ?>"
                        placeholder="Nomor HP petugas">
                    <?php if ($validation->hasError('no_hp_petugas_ticket')): ?>
                        <p class="text-red-500 text-xs italic mt-1"><?= $validation->getError('no_hp_petugas_ticket') ?></p>
                    <?php endif; ?>
                </div>
            </div>
            <div class="mb-6">
                <label for="role_petugas_ticket" class="block text-gray-700 text-sm font-bold mb-2">Role Petugas:</label>
                <input type="text" name="role_petugas_ticket" id="role_petugas_ticket"
                    value="<?= old('role_petugas_ticket', $ticket['role_petugas_ticket']) ?>"
                    class="shadow appearance-none border rounded-lg w-full py-3 px-4 text-gray-700 leading-tight focus:outline-none focus:ring-2 focus:ring-amber-500 focus:border-transparent
                    <?= $validation->hasError('role_petugas_ticket') ? 'border-red-500' : '' ?>"
                    placeholder="Role petugas">
                <?php if ($validation->hasError('role_petugas_ticket')): ?>
                    <p class="text-red-500 text-xs italic mt-1"><?= $validation->getError('role_petugas_ticket') ?></p>
                <?php endif; ?>
            </div>

            <div class="flex flex-col sm:flex-row items-center justify-between gap-4 mt-8">
                <button type="submit" class="w-full sm:w-auto bg-amber-600 hover:bg-amber-700 text-white font-bold py-3 px-6 rounded-lg focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-amber-500 transition duration-300 ease-in-out transform hover:scale-105">
                    Update Tiket
                </button>
                <a href="<?= base_url('tickets') ?>" class="w-full sm:w-auto text-center inline-block align-baseline font-bold text-sm text-gray-500 hover:text-gray-800 py-3 px-6 rounded-lg transition duration-300">
                    Batal
                </a>
            </div>
        </form>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const customerIdSelect = document.getElementById('customer_id');
        const namaCustomerInput = document.getElementById('nama_customer_ticket');
        const alamatCustomerInput = document.getElementById('alamat_customer_ticket');
        const noHpCustomerInput = document.getElementById('no_hp_customer_ticket');

        const petugasIdSelect = document.getElementById('petugas_id');
        const namaPetugasInput = document.getElementById('nama_petugas_ticket');
        const noHpPetugasInput = document.getElementById('no_hp_petugas_ticket');
        const rolePetugasInput = document.getElementById('role_petugas_ticket');

        // Menginisialisasi Select2 pada dropdown
        $(customerIdSelect).select2();
        $(petugasIdSelect).select2();

        // Fungsi untuk mengaktifkan/menonaktifkan dan mengisi detail customer
        function toggleCustomerFields(selectedCustomerId) {
            const isCustomInput = selectedCustomerId === "";

            namaCustomerInput.disabled = !isCustomInput;
            alamatCustomerInput.disabled = !isCustomInput;
            noHpCustomerInput.disabled = !isCustomInput;

            // Tambahkan kelas background abu-abu jika disabled
            if (!isCustomInput) {
                namaCustomerInput.classList.add('bg-gray-100');
                alamatCustomerInput.classList.add('bg-gray-100');
                noHpCustomerInput.classList.add('bg-gray-100');
            } else {
                namaCustomerInput.classList.remove('bg-gray-100');
                alamatCustomerInput.classList.remove('bg-gray-100');
                noHpCustomerInput.classList.remove('bg-gray-100');
            }

            // Jika pilih customer, ambil datanya
            if (!isCustomInput && selectedCustomerId) {
                fetch(`<?= base_url('tickets/getcustomerdetails/') ?>${selectedCustomerId}`)
                    .then(response => response.json())
                    .then(data => {
                        namaCustomerInput.value = data.nama_customer || '';
                        alamatCustomerInput.value = data.alamat || '';
                        noHpCustomerInput.value = data.no_hp || '';
                    });
            } else {
                // Biarkan nilai tetap saat mode custom
            }
        }

        // Fungsi untuk mengaktifkan/menonaktifkan dan mengisi detail petugas
        function togglePetugasFields(selectedPetugasId) {
            const isCustomInput = selectedPetugasId === "";

            namaPetugasInput.disabled = !isCustomInput;
            noHpPetugasInput.disabled = !isCustomInput;
            rolePetugasInput.disabled = !isCustomInput;

            // Tambahkan kelas background abu-abu jika disabled
            if (!isCustomInput) {
                namaPetugasInput.classList.add('bg-gray-100');
                noHpPetugasInput.classList.add('bg-gray-100');
                rolePetugasInput.classList.add('bg-gray-100');
            } else {
                namaPetugasInput.classList.remove('bg-gray-100');
                noHpPetugasInput.classList.remove('bg-gray-100');
                rolePetugasInput.classList.remove('bg-gray-100');
            }

            if (!isCustomInput && selectedPetugasId) {
                fetch(`<?= base_url('tickets/getpetugasdetails/') ?>${selectedPetugasId}`)
                    .then(response => response.json())
                    .then(data => {
                        namaPetugasInput.value = data.nama_petugas || '';
                        noHpPetugasInput.value = data.no_hp || '';
                        rolePetugasInput.value = data.role || '';
                    });
            } else {
                // Biarkan nilai tetap saat mode custom
            }
        }

        // Event listener untuk customer dropdown
        customerIdSelect.addEventListener('change', function() {
            toggleCustomerFields(this.value);
        });

        // Event listener untuk petugas dropdown
        petugasIdSelect.addEventListener('change', function() {
            togglePetugasFields(this.value);
        });

        // Panggil fungsi toggle saat halaman dimuat untuk mengisi data awal
        toggleCustomerFields(customerIdSelect.value);
        togglePetugasFields(petugasIdSelect.value);
    });
</script>

<?= $this->endSection() ?>