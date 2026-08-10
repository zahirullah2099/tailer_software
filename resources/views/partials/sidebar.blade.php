<aside
    :class="sidebarOpen ? 'w-72' : 'w-20'"
    class="fixed top-16 left-0 h-[calc(100vh-4rem)] bg-slate-900 text-white transition-all duration-300 shadow-lg overflow-y-auto">

    <div class="py-6">

        <!-- Dashboard -->
        <a href="{{ route('dashboard') }}"
           class="flex items-center px-6 py-3 hover:bg-slate-800">

            <i class="fa-solid fa-gauge-high w-6 text-center"></i>

            <span
                x-show="sidebarOpen"
                x-transition
                class="ml-4">
                Dashboard
            </span>

        </a>

        <!-- Customers -->
        <div x-data="{ open: true }">

            <button
                @click="open = !open"
                class="w-full flex items-center justify-between px-6 py-3 hover:bg-slate-800">

                <div class="flex items-center">

                    <i class="fa-solid fa-users w-6 text-center"></i>

                    <span
                        x-show="sidebarOpen"
                        class="ml-4">
                        Customers
                    </span>

                </div>

                <i
                    x-show="sidebarOpen"
                    :class="open ? 'fa-chevron-up' : 'fa-chevron-down'"
                    class="fa-solid text-xs">
                </i>

            </button>

            <div
                x-show="open && sidebarOpen"
                x-transition>

                <a href="{{ route('customers.index') }}" class="block pl-16 py-2 hover:bg-slate-800">
                    All Customers
                </a>

                <a href="{{ route('customers.create') }}" class="block pl-16 py-2 hover:bg-slate-800">
                    Add Customer
                </a>

            </div>

        </div>

        <!-- Orders -->
        <div x-data="{ open: true }">

            <button
                @click="open = !open"
                class="w-full flex items-center justify-between px-6 py-3 hover:bg-slate-800">

                <div class="flex items-center">

                    <i class="fa-solid fa-file-invoice w-6 text-center"></i>

                    <span
                        x-show="sidebarOpen"
                        class="ml-4">
                        Orders
                    </span>

                </div>

                <i
                    x-show="sidebarOpen"
                    :class="open ? 'fa-chevron-up' : 'fa-chevron-down'"
                    class="fa-solid text-xs">
                </i>

            </button>

            <div
                x-show="open && sidebarOpen"
                x-transition>

                <a href="{{ route('orders.create') }}" class="block pl-16 py-2 hover:bg-slate-800">
                    New Order
                </a>

                <a href="{{ route('orders.index') }}" class="block pl-16 py-2 hover:bg-slate-800">
                    All Orders
                </a>

                <a href="{{ route('orders.pending') }}" class="block pl-16 py-2 hover:bg-slate-800">
                    Pending Orders
                </a>

                <a href="{{ route('orders.completed') }}" class="block pl-16 py-2 hover:bg-slate-800">
                    Completed Orders
                </a>

            </div>

        </div>

        <!-- Reports -->
        <a href="#" class="flex items-center px-6 py-3 hover:bg-slate-800">

            <i class="fa-solid fa-chart-column w-6 text-center"></i>

            <span
                x-show="sidebarOpen"
                class="ml-4">
                Reports
            </span>

        </a>

        <!-- Settings -->
        <a href="#" class="flex items-center px-6 py-3 hover:bg-slate-800">

            <i class="fa-solid fa-gear w-6 text-center"></i>

            <span
                x-show="sidebarOpen"
                class="ml-4">
                Settings
            </span>

        </a>

        <!-- Profile -->
        <a href="#" class="flex items-center px-6 py-3 hover:bg-slate-800">

            <i class="fa-solid fa-user w-6 text-center"></i>

            <span
                x-show="sidebarOpen"
                class="ml-4">
                Profile
            </span>

        </a>

        <!-- Logout -->
        <form method="POST" action="{{ route('logout') }}">

            @csrf

            <button
                class="w-full flex items-center px-6 py-3 hover:bg-red-700">

                <i class="fa-solid fa-right-from-bracket w-6 text-center"></i>

                <span
                    x-show="sidebarOpen"
                    class="ml-4">
                    Logout
                </span>

            </button>

        </form>

    </div>

</aside>