<?= $this->extend('layout/layout') ?>

<?= $this->section('content') ?>


<div class="container mx-auto px-2 py-2 sm:px-6 lg:px-8">
    <div class="bg-white shadow-xl rounded-xl p-4 md:p-6 lg:p-8">

        <div class="flex flex-col sm:flex-row sm:justify-between sm:items-center mb-6 md:mb-8 gap-4">
            <h2 class="text-3xl font-extrabold text-amber-600 tracking-tight">
                <?= $title ?>
            </h2>
            <div class="flex flex-col sm:flex-row gap-2">
                <button type="button" onclick="showScheduleExportModal()" class="inline-flex items-center justify-center px-6 py-3 border border-transparent text-base font-medium rounded-lg shadow-sm text-white bg-amber-600 hover:bg-amber-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-amber-500 transition duration-300 ease-in-out transform hover:scale-105">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <rect x="3" y="4" width="18" height="18" rx="2" ry="2"></rect>
                        <line x1="16" y1="2" x2="16" y2="6"></line>
                        <line x1="8" y1="2" x2="8" y2="6"></line>
                        <line x1="3" y1="10" x2="21" y2="10"></line>
                    </svg>
                    Export Jadwal
                </button>
                <a href="<?= base_url('tickets/create') ?>" class="inline-flex items-center justify-center px-6 py-3 border border-transparent text-base font-medium rounded-lg shadow-sm text-white bg-amber-600 hover:bg-amber-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-amber-500 transition duration-300 ease-in-out transform hover:scale-105">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" viewBox="0 0 20 20" fill="currentColor">
                        <path fill-rule="evenodd" d="M10 5a1 1 0 011 1v3h3a1 1 0 110 2h-3v3a1 1 0 11-2 0v-3H6a1 1 0 110-2h3V6a1 1 0 011-1z" clip-rule="evenodd" />
                    </svg>
                    Buat Tiket Baru
                </a>
            </div>
        </div>

        <form id="filterSearchForm" action="<?= base_url('tickets') ?>" method="get" class="mb-6 flex flex-col sm:flex-row gap-4 items-center">
            <div class="w-full sm:w-auto flex-grow">
                <label for="search" class="sr-only">Cari Tiket</label>
                <input type="text" name="search" id="search" placeholder="Cari Kode, Customer, Keluhan..."
                    value="<?= esc($search_query ?? '') ?>"
                    class="shadow-sm focus:ring-amber-500 focus:border-amber-500 block w-full border-gray-300 rounded-md py-2 px-3">
            </div>
            <div class="w-full sm:w-auto">
                <label for="status_filter" class="sr-only">Filter Status</label>
                <select id="status_filter" name="status_filter" class="block w-full sm:w-48 py-2 px-3 border border-gray-300 bg-white rounded-md shadow-sm focus:outline-none focus:ring-amber-500 focus:border-amber-500 text-sm">
                    <option value="all" <?= ($status_filter_selected == 'all' || !isset($status_filter_selected)) ? 'selected' : '' ?>>Semua Status</option>
                    <option value="open" <?= ($status_filter_selected == 'open') ? 'selected' : '' ?>>Open</option>
                    <option value="progress" <?= ($status_filter_selected == 'progress') ? 'selected' : '' ?>>Progress</option>
                    <option value="closed" <?= ($status_filter_selected == 'closed') ? 'selected' : '' ?>>Closed</option>
                </select>
            </div>
        </form>

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
                            <th scope="col" class="px-6 py-3 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">Kategori Tiket</th>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">Status</th>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">Prioritas</th>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">Petugas</th>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        <?php $no = (isset($pager) && !empty($pager)) ? ($pager->getCurrentPage() - 1) * $pager->getPerPage() + 1 : 1; ?>
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
                                        else if ($ticket['status'] == 'selesai') echo 'bg-purple-100 text-purple-800';
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
                                        <button type="button" class="text-gray-600 hover:text-gray-900 transition duration-150 ease-in-out" onclick="showExportModal(<?= esc(json_encode($ticket), 'attr') ?>)">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                                                <path fill-rule="evenodd" d="M.5 9.9a.5.5 0 01.5.5v2.5a.5.5 0 00.5.5h14a.5.5 0 00.5-.5v-2.5a.5.5 0 011 0v2.5A1.5 1.5 0 0115.5 15h-14A1.5 1.5 0 010 13.4v-2.5a.5.5 0 01.5-.5zM7.646 11.854a.5.5 0 00.708 0l3-3a.5.5 0 00-.708-.708L8.5 10.293V3.5a.5.5 0 00-1 0v6.793L5.354 8.146a.5.5 0 10-.708.708l3 3z" clip-rule="evenodd" />
                                            </svg>
                                        </button>
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
                <?php $no_mobile = (isset($pager) && !empty($pager)) ? ($pager->getCurrentPage() - 1) * $pager->getPerPage() + 1 : 1; ?>
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
                                    else if ($ticket['status'] == 'selesai') echo 'bg-purple-100 text-purple-800';
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
                            <button type="button" class="inline-flex items-center px-3 py-1.5 border border-transparent text-xs font-medium rounded-md shadow-sm text-gray-700 bg-gray-100 hover:bg-gray-200 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-gray-500" onclick="showExportModal(<?= esc(json_encode($ticket), 'attr') ?>)">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1" viewBox="0 0 20 20" fill="currentColor">
                                    <path fill-rule="evenodd" d="M.5 9.9a.5.5 0 01.5.5v2.5a.5.5 0 00.5.5h14a.5.5 0 00.5-.5v-2.5a.5.5 0 011 0v2.5A1.5 1.5 0 0115.5 15h-14A1.5 1.5 0 010 13.4v-2.5a.5.5 0 01.5-.5zM7.646 11.854a.5.5 0 00.708 0l3-3a.5.5 0 00-.708-.708L8.5 10.293V3.5a.5.5 0 00-1 0v6.793L5.354 8.146a.5.5 0 10-.708.708l3 3z" clip-rule="evenodd" />
                                </svg>
                                Export
                            </button>
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

         <div class="mt-4 flex justify-end">
                <?php if (isset($pager) && !empty($pager)): ?>
                    <?= $pager->links('default', 'pagination_tailwind') ?>
                <?php endif; ?>
            </div>
        <?php endif; ?>
    </div>
