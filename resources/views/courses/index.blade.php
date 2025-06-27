<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Course Management') }}
        </h2>
    </x-slot>

    @auth
        <x-flash-message :data="session()"/>
    @endauth

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-md sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">

                    <div class="flex items-center justify-between mb-6">
                        <h3 class="text-xl font-bold">Courses</h3>

                        <div class="flex items-center space-x-4">
                            @auth
                                <form action="{{ route('courses.search') }}" method="POST" class="flex items-center space-x-2">
                                    @csrf
                                    <x-text-input type="text" name="keywords" placeholder="Course search..." value=""
                                                  class="px-4 py-2 focus:outline-none text-black w-80"/>
                                    <x-primary-button type="submit"
                                                      class="bg-sky-500 hover:bg-sky-600 text-white px-4 py-2 focus:outline-none transition ease-in-out duration-500">
                                        <i class="fa fa-search"></i> {{ __('Search') }}
                                    </x-primary-button>
                                </form>
                            @else
                                <form action="{{ route('search') }}" method="POST" class="flex items-center space-x-2">
                                    @csrf
                                    <x-text-input type="text" name="keywords" placeholder="Course search..." value=""
                                                  class="px-4 py-2 focus:outline-none text-black"/>
                                    <x-primary-button type="submit"
                                                      class="bg-sky-500 hover:bg-sky-600 text-white px-4 py-2 focus:outline-none transition ease-in-out duration-500">
                                        <i class="fa fa-search"></i> {{ __('Search') }}
                                    </x-primary-button>
                                </form>
                            @endauth

                            <x-primary-link-button href="{{ route('courses.create') }}"
                                                   class="bg-zinc-200 hover:bg-zinc-900 text-zinc-800 hover:text-white px-4 py-2">
                                <i class="fa-solid fa-user-plus"></i>
                                <span class="pl-2">Add Course</span>
                            </x-primary-link-button>
                        </div>
                    </div>

                    <div class="overflow-x-auto">
                        <table class="min-w-full text-left text-sm font-light text-surface dark:text-white">
                            <thead
                                class="border-b border-neutral-200 bg-zinc-800 font-medium text-white dark:border-white/10">
                            <tr>
                                <th scope="col" class="px-6 py-4">#</th>
                                <th scope="col" class="px-6 py-4">National Code</th>
                                <th scope="col" class="px-6 py-4">AQF Level</th>
                                <th scope="col" class="px-6 py-4">Title</th>
                                <th scope="col" class="px-6 py-4">TGA Status</th>
                                <th scope="col" class="px-6 py-4"></th>
                            </tr>
                            </thead>

                            <tbody>
                            @foreach($courses as $course)
                                <tr class="border-b border-zinc-300 text-black dark:border-white/10">
                                    <td class="whitespace-nowrap px-6 py-4 font-medium">{{ $courses->firstItem() + $loop->index }}</td>
                                    <td class="whitespace-nowrap px-6 py-4">{{ $course->national_code }}</td>
                                    <td class="whitespace-nowrap px-6 py-4">{{ $course->aqf_level }}</td>
                                    <td class="whitespace-nowrap px-6 py-4 w-full">{{ $course->title }}</td>
                                    <td class="whitespace-nowrap px-6 py-4 w-full">{{ $course->tga_status }}</td>
                                    <td class="whitespace-nowrap px-0 py-4">
                                        <form action="{{ route('courses.destroy', $course) }}"
                                              method="POST"
                                              class="flex gap-4">
                                            @csrf
                                            @method('DELETE')

                                            <x-primary-link-button href="{{ route('courses.show', $course) }}"
                                                                   class="bg-zinc-800">
                                                <span>Show </span>
                                                <i class="fa-solid fa-eye pr-2 order-first"></i>
                                            </x-primary-link-button>
                                            <x-primary-link-button href="{{ route('courses.edit', $course) }}"
                                                                   class="bg-zinc-800">
                                                <span>Edit </span>
                                                <i class="fa-solid fa-edit pr-2 order-first"></i>
                                            </x-primary-link-button>
                                            <x-secondary-button type="submit"
                                                                class="bg-zinc-200">
                                                <span>Delete</span>
                                                <i class="fa-solid fa-times pr-2 order-first"></i>
                                            </x-secondary-button>

                                        </form>
                                    </td>
                                </tr>
                            @endforeach
                            </tbody>

                            <tfoot>
                            <tr class="bg-zinc-100">
                                <td colspan="14" class="px-6 py-2 text-center">
                                    @if( $courses->hasPages() )
                                        {{ $courses->links() }}
                                    @elseif( $courses->total() === 0 )
                                        <p class="text-xl">No courses found</p>
                                    @else
                                        <p class="py-2 text-zinc-800 text-sm">All courses shown</p>
                                    @endif
                                </td>
                            </tr>
                            </tfoot>

                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
