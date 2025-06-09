<nav class="bg-white shadow">
    <div class="container mx-auto px-4">
        <div class="flex justify-between h-16">
            <div class="flex">
                <!-- Logo -->
                <div class="flex-shrink-0 flex items-center">
                    <a href="{{ route('home') }}" class="text-xl font-bold text-primary">
                        Kiansantang Store
                    </a>
                </div>

                <!-- Navigation Links -->
                <div class="hidden sm:ml-6 sm:flex sm:space-x-8">
                    <a href="{{ route('home') }}" class="inline-flex items-center px-1 pt-1 border-b-2 {{ request()->routeIs('home') ? 'border-primary text-gray-900' : 'border-transparent text-gray-500 hover:border-gray-300 hover:text-gray-700' }}">
                        Home
                    </a>
                    <a href="{{ route('products.all') }}" class="inline-flex items-center px-1 pt-1 border-b-2 {{ request()->routeIs('products.*') ? 'border-primary text-gray-900' : 'border-transparent text-gray-500 hover:border-gray-300 hover:text-gray-700' }}">
                        Products
                    </a>
                    <a href="{{ route('sales.index') }}" class="inline-flex items-center px-1 pt-1 border-b-2 {{ request()->routeIs('sales.*') ? 'border-primary text-gray-900' : 'border-transparent text-gray-500 hover:border-gray-300 hover:text-gray-700' }}">
                        Contact Sales
                    </a>
                    <a href="{{ route('info.index') }}" class="inline-flex items-center px-1 pt-1 border-b-2 {{ request()->routeIs('info.index') ? 'border-primary text-gray-900' : 'border-transparent text-gray-500 hover:border-gray-300 hover:text-gray-700' }}">
                        Store Info
                    </a>
                    @if(auth()->check() && auth()->user()->is_admin)
                        <a href="{{ route('admin.dashboard') }}" class="inline-flex items-center px-1 pt-1 border-b-2 {{ request()->routeIs('admin.dashboard') ? 'border-yellow-500 text-yellow-600' : 'border-transparent text-gray-500 hover:border-gray-300 hover:text-gray-700' }}">
                            <i class="fas fa-tools mr-1"></i> Admin Dashboard
                        </a>
                    @endif
                </div>
            </div>

            <!-- Right Side -->
            <div class="flex items-center">
                <!-- Authentication Links -->
                @guest
                    <a href="{{ route('login') }}" class="text-gray-500 hover:text-gray-700">Login</a>
                    <a href="{{ route('register') }}" class="ml-4 text-gray-500 hover:text-gray-700">Register</a>
                @else
                    <div class="ml-4 relative">
                        <button type="button" class="flex items-center text-gray-500 hover:text-gray-700 focus:outline-none" id="user-menu-button">
                            <span class="mr-2">{{ Auth::user()->name }}</span>
                            <svg class="h-5 w-5" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                                <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" />
                            </svg>
                        </button>

                        <!-- Dropdown menu -->
                        <div class="hidden origin-top-right absolute right-0 mt-2 w-48 rounded-md shadow-lg bg-white ring-1 ring-black ring-opacity-5 focus:outline-none" id="user-menu" role="menu">
                            <div class="py-1" role="none">
                                <a href="{{ route('favorites.index') }}" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100" role="menuitem">Favorites</a>
                                <form method="POST" action="{{ route('logout') }}">
                                    @csrf
                                    <button type="submit" class="block w-full text-left px-4 py-2 text-sm text-gray-700 hover:bg-gray-100" role="menuitem">Logout</button>
                                </form>
                            </div>
                        </div>
                    </div>
                @endguest
            </div>
        </div>
    </div>
</nav>

@push('scripts')
<script>
    const userMenuButton = document.getElementById('user-menu-button');
    const userMenu = document.getElementById('user-menu');

    userMenuButton.addEventListener('click', () => {
        userMenu.classList.toggle('hidden');
    });

    // Close the menu when clicking outside
    document.addEventListener('click', (event) => {
        if (!userMenuButton.contains(event.target) && !userMenu.contains(event.target)) {
            userMenu.classList.add('hidden');
        }
    });
</script>
@endpush 