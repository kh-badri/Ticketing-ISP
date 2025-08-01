<?= $this->extend('layout/layout') ?>

<?= $this->section('content') ?>

<div class="container mx-auto px-4 py-8 sm:px-6 lg:px-8">
    <div class="bg-white shadow-xl rounded-xl p-6 md:p-8 lg:p-10">

        <div class="flex flex-col sm:flex-row sm:justify-between sm:items-center mb-8 gap-4">
            <h2 class="text-3xl font-extrabold text-amber-600 tracking-tight">
                <?= $title ?>
            </h2>
            <a href="<?= base_url('tickets/create') ?>" class="inline-flex items-center justify-center px-6 py-3 border border-transparent text-base font-medium rounded-lg shadow-sm text-white bg-amber-600 hover:bg-amber-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-amber-500 transition duration-300 ease-in-out transform hover:scale-105">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" viewBox="0 0 20 20" fill="currentColor">
                    <path fill-rule="evenodd" d="M10 5a1 1 0 011 1v3h3a1 1 0 110 2h-3v3a1 1 0 11-2 0v-3H6a1 1 0 110-2h3V6a1 1 0 011-1z" clip-rule="evenodd" />
                </svg>
                Buat Tiket Baru
            </a>
        </div>

        <?php if (session()->getFlashdata('success')): ?>
            <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative mb-4" role="alert">
                <span class="block sm:inline"><?= session()->getFlashdata('success') ?></span>
            </div>
        <?php endif; ?>
        <?php if (session()->getFlashdata('error')): ?>
            <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative mb-4" role="alert">
                <span class="block sm:inline"><?= session()->getFlashdata('error') ?></span>
            </div>
        <?php endif; ?>

        <?php if (empty($tickets)): ?>
            <div class="text-center py-10">
                <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor" aria-hidden="true">
                    <path vector-effect="non-scaling-stroke" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 13h6m-3-3v6m-9 1V7a2 2 0 012-2h6l2 2h6a2 2 0 012 2v8a2 2 0 01-2 2H5a2 2 0 01-2-2z" />
                </svg>
                <h3 class="mt-2 text-lg font-medium text-gray-900">Belum ada tiket yang dibuat</h3>
                <p class="mt-1 text-sm text-gray-500">
                    Mulai dengan membuat tiket baru untuk melacak keluhan pelanggan.
                </p>
                <div class="mt-6">
                    <a href="<?= base_url('tickets/create') ?>" class="inline-flex items-center px-4 py-2 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-amber-600 hover:bg-amber-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-amber-500">
                        <svg class="-ml-1 mr-2 h-5 w-5" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                            <path fill-rule="evenodd" d="M10 5a1 1 0 011 1v3h3a1 1 0 110 2h-3v3a1 1 0 11-2 0v-3H6a1 1 0 110-2h3V6a1 1 0 011-1z" clip-rule="evenodd" />
                        </svg>
                        Buat Tiket Baru
                    </a>
                </div>
            </div>
        <?php else: ?>
            <div class="hidden md:block overflow-x-auto rounded-lg border border-gray-200 shadow-sm">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">No.</th>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">Kode Tiket</th>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">Customer</th>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">Keluhan</th>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">Status</th>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">Prioritas</th>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">Petugas</th>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        <?php $no = 1; // Inisialisasi counter 
                        ?>
                        <?php foreach ($tickets as $ticket): ?>
                            <tr>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900"><?= $no++ ?>.</td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-amber-700"><?= esc($ticket['code_ticket']) ?></td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                    <?= esc($ticket['nama_customer_ticket']) ?><br>
                                    <span class="text-gray-500 text-xs">HP: <?= esc($ticket['no_hp_customer_ticket']) ?></span>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900"><?= esc($ticket['keluhan']) ?></td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm">
                                    <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full
                                        <?php
                                        if ($ticket['status'] == 'open') echo 'bg-blue-100 text-blue-800';
                                        else if ($ticket['status'] == 'progress') echo 'bg-yellow-100 text-yellow-800';
                                        else if ($ticket['status'] == 'closed') echo 'bg-green-100 text-green-800';
                                        ?> capitalize">
                                        <?= esc($ticket['status']) ?>
                                    </span>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm">
                                    <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full
                                        <?php
                                        if ($ticket['prioritas'] == 'low') echo 'bg-gray-100 text-gray-800';
                                        else if ($ticket['prioritas'] == 'medium') echo 'bg-blue-100 text-blue-800';
                                        else if ($ticket['prioritas'] == 'high') echo 'bg-orange-100 text-orange-800';
                                        else if ($ticket['prioritas'] == 'urgent') echo 'bg-red-100 text-red-800';
                                        ?> capitalize">
                                        <?= esc($ticket['prioritas']) ?>
                                    </span>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                    <?= esc($ticket['nama_petugas_ticket']) ?> (<?= esc($ticket['role_petugas_ticket']) ?>)<br>
                                    <span class="text-gray-500 text-xs">HP: <?= esc($ticket['no_hp_petugas_ticket']) ?></span>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                    <div class="flex items-center space-x-3">
                                        <a href="<?= base_url('tickets/edit/' . $ticket['id']) ?>" class="text-amber-600 hover:text-amber-900 transition duration-150 ease-in-out">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                                                <path d="M13.586 3.586a2 2 0 112.828 2.828l-.793.793-2.828-2.828.793-.793zM11.379 5.793L3 14.172V17h2.828l8.38-8.38-2.828-2.829z" />
                                            </svg>
                                        </a>
                                        <button type="button" class="text-red-600 hover:text-red-900 transition duration-150 ease-in-out" onclick="showDeleteModal('<?= base_url('tickets/delete/' . $ticket['id']) ?>')">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                                                <path fill-rule="evenodd" d="M9 2a1 1 0 00-.894.553L7.382 4H4a1 1 0 000 2v10a2 2 0 002 2h8a2 2 0 002-2V6a1 1 0 100-2h-3.382l-.724-1.447A1 1 0 0011 2H9zM7 8a1 1 0 011-1h4a1 1 0 110 2H8a1 1 0 01-1-1zm6 4a1 1 0 10-2 0v3a1 1 0 102 0v-3z" clip-rule="evenodd" />
                                            </svg>
                                        </button>
                                    </div>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>

            <div class="md:hidden space-y-4">
                <?php $no_mobile = 1; ?>
                <?php foreach ($tickets as $ticket): ?>
                    <div class="bg-white shadow-md rounded-lg p-4 border border-gray-200">
                        <div class="flex items-center justify-between mb-2">
                            <div class="text-sm font-semibold text-amber-700">#<?= esc($ticket['code_ticket']) ?></div>
                            <div class="text-xs text-gray-500">No. <?= $no_mobile++ ?></div>
                        </div>
                        <div class="text-lg font-bold text-gray-900 mb-2"><?= esc($ticket['keluhan']) ?></div>
                        <p class="text-sm text-gray-700 mb-1">
                            <span class="font-medium">Customer:</span> <?= esc($ticket['nama_customer_ticket']) ?> (<?= esc($ticket['no_hp_customer_ticket']) ?>)
                        </p>
                        <p class="text-sm text-gray-700 mb-2">
                            <span class="font-medium">Petugas:</span> <?= esc($ticket['nama_petugas_ticket']) ?> (<?= esc($ticket['role_petugas_ticket']) ?>)
                        </p>
                        <div class="flex justify-between items-center text-sm mb-4">
                            <div>
                                <span class="px-2 py-0.5 inline-flex text-xs leading-5 font-semibold rounded-full
                                    <?php
                                    if ($ticket['status'] == 'open') echo 'bg-blue-100 text-blue-800';
                                    else if ($ticket['status'] == 'progress') echo 'bg-yellow-100 text-yellow-800';
                                    else if ($ticket['status'] == 'closed') echo 'bg-green-100 text-green-800';
                                    ?> capitalize">
                                    <?= esc($ticket['status']) ?>
                                </span>
                            </div>
                            <div>
                                <span class="px-2 py-0.5 inline-flex text-xs leading-5 font-semibold rounded-full
                                    <?php
                                    if ($ticket['prioritas'] == 'low') echo 'bg-gray-100 text-gray-800';
                                    else if ($ticket['prioritas'] == 'medium') echo 'bg-blue-100 text-blue-800';
                                    else if ($ticket['prioritas'] == 'high') echo 'bg-orange-100 text-orange-800';
                                    else if ($ticket['prioritas'] == 'urgent') echo 'bg-red-100 text-red-800';
                                    ?> capitalize">
                                    <?= esc($ticket['prioritas']) ?>
                                </span>
                            </div>
                        </div>
                        <div class="flex justify-end space-x-2">
                            <a href="<?= base_url('tickets/edit/' . $ticket['id']) ?>" class="inline-flex items-center px-3 py-1.5 border border-transparent text-xs font-medium rounded-md shadow-sm text-amber-700 bg-amber-100 hover:bg-amber-200 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-amber-500">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1" viewBox="0 0 20 20" fill="currentColor">
                                    <path d="M13.586 3.586a2 2 0 112.828 2.828l-.793.793-2.828-2.828.793-.793zM11.379 5.793L3 14.172V17h2.828l8.38-8.38-2.828-2.829z" />
                                </svg>
                                Edit
                            </a>
                            <button type="button" class="inline-flex items-center px-3 py-1.5 border border-transparent text-xs font-medium rounded-md shadow-sm text-red-700 bg-red-100 hover:bg-red-200 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500" onclick="showDeleteModal('<?= base_url('tickets/delete/' . $ticket['id']) ?>')">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1" viewBox="0 0 20 20" fill="currentColor">
                                    <path fill-rule="evenodd" d="M9 2a1 1 0 00-.894.553L7.382 4H4a1 1 0 000 2v10a2 2 0 002 2h8a2 2 0 002-2V6a1 1 0 100-2h-3.382l-.724-1.447A1 1 0 0011 2H9zM7 8a1 1 0 011-1h4a1 1 0 110 2H8a1 1 0 01-1-1zm6 4a1 1 0 10-2 0v3a1 1 0 102 0v-3z" clip-rule="evenodd" />
                                </svg>
                                Hapus
                            </button>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        <?php endif; ?>
    </div>
