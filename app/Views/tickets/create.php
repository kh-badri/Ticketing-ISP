<?= $this->extend('layout/layout') ?>

<?= $this->section('content') ?>

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
                        <option value="">-- Pilih Customer --</option>
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
                        'Pemasangan Perangkat',
                        'Pergantian Perangkat',
                        'Penambahan Perangkat',
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
                    <option value="">-- Pilih Petugas --</option>
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

<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Set current date and time for tanggal_buat input
        function setCurrentDateTime() {
            const now = new Date();
            now.setMinutes(now.getMinutes() - now.getTimezoneOffset());
            const formattedDate = now.toISOString().slice(0, 16);
            document.getElementById('tanggal_buat').value = formattedDate;
        }

        // Call the function on page load
        setCurrentDateTime();

        // === Bagian Opsi Customer ===
        const btnPilihCustomer = document.getElementById('btnPilihCustomer');
        const btnCustomCustomer = document.getElementById('btnCustomCustomer');
        const pilihCustomerContainer = document.getElementById('pilihCustomerContainer');

        const customerIdSelect = document.getElementById('customer_id');
        const namaCustomerInput = document.getElementById('nama_customer_ticket');
        const alamatCustomerInput = document.getElementById('alamat_customer_ticket');
        const noHpCustomerInput = document.getElementById('no_hp_customer_ticket');

        // Fungsi untuk mengosongkan input customer
        const clearCustomerFields = () => {
            customerIdSelect.value = '';
            namaCustomerInput.value = '';
            alamatCustomerInput.value = '';
            noHpCustomerInput.value = '';
        };

        // Fungsi untuk mengatur tampilan mode "Pilih Customer"
        const setPilihMode = () => {
            pilihCustomerContainer.style.display = 'block';
            namaCustomerInput.readOnly = true;
            namaCustomerInput.classList.add('bg-gray-100');
            alamatCustomerInput.readOnly = true;
            alamatCustomerInput.classList.add('bg-gray-100');
            noHpCustomerInput.readOnly = true;
            noHpCustomerInput.classList.add('bg-gray-100');
            customerIdSelect.setAttribute('required', 'required');

            // Styling tombol
            btnPilihCustomer.classList.remove('bg-gray-200', 'text-gray-700');
            btnPilihCustomer.classList.add('bg-amber-600', 'text-white');
            btnCustomCustomer.classList.remove('bg-amber-600', 'text-white');
            btnCustomCustomer.classList.add('bg-gray-200', 'text-gray-700');

            if (customerIdSelect.value) {
                customerIdSelect.dispatchEvent(new Event('change'));
            } else {
                namaCustomerInput.value = '';
                alamatCustomerInput.value = '';
                noHpCustomerInput.value = '';
            }
        };

        // Fungsi untuk mengatur tampilan mode "Custom Input"
        const setCustomMode = () => {
            clearCustomerFields();
            pilihCustomerContainer.style.display = 'none';
            namaCustomerInput.readOnly = false;
            namaCustomerInput.classList.remove('bg-gray-100');
            alamatCustomerInput.readOnly = false;
            alamatCustomerInput.classList.remove('bg-gray-100');
            noHpCustomerInput.readOnly = false;
            noHpCustomerInput.classList.remove('bg-gray-100');
            customerIdSelect.removeAttribute('required');

            // Styling tombol
            btnCustomCustomer.classList.remove('bg-gray-200', 'text-gray-700');
            btnCustomCustomer.classList.add('bg-amber-600', 'text-white');
            btnPilihCustomer.classList.remove('bg-amber-600', 'text-white');
            btnPilihCustomer.classList.add('bg-gray-200', 'text-gray-700');
        };

        btnPilihCustomer.addEventListener('click', setPilihMode);
        btnCustomCustomer.addEventListener('click', setCustomMode);

        // === Bagian Detail Customer dari Select ===
        customerIdSelect.addEventListener('change', function() {
            const customerId = this.value;
            if (customerId) {
                fetch(`<?= base_url('tickets/getcustomerdetails/') ?>${customerId}`)
                    .then(response => {
                        if (!response.ok) throw new Error('Customer not found');
                        return response.json();
                    })
                    .then(data => {
                        namaCustomerInput.value = data.nama_customer || '';
                        alamatCustomerInput.value = data.alamat || '';
                        noHpCustomerInput.value = data.no_hp || '';
                    })
                    .catch(error => {
                        console.error('Error fetching customer details:', error);
                        clearCustomerFields();
                    });
            } else {
                namaCustomerInput.value = '';
                alamatCustomerInput.value = '';
                noHpCustomerInput.value = '';
            }
        });

        // === Bagian Detail Petugas ===
        const petugasIdSelect = document.getElementById('petugas_id');
        const namaPetugasInput = document.getElementById('nama_petugas_ticket');
        const noHpPetugasInput = document.getElementById('no_hp_petugas_ticket');
        const rolePetugasInput = document.getElementById('role_petugas_ticket');

        petugasIdSelect.addEventListener('change', function() {
            const petugasId = this.value;
            if (petugasId) {
                fetch(`<?= base_url('tickets/getpetugasdetails/') ?>${petugasId}`)
                    .then(response => {
                        if (!response.ok) throw new Error('Petugas not found');
                        return response.json();
                    })
                    .then(data => {
                        namaPetugasInput.value = data.nama_petugas || '';
                        noHpPetugasInput.value = data.no_hp || '';
                        rolePetugasInput.value = data.role || '';
                    })
                    .catch(error => {
                        console.error('Error fetching petugas details:', error);
                        namaPetugasInput.value = '';
                        noHpPetugasInput.value = '';
                        rolePetugasInput.value = '';
                    });
            } else {
                namaPetugasInput.value = '';
                noHpPetugasInput.value = '';
                rolePetugasInput.value = '';
            }
        });

        // === Inisialisasi & Memuat ulang data jika ada old input ===
        <?php if (old('nama_customer_ticket') && !old('customer_id')): ?>
            setCustomMode();
        <?php else: ?>
            setPilihMode();
        <?php endif; ?>

        <?php if (old('petugas_id')): ?>
            petugasIdSelect.dispatchEvent(new Event('change'));
        <?php endif; ?>
    });
</script>

<?= $this->endSection() ?>