</div>

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

<div id="exportModal" class="fixed inset-0 bg-gray-600 bg-opacity-75 flex items-center justify-center z-50 hidden">
    <div class="bg-white rounded-lg shadow-xl p-6 w-full max-w-md mx-auto">
        <h3 class="text-lg font-bold text-gray-900 mb-4">Detail Tiket</h3>
        <div class="space-y-2 text-sm text-gray-700 leading-relaxed">
            <p><span class="font-bold">Kode Tiket:</span> <span id="export-code"></span></p>
            <p><span class="font-bold">Tanggal Dibuat:</span> <span id="export-date"></span></p>
            <p><span class="font-bold">Kategori:</span> <span id="export-category"></span></p>
            <p><span class="font-bold">Deskripsi:</span> <span id="export-description"></span></p>
            <p><span class="font-bold">Status:</span> <span id="export-status"></span></p>
            <p><span class="font-bold">Prioritas:</span> <span id="export-priority"></span></p>
            <p><span class="font-bold">Customer:</span> <span id="export-customer"></span> (<span id="export-customer-hp"></span>)</p>
            <p><span class="font-bold">Alamat:</span> <span id="export-customer-address"></span></p>
            <p><span class="font-bold">Petugas:</span> <span id="export-officer"></span> (<span id="export-officer-role"></span>)</p>
            <p><span class="font-bold">No. HP Petugas:</span> <span id="export-officer-hp"></span></p>
        </div>
        <div class="flex justify-end space-x-3 mt-4">
            <button type="button" class="px-4 py-2 bg-gray-200 text-gray-800 rounded-md hover:bg-gray-300 transition-colors" onclick="hideExportModal()">Tutup</button>
            <button type="button" id="copyExportContent" class="px-4 py-2 bg-amber-600 text-white rounded-md hover:bg-amber-700 transition-colors">Salin Teks</button>
        </div>
    </div>
</div>

