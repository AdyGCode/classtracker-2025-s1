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

                    <h3 class="text-xl font-bold mb-6">Create Clusters</h3>

                    @if (count($errors) > 0)
                        <div class="alert alert-danger text-red-600">
                            There were some problems with your input.<br><br>
                        </div>
                    @endif

                    <div class="overflow-x-auto">
                        <form action="{{ route('clusters.store') }}"
                              method="POST"
                              class="flex gap-4">

                            @csrf

                            <div class="min-w-full text-left text-sm font-light text-surface dark:text-white">
                                <header
                                    class="border-b border-neutral-200 bg-zinc-800 font-medium text-white dark:border-white/10">
                                    <p class="col-span-1 px-6 py-4 border-b border-zinc-200 dark:border-white/10">
                                        Enter new cluster's details
                                    </p>
                                </header>

                                <section
                                    class="py-4 px-6 border-b border-neutral-200 bg-gray-100 font-medium text-zinc-800 dark:border-white/10">

                                    <div class="flex flex-col my-2">
                                        <x-input-label for="code">
                                            Code
                                        </x-input-label>
                                        <x-text-input id="code" name="code" value="{{ old('code') }}" placeholder="e.g. ADVPROG"
                                                      class="placeholder-gray-500 text-black"/>
                                        <x-input-error :messages="$errors->get('code')" class="mt-2"/>
                                    </div>

                                    <div class="flex flex-col my-2">
                                        <x-input-label for="title">
                                            Title
                                        </x-input-label>
                                        <x-text-input id="title" name="title" value="{{ old('title') }}" placeholder="e.g. Advanced Programming"
                                                      class="placeholder-gray-500 text-black"/>
                                        <x-input-error :messages="$errors->get('title')" class="mt-2"/>
                                    </div>

                                    <div class="flex flex-col my-2">
                                        <x-input-label for="qualification">
                                            Qualification
                                        </x-input-label>
                                        <x-text-input id="qualification" name="qualification" value="{{ old('qualification') }}" placeholder="e.g. ICT00000"
                                                      class="placeholder-gray-500 text-black"/>
                                        <x-input-error :messages="$errors->get('qualification')" class="mt-2"/>
                                    </div>

                                    <div class="flex flex-col my-2">
                                        <x-input-label for="qualification_code">
                                            Qualification Code
                                        </x-input-label>
                                        <x-text-input id="qualification_code" name="qualification_code" value="{{ old('qualification_code') }}" placeholder="e.g. AC00"
                                                      class="placeholder-gray-500 text-black"/>
                                        <x-input-error :messages="$errors->get('qualification_code')" class="mt-2"/>
                                    </div>

                                    @foreach(range(1, 8) as $units)
                                        <div class="flex flex-col my-2">
                                            <x-input-label for="{{ 'unit_' . $unit }}">
                                                Unit {{ $unit }}
                                            </x-input-label>
                                            <select name="unit_{{ $unit }}" class="border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm">
                                                <option value="">Select Unit</option>
                                                @foreach ($cluster->units as $unit)
                                                    <option value="{{ $unitItem->id }}">
                                                        {{ $unitItem->national_code }}
                                                    </option>
                                                @endforeach
                                            </select>
                                            <x-input-error :messages="$errors->get('unit_' . $unit)" class="mt-2"/>
                                        </div>
                                    @endforeach
                                </section>

                                <footer
                                    class="flex gap-4 px-6 py-4 border-b border-neutral-200 font-medium text-zinc-800 dark:border-white/10">

                                    <x-primary-link-button href="{{ route('clusters.index') }}" class="bg-zinc-800">
                                        Cancel
                                    </x-primary-link-button>

                                    <x-primary-button type="submit" class="bg-zinc-800">
                                        Save
                                    </x-primary-button>
                                </footer>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
