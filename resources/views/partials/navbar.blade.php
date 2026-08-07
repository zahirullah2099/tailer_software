<nav class="sticky top-0 z-50 bg-white border-b border-gray-200 shadow-sm">

    <div class="flex items-center justify-between h-16 px-6">

        <!-- Left Side -->
        <div class="flex items-center space-x-4">

            <!-- Sidebar Toggle -->
            

            <button @click="sidebarOpen = !sidebarOpen" class="w-10 h-10 rounded-lg hover:bg-gray-100">
                <i class="fa-solid fa-bars"></i>
            </button>

            <!-- Logo -->
            <div class="flex items-center space-x-3">

                <div class="w-10 h-10 rounded-lg bg-blue-600 flex items-center justify-center">

                    <i class="fa-solid fa-scissors text-white"></i>

                </div>

                <div>

                    <h1 class="text-lg font-bold text-gray-800">

                        Tailor Management

                    </h1>

                    <p class="text-xs text-gray-500">

                        Management System

                    </p>

                </div>

            </div>

        </div>

        <!-- Right Side -->
        <div class="relative">

            <button id="userMenuButton"
                class="flex items-center space-x-3 px-3 py-2 rounded-lg hover:bg-gray-100 transition">

                <div class="w-10 h-10 rounded-full bg-blue-600 flex items-center justify-center">

                    <i class="fa-solid fa-user text-white"></i>

                </div>

                <div class="text-left">

                    <h4 class="font-semibold text-sm">

                        {{ auth()->user()->name }}

                    </h4>

                    <p class="text-xs text-gray-500">

                        Administrator

                    </p>

                </div>

                <i class="fa-solid fa-chevron-down text-xs text-gray-500"></i>

            </button>

            <!-- Dropdown -->
            <div id="userDropdown"
                class="hidden absolute right-0 mt-3 w-56 bg-white rounded-xl shadow-lg border border-gray-200 overflow-hidden">

                <a href="#" class="flex items-center px-4 py-3 hover:bg-gray-100">

                    <i class="fa-solid fa-user mr-3 text-blue-600"></i>

                    Profile

                </a>

                <a href="#" class="flex items-center px-4 py-3 hover:bg-gray-100">

                    <i class="fa-solid fa-key mr-3 text-green-600"></i>

                    Change Password

                </a>

                <hr>

                <form action="{{ route('logout') }}" method="POST">

                    @csrf

                    <button class="w-full text-left flex items-center px-4 py-3 hover:bg-red-50 text-red-600">

                        <i class="fa-solid fa-right-from-bracket mr-3"></i>

                        Logout

                    </button>

                </form>

            </div>

        </div>

    </div>

</nav>

<script>
    const button = document.getElementById('userMenuButton');
    const dropdown = document.getElementById('userDropdown');

    button.addEventListener('click', () => {

        dropdown.classList.toggle('hidden');

    });

    window.addEventListener('click', function(e) {

        if (!button.contains(e.target) && !dropdown.contains(e.target)) {

            dropdown.classList.add('hidden');

        }

    });
</script>
