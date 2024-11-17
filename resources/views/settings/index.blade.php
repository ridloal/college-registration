
<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Settings') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                
                @if (session('success'))
                <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative mb-4" role="alert">
                    <strong class="font-bold">Success!</strong>
                    <span class="block sm:inline">{{ session('success') }}</span>
                </div>
                @endif

                    <form action="{{ route('settings.update') }}" method="POST">
                        @csrf
                        @method('PUT')

                        <div class="mb-4">
                            <label for="registration_date_start" class="block font-medium text-sm text-gray-700">Registration Start Date</label>
                            <input type="date" name="registration_date_start" id="registration_date_start" value="{{ $settings->registration_date_start }}" required class="border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 rounded-md shadow-sm block w-full mt-1">
                        </div>

                        <div class="mb-4">
                            <label for="registration_date_end" class="block font-medium text-sm text-gray-700">Registration End Date</label>
                            <input type="date" name="registration_date_end" id="registration_date_end" value="{{ $settings->registration_date_end }}" required class="border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 rounded-md shadow-sm block w-full mt-1">
                        </div>

                        <div class="mb-4">
                            <label for="quota" class="block font-medium text-sm text-gray-700">Quota per Department</label>
                            <input type="number" name="quota" id="quota" value="{{ $settings->quota }}" min="1" required class="border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 rounded-md shadow-sm block w-full mt-1">
                        </div>

                        <div class="mb-4">
                            <label for="min_math_score" class="block font-medium text-sm text-gray-700">Minimum Math Score</label>
                            <input type="number" name="min_math_score" id="min_math_score" value="{{ $settings->min_math_score }}" step="0.1" min="0" max="10" required class="border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 rounded-md shadow-sm block w-full mt-1">
                        </div>

                        <div class="mb-4">
                            <label for="min_science_score" class="block font-medium text-sm text-gray-700">Minimum Science Score</label>
                            <input type="number" name="min_science_score" id="min_science_score" value="{{ $settings->min_science_score }}" step="0.1" min="0" max="10" required class="border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 rounded-md shadow-sm block w-full mt-1">
                        </div>

                        <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-600">
                            Save
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>