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

                    <h3 class="text-xl font-bold mb-6">Edit Lesson</h3>

                    @if (count($errors) > 0)
                        <div class="alert alert-danger text-red-600">
                            There were some problems with your input.<br><br>
                        </div>
                    @endif

                    <div class="overflow-x-auto">
                        <form action="{{ route('lessons.update', $lesson->id) }}"
                              method="POST"
                              class="flex gap-4">

                            @method('patch')
                            @csrf

                            <div class="min-w-full text-left text-sm font-light text-surface dark:text-white">
                                <header
                                    class="border-b border-neutral-200 bg-zinc-800 font-medium text-white dark:border-white/10">
                                    <p class="col-span-1 px-6 py-4 border-b border-zinc-200 dark:border-white/10">
                                        Edit new lesson's details
                                    </p>
                                </header>

                                <section
                                    class="py-4 px-6 border-b border-neutral-200 bg-gray-100 font-medium text-zinc-800 dark:border-white/10">

                                    <div class="flex flex-col my-2">
                                        <x-input-label for="name">
                                            Name
                                        </x-input-label>
                                        <x-text-input id="name" name="name" value="{{ old('name') ?? $lesson->name}}"/>
                                        <x-input-error :messages="$errors->get('name')" class="mt-2"/>
                                    </div>

                                    <div class="flex flex-col my-2">
                                        <x-input-label for="family_name">
                                            Cluster ID
                                        </x-input-label>
                                        <select name="cluster_id" class="border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm">
                                            @foreach ($clusters as $cluster)
                                                <option value="{{ $cluster->code }}" {{ (old('cluster_id', $lesson->cluster_id) == $cluster->code) ? 'selected' : '' }}>
                                                    {{ $cluster->code }}
                                                </option>
                                            @endforeach
                                        </select>
                                        <x-input-error :messages="$errors->get('cluster_id')" class="mt-2"/>
                                    </div>

                                    <div class="flex flex-col my-2">
                                        <x-input-label for="course_id">
                                            Course ID
                                        </x-input-label>
                                        <x-text-input id="course_id" name="course_id" value="{{ old('course_id') ?? $lesson->course_id}}"/>
                                    </div>

                                    <div class="flex flex-col my-2">
                                        <x-input-label for="start_date">
                                            Start Date
                                        </x-input-label>
                                        <x-text-input id="start_date" name="start_date" type="date" value="{{ old('start_date') ?? $lesson->start_date}}"/>
                                        <x-input-error :messages="$errors->get('start_date')" class="mt-2"/>
                                    </div>

                                    <div class="flex flex-col my-2">
                                        <x-input-label for="end_date">
                                            End Date
                                        </x-input-label>
                                        <x-text-input id="end_date" name="end_date" type="date" value="{{ old('end_date') ?? $lesson->end_date}}"/>
                                        <x-input-error :messages="$errors->get('end_date')" class="mt-2"/>
                                    </div>

                                    <div class="flex flex-col my-2">
                                        <x-input-label for="start_time">
                                            Start Time
                                        </x-input-label>
                                        <x-text-input id="start_time" name="start_time" type="time" value="{{ old('start_time') ?? $lesson->start_time}}"/>
                                        <x-input-error :messages="$errors->get('start_time')" class="mt-2"/>
                                    </div>

                                    <div class="flex flex-col my-2">
                                        <x-input-label for="weekday">
                                            Weekday
                                        </x-input-label>
                                        <select id="weekday" name="weekday" class="border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm">
                                            @foreach (['Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday'] as $day)
                                                <option value="{{ $day }}" {{ (old('weekday', $lesson->weekday) == $day) ? 'selected' : '' }}>
                                                    {{ $day }}
                                                </option>
                                            @endforeach
                                        </select>
                                        <x-input-error :messages="$errors->get('weekday')" class="mt-2"/>
                                    </div>

                                    <div class="flex flex-col my-2">
                                        <x-input-label for="duration">
                                            Duration
                                        </x-input-label>
                                        <x-text-input id="duration" name="duration" type="number" min="1" max="4" step="0.5" value="{{ old('duration') ?? $lesson->duration}}"/>
                                        <x-input-error :messages="$errors->get('duration')" class="mt-2" />
                                    </div>

                                    <div class="flex flex-col my-2">
                                        <x-input-label for="lecture">
                                            Assign Lecture
                                        </x-input-label>
                                        <div class="bg-white rounded-lg border border-gray-200 shadow-sm">

                                            <div class="overflow-y-auto max-h-64" id="staffList">
                                                @foreach($staffs as $staff)
                                                    <label class="flex items-center p-3 hover:bg-blue-50 cursor-pointer border-b last:border-b-0 transition-colors group">
                                                        <input
                                                            type="radio"
                                                            name="staff_ids[]"
                                                            value="{{ $staff->id }}"
                                                            class="rounded border-gray-300 text-blue-600 focus:ring-blue-500"
                                                            {{ in_array($staff->id, old('staff_ids', $lesson->staff->pluck('id')->toArray())) ? 'checked' : '' }}
                                                        >
                                                        <span class="ml-3 text-sm text-gray-700 group-hover:text-blue-800">
                                                            {{ $staff->given_name .' '. $staff->family_name }}
                                                            <span class="text-gray-400 text-xs">({{ $staff->email }})</span>
                                                        </span>
                                                    </label>
                                                @endforeach
                                            </div>
                                        </div>
                                    </div>

                                    <div class="flex flex-col my-2">
                                        <x-input-label for="student">
                                            Assign Students
                                        </x-input-label>
                                        <div class="bg-white rounded-lg border border-gray-200 shadow-sm">

                                            <div class="overflow-y-auto max-h-64" id="studentList">
                                                @foreach($students as $student)
                                                    <label class="flex items-center p-3 hover:bg-blue-50 cursor-pointer border-b last:border-b-0 transition-colors group">
                                                        <input
                                                            type="checkbox"
                                                            name="student_ids[]"
                                                            value="{{ $student->id }}"
                                                            class="rounded border-gray-300 text-blue-600 focus:ring-blue-500"
                                                            {{ in_array($student->id, old('student_ids', $lesson->students->pluck('id')->toArray())) ? 'checked' : '' }}
                                                        >
                                                        <span class="ml-3 text-sm text-gray-700 group-hover:text-blue-800">
                                                            {{ $student->given_name .' '. $student->family_name }}
                                                            <span class="text-gray-400 text-xs">({{ $student->email }})</span>
                                                        </span>
                                                    </label>
                                                @endforeach
                                            </div>
                                        </div>
                                    </div>

                                </section>

                                <footer
                                    class="flex gap-4 px-6 py-4 border-b border-neutral-200 font-medium text-zinc-800 dark:border-white/10">

                                    <x-primary-link-button href="{{ route('lessons.index') }}" class="bg-zinc-800">
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

