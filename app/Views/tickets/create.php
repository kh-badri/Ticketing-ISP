<?= $this->extend('layout/layout') ?>

<?= $this->section('content') ?>

<style>
/* CSS kustom untuk Select2 */
.select2-container .select2-selection--single {
    height: 48px !important;
    display: flex !important;
    align-items: center !important;
    border: 1px solid #D1D5DB;
    border-radius: 0.5rem;
    width: 100% !important; /* Memastikan lebar 100% di semua ukuran layar */
}

/* Mengatur fokus */
.select2-container--default.select2-container--focus .select2-selection--single {
    border-color: #FBBF24;
    box-shadow: 0 0 0 2px rgba(251, 191, 36, 0.5);
}

/* Mengatur tampilan teks di dalam Select2 */
.select2-container--default .select2-selection--single .select2-selection__rendered {
    line-height: 46px;
    padding: 0 16px; /* Menggunakan padding konsisten */
    color: #4B5563;
}

/* Mengatur tampilan panah dropdown */
.select2-container--default .select2-selection--single .select2-selection__arrow {
    height: 46px;
    width: 20px;
    right: 8px;
}

/* Mengatur tampilan input pencarian di dropdown */
.select2-container--default .select2-search--dropdown .select2-search__field {
    border-radius: 0.5rem !important;
    border: 1px solid #D1D5DB !important;
    padding: 0.5rem 1rem !important;
    font-size: 0.875rem;
}

/* Mengatur menu dropdown */
.select2-dropdown {
    border-color: #D1D5DB;
    border-radius: 0.5rem;
    box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1), 0 2px 4px -1px rgba(0, 0, 0, 0.06);
}

/* Mengatur opsi di dalam dropdown */
.select2-results__option {
    padding: 0.75rem 1rem;
    font-size: 0.875rem;
}

/* Mengatur hover pada opsi */
.select2-results__option--highlighted {
    background-color: #FEF3C7 !important;
    color: #92400E !important;
}

/* Styling responsif untuk tombol "x" */
@media (max-width: 767px) {
    .select2-container--default .select2-selection--single .select2-selection__clear {
        right: 48px; /* Atur posisi agar tidak menabrak panah di layar kecil */
    }
}

/* Tampilan desktop */
@media (min-width: 768px) {
    .select2-container--default .select2-selection--single .select2-selection__clear {
        right: 32px;
        color: #F59E0B;
        font-size: 1.25rem;
        position: absolute;
        line-height: 46px;
    }

    .select2-container--default .select2-selection--single .select2-selection__clear:hover {
        color: #D97706;
    }
}
</style>

