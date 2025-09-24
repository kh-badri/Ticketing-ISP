<aside class="flex flex-col h-full">
    <div class="flex flex-col items-center p-3 sm:p-4 md:p-6">
        <img
            id="profileImage"
            src="<?= base_url('uploads/foto_profil/' . esc(session()->get('foto')) . '?t=' . time()) ?>"
            alt="Foto Profil"
            class="w-14 h-14 sm:w-18 sm:h-18 md:w-24 md:h-24 lg:w-28 lg:h-28 rounded-full object-cover select-none cursor-pointer
                   ring-4 ring-amber-600 transition-all duration-200">
        <div class="mt-2 sm:mt-3 md:mt-4 text-center">
            <p class="text-sm sm:text-base md:text-lg font-bold text-amber-800 leading-tight">
                Hallo, <?= esc(session()->get('username')) ?>
            </p>
            <div class="flex items-center justify-center mt-1 sm:mt-1.5 md:mt-2 space-x-1">
                <span class="w-2 h-2 sm:w-2.5 sm:h-2.5 rounded-full bg-green-500 shadow-md"></span>
                <span class="text-xs sm:text-sm text-gray-600 font-medium">Online</span>
            </div>
        </div>
    </div>

    <nav class="flex-grow p-2 sm:p-3 md:p-4">
        <hr class="border-gray-200 mb-2 sm:mb-3 md:mb-4">
        <ul class="space-y-1 sm:space-y-1.5 md:space-y-2" role="menu">
            <li role="none">
                <a href="<?= base_url('/') ?>" ;
                    role="menuitem"
                    class="flex items-center gap-2 sm:gap-2.5 md:gap-3 px-2 sm:px-3 md:px-4 py-2 sm:py-2 md:py-2.5 rounded-lg transition-all duration-200
                    <?= (current_url() == base_url() || ($active_menu ?? '') === 'dashboard') ? 'bg-amber-600 text-white font-semibold shadow-md' : 'text-black hover:bg-amber-600 hover:text-white' ?>">
                    <i class="fa-solid fa-house w-4 sm:w-4 md:w-5 text-center text-sm sm:text-base" aria-hidden="true"></i>
                    <span class="font-medium text-sm sm:text-sm md:text-base">Dashboard</span>
                </a>
            </li>
            <li role="none">
                <a href="<?= base_url('/customer') ?>"
                    role="menuitem"
                    class="flex items-center gap-2 sm:gap-2.5 md:gap-3 px-2 sm:px-3 md:px-4 py-2 sm:py-2 md:py-2.5 rounded-lg transition-all duration-200
                    <?= ($active_menu ?? '') === 'customer' ? 'bg-amber-600 text-white font-semibold shadow-md' : 'text-black hover:bg-amber-600 hover:text-white' ?>">
                    <i class="fa-solid fa-user-group w-4 sm:w-4 md:w-5 text-center text-sm sm:text-base" aria-hidden="true"></i>
                    <span class="font-medium text-sm sm:text-sm md:text-base">Customer</span>
                </a>
            </li>
            <li role="none">
                <a href="<?= base_url('/petugas') ?>"
                    role="menuitem"
                    class="flex items-center gap-2 sm:gap-2.5 md:gap-3 px-2 sm:px-3 md:px-4 py-2 sm:py-2 md:py-2.5 rounded-lg transition-all duration-200
                    <?= ($active_menu ?? '') === 'petugas' ? 'bg-amber-600 text-white font-semibold shadow-md' : 'text-black hover:bg-amber-600 hover:text-white' ?>">
                    <i class="fa-solid fa-headset w-4 sm:w-4 md:w-5 text-center text-sm sm:text-base" aria-hidden="true"></i>
                    <span class="font-medium text-sm sm:text-sm md:text-base leading-tight">Petugas</span>
                </a>
            </li>
            <li role="none">
                <a href="<?= base_url('/tickets') ?>"
                    role="menuitem"
                    class="flex items-center gap-2 sm:gap-2.5 md:gap-3 px-2 sm:px-3 md:px-4 py-2 sm:py-2 md:py-2.5 rounded-lg transition-all duration-200
                    <?= ($active_menu ?? '') === 'tickets' ? 'bg-amber-600 text-white font-semibold shadow-md' : 'text-black hover:bg-amber-600 hover:text-white' ?>">
                    <i class="fa-solid fa-ticket w-4 sm:w-4 md:w-5 text-center text-sm sm:text-base" aria-hidden="true"></i>
                    <span class="font-medium text-sm sm:text-sm md:text-base leading-tight">Tickets</span>
                </a>
            </li>
            <li role="none">
                <a href="<?= base_url('/broadcast') ?>"
                    role="menuitem"
                    class="flex items-center gap-2 sm:gap-2.5 md:gap-3 px-2 sm:px-3 md:px-4 py-2 sm:py-2 md:py-2.5 rounded-lg transition-all duration-200
        <?= ($active_menu ?? '') === 'broadcast' ? 'bg-amber-600 text-white font-semibold shadow-md' : 'text-black hover:bg-amber-600 hover:text-white' ?>">

                    <i class="fa-solid fa-tower-broadcast w-4 sm:w-4 md:w-5 text-center text-sm sm:text-base" aria-hidden="true"></i>

                    <span class="font-medium text-sm sm:text-sm md:text-base leading-tight">Broadcast</span>
                </a>
            </li>
        </ul>
    </nav>

    <div class="p-2 sm:p-3 md:p-4 mt-auto">
        <ul class="space-y-1 sm:space-y-1.5 md:space-y-2" role="menu">
            <li role="none">
                <a href="<?= base_url('/akun') ?>"
                    role="menuitem"
                    class="flex items-center gap-2 sm:gap-2.5 md:gap-3 px-2 sm:px-3 md:px-4 py-2 sm:py-2 md:py-2.5 rounded-lg transition-all duration-200
                    <?= ($active_menu ?? '') === 'akun' ? 'bg-amber-600 text-white font-semibold shadow-md' : 'text-black hover:bg-amber-600 hover:text-white' ?>">
                    <i class="fa-solid fa-user w-4 sm:w-4 md:w-5 text-center text-sm sm:text-base" aria-hidden="true"></i>
                    <span class="font-medium text-sm sm:text-sm md:text-base">Akun</span>
                </a>
            </li>
            <li role="none">
                <a href="<?= site_url('logout') ?>"
                    role="menuitem"
                    class="flex items-center gap-2 sm:gap-2.5 md:gap-3 px-2 sm:px-3 md:px-4 py-2 sm:py-2 md:py-2.5 rounded-lg transition-all duration-200 text-black hover:bg-amber-600 hover:text-white">
                    <i class="fa-solid fa-right-from-bracket w-4 sm:w-4 md:w-5 text-center text-sm sm:text-base" aria-hidden="true"></i>
                    <span class="font-medium text-sm sm:text-sm md:text-base">Logout</span>
                </a>
            </li>
        </ul>
    </div>
</aside>