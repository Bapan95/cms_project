<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Forbidden') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
            <div class="p-4 sm:p-8 bg-white dark:bg-gray-800 shadow sm:rounded-lg">
                <h1 class="text-2xl font-bold text-red-600 mb-4">403 Forbidden</h1>
                <p class="text-gray-700 dark:text-gray-300 mb-6">
                    You do not have permission to access this page. If you believe this is an error, please contact support.
                </p>
                <a href="{{ route('articles.index') }}" class="bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-600 transition duration-200" aria-label="Go Back to Articles">
                    Go Back to Articles
                </a>
            </div>
        </div>
    </div>
</x-app-layout>