<div class="container mx-auto px-4 py-8 sm:px-6 lg:px-8">
    <div class="bg-white shadow-xl rounded-xl p-6 md:p-8 lg:p-10">
        <h2 class="text-3xl font-extrabold text-amber-600 tracking-tight mb-8 text-center">
            <?= esc($title) ?>
        </h2>

        <form action="<?= base_url('tickets/store') ?>" method="post" class="space-y-6">
            <?= csrf_field() ?>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <label for="code_ticket" class="block text-gray-800 text-sm font-bold mb-2">Kode Tiket:</label>
                    <input type="text" name="code_ticket" id="code_ticket"
                        value="<?= old('code_ticket', $code_ticket_generated) ?>"
                        class="shadow appearance-none border rounded-lg w-full py-3 px-4 text-gray-700 leading-tight focus:outline-none focus:ring-2 focus:ring-amber-500 focus:border-transparent
                        <?= $validation->hasError('code_ticket') ? 'border-red-500' : '' ?>"
                        required readonly>
                    <?php if ($validation->hasError('code_ticket')): ?>
                        <p class="text-red-500 text-xs italic mt-1"><?= $validation->getError('code_ticket') ?></p>
                    <?php endif; ?>
                </div>
                <div>
                    <label for="tanggal_buat" class="block text-gray-700 text-sm font-bold mb-2">Tanggal Buat:</label>
                    <input type="datetime-local" name="tanggal_buat" id="tanggal_buat"
                        value="<?= old('tanggal_buat') ?>"
                        class="shadow appearance-none border rounded-lg w-full py-3 px-4 text-gray-700 leading-tight focus:outline-none focus:ring-2 focus:ring-amber-500 focus:border-transparent
                        <?= $validation->hasError('tanggal_buat') ? 'border-red-500' : '' ?>"
                        required readonly>
                    <?php if ($validation->hasError('tanggal_buat')): ?>
                        <p class="text-red-500 text-xs italic mt-1"><?= $validation->getError('tanggal_buat') ?></p>
                    <?php endif; ?>
                </div>
            </div>

            <hr class="border-gray-200 my-6">
            <h3 class="text-xl font-semibold text-gray-800 mb-4">Informasi Customer</h3>

            <div class="flex space-x-2 mb-4">
                <button type="button" id="btnPilihCustomer" class="px-4 py-2 text-sm font-medium text-white bg-amber-600 rounded-lg hover:bg-amber-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-amber-500">
                    Pilih Customer
                </button>
                <button type="button" id="btnCustomCustomer" class="px-4 py-2 text-sm font-medium text-gray-700 bg-gray-200 rounded-lg hover:bg-gray-300 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-gray-400">
                    Custom Input
                </button>
            </div>

            <div id="pilihCustomerContainer">
                <div class="mb-4">
                    <label for="customer_id" class="block text-gray-700 text-sm font-bold mb-2">Pilih Customer:</label>
                    <select name="customer_id" id="customer_id"
                        class="shadow appearance-none border rounded-lg w-full py-3 px-4 text-gray-800 leading-tight focus:outline-none focus:ring-2 focus:ring-amber-500 focus:border-transparent
                        <?= $validation->hasError('customer_id') ? 'border-red-500' : '' ?>">
                        <option value="">-- Cari atau Pilih Customer --</option>
                        <?php foreach ($customers as $customer): ?>
                            <option value="<?= $customer['id'] ?>"
                                <?= old('customer_id') == $customer['id'] ? 'selected' : '' ?>>
                                <?= esc($customer['id_customer']) ?> - <?= esc($customer['nama_customer']) ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                    <?php if ($validation->hasError('customer_id')): ?>
                        <p class="text-red-500 text-xs italic mt-1"><?= $validation->getError('customer_id') ?></p>
                    <?php endif; ?>
                </div>
            </div>

            <div id="detailCustomerContainer">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label for="nama_customer_ticket" class="block text-gray-700 text-sm font-bold mb-2">Nama Customer:</label>
                        <input type="text" name="nama_customer_ticket" id="nama_customer_ticket"
                            value="<?= old('nama_customer_ticket') ?>"
                            class="shadow appearance-none border rounded-lg w-full py-3 px-4 text-gray-700 leading-tight focus:outline-none focus:ring-2 focus:ring-amber-500 focus:border-transparent
                            <?= $validation->hasError('nama_customer_ticket') ? 'border-red-500' : '' ?>"
                            required placeholder="Nama customer">
                        <?php if ($validation->hasError('nama_customer_ticket')): ?>
                            <p class="text-red-500 text-xs italic mt-1"><?= $validation->getError('nama_customer_ticket') ?></p>
                        <?php endif; ?>
                    </div>
                    <div>
                        <label for="no_hp_customer_ticket" class="block text-gray-700 text-sm font-bold mb-2">No. HP Customer:</label>
                        <input type="text" name="no_hp_customer_ticket" id="no_hp_customer_ticket"
                            value="<?= old('no_hp_customer_ticket') ?>"
                            class="shadow appearance-none border rounded-lg w-full py-3 px-4 text-gray-700 leading-tight focus:outline-none focus:ring-2 focus:ring-amber-500 focus:border-transparent
                            <?= $validation->hasError('no_hp_customer_ticket') ? 'border-red-500' : '' ?>"
                            required placeholder="Nomor HP customer">
                        <?php if ($validation->hasError('no_hp_customer_ticket')): ?>
                            <p class="text-red-500 text-xs italic mt-1"><?= $validation->getError('no_hp_customer_ticket') ?></p>
                        <?php endif; ?>
                    </div>
                </div>
                <div class="mt-6">
                    <label for="alamat_customer_ticket" class="block text-gray-700 text-sm font-bold mb-2">Alamat Customer:</label>
                    <textarea name="alamat_customer_ticket" id="alamat_customer_ticket" rows="3"
                        class="shadow appearance-none border rounded-lg w-full py-3 px-4 text-gray-700 leading-tight focus:outline-none focus:ring-2 focus:ring-amber-500 focus:border-transparent
                        <?= $validation->hasError('alamat_customer_ticket') ? 'border-red-500' : '' ?>"
                        placeholder="Alamat customer" required><?= old('alamat_customer_ticket') ?></textarea>
                    <?php if ($validation->hasError('alamat_customer_ticket')): ?>
                        <p class="text-red-500 text-xs italic mt-1"><?= $validation->getError('alamat_customer_ticket') ?></p>
                    <?php endif; ?>
                </div>
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
                        <option value="<?= esc($option) ?>" <?= old('keluhan') == $option ? 'selected' : '' ?>>
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
                    placeholder="Jelaskan masalah secara lebih detail"><?= old('deskripsi') ?></textarea>
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
                        <option value="open" <?= old('status', 'open') == 'open' ? 'selected' : '' ?>>Open</option>
                        <option value="progress" <?= old('status') == 'progress' ? 'selected' : '' ?>>Progress</option>
                        <option value="closed" <?= old('status') == 'closed' ? 'selected' : '' ?>>Closed</option>
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
                        <option value="low" <?= old('prioritas', 'low') == 'low' ? 'selected' : '' ?>>Low</option>
                        <option value="medium" <?= old('prioritas') == 'medium' ? 'selected' : '' ?>>Medium</option>
                        <option value="high" <?= old('prioritas') == 'high' ? 'selected' : '' ?>>High</option>
                        <option value="urgent" <?= old('prioritas') == 'urgent' ? 'selected' : '' ?>>Urgent</option>
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
                    <option value="">-- Cari atau Pilih Petugas --</option>
                    <?php foreach ($petugas as $p): ?>
                        <option value="<?= $p['id_petugas'] ?>"
                            <?= old('petugas_id') == $p['id_petugas'] ? 'selected' : '' ?>>
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
                        value="<?= old('nama_petugas_ticket') ?>"
                        class="shadow appearance-none border rounded-lg w-full py-3 px-4 text-gray-700 bg-gray-100 leading-tight focus:outline-none focus:ring-2 focus:ring-amber-500 focus:border-transparent
                        <?= $validation->hasError('nama_petugas_ticket') ? 'border-red-500' : '' ?>"
                        required placeholder="Nama petugas" readonly>
                    <?php if ($validation->hasError('nama_petugas_ticket')): ?>
                        <p class="text-red-500 text-xs italic mt-1"><?= $validation->getError('nama_petugas_ticket') ?></p>
                    <?php endif; ?>
                </div>
                <div>
                    <label for="no_hp_petugas_ticket" class="block text-gray-700 text-sm font-bold mb-2">No. HP Petugas:</label>
                    <input type="text" name="no_hp_petugas_ticket" id="no_hp_petugas_ticket"
                        value="<?= old('no_hp_petugas_ticket') ?>"
                        class="shadow appearance-none border rounded-lg w-full py-3 px-4 text-gray-700 bg-gray-100 leading-tight focus:outline-none focus:ring-2 focus:ring-amber-500 focus:border-transparent
                        <?= $validation->hasError('no_hp_petugas_ticket') ? 'border-red-500' : '' ?>"
                        required placeholder="Nomor HP petugas" readonly>
                    <?php if ($validation->hasError('no_hp_petugas_ticket')): ?>
                        <p class="text-red-500 text-xs italic mt-1"><?= $validation->getError('no_hp_petugas_ticket') ?></p>
                    <?php endif; ?>
                </div>
            </div>
            <div class="mb-6">
                <label for="role_petugas_ticket" class="block text-gray-700 text-sm font-bold mb-2">Role Petugas:</label>
                <input type="text" name="role_petugas_ticket" id="role_petugas_ticket"
                    value="<?= old('role_petugas_ticket') ?>"
                    class="shadow appearance-none border rounded-lg w-full py-3 px-4 text-gray-700 bg-gray-100 leading-tight focus:outline-none focus:ring-2 focus:ring-amber-500 focus:border-transparent
                    <?= $validation->hasError('role_petugas_ticket') ? 'border-red-500' : '' ?>"
                    required placeholder="Role petugas" readonly>
                <?php if ($validation->hasError('role_petugas_ticket')): ?>
                    <p class="text-red-500 text-xs italic mt-1"><?= $validation->getError('role_petugas_ticket') ?></p>
                <?php endif; ?>
            </div>

            <div class="flex flex-col sm:flex-row items-center justify-between gap-4 mt-8">
                <button type="submit" class="w-full sm:w-auto bg-amber-600 hover:bg-amber-700 text-white font-bold py-3 px-6 rounded-lg focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-amber-500 transition duration-300 ease-in-out transform hover:scale-105">
                    Buat Tiket
                </button>
                <a href="<?= base_url('tickets') ?>" class="w-full sm:w-auto text-center inline-block align-baseline font-bold text-sm text-gray-500 hover:text-gray-800 py-3 px-6 rounded-lg transition duration-300">
                    Batal
                </a>
            </div>
        </form>
    </div>
