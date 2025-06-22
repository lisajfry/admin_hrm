<!DOCTYPE html>
<html lang="id" class="dark">
<head>
    <meta charset="UTF-8">
    <title>Dashboard Admin - PayrollMetrics</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            darkMode: 'class'
        }

        function toggleSidebar() {
            document.getElementById('sidebar').classList.toggle('-translate-x-full');
        }

        function toggleDarkMode() {
            document.documentElement.classList.toggle('dark');
        }
    </script>
</head>
<body class="bg-gray-100 dark:bg-gray-900 dark:text-gray-100 font-sans">

<!-- Navbar -->
<nav class="bg-blue-800 text-white px-4 py-3 shadow flex justify-between items-center md:px-6">
    <div class="flex items-center gap-3">
        <button onclick="toggleSidebar()" class="md:hidden">
            <svg class="w-6 h-6" fill="none" stroke="currentColor" stroke-width="2"
                 viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round"
                      d="M4 6h16M4 12h16M4 18h16"/>
            </svg>
        </button>
        <h1 class="text-xl font-bold tracking-wide">PayrollMetrics</h1>
    </div>
    <div class="flex items-center gap-4 text-sm">
        <button onclick="toggleDarkMode()" class="hover:opacity-80 transition">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2"
                 viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round"
                      d="M12 3v1m0 16v1m8.49-8.49h1M3 12H2m15.36-6.36l.71.71M6.34 17.66l-.71.71m12.02 0l-.71-.71M6.34 6.34l.71-.71"/>
            </svg>
        </button>
        <span>Halo, <strong>Admin</strong></span>
        <form method="POST" action="{{ route('logout') }}">
            @csrf
            <button class="bg-red-500 hover:bg-red-600 px-3 py-1 rounded text-sm transition">Logout</button>
        </form>
    </div>
</nav>

<!-- Layout -->
<div class="flex min-h-screen">
    <!-- Sidebar -->
    <aside id="sidebar"
           class="bg-white dark:bg-gray-800 w-64 p-5 border-r dark:border-gray-700 shadow-sm transform md:translate-x-0 -translate-x-full fixed md:relative z-50 transition-transform duration-300 ease-in-out">
        <h2 class="text-blue-800 dark:text-blue-300 text-lg font-semibold mb-6">Navigasi</h2>
        <ul class="space-y-2 text-sm">
            @php $active = 'bg-blue-100 text-blue-700 font-semibold dark:bg-gray-700 dark:text-white'; @endphp

            @php
                $menus = [
                    ['route'=>'admin.dashboard','label'=>'Dashboard','icon'=>'home','match'=>'admin/dashboard*'],
                    ['route'=>'jabatan.index','label'=>'Jabatan','icon'=>'briefcase','match'=>'admin/jabatan*'],
                    ['route'=>'karyawan.index','label'=>'Karyawan','icon'=>'users','match'=>'admin/karyawan*'],
                    ['route'=>'absensi.index','label'=>'Absensi','icon'=>'calendar','match'=>'admin/absensi*'],
                    ['route'=>'izin.index','label'=>'Izin & Cuti','icon'=>'clock','match'=>'admin/izin*'],
                    ['route'=>'dinas.index','label'=>'Dinas','icon'=>'map','match'=>'admin/dinas*'],
                    ['route'=>'lembur.index','label'=>'Lembur','icon'=>'clock','match'=>'admin/lembur*'],
                    ['route'=>'task.index','label'=>'Task','icon'=>'check-circle','match'=>'admin/task*'],
                    ['route'=>'payroll.index','label'=>'Payroll','icon'=>'file-text','match'=>'admin/payroll*'],
                ];
            @endphp

            @foreach($menus as $menu)
                <li>
                    <a href="{{ route($menu['route']) }}"
                       class="flex items-center gap-3 px-3 py-2 rounded-lg hover:bg-gray-100 dark:hover:bg-gray-700 transition
                           {{ request()->is($menu['match']) ? $active : 'text-gray-700 dark:text-gray-300' }}">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2"
                             viewBox="0 0 24 24">
                            <use xlink:href="#icon-{{ $menu['icon'] }}" />
                        </svg>
                        {{ $menu['label'] }}
                    </a>
                </li>
            @endforeach
        </ul>
    </aside>

    <!-- Konten -->
    <main class="flex-1 px-6 py-6 bg-gray-50 dark:bg-gray-900 transition-colors duration-200">
        @yield('content')
    </main>
</div>

<!-- Footer -->
<footer class="bg-gray-100 dark:bg-gray-800 text-center py-3 text-xs text-gray-500 dark:text-gray-400">
    &copy; {{ date('Y') }} PayrollMetrics. All rights reserved.
</footer>

<!-- Inline SVG for Icons -->
<svg style="display:none;">
    <symbol id="icon-home" viewBox="0 0 24 24">
        <path d="M3 12l9-9 9 9M4 10v10h16V10" stroke-linecap="round" stroke-linejoin="round"/>
    </symbol>
    <symbol id="icon-briefcase" viewBox="0 0 24 24">
        <path d="M4 7h16v13H4zM16 3h-8v4h8z" stroke-linecap="round" stroke-linejoin="round"/>
    </symbol>
    <symbol id="icon-users" viewBox="0 0 24 24">
        <path d="M17 21v-2a4 4 0 0 0-3-3.87M9 21v-2a4 4 0 0 1 3-3.87M16 3.13a4 4 0 1 1-8 0M12 7a4 4 0 0 0-4 4" stroke-linecap="round" stroke-linejoin="round"/>
    </symbol>
    <symbol id="icon-calendar" viewBox="0 0 24 24">
        <path d="M3 8h18M8 3v2M16 3v2M3 21h18V5H3v16z" stroke-linecap="round" stroke-linejoin="round"/>
    </symbol>
    <symbol id="icon-clock" viewBox="0 0 24 24">
        <path d="M12 8v4l3 3M12 2a10 10 0 1 1 0 20 10 10 0 0 1 0-20z" stroke-linecap="round" stroke-linejoin="round"/>
    </symbol>
    <symbol id="icon-map" viewBox="0 0 24 24">
        <path d="M9 2l6 2 6-2v20l-6 2-6-2-6 2V2l6-2z" stroke-linecap="round" stroke-linejoin="round"/>
    </symbol>
    <symbol id="icon-check-circle" viewBox="0 0 24 24">
        <path d="M9 12l2 2 4-4M12 2a10 10 0 1 0 0 20 10 10 0 0 0 0-20z" stroke-linecap="round" stroke-linejoin="round"/>
    </symbol>
    <symbol id="icon-file-text" viewBox="0 0 24 24">
        <path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8zM14 2v6h6M16 13H8M16 17H8M10 9H8" stroke-linecap="round" stroke-linejoin="round"/>
    </symbol>
</svg>

</body>
</html>
