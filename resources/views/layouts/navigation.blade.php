<nav x-data="{ open: false }" class="bg-white border-b border-gray-100">
    <!-- Primary Navigation Menu -->
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between h-16">
            <div class="flex">
                <!-- Logo -->
                <div class="shrink-0 flex items-center">
                    <a href="{{ route('static.home') }}">
                        <x-application-logo class="block h-9 w-auto fill-current text-blue-500" />
                    </a>
                </div>

                <!-- Navigation Links -->
                <div class="hidden space-x-8 sm:-my-px sm:ml-10 sm:flex">
                    <x-nav-link :href="route('static.home')" :active="request()->routeIs('static.home')">
                        {{ __('Home') }}
                    </x-nav-link>
                </div>

                <div class="hidden space-x-8 sm:-my-px sm:ms-10 sm:flex">
                    <x-nav-link :href="route('dashboard')" :active="request()->routeIs('dashboard')">
                        {{ __('Dashboard') }}
                    </x-nav-link>
                </div>

                <!-- Users Link (Only for Super Admin and Admin) -->
                @role('Super Admin|Admin|Staff')
                    <div class="hidden space-x-8 sm:-my-px sm:ml-10 sm:flex">
                        <x-nav-link :href="route('users.index')" :active="request()->routeIs('users.index')">
                            {{ __('Users') }}
                        </x-nav-link>
                    </div>
                @endrole

                <!-- Roles & Permissions (Only for Super Admin) -->
                @role('Super Admin')
                    <div class="hidden space-x-8 sm:-my-px sm:ml-10 sm:flex">
                        <x-nav-link :href="route('roles-permissions.index')" :active="request()->routeIs('roles-permissions.index')">
                            {{ __('Roles & Permission') }}
                        </x-nav-link>
                    </div>
                @endrole

                <!-- Lessons (Available to Super Admin, Admin, Staff, and Student) -->
                @role('Super Admin|Admin|Staff|Student')
                    <div class="hidden space-x-8 sm:-my-px sm:ms-10 sm:flex">
                        <x-nav-link :href="route('lessons.index')" :active="request()->routeIs('lessons.index')">
                            {{ __('Lessons') }}
                        </x-nav-link>
                    </div>
                @endrole

                <!-- Courses (Only for Super Admin, Admin, Staff and Student) -->
                @role('Super Admin|Admin|Staff|Student')
                    <div class="hidden space-x-8 sm:-my-px sm:ms-10 sm:flex">
                        <x-nav-link :href="route('course')" :active="request()->routeIs('course')">
                            {{ __('Courses') }}
                        </x-nav-link>
                    </div>
                @endrole

                <!-- Clusters -->
                @role('Super Admin|Admin|Staff|Student')
                    <div class="hidden space-x-8 sm:-my-px sm:ms-10 sm:flex">
                        <x-nav-link :href="route('cluster')" :active="request()->routeIs('cluster')">
                            {{ __('Clusters') }}
                        </x-nav-link>
                    </div>
                @endrole

                <!-- Units -->
                @role('Super Admin|Admin|Staff')
                    <div class="hidden space-x-8 sm:-my-px sm:ms-10 sm:flex">
                        <x-nav-link :href="route('unit')" :active="request()->routeIs('unit')">
                            {{ __('Units') }}
                        </x-nav-link>
                    </div>
                @endrole

                <!-- Packages -->
                @role('Super Admin|Admin|Staff')
                    <div class="hidden space-x-8 sm:-my-px sm:ms-10 sm:flex">
                        <x-nav-link :href="route('package')" :active="request()->routeIs('package')">
                            {{ __('Packages') }}
                        </x-nav-link>
                    </div>
                @endrole

            </div>

            <div class="hidden sm:flex sm:items-center sm:ml-6">
                @auth
                    <div class="flex items-center space-x-4">
                        <x-nav-link  :href="route('profile.edit')" >
                            <div class="text-blue-500 font-bold italic">{{ Auth::user()->preffered_name ?? Auth::user()->given_name }}</div>
                        </x-nav-link>

                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <button type="submit" class="text-blue-500 hover:text-blue-700 font-bold border-b-2 border-blue-300 hover:border-blue-700 pb-1 transition duration-300 ease-in-out">
                                {{ __('Logout') }}
                            </button>
                        </form>
                    </div>
                @else
                    <div class="flex space-x-4">
                        <a href="{{ route('login') }}" class="text-blue-500 hover:text-blue-700 font-bold border-b-2 border-blue-300 hover:border-blue-700 pb-1 transition duration-300 ease-in-out">
                            {{ __('Login') }}
                        </a>
                        <a href="{{ route('register') }}" class="text-blue-500 hover:text-blue-700 font-bold border-b-2 border-blue-300 hover:border-blue-700 pb-1 transition duration-300 ease-in-out">
                            {{ __('Register') }}
                        </a>
                    </div>
                @endauth
            </div>


            <!-- Hamburger -->
            <div class="-me-2 flex items-center sm:hidden">
                <button @click="open = ! open" class="inline-flex items-center justify-center p-2 rounded-md text-gray-400 hover:text-gray-500 hover:bg-gray-100 focus:outline-none focus:bg-gray-100 focus:text-gray-500 transition duration-150 ease-in-out">
                    <svg class="h-6 w-6" stroke="currentColor" fill="none" viewBox="0 0 24 24">
                        <path :class="{'hidden': open, 'inline-flex': ! open }" class="inline-flex" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                        <path :class="{'hidden': ! open, 'inline-flex': open }" class="hidden" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>
        </div>
    </div>

    <!-- Responsive Navigation Menu -->
    <div :class="{'block': open, 'hidden': ! open}" class="hidden sm:hidden">

        <div class="pt-2 pb-3 space-y-1">
            <x-responsive-nav-link :href="route('dashboard')" :active="request()->routeIs('dashboard')">
                {{ __('Dashboard') }}
            </x-responsive-nav-link>
        </div>

        <!-- Responsive Settings Options -->
         @auth
            <div class="pt-4 pb-1 border-t border-gray-200">
                <div class="px-4">
                    <div class="font-medium text-base text-gray-800">{{ Auth::user()->name }}</div>
                    <div class="font-medium text-sm text-gray-500">{{ Auth::user()->email }}</div>
                </div>

                <div class="mt-3 space-y-1">
                    <x-responsive-nav-link :href="route('profile.edit')">
                        {{ __('Profile') }}
                    </x-responsive-nav-link>

                    <!-- Authentication -->
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf

                        <x-responsive-nav-link :href="route('logout')"
                                               onclick="event.preventDefault();
                                                          this.closest('form').submit();">
                            {{ __('Logout') }}
                        </x-responsive-nav-link>
                    </form>
                </div>
            </div>
        @else
            <div class="pt-4 pb-1 border-t border-gray-200">
                <div class="mt-3 space-y-1">
                    <x-responsive-nav-link :href="route('login')">
                        {{ __('Login') }}
                    </x-responsive-nav-link>
                    <x-responsive-nav-link :href="route('register')">
                        {{ __('Register') }}
                    </x-responsive-nav-link>
                </div>
            </div>
        @endauth
    </div>
</nav>
