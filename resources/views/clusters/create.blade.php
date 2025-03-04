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
                                        <x-text-input id="code" name="code" value="{{ old('code') }}"/>
                                        <x-input-error :messages="$errors->get('code')" class="mt-2"/>
                                    </div>

                                    <div class="flex flex-col my-2">
                                        <x-input-label for="title">
                                            Title
                                        </x-input-label>
                                        <x-text-input id="title" name="title" value="{{ old('title') }}"/>
                                        <x-input-error :messages="$errors->get('title')" class="mt-2"/>
                                    </div>

                                    <div class="flex flex-col my-2">
                                        <x-input-label for="qualification">
                                            Qualification
                                        </x-input-label>
                                        <x-text-input id="qualification" name="qualification" value="{{ old('qualification') }}"/>
                                        <x-input-error :messages="$errors->get('qualification')" class="mt-2"/>
                                    </div>

                                    <div class="flex flex-col my-2">
                                        <x-input-label for="qualification_code">
                                            Qualification Code
                                        </x-input-label>
                                        <x-text-input id="qualification_code" name="qualification_code" value="{{ old('qualification_code') }}"/>
                                        <x-input-error :messages="$errors->get('qualification_code')" class="mt-2"/>
                                    </div>

                                    <div class="flex flex-col my-2">
                                        <x-input-label for="unit_1">
                                            Unit 1
                                        </x-input-label>
                                        <x-text-input id="unit_1" name="unit_1" value="{{ old('unit_1') }}"/>
                                        <x-input-error :messages="$errors->get('unit_1')" class="mt-2"/>
                                    </div>

                                    <div class="flex flex-col my-2">
                                        <x-input-label for="unit_2">
                                            Unit 2
                                        </x-input-label>
                                        <x-text-input id="unit_2" name="unit_2" value="{{ old('unit_2') }}"/>
                                        <x-input-error :messages="$errors->get('unit_2')" class="mt-2"/>
                                    </div>

                                    <div class="flex flex-col my-2">
                                        <x-input-label for="unit_3">
                                            Unit 3
                                        </x-input-label>
                                        <x-text-input id="unit_3" name="unit_3" value="{{ old('unit_3') }}"/>
                                        <x-input-error :messages="$errors->get('unit_3')" class="mt-2"/>
                                    </div>

                                    <div class="flex flex-col my-2">
                                        <x-input-label for="unit_4">
                                            Unit 4
                                        </x-input-label>
                                        <x-text-input id="unit_4" name="unit_4" value="{{ old('unit_4') }}"/>
                                        <x-input-error :messages="$errors->get('unit_4')" class="mt-2"/>
                                    </div>

                                    <div class="flex flex-col my-2">
                                        <x-input-label for="unit_5">
                                            Unit 5
                                        </x-input-label>
                                        <x-text-input id="unit_5" name="unit_5" value="{{ old('unit_5') }}"/>
                                        <x-input-error :messages="$errors->get('unit_5')" class="mt-2"/>
                                    </div>

                                    <div class="flex flex-col my-2">
                                        <x-input-label for="unit_6">
                                            Unit 6
                                        </x-input-label>
                                        <x-text-input id="unit_6" name="unit_6" value="{{ old('unit_6') }}"/>
                                        <x-input-error :messages="$errors->get('unit_6')" class="mt-2"/>
                                    </div>

                                    <div class="flex flex-col my-2">
                                        <x-input-label for="unit_7">
                                            Unit 7
                                        </x-input-label>
                                        <x-text-input id="unit_7" name="unit_7" value="{{ old('unit_7') }}"/>
                                        <x-input-error :messages="$errors->get('unit_7')" class="mt-2"/>
                                    </div>

                                    <div class="flex flex-col my-2">
                                        <x-input-label for="unit_8">
                                            Unit 8
                                        </x-input-label>
                                        <x-text-input id="unit_8" name="unit_8" value="{{ old('unit_8') }}"/>
                                        <x-input-error :messages="$errors->get('unit_8')" class="mt-2"/>
                                    </div>

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
