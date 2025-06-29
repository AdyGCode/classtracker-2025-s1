<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Cluster Management') }}
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
                        <h3 class="text-xl font-bold mb-6">Clusters Detail</h3>
                    </div>

                    <div class="min-w-full text-left text-sm font-light text-surface dark:text-white">
                        <header
                            class="grid grid-cols-6 border-b border-neutral-200 bg-zinc-800 font-medium text-white dark:border-white/10">
                            <p class="col-span-1 px-6 py-4 border-b border-zinc-200 dark:border-white/10">Item</p>
                            <p class="col-span-5 px-6 py-4 border-b border-zinc-200 dark:border-white/10">Content</p>
                        </header>

                        <section class="grid grid-cols-6 border-b border-neutral-200 bg-white font-medium text-zinc-800 dark:border-white/10">
                            <p class="col-span-1 bg-zinc-300 whitespace-nowrap px-6 py-4 border-b border-zinc-200 dark:border-white/10">Code</p>
                            <p class="col-span-5 whitespace-nowrap px-6 py-4 border-b border-zinc-200 dark:border-white/10">{{ $cluster->code }}</p>
                            <p class="col-span-1 bg-zinc-300 whitespace-nowrap px-6 py-4 border-b border-zinc-200 dark:border-white/10">Title</p>
                            <p class="col-span-5 whitespace-nowrap  px-6 py-4 border-b border-zinc-200 dark:border-white/10">{{ $cluster->title }}</p>
                            <p class="col-span-1 bg-zinc-300 whitespace-nowrap px-6 py-4 border-b border-zinc-200 dark:border-white/10">Qualification</p>
                            <p class="col-span-5 whitespace-nowrap px-6 py-4 border-b border-zinc-200 dark:border-white/10">{{ $cluster->qualification }}</p>
                            <p class="col-span-1 bg-zinc-300 whitespace-nowrap px-6 py-4 border-b border-zinc-200 dark:border-white/10">Qualification Code</p>
                            <p class="col-span-5 whitespace-nowrap px-6 py-4 border-b border-zinc-200 dark:border-white/10">{{ $cluster->qualification_code }}</p>
                            @foreach($units as $unit)
                                <p class="col-span-1 bg-zinc-300 whitespace-nowrap px-6 py-4 border-b border-zinc-200 dark:border-white/10">Unit {{ $loop->index + 1 }}</p>
                                <p class="col-span-5 whitespace-nowrap px-6 py-4 border-b border-zinc-200 dark:border-white/10">{{ $unit->national_code }} - {{ $unit->title }}</p>
                            @endforeach
                            @foreach($cluster->units as $unit)
                                <p class="col-span-1 bg-zinc-300 whitespace-nowrap px-6 py-4 border-b border-zinc-200 dark:border-white/10">Unit {{ $loop->index + 1 }}</p>
                                <p class="col-span-5 whitespace-nowrap px-6 py-4 border-b border-zinc-200 dark:border-white/10">{{ $unit->national_code }} - {{ $unit->title }}</p>
 =                           @endforeach
                        </section>

                        <footer class="grid gid-cols-1 px-6 py-4 border-b border-neutral-200 font-medium text-zinc-800 dark:border-white/10">
                            <form action="{{ route('clusters.destroy', $cluster) }}"
                                  method="POST"
                                  class="flex gap-4">
                                @csrf
                                @method('DELETE')

                                <x-primary-link-button href="{{ route('clusters.index',$cluster) }}" class="bg-zinc-800">
                                    Back
                                </x-primary-link-button>
                                <x-primary-link-button href="{{ route('clusters.edit',$cluster->id) }}" class="bg-zinc-800">
                                    Edit
                                </x-primary-link-button>
                                <x-secondary-button type="submit" class="bg-zinc-200">
                                    Delete
                                </x-secondary-button>
                            </form>
                        </footer>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
