<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Package Management') }}
        </h2>
    </x-slot>

    @auth
        <x-flash-message :data="session()"/>
    @endauth

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-md sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">

                    <h3 class="text-xl font-bold mb-6">Edit Packages</h3>

                    @if (count($errors) > 0)
                        <div class="alert alert-danger text-red-600">
                            There were some problems with your input.<br><br>
                        </div>
                    @endif

                    <div class="overflow-x-auto">
                        <form action="{{ route('packages.update', $package) }}"
                              method="POST"
                              class="flex gap-4">

                            @method('patch')
                            @csrf

                            <div class="min-w-full text-left text-sm font-light text-surface dark:text-white">
                                <header
                                    class="border-b border-neutral-200 bg-zinc-800 font-medium text-white dark:border-white/10">
                                    <p class="col-span-1 px-6 py-4 border-b border-zinc-200 dark:border-white/10">
                                        Edit new package's details
                                    </p>
                                </header>

                                <section
                                    class="py-4 px-6 border-b border-neutral-200 bg-gray-100 font-medium text-zinc-800 dark:border-white/10">

                                    <div class="flex flex-col my-2">
                                        <x-input-label for="national_code">
                                            National Code  <span class="text-red-600">*</span>
                                        </x-input-label>
                                        <x-text-input id="national_code" name="national_code" value="{{ old('national_code') ?? $package->national_code}}" placeholder="E.g. FNS"
                                                      class="placeholder-gray-500 text-black"/>
                                        <x-input-error :messages="$errors->get('national_code')" class="mt-2"/>
                                    </div>

                                    <div class="flex flex-col my-2">
                                        <x-input-label for="title">
                                            Title  <span class="text-red-600">*</span>
                                        </x-input-label>
                                        <x-text-input id="title" name="title" value="{{ old('title') ?? $package->title }}" placeholder="E.g. Financial Services Training Package"
                                                      class="placeholder-gray-500 text-black"/>
                                        <x-input-error :messages="$errors->get('title')" class="mt-2"/>
                                    </div>

                                    <div class="flex flex-col my-2">
                                        <x-input-label for="tga_status">
                                            TGA Status  <span class="text-red-600">*</span>
                                        </x-input-label>
                                        <select id="tga_status" name="tga_status" class="rounded-md shadow-sm border-gray-300 text-black placeholder-gray-500">
                                            <option value="Current" {{ old('tga_status', $package->tga_status) == 'Current' ? 'selected' : '' }}>Current</option>
                                            <option value="Replaced" {{ old('tga_status', $package->tga_status) == 'Replaced' ? 'selected' : '' }}>Replaced</option>
                                            <option value="Expired" {{ old('tga_status', $package->tga_status) == 'Expired' ? 'selected' : '' }}>Expired</option>
                                            <option value="Not Provided" {{ old('tga_status', $package->tga_status) == 'null' ? 'selected' : '' }}>Not Provided</option>
                                        </select>
                                        <x-input-error :messages="$errors->get('tga_status')" class="mt-2"/>
                                    </div>

                                    <div class="flex flex-wrap gap-4">
                                        <x-input-label for="course_id" class="w-full">
                                            Course National Code
                                        </x-input-label>
                                        @for($i = 0; $i <= 3; $i++)
                                            @if(isset($package->courses[$i]))
                                                <div class="w-1/5">
                                                    <select id="course_{{$i}}" name="course_ids[]" class="rounded-md shadow-sm border-gray-300 text-black placeholder-gray-500 w-full">
                                                        <option value=null>No course</option>
                                                    @foreach($courses as $availableCourse)
                                                            <option value="{{ $availableCourse->id }}"
                                                                {{ (old('course_' . $package->courses[$i]->id,$package->courses[$i]->id) == $availableCourse->id) ? 'selected' : '' }}>
                                                                {{ $availableCourse->national_code }}
                                                            </option>
                                                        @endforeach
                                                    </select>
                                                    <x-input-error :messages="$errors->get('course_' . $package->courses[$i])" class="mt-2"/>
                                                </div>
                                            @else
                                                <div class="w-1/5">
                                                    <select id="course_{{$i}}" name="course_ids[]" class="rounded-md shadow-sm border-gray-300 text-black placeholder-gray-500 w-full">
                                                        <option value=null>No course</option>
                                                        @foreach($courses as $availableCourse)
                                                            <option value="{{ $availableCourse->id }}">
                                                                {{ $availableCourse->national_code }}
                                                            </option>
                                                        @endforeach
                                                    </select>
                                                    <x-input-error :messages="$errors->get('course_' . $i)" class="mt-2" />
                                                </div>
                                            @endif
                                        @endfor
                                    </div>

                                </section>

                                <footer
                                    class="flex gap-4 px-6 py-4 border-b border-neutral-200 font-medium text-zinc-800 dark:border-white/10">

                                    <x-primary-link-button href="{{ route('packages.index') }}" class="bg-zinc-800">
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