</div>

<script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>


<script>
    $(document).ready(function() {
        // Set current date and time for tanggal_buat input
        const now = new Date();
        now.setMinutes(now.getMinutes() - now.getTimezoneOffset());
        const formattedDate = now.toISOString().slice(0, 16);
        $('#tanggal_buat').val(formattedDate);

        // --- Inisialisasi Select2 ---
        const customerSelect2 = $('#customer_id').select2({
            placeholder: "-- Cari atau Pilih Customer --",
            allowClear: false
        });

        $('#petugas_id').select2({
            placeholder: "-- Cari atau Pilih Petugas --",
            allowClear: false,
        });

        // --- Logika Tombol Opsi Customer ---
        const customerInputs = $('#nama_customer_ticket, #no_hp_customer_ticket, #alamat_customer_ticket');

        function setPilihMode() {
            // Sembunyikan input manual dan tampilkan Select2
            customerSelect2.next('.select2-container').show();
            customerInputs.prop('readonly', true).addClass('bg-gray-100');
            $('#customer_id').prop('required', true);

            // Styling tombol
            $('#btnPilihCustomer').removeClass('bg-gray-200 text-gray-700').addClass('bg-amber-600 text-white');
            $('#btnCustomCustomer').removeClass('bg-amber-600 text-white').addClass('bg-gray-200 text-gray-700');
        }

        function setCustomMode() {
            // Sembunyikan Select2 dan tampilkan input manual
            customerSelect2.val(null).trigger('change');
            customerSelect2.next('.select2-container').hide();
            customerInputs.prop('readonly', false).removeClass('bg-gray-100').val('');
            $('#customer_id').prop('required', false);

            // Styling tombol
            $('#btnCustomCustomer').removeClass('bg-gray-200 text-gray-700').addClass('bg-amber-600 text-white');
            $('#btnPilihCustomer').removeClass('bg-amber-600 text-white').addClass('bg-gray-200 text-gray-700');
        }

        $('#btnPilihCustomer').on('click', setPilihMode);
        $('#btnCustomCustomer').on('click', setCustomMode);

        // --- Mengisi data customer dari Select2 ---
        customerSelect2.on('change', function() {
            const customerId = $(this).val();
            if (customerId) {
                fetch(`<?= base_url('tickets/getcustomerdetails/') ?>${customerId}`)
                    .then(response => response.json())
                    .then(data => {
                        $('#nama_customer_ticket').val(data.nama_customer || '');
                        $('#alamat_customer_ticket').val(data.alamat || '');
                        $('#no_hp_customer_ticket').val(data.no_hp || '');
                    })
                    .catch(error => console.error('Error fetching customer details:', error));
            } else {
                customerInputs.val('');
            }
        });

        // --- Mengisi data petugas dari Select2 ---
        $('#petugas_id').on('change', function() {
            const petugasId = $(this).val();
            if (petugasId) {
                fetch(`<?= base_url('tickets/getpetugasdetails/') ?>${petugasId}`)
                    .then(response => response.json())
                    .then(data => {
                        $('#nama_petugas_ticket').val(data.nama_petugas || '');
                        $('#no_hp_petugas_ticket').val(data.no_hp || '');
                        $('#role_petugas_ticket').val(data.role || '');
                    })
                    .catch(error => console.error('Error fetching petugas details:', error));
            } else {
                $('#nama_petugas_ticket, #no_hp_petugas_ticket, #role_petugas_ticket').val('');
            }
        });

        // --- Logika inisialisasi awal saat halaman dimuat ---
        // Cek apakah ada old input untuk "Custom Input"
        <?php if (old('nama_customer_ticket') && !old('customer_id')): ?>
            setCustomMode();
        <?php else: ?>
            setPilihMode();
            if ('<?= old('customer_id') ?>') {
                customerSelect2.val('<?= old('customer_id') ?>').trigger('change');
            }
        <?php endif; ?>

        // Muat data petugas jika ada old input
        <?php if (old('petugas_id')): ?>
            $('#petugas_id').val('<?= old('petugas_id') ?>').trigger('change');
        <?php endif; ?>
    });
</script>

<?= $this->endSection() ?>