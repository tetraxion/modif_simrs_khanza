<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Dashboard Admin') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    <h3 class="text-lg font-semibold mb-4">Selamat Datang, Administrator!</h3>
                    <p class="mb-6">Anda login sebagai: <strong>{{ auth()->user()->name }}</strong></p>
                    
                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4">
                        <!-- Card Statistik -->
                        <div class="bg-blue-100 dark:bg-blue-900 p-4 rounded-lg">
                            <h4 class="font-semibold text-blue-800 dark:text-blue-200">Total Pasien</h4>
                            <p class="text-2xl font-bold text-blue-900 dark:text-blue-100">{{ \App\Models\Pasien::count() }}</p>
                        </div>

                        <div class="bg-green-100 dark:bg-green-900 p-4 rounded-lg">
                            <h4 class="font-semibold text-green-800 dark:text-green-200">Total Dokter</h4>
                            <p class="text-2xl font-bold text-green-900 dark:text-green-100">{{ \App\Models\Dokter::count() }}</p>
                        </div>

                        <div class="bg-yellow-100 dark:bg-yellow-900 p-4 rounded-lg">
                            <h4 class="font-semibold text-yellow-800 dark:text-yellow-200">Poliklinik Aktif</h4>
                            <p class="text-2xl font-bold text-yellow-900 dark:text-yellow-100">{{ \App\Models\Poliklinik::where('is_active', true)->count() }}</p>
                        </div>

                        <div class="bg-purple-100 dark:bg-purple-900 p-4 rounded-lg">
                            <h4 class="font-semibold text-purple-800 dark:text-purple-200">Kamar Tersedia</h4>
                            <p class="text-2xl font-bold text-purple-900 dark:text-purple-100">{{ \App\Models\Bed::where('status', 'Tersedia')->count() }} Beds</p>
                        </div>
                    </div>

                    <div class="mt-6">
                        <h4 class="font-semibold text-lg mb-3">Menu Manajemen</h4>
                        <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-3">
                            <a href="#" class="block p-4 bg-gray-100 dark:bg-gray-700 rounded-lg hover:bg-gray-200 dark:hover:bg-gray-600 text-center">
                                <span class="font-semibold">Data Pasien</span>
                            </a>
                            <a href="#" class="block p-4 bg-gray-100 dark:bg-gray-700 rounded-lg hover:bg-gray-200 dark:hover:bg-gray-600 text-center">
                                <span class="font-semibold">Data Dokter</span>
                            </a>
                            <a href="#" class="block p-4 bg-gray-100 dark:bg-gray-700 rounded-lg hover:bg-gray-200 dark:hover:bg-gray-600 text-center">
                                <span class="font-semibold">Poliklinik</span>
                            </a>
                            <a href="#" class="block p-4 bg-gray-100 dark:bg-gray-700 rounded-lg hover:bg-gray-200 dark:hover:bg-gray-600 text-center">
                                <span class="font-semibold">Kamar & Bed</span>
                            </a>
                            <a href="#" class="block p-4 bg-gray-100 dark:bg-gray-700 rounded-lg hover:bg-gray-200 dark:hover:bg-gray-600 text-center">
                                <span class="font-semibold">Data Obat</span>
                            </a>
                            <a href="#" class="block p-4 bg-gray-100 dark:bg-gray-700 rounded-lg hover:bg-gray-200 dark:hover:bg-gray-600 text-center">
                                <span class="font-semibold">User Management</span>
                            </a>
                            <a href="#" class="block p-4 bg-gray-100 dark:bg-gray-700 rounded-lg hover:bg-gray-200 dark:hover:bg-gray-600 text-center">
                                <span class="font-semibold">Laporan</span>
                            </a>
                            <a href="#" class="block p-4 bg-gray-100 dark:bg-gray-700 rounded-lg hover:bg-gray-200 dark:hover:bg-gray-600 text-center">
                                <span class="font-semibold">Pengaturan</span>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
