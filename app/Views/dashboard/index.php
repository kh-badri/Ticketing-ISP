<?= $this->extend('layout/layout') ?>

<?= $this->section('content') ?>

<style>
    /* Font dari Google Fonts untuk tampilan lebih modern */
    @import url('https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap');

    body {
        font-family: 'Inter', sans-serif;
    }

    /* Animasi Keyframes */
    @keyframes fadeIn {
        from { opacity: 0; transform: translateY(10px); }
        to { opacity: 1; transform: translateY(0); }
    }
    @keyframes pulse {
        50% { opacity: .5; }
    }
    @keyframes shine {
        100% { left: 125%; }
    }

    /* Utilitas Animasi */
    .animate-fade-in {
        animation: fadeIn 0.5s ease-out forwards;
    }
    .animate-pulse {
        animation: pulse 2s cubic-bezier(0.4, 0, 0.6, 1) infinite;
    }

    /* Efek Shine/Kilau pada Kartu */
    .shine-effect {
        position: relative;
        overflow: hidden;
    }
    .shine-effect::after {
        content: '';
        position: absolute;
        top: 0;
        left: -100%;
        width: 40%;
        height: 100%;
        background: linear-gradient(90deg, transparent, rgba(255, 255, 255, 0.4), transparent);
        transition: left 0.5s;
        animation: shine 2.5s infinite linear;
    }

    /* Styling untuk Donut Chart */
    @property --p {
        syntax: '<number>';
        inherits: true;
        initial-value: 0;
    }
    .donut-chart {
        --w: 120px; /* Lebar chart */
        --b: 12px;  /* Ketebalan garis */
        --c: #fb923c; /* Warna utama (oranye) */
        --g: #e5e7eb; /* Warna latar belakang (abu-abu) */
        width: var(--w);
        height: var(--w);
        border-radius: 50%;
        display: grid;
        place-content: center;
        position: relative;
        font-weight: 800;
        font-size: 1.5rem;
        color: var(--c);
        transition: --p 1.5s cubic-bezier(0.25, 1, 0.5, 1); /* Transisi halus */
    }
    .donut-chart:before {
        content: "";
        position: absolute;
        inset: 0;
        border-radius: 50%;
        background: conic-gradient(var(--c) calc(var(--p) * 1%), var(--g) 0);
        -webkit-mask: radial-gradient(farthest-side, #0000 calc(99% - var(--b)), #000 calc(100% - var(--b)));
        mask: radial-gradient(farthest-side, #0000 calc(99% - var(--b)), #000 calc(100% - var(--b)));
    }
    
    /* Delay animasi agar muncul berurutan */
    <?php for ($i = 1; $i <= 10; $i++): ?>
    .animation-delay-<?= $i * 100 ?> { animation-delay: <?= $i * 100 ?>ms; }
    <?php endfor; ?>
</style>

<div class="bg-gray-100 min-h-screen">
    
    <div id="dashboard-loader" class="container mx-auto px-4 py-8 sm:px-6 lg:px-8">
        <div class="h-10 w-3/4 bg-gray-300 rounded-lg animate-pulse mb-2"></div>
        <div class="h-6 w-1/2 bg-gray-200 rounded-lg animate-pulse mb-10"></div>
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-6">
            <div class="h-32 bg-gray-200 rounded-xl animate-pulse"></div>
            <div class="h-32 bg-gray-200 rounded-xl animate-pulse"></div>
            <div class="h-32 bg-gray-200 rounded-xl animate-pulse"></div>
            <div class="h-32 bg-gray-200 rounded-xl animate-pulse lg:col-span-2 xl:col-span-1"></div>
            <div class="h-64 bg-gray-200 rounded-xl animate-pulse lg:col-span-2"></div>
            <div class="h-64 bg-gray-200 rounded-xl animate-pulse lg:col-span-2"></div>
        </div>
    </div>
    
    <div id="dashboard-content" class="container mx-auto px-4 py-8 sm:px-6 lg:px-8 hidden">
        <div class="animate-fade-in">
            <h1 class="text-4xl font-extrabold tracking-tight text-gray-900">Dashboard</h1>
            <p class="mt-2 text-lg text-gray-600">Selamat datang kembali! Analisis data interaktif dan real-time.</p>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mt-8">
            <div class="animate-fade-in animation-delay-100 opacity-0 bg-white p-6 rounded-2xl shadow-lg transform transition-transform duration-300 hover:-translate-y-1">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm font-medium text-gray-500">Total Customers</p>
                        <p class="count-up text-4xl font-bold text-gray-800" data-target="<?= $totalCustomers ?>">0</p>
                    </div>
                    <div class="p-3 bg-orange-100 rounded-xl"><i class="fa-solid fa-users text-orange-500 text-2xl"></i></div>
                </div>
            </div>

            <div class="animate-fade-in animation-delay-200 opacity-0 bg-white p-6 rounded-2xl shadow-lg transform transition-transform duration-300 hover:-translate-y-1">
                 <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm font-medium text-gray-500">Total Petugas</p>
                        <p class="count-up text-4xl font-bold text-gray-800" data-target="<?= $totalPetugas ?>">0</p>
                    </div>
                    <div class="p-3 bg-blue-100 rounded-xl"><i class="fa-solid fa-screwdriver-wrench text-blue-500 text-2xl"></i></div>
                </div>
            </div>

            <div class="animate-fade-in animation-delay-300 opacity-0 bg-white p-6 rounded-2xl shadow-lg transform transition-transform duration-300 hover:-translate-y-1">
                 <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm font-medium text-gray-500">Tiket Open</p>
                        <p class="count-up text-4xl font-bold text-gray-800" data-target="<?= $ticketsOpen ?>">0</p>
                    </div>
                    <div class="p-3 bg-yellow-100 rounded-xl"><i class="fa-solid fa-folder-open text-yellow-500 text-2xl"></i></div>
                </div>
            </div>

            <div class="animate-fade-in animation-delay-400 opacity-0 bg-white p-6 rounded-2xl shadow-lg transform transition-transform duration-300 hover:-translate-y-1">
                 <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm font-medium text-gray-500">Tiket Closed</p>
                        <p class="count-up text-4xl font-bold text-gray-800" data-target="<?= $ticketsClosed ?>">0</p>
                    </div>
                    <div class="p-3 bg-green-100 rounded-xl"><i class="fa-solid fa-check-double text-green-500 text-2xl"></i></div>
                </div>
            </div>
            
            <div class="animate-fade-in animation-delay-500 opacity-0 md:col-span-2 lg:col-span-2 bg-white p-6 rounded-2xl shadow-lg">
                <h3 class="text-lg font-bold text-gray-800 mb-4">Ringkasan Status Tiket</h3>
                <?php
                    $totalStatus = ($ticketsOpen + $ticketsProgress + $ticketsClosed) ?: 1;
                    $openPercentage = ($ticketsOpen / $totalStatus) * 100;
                    $progressPercentage = ($ticketsProgress / $totalStatus) * 100;
                    $closedPercentage = ($ticketsClosed / $totalStatus) * 100;
                ?>
                <div class="flex flex-wrap items-center justify-around gap-4">
                    <div class="text-center">
                        <div class="donut-chart" style="--c:#3b82f6;" data-value="<?= round($openPercentage) ?>"></div>
                        <p class="mt-2 text-sm font-semibold text-gray-600">Open</p>
                    </div>
                    <div class="text-center">
                        <div class="donut-chart" style="--c:#f59e0b;" data-value="<?= round($progressPercentage) ?>"></div>
                        <p class="mt-2 text-sm font-semibold text-gray-600">In Progress</p>
                    </div>
                    <div class="text-center">
                        <div class="donut-chart" style="--c:#22c55e;" data-value="<?= round($closedPercentage) ?>"></div>
                        <p class="mt-2 text-sm font-semibold text-gray-600">Closed</p>
                    </div>
                </div>
            </div>
            
            <div class="animate-fade-in animation-delay-600 opacity-0 lg:col-span-2 bg-white p-6 rounded-2xl shadow-lg">
                <h3 class="text-lg font-bold text-gray-800 mb-4">Tiket Terbaru</h3>
                <div class="overflow-y-auto max-h-80 pr-2">
                    <table class="min-w-full hidden md:table">
                        <tbody>
                        <?php if (empty($recentTickets)): ?>
                            <tr><td class="text-center py-8 text-gray-500">Belum ada tiket.</td></tr>
                        <?php else: ?>
                            <?php foreach (array_slice($recentTickets, 0, 5) as $ticket): ?>
                                <tr class="border-b border-gray-100 hover:bg-orange-50 transition">
                                    <td class="p-3">
                                        <p class="font-bold text-orange-600"><?= esc($ticket['code_ticket']) ?></p>
                                        <p class="text-xs text-gray-500"><?= esc($ticket['nama_customer_ticket']) ?></p>
                                    </td>
                                    <td class="p-3 text-right">
                                        <span class="px-2 py-1 inline-flex text-xs font-semibold rounded-md capitalize 
                                            <?= $ticket['status'] == 'open' ? 'bg-blue-100 text-blue-800' : ($ticket['status'] == 'progress' ? 'bg-yellow-100 text-yellow-800' : 'bg-green-100 text-green-800') ?>">
                                            <?= esc($ticket['status']) ?>
                                        </span>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        <?php endif; ?>
                        </tbody>
                    </table>
                    
                    <div class="md:hidden space-y-4">
                    <?php if (empty($recentTickets)): ?>
                        <p class="text-center py-8 text-gray-500">Belum ada tiket.</p>
                    <?php else: ?>
                        <?php foreach (array_slice($recentTickets, 0, 5) as $ticket): ?>
                            <div class="bg-gray-50 border border-gray-200 rounded-lg p-4">
                                <div class="flex justify-between items-start">
                                    <div>
                                        <p class="font-bold text-orange-600"><?= esc($ticket['code_ticket']) ?></p>
                                        <p class="text-sm text-gray-600"><?= esc($ticket['nama_customer_ticket']) ?></p>
                                    </div>
                                    <span class="px-2 py-1 text-xs font-semibold rounded-md capitalize 
                                        <?= $ticket['status'] == 'open' ? 'bg-blue-100 text-blue-800' : ($ticket['status'] == 'progress' ? 'bg-yellow-100 text-yellow-800' : 'bg-green-100 text-green-800') ?>">
                                        <?= esc($ticket['status']) ?>
                                    </span>
                                </div>
                                <p class="mt-2 text-xs text-gray-500">Keluhan: <?= esc($ticket['keluhan']) ?></p>
                            </div>
                        <?php endforeach; ?>
                    <?php endif; ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>


<script>
document.addEventListener('DOMContentLoaded', () => {

    // --- LOGIKA SKELETON LOADER ---
    const loader = document.getElementById('dashboard-loader');
    const content = document.getElementById('dashboard-content');
    
    // Simulasikan waktu loading, misalnya 1.5 detik
    setTimeout(() => {
        if(loader) loader.classList.add('hidden');
        if(content) {
            content.classList.remove('hidden');
            // Jalankan observer SETELAH konten ditampilkan
            initializeAnimations();
        }
    }, 1500);


    // --- LOGIKA ANIMASI SAAT SCROLL ---
    const initializeAnimations = () => {
        // Fungsi untuk animasi Count-Up
        const countUp = (el) => {
            const target = parseInt(el.dataset.target, 10);
            if (isNaN(target)) return;
            let current = 0;
            const step = Math.max(1, Math.ceil(target / 100)); // Langkah increment
            
            const updateCount = () => {
                current += step;
                if (current >= target) {
                    el.innerText = target.toLocaleString('id-ID');
                } else {
                    el.innerText = current.toLocaleString('id-ID');
                    requestAnimationFrame(updateCount);
                }
            };
            requestAnimationFrame(updateCount);
        };

        // Fungsi untuk animasi Donut Chart
        const animateDonut = (el) => {
            const value = el.dataset.value;
            if (!value) return;
            el.style.setProperty('--p', value);
            // Animasikan teks di tengah chart
            let current = 0;
            const interval = setInterval(() => {
                if (current >= parseInt(value)) {
                    clearInterval(interval);
                    current = value;
                }
                el.innerText = `${current}%`;
                current++;
            }, 15);
        };

        // Intersection Observer
        const observer = new IntersectionObserver((entries, observer) => {
            entries.forEach(entry => {
                if (entry.isIntersecting) {
                    if (entry.target.classList.contains('count-up')) {
                        countUp(entry.target);
                    }
                    if (entry.target.classList.contains('donut-chart')) {
                        animateDonut(entry.target);
                    }
                    observer.unobserve(entry.target);
                }
            });
        }, { threshold: 0.5 }); // Trigger saat 50% elemen terlihat

        document.querySelectorAll('.count-up, .donut-chart').forEach(el => {
            observer.observe(el);
        });
    };
});
</script>

<?= $this->endSection() ?>