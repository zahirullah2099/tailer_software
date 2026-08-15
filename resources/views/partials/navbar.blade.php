<nav class="sticky top-0 z-50 bg-white border-b border-gray-200 shadow-sm">

    <div class="flex items-center justify-between h-16 px-6">

        <!-- Left: Toggle + Shop Brand -->
        <div class="flex items-center space-x-4">

            <button @click="sidebarOpen = !sidebarOpen"
                    class="w-10 h-10 rounded-lg hover:bg-gray-100 flex items-center justify-center">
                <i class="fa-solid fa-bars text-gray-600"></i>
            </button>

            <div class="flex items-center space-x-3">

                <!-- Logo: uploaded image or default scissors icon -->
                <div class="w-10 h-10 rounded-lg bg-blue-600 flex items-center justify-center overflow-hidden" id="navLogoWrapper">
                    @if ($shopLogo)
                        <img id="navLogoImg" src="{{ asset('storage/' . $shopLogo) }}"
                             alt="Logo" class="w-full h-full object-cover">
                    @else
                        <i id="navLogoIcon" class="fa-solid fa-scissors text-white"></i>
                    @endif
                </div>

                <div>
                    <h1 class="text-lg font-bold text-gray-800 leading-tight" id="navShopName">
                        {{ $shopName }}
                    </h1>
                    <p class="text-xs text-gray-500">Management System</p>
                </div>

            </div>

        </div>

        <!-- Right: User Dropdown -->
        <div class="relative">

            <button id="userMenuButton"
                    class="flex items-center space-x-3 px-3 py-2 rounded-lg hover:bg-gray-100 transition">

                <!-- Avatar -->
                <div class="w-10 h-10 rounded-full overflow-hidden bg-blue-600 flex items-center justify-center flex-shrink-0">
                    @if (auth()->user()->avatar)
                        <img id="navAvatar" src="{{ auth()->user()->avatar_url }}"
                             alt="Avatar" class="w-full h-full object-cover">
                    @else
                        <i id="navAvatarIcon" class="fa-solid fa-user text-white"></i>
                    @endif
                </div>

                <div class="text-left">
                    <h4 class="font-semibold text-sm text-gray-800">{{ auth()->user()->name }}</h4>
                    <p class="text-xs text-gray-500">Administrator</p>
                </div>

                <i class="fa-solid fa-chevron-down text-xs text-gray-500"></i>

            </button>

            <!-- Dropdown -->
            <div id="userDropdown"
                 class="hidden absolute right-0 mt-2 w-52 bg-white rounded-xl shadow-lg border border-gray-100 overflow-hidden z-50">

                <a href="{{ route('profile.index') }}"
                   class="flex items-center gap-3 px-4 py-3 text-sm text-gray-700 hover:bg-blue-50 hover:text-blue-700">
                    <i class="fa-solid fa-user w-4 text-blue-600"></i>
                    Profile &amp; Settings
                </a>

                <div class="border-t border-gray-100"></div>

                <form action="{{ route('logout') }}" method="POST">
                    @csrf
                    <button type="submit"
                            class="w-full flex items-center gap-3 px-4 py-3 text-sm text-red-600 hover:bg-red-50">
                        <i class="fa-solid fa-right-from-bracket w-4"></i>
                        Logout
                    </button>
                </form>

            </div>

        </div>

    </div>

</nav>

<script>
    const userMenuBtn = document.getElementById('userMenuButton');
    const userDropdown = document.getElementById('userDropdown');

    userMenuBtn.addEventListener('click', (e) => {
        e.stopPropagation();
        userDropdown.classList.toggle('hidden');
    });

    document.addEventListener('click', () => {
        userDropdown.classList.add('hidden');
    });
</script>
