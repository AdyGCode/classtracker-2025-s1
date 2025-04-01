<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Lessons Management') }}
        </h2>
    </x-slot>

    @auth
        <x-flash-message :data="session()"/>
    @endauth

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-md sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">

                    <div class="flex justify-between items-center mb-6">
                        <h3 class="text-xl font-bold mb-6">Lessons</h3>
                        <x-primary-link-button href="{{ route('lessons.create') }}"
                                               class="bg-zinc-200 hover:bg-zinc-900 text-zinc-800 hover:text-white">
                            <i class="fa-solid fa-user-plus "></i>
                            <span class="pl-4">Add Lesson</span>
                        </x-primary-link-button>
                    </div>

                    <div class="overflow-x-auto">
                        <table class="min-w-full text-left text-sm font-light text-surface dark:text-white">
                            <thead
                                class="border-b border-neutral-200 bg-zinc-800 font-medium text-white dark:border-white/10">
                            <tr>
                                <th scope="col" class="px-6 py-4">#</th>
                                <th scope="col" class="px-6 py-4">Name</th>
                                <th scope="col" class="px-6 py-4">Cluster ID</th>
                                <th scope="col" class="px-6 py-4">Lecture</th>
                                <th scope="col" class="px-6 py-4">Time</th>
                                <th scope="col" class="px-6 py-4">Duration</th>
                                <th scope="col" class="px-6 py-4">Actions</th>
                            </tr>
                            </thead>

                            <tbody>
                            @foreach($data as $lesson)
                                <tr class="border-b border-zinc-300 dark:border-white/10">
                                    <td class="whitespace-nowrap px-6 py-4 font-medium">{{ $loop->index + 1 }}</td>
                                    <td class="whitespace-nowrap px-6 py-4">{{ $lesson->name }}</td>
                                    <td class="whitespace-nowrap px-6 py-4 w-full">{{ $lesson->cluster_id }}</td>
                                    <td class="whitespace-nowrap px-6 py-4">{{ $lesson->users->first()?->given_name ?? '#'}}</td>
                                    <td class="whitespace-nowrap px-6 py-4">{{$lesson->weekday}} {{ $lesson->start_time }}</td>
                                    <td class="whitespace-nowrap px-6 py-4">{{ $lesson->duration }} h</td>
                                    <td class="whitespace-nowrap px-6 py-4">
                                        <form action="{{ route('lessons.destroy', $lesson) }}"
                                              method="POST"
                                              class="flex gap-4">
                                            @csrf
                                            @method('DELETE')

                                            <x-primary-link-button href="{{ route('lessons.show', $lesson) }}"
                                                                   class="bg-zinc-800">
                                                <span>Show </span>
                                                <i class="fa-solid fa-eye pr-2 order-first"></i>
                                            </x-primary-link-button>
                                            <x-primary-link-button href="{{ route('lessons.edit', $lesson) }}"
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
                                <td colspan="7" class="px-6 py-2">
                                    @if( $data->hasPages() )
                                        {{ $data->links() }}
                                    @elseif( $data->total() === 0 )
                                        <p class="text-xl">No lessons found</p>
                                    @else
                                        <p class="py-2 text-zinc-800 text-sm">All lessons shown</p>
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

