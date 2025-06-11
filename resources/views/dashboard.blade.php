<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    <h1 class="mb-8 text-3xl font-bold text-white-900 text-left">Welcome, {{ Auth::user()->name }}!</h1>
                    <p class="mb-8 text-xl text-white-900 text-left">Start making your CLT project here!</p>
                    <a href="{{ route('project.index') }}" class="inline-block text-base px-3 py-1 bg-indigo-600 hover:bg-indigo-700 rounded font-medium">
                        {{ __('Go to Projects') }}
                    </a>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