<div id="scheduleExportModal" class="fixed inset-0 bg-gray-600 bg-opacity-75 flex items-center justify-center z-50 hidden">
    <div class="bg-white rounded-lg shadow-xl p-6 w-full max-w-md mx-auto">
        <h3 class="text-lg font-bold text-gray-900 mb-4">Jadwal Tiket Hari Ini</h3>
        <p class="text-sm text-gray-700 mb-4">Daftar tiket yang masih berstatus 'open' hari ini.</p>
        <textarea id="scheduleExportContent" class="w-full h-64 p-3 border border-gray-300 rounded-md resize-none text-sm font-mono bg-gray-50 focus:outline-none focus:ring-2 focus:ring-amber-500" readonly></textarea>
        <div class="flex justify-end space-x-3 mt-4">
            <button type="button" class="px-4 py-2 bg-gray-200 text-gray-800 rounded-md hover:bg-gray-300 transition-colors" onclick="hideScheduleExportModal()">Tutup</button>
            <button type="button" id="copyScheduleContent" class="px-4 py-2 bg-amber-600 text-white rounded-md hover:bg-amber-700 transition-colors">Salin Teks</button>
        </div>
    </div>
</div>

<script>
    let deleteFormAction = '';
    const tickets = <?= json_encode($tickets) ?>;

    function showDeleteModal(deleteUrl) {
        deleteFormAction = deleteUrl;
        document.getElementById('deleteForm').action = deleteFormAction;
        document.getElementById('deleteModal').classList.remove('hidden');
    }

    function hideDeleteModal() {
        document.getElementById('deleteModal').classList.add('hidden');
        deleteFormAction = '';
        document.getElementById('deleteForm').action = '';
    }

    function showExportModal(ticketDetails) {
        document.getElementById('export-code').textContent = ticketDetails.code_ticket;
        document.getElementById('export-date').textContent = ticketDetails.tanggal_buat;
        document.getElementById('export-category').textContent = ticketDetails.keluhan;
        document.getElementById('export-description').textContent = ticketDetails.deskripsi || 'Tidak ada deskripsi tambahan';
        document.getElementById('export-status').textContent = ticketDetails.status;
        document.getElementById('export-priority').textContent = ticketDetails.prioritas;
        document.getElementById('export-customer').textContent = ticketDetails.nama_customer_ticket;
        document.getElementById('export-customer-hp').textContent = ticketDetails.no_hp_customer_ticket;
        document.getElementById('export-customer-address').textContent = ticketDetails.alamat_customer_ticket;
        document.getElementById('export-officer').textContent = ticketDetails.nama_petugas_ticket;
        document.getElementById('export-officer-role').textContent = ticketDetails.role_petugas_ticket;
        document.getElementById('export-officer-hp').textContent = ticketDetails.no_hp_petugas_ticket;

        document.getElementById('exportModal').classList.remove('hidden');
    }

    function hideExportModal() {
        document.getElementById('exportModal').classList.add('hidden');
    }

    document.getElementById('copyExportContent').addEventListener('click', function() {
        let content = `--- Detail Tiket ---\n\n`;
        content += `Kode Tiket: ${document.getElementById('export-code').textContent}\n`;
        content += `Tanggal Dibuat: ${document.getElementById('export-date').textContent}\n`;
        content += `Kategori: ${document.getElementById('export-category').textContent}\n`;
        content += `Deskripsi: ${document.getElementById('export-description').textContent}\n`;
        content += `Status: ${document.getElementById('export-status').textContent}\n`;
        content += `Prioritas: ${document.getElementById('export-priority').textContent}\n\n`;
        content += `--- Informasi Pelanggan ---\n\n`;
        content += `Nama Pelanggan: ${document.getElementById('export-customer').textContent}\n`;
        content += `No. HP Pelanggan: ${document.getElementById('export-customer-hp').textContent}\n`;
        content += `Alamat Pelanggan: ${document.getElementById('export-customer-address').textContent}\n\n`;
        content += `--- Informasi Petugas ---\n\n`;
        content += `Nama Petugas: ${document.getElementById('export-officer').textContent}\n`;
        content += `No. HP Petugas: ${document.getElementById('export-officer-hp').textContent}\n`;
        content += `Role Petugas: ${document.getElementById('export-officer-role').textContent}\n`;

        const tempTextarea = document.createElement('textarea');
        tempTextarea.value = content;
        document.body.appendChild(tempTextarea);
        tempTextarea.select();
        document.execCommand('copy');
        document.body.removeChild(tempTextarea);

        const originalText = this.textContent;
        this.textContent = 'Disalin!';
        setTimeout(() => {
            this.textContent = originalText;
        }, 1500);
    });

    document.addEventListener('DOMContentLoaded', function() {
        const filterSearchForm = document.getElementById('filterSearchForm');
        const searchInput = document.getElementById('search');
        const statusFilterSelect = document.getElementById('status_filter');
        let searchTimeout;

        const submitForm = () => {
            filterSearchForm.submit();
        };

        statusFilterSelect.addEventListener('change', submitForm);

        searchInput.addEventListener('input', function() {
            clearTimeout(searchTimeout);
            searchTimeout = setTimeout(submitForm, 500);
        });
    });
    
    function exportTicketsToCsv() {
        if (tickets.length === 0) {
            alert('Tidak ada data tiket untuk diekspor.');
            return;
        }

        const headers = [
            "No.", "Kode Tiket", "Nama Customer", "No. HP Customer", "Alamat Customer", 
            "Kategori Tiket", "Deskripsi", "Status", "Prioritas", 
            "Nama Petugas", "No. HP Petugas", "Role Petugas", "Tanggal Buat"
        ];
        
        let csvContent = headers.join(";") + "\n";
        
        const currentPage = (typeof pager !== 'undefined' && pager) ? pager.getCurrentPage() : 1;
        const perPage = (typeof pager !== 'undefined' && pager) ? pager.getPerPage() : tickets.length;
        const startNumber = (currentPage - 1) * perPage;

        tickets.forEach((ticket, index) => {
            let row = [
                startNumber + index + 1,
                `"${ticket.code_ticket}"`,
                `"${ticket.nama_customer_ticket}"`,
                `"${ticket.no_hp_customer_ticket}"`,
                `"${ticket.alamat_customer_ticket}"`,
                `"${ticket.keluhan}"`,
                `"${ticket.deskripsi.replace(/"/g, '""')}"`,
                `"${ticket.status}"`,
                `"${ticket.prioritas}"`,
                `"${ticket.nama_petugas_ticket}"`,
                `"${ticket.no_hp_petugas_ticket}"`,
                `"${ticket.role_petugas_ticket}"`,
                `"${ticket.tanggal_buat}"`
            ];
            csvContent += row.join(";") + "\n";
        });

        const blob = new Blob([csvContent], { type: 'text/csv;charset=utf-8;' });
        const link = document.createElement("a");
        if (link.download !== undefined) {
            const url = URL.createObjectURL(blob);
            link.setAttribute("href", url);
            link.setAttribute("download", "data_tickets.csv");
            link.style.visibility = 'hidden';
            document.body.appendChild(link);
            link.click();
            document.body.removeChild(link);
        }
    }

    function showScheduleExportModal() {
        const ticketsData = <?= json_encode($tickets) ?>;
        const today = new Date().toISOString().slice(0, 10);
        let scheduleContent = `*Ticket Maintenance Teknisi Lapangan*\n\n`;
        let counter = 1;

        ticketsData.forEach(ticket => {
            const ticketDate = ticket.tanggal_buat.slice(0, 10);
            if (ticket.status === 'open' && ticketDate === today) {
                const customerName = ticket.nama_customer_ticket;
                const description = ticket.deskripsi || 'Tidak ada deskripsi';
                scheduleContent += `${counter}. ${ticket.code_ticket} : ${customerName}, Status ${description}\n`;
                counter++;
            }
        });

        if (counter === 1) {
            scheduleContent += "Tidak ada tiket 'open' hari ini.";
        }

        document.getElementById('scheduleExportContent').value = scheduleContent;
        document.getElementById('scheduleExportModal').classList.remove('hidden');
    }

    function hideScheduleExportModal() {
        document.getElementById('scheduleExportModal').classList.add('hidden');
    }

    document.getElementById('copyScheduleContent').addEventListener('click', function() {
        const scheduleContent = document.getElementById('scheduleExportContent');
        scheduleContent.select();
        document.execCommand('copy');
        const originalText = this.textContent;
        this.textContent = 'Disalin!';
        setTimeout(() => {
            this.textContent = originalText;
        }, 1500);
    });
    
    
</script>

<?= $this->endSection() ?>