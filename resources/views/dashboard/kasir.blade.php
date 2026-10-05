<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Dashboard Kasir') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    <h3 class="text-lg font-semibold mb-4">Selamat Datang, {{ auth()->user()->name }}!</h3>
                    
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-6">
                        <div class="bg-red-100 dark:bg-red-900 p-4 rounded-lg">
                            <h4 class="font-semibold text-red-800 dark:text-red-200">Belum Dibayar</h4>
                            <p class="text-2xl font-bold text-red-900 dark:text-red-100">
                                {{ \App\Models\Billing::where('status', 'Belum Dibayar')->count() }}
                            </p>
                        </div>

                        <div class="bg-yellow-100 dark:bg-yellow-900 p-4 rounded-lg">
                            <h4 class="font-semibold text-yellow-800 dark:text-yellow-200">Dibayar Sebagian</h4>
                            <p class="text-2xl font-bold text-yellow-900 dark:text-yellow-100">
                                {{ \App\Models\Billing::where('status', 'Dibayar Sebagian')->count() }}
                            </p>
                        </div>

                        <div class="bg-green-100 dark:bg-green-900 p-4 rounded-lg">
                            <h4 class="font-semibold text-green-800 dark:text-green-200">Lunas Hari Ini</h4>
                            <p class="text-2xl font-bold text-green-900 dark:text-green-100">
                                {{ \App\Models\Billing::where('status', 'Lunas')->whereDate('updated_at', today())->count() }}
                            </p>
                        </div>
                    </div>

                    <div>
                        <h4 class="font-semibold text-lg mb-3">Menu</h4>
                        <div class="grid grid-cols-2 md:grid-cols-3 gap-3">
                            <a href="#" class="block p-4 bg-gray-100 dark:bg-gray-700 rounded-lg hover:bg-gray-200 dark:hover:bg-gray-600 text-center">
                                <span class="font-semibold">Pembayaran Rawat Jalan</span>
                            </a>
                            <a href="#" class="block p-4 bg-gray-100 dark:bg-gray-700 rounded-lg hover:bg-gray-200 dark:hover:bg-gray-600 text-center">
                                <span class="font-semibold">Pembayaran Rawat Inap</span>
                            </a>
                            <a href="#" class="block p-4 bg-gray-100 dark:bg-gray-700 rounded-lg hover:bg-gray-200 dark:hover:bg-gray-600 text-center">
                                <span class="font-semibold">Riwayat Transaksi</span>
                            </a>
                            <a href="#" class="block p-4 bg-gray-100 dark:bg-gray-700 rounded-lg hover:bg-gray-200 dark:hover:bg-gray-600 text-center">
                                <span class="font-semibold">Laporan Keuangan</span>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
