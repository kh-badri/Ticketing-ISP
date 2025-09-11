<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - ISP Ticketing System</title>

    <script src="https://cdn.tailwindcss.com"></script>

    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">

    <style>
        /* Menggunakan font Inter sebagai default jika tersedia */
        body {
            font-family: 'Inter', sans-serif;
        }
    </style>
</head>

<body class="bg-gray-100">

    <div class="flex items-center justify-center min-h-screen p-4">
        <div class="flex w-full max-w-5xl mx-auto overflow-hidden bg-white rounded-2xl shadow-xl">

            <div class="w-full lg:w-1/2 p-8 sm:p-12 flex flex-col justify-center">
                <div class="w-full max-w-md mx-auto">
                    <div class="flex items-center justify-start mb-8">
                        <img src="<?= base_url('public/inmeet-logo.png') ?>" alt="Logo ISP" class="h-14 w-auto mb-2">
                        <div>
                            <h1 class="md:text-2xl sm:text-xl font-bold text-amber-600 text-shadow">App Ticketing ISP</h1>

                        </div>
                    </div>

                    <form action="<?= base_url('/login') ?>" method="post" class="space-y-6">
                        <div>
                            <label for="username" class="block text-sm font-medium text-gray-700">Username</label>
                            <div class="mt-1">
                                <input id="username" name="username" type="text" required
                                    class="w-full px-4 py-3 border border-gray-300 rounded-lg shadow-sm focus:outline-none focus:ring-2 focus:ring-amber-500 focus:border-amber-500 transition duration-150 ease-in-out"
                                    placeholder="contoh: admin_teknis">
                            </div>
                        </div>

                        <div>
                            <label for="password" class="block text-sm font-medium text-gray-700">Password</label>
                            <div class="mt-1">
                                <input id="password" name="password" type="password" required
                                    class="w-full px-4 py-3 border border-gray-300 rounded-lg shadow-sm focus:outline-none focus:ring-2 focus:ring-amber-500 focus:border-amber-500 transition duration-150 ease-in-out"
                                    placeholder="••••••••">
                            </div>
                        </div>

                        <div>
                            <button type="submit"
                                class="w-full flex justify-center py-3 px-4 border border-transparent rounded-lg shadow-sm text-sm font-medium text-white bg-amber-600 hover:bg-amber-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-amber-500 transition duration-150 ease-in-out">
                                Masuk
                            </button>
                        </div>
                    </form>

                    <div class="mt-6 text-center">
                        <p class="text-sm text-gray-600">
                            Belum punya akun?
                            <a href="<?= site_url('register') ?>" class="font-medium text-amber-600 hover:text-amber-500">
                                Daftar di sini
                            </a>
                        </p>
                    </div>
                </div>
            </div>

            <div class="hidden lg:flex lg:w-1/2 items-center justify-center p-8 bg-amber-50 relative">
                <img src="https://images.unsplash.com/photo-1522071820081-009f0129c71c?q=80&w=2070&auto=format&fit=crop"
                    alt="Ilustrasi ISP" class="object-cover w-full h-full rounded-2xl">
                <div class="absolute inset-0 bg-amber-600 opacity-30 rounded-2xl"></div>
                <div class="absolute bottom-8 left-8 right-8 p-6 bg-white/80 backdrop-blur-sm rounded-lg">
                    <h3 class="text-xl font-bold text-gray-900">Manajemen Tiket Terpusat</h3>
                    <p class="mt-2 text-sm text-gray-700">Kelola semua laporan dan permintaan pelanggan dengan efisien di satu tempat.</p>
                </div>
            </div>

        </div>
    </div>

    <?php $successMessage = session()->getFlashdata('success'); ?>
    <?php if ($successMessage): ?>
        <script>
            Swal.fire({
                icon: 'success',
                title: 'Berhasil!',
                text: '<?= esc($successMessage, 'js') ?>',
                timer: 2000,
                showConfirmButton: false
            }).then(() => {
                window.location.href = "<?= base_url('/dashboard') ?>";
            });
        </script>
    <?php endif; ?>

    <?php $errorMessage = session()->getFlashdata('error'); ?>
    <?php if ($errorMessage) : ?>
        <script>
            Swal.fire({
                icon: 'error',
                title: 'Login Gagal',
                text: '<?= esc($errorMessage, 'js') ?>',
            });
        </script>
    <?php endif; ?>

</body>

</html>