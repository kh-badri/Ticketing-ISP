<?= $this->extend('layout/layout') ?>
<?= $this->section('content') ?>

<div class="container mx-auto px-4 py-8 sm:px-6 lg:px-8">
    <div class="bg-white shadow-xl rounded-xl p-6 md:p-8 lg:p-10">

        <div class="flex flex-col sm:flex-row sm:justify-between sm:items-center mb-8 gap-4">
            <h2 class="text-3xl font-extrabold text-amber-600 tracking-tight">
                <?= esc($title) ?>
            </h2>
            <a href="<?= base_url('customer/create') ?>" class="inline-flex items-center justify-center px-6 py-3 border border-transparent text-base font-medium rounded-lg shadow-sm text-white bg-amber-600 hover:bg-amber-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-amber-500 transition duration-300 ease-in-out transform hover:scale-105">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" viewBox="0 0 20 20" fill="currentColor">
                    <path fill-rule="evenodd" d="M10 5a1 1 0 011 1v3h3a1 1 0 110 2h-3v3a1 1 0 11-2 0v-3H6a1 1 0 110-2h3V6a1 1 0 011-1z" clip-rule="evenodd" />
                </svg>
                Tambah Customer
            </a>
        </div>
        
        <form id="searchForm" action="<?= base_url('customer') ?>" method="get" class="mb-6">
            <div class="relative">
                 <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                    <svg class="h-5 w-5 text-gray-400" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                      <path fill-rule="evenodd" d="M8 4a4 4 0 100 8 4 4 0 000-8zM2 8a6 6 0 1110.89 3.476l4.817 4.817a1 1 0 01-1.414 1.414l-4.816-4.816A6 6 0 012 8z" clip-rule="evenodd" />
                    </svg>
                 </div>
                <input type="text" name="search" id="search" placeholder="Cari berdasarkan ID, Nama, No. HP, atau Email..."
                    value="<?= esc($search_query ?? '') ?>"
                    class="shadow-sm focus:ring-amber-500 focus:border-amber-500 block w-full border-gray-300 rounded-md py-3 pl-10 pr-4">
            </div>
        </form>

        <?php if (empty($customers)): ?>
            <div class="text-center py-10">
                <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor" aria-hidden="true">
                    <path vector-effect="non-scaling-stroke" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 13h6m-3-3v6m-9 1V7a2 2 0 012-2h6l2 2h6a2 2 0 012 2v8a2 2 0 01-2 2H5a2 2 0 01-2-2z" />
                </svg>
                <h3 class="mt-2 text-lg font-medium text-gray-900">
                    <?= !empty($search_query) ? 'Customer tidak ditemukan' : 'Belum ada data customer' ?>
                </h3>
                <p class="mt-1 text-sm text-gray-500">
                    <?php if (!empty($search_query)): ?>
                        Coba gunakan kata kunci lain atau <a href="<?= base_url('customer') ?>" class="text-amber-600 hover:underline">tampilkan semua customer</a>.
                    <?php else: ?>
                        Mulai dengan menambahkan customer baru.
                    <?php endif; ?>
                </p>
            </div>
        <?php else: ?>
            <div class="overflow-x-auto rounded-lg border border-gray-200 shadow-sm">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">No.</th>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">ID Customer</th>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">Nama Customer</th>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">No. HP</th>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">Email</th>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        <?php $no = ($pager->getCurrentPage('customers') - 1) * $pager->getPerPage('customers') + 1; ?>
                        <?php foreach ($customers as $customer): ?>
                            <tr>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900"><?= $no++ ?>.</td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-amber-700"><?= esc($customer['id_customer']) ?></td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900"><?= esc($customer['nama_customer']) ?></td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900"><?= esc($customer['no_hp']) ?></td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500"><?= esc($customer['email']) ?></td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                    <div class="flex items-center space-x-3">
                                        <a href="<?= base_url('customer/edit/' . $customer['id']) ?>" class="text-amber-600 hover:text-amber-900"><svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor"><path d="M13.586 3.586a2 2 0 112.828 2.828l-.793.793-2.828-2.828.793-.793zM11.379 5.793L3 14.172V17h2.828l8.38-8.38-2.828-2.829z" /></svg></a>
                                        <form action="<?= base_url('customer/delete/' . $customer['id']) ?>" method="post" class="inline" onsubmit="return confirm('Anda yakin ingin menghapus data ini?');">
                                            <?= csrf_field() ?>
                                            <input type="hidden" name="_method" value="DELETE">
                                            <button type="submit" class="text-red-600 hover:text-red-900"><svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor"><path fill-rule="evenodd" d="M9 2a1 1 0 00-.894.553L7.382 4H4a1 1 0 000 2v10a2 2 0 002 2h8a2 2 0 002-2V6a1 1 0 100-2h-3.382l-.724-1.447A1 1 0 0011 2H9zM7 8a1 1 0 011-1h4a1 1 0 110 2H8a1 1 0 01-1-1zm6 4a1 1 0 10-2 0v3a1 1 0 102 0v-3z" clip-rule="evenodd" /></svg></button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>

            <div class="mt-6 flex justify-end">
                <?php if ($pager): ?>
                    <?= $pager->links('customers', 'pagination_tailwind') ?>
                <?php endif; ?>
            </div>
        <?php endif; ?>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    
    // --- START: KODE UNTUK REDIRECT KE HALAMAN TERAKHIR ---
    <?php 
        // Tambahkan pengecekan session flashdata di sini
        if (
            isset($pager) && 
            $pager->getPageCount('customers') > 1 && 
            empty($search_query) && 
            !session()->getFlashdata('success') && 
            !session()->getFlashdata('error')
        ): 
    ?>
        const urlParamsRedirect = new URLSearchParams(window.location.search);
        
        if (!urlParamsRedirect.has('page_customers')) {
            const lastPage = <?= $pager->getPageCount('customers') ?>;
            urlParamsRedirect.set('page_customers', lastPage);
            window.location.href = `<?= current_url() ?>?${urlParamsRedirect.toString()}`;
        }
    <?php endif; ?>
    // --- END: KODE REDIRECT ---

    // Fitur pencarian otomatis
    const searchForm = document.getElementById('searchForm');
    const searchInput = document.getElementById('search');
    let searchTimeout;

    searchInput.addEventListener('input', function() {
        clearTimeout(searchTimeout);
        searchTimeout = setTimeout(() => {
            searchForm.submit();
        }, 500);
    });
});
</script>

<?= $this->endSection() ?>