</div>

<!-- Delete Confirmation Modal -->
<div id="deleteModal" class="fixed inset-0 bg-gray-600 bg-opacity-75 flex items-center justify-center z-50 hidden">
    <div class="bg-white rounded-lg shadow-xl p-6 w-full max-w-sm mx-auto">
        <h3 class="text-lg font-bold text-gray-900 mb-4">Konfirmasi Hapus</h3>
        <p class="text-sm text-gray-700 mb-6">Anda yakin ingin menghapus tiket ini? Tindakan ini tidak dapat dibatalkan.</p>
        <div class="flex justify-end space-x-3">
            <button type="button" class="px-4 py-2 bg-gray-200 text-gray-800 rounded-md hover:bg-gray-300 transition-colors" onclick="hideDeleteModal()">Batal</button>
            <form id="deleteForm" method="post" class="inline">
                <?= csrf_field() ?>
                <input type="hidden" name="_method" value="DELETE">
                <button type="submit" class="px-4 py-2 bg-red-600 text-white rounded-md hover:bg-red-700 transition-colors">Hapus</button>
            </form>
        </div>
    </div>
</div>

<script>
    let deleteFormAction = ''; // Variable to store the delete URL

    function showDeleteModal(deleteUrl) {
        deleteFormAction = deleteUrl;
        document.getElementById('deleteForm').action = deleteFormAction;
        document.getElementById('deleteModal').classList.remove('hidden');
    }

    function hideDeleteModal() {
        document.getElementById('deleteModal').classList.add('hidden');
        deleteFormAction = ''; // Clear the URL
        document.getElementById('deleteForm').action = ''; // Clear form action
    }
</script>

<?= $this->endSection() ?>