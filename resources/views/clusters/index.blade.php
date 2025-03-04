<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Clusters Management') }}
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
                        <h3 class="text-xl font-bold mb-6">Clusters</h3>
                        <x-primary-link-button href="{{ route('clusters.create') }}"
                                               class="bg-zinc-200 hover:bg-zinc-900 text-zinc-800 hover:text-white">
                            <i class="fa-solid fa-user-plus "></i>
                            <span class="pl-4">Add Cluster</span>
                        </x-primary-link-button>
                    </div>

                    <div class="overflow-x-auto">
                        <table class="w-full text-left text-sm font-light text-surface dark:text-white">
                            <thead
                                class="border-b border-neutral-200 bg-zinc-800 font-medium text-white dark:border-white/10">
                            <tr>
                                <th scope="col" class="px-6 py-4">#</th>
                                <th scope="col" class="px-6 py-4">Code</th>
                                <th scope="col" class="px-6 py-4">Title</th>
                                <th scope="col" class="px-6 py-4">Qualification</th>
                                <th scope="col" class="px-6 py-4"></th>
                            </tr>
                            </thead>

                            <tbody>
                            @foreach($clusters as $cluster)
                                <tr class="border-b border-zinc-300 text-black dark:border-white/10">
                                    <td class="whitespace-nowrap px-6 py-4 font-medium">{{ $clusters->firstItem() + $loop->index }}</td>
                                    <td class="whitespace-nowrap px-6 py-4 w-full">{{ $cluster->code }}</td>
                                    <td class="whitespace-nowrap px-6 py-4 w-full">{{ $cluster->title }}</td>
                                    <td class="whitespace-nowrap px-6 py-4 w-full">{{ $cluster->qualification }}</td>
                                    <td class="whitespace-nowrap px-6 py-4 w-full">
                                        <form action="{{ route('clusters.destroy', $cluster) }}"
                                              method="POST"
                                              class="flex gap-4">
                                            @csrf
                                            @method('DELETE')

                                            <x-primary-link-button href="{{ route('clusters.show', $cluster) }}"
                                                                   class="bg-zinc-800">
                                                <span>Show </span>
                                                <i class="fa-solid fa-eye pr-2 order-first"></i>
                                            </x-primary-link-button>
                                            <x-primary-link-button href="{{ route('clusters.edit', $cluster) }}"
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
                                    @if( $clusters->hasPages() )
                                        {{ $clusters->links() }}
                                    @elseif( $clusters->total() === 0 )
                                        <p class="text-xl">No clusters found</p>
                                    @else
                                        <p class="py-2 text-zinc-800 text-sm">All clusters shown</p>
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
