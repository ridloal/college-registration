
<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Student Registration Form') }}
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

                    @if ($errors->any())
                        <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative mb-4" role="alert">
                            <strong class="font-bold">Error!</strong>
                            <ul>
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <form action="{{ route('registration.store') }}" method="POST">
                        @csrf

                        <div class="mb-4">
                            <label for="name" class="block font-medium text-sm text-gray-700">Full Name</label>
                            <input type="text" name="name" id="name" value="{{ old('name') }}" required 
                                class="border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 rounded-md shadow-sm block w-full mt-1">
                        </div>

                        <div class="mb-4">
                            <label for="email" class="block font-medium text-sm text-gray-700">Email</label>
                            <input type="email" name="email" id="email" value="{{ old('email') }}" required 
                                class="border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 rounded-md shadow-sm block w-full mt-1">
                        </div>

                        <div class="mb-4">
                            <label for="phone" class="block font-medium text-sm text-gray-700">Phone Number</label>
                            <input type="text" name="phone" id="phone" value="{{ old('phone') }}" required 
                                class="border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 rounded-md shadow-sm block w-full mt-1">
                        </div>

                        <div class="mb-4">
                            <label for="faculty_id" class="block font-medium text-sm text-gray-700">Faculty</label>
                            <select name="faculty_id" id="faculty_id" required 
                                class="border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 rounded-md shadow-sm block w-full mt-1">
                                <option value="">Select Faculty</option>
                                @foreach($faculties as $faculty)
                                    <option value="{{ $faculty->id }}" {{ old('faculty_id') == $faculty->id ? 'selected' : '' }}>
                                        {{ $faculty->name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <div class="mb-4">
                            <label for="major_study" class="block font-medium text-sm text-gray-700">Major Study</label>
                            <input type="text" name="major_study" id="major_study" value="{{ old('major_study') }}" required 
                                class="border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 rounded-md shadow-sm block w-full mt-1">
                        </div>

                        <div class="mb-4">
                            <label for="math_score" class="block font-medium text-sm text-gray-700">Math Score</label>
                            <input type="number" name="math_score" id="math_score" value="{{ old('math_score') }}" 
                                step="0.1" min="0" max="10" required 
                                class="border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 rounded-md shadow-sm block w-full mt-1">
                        </div>

                        <div class="mb-4">
                            <label for="science_score" class="block font-medium text-sm text-gray-700">Science Score</label>
                            <input type="number" name="science_score" id="science_score" value="{{ old('science_score') }}" 
                                step="0.1" min="0" max="10" required 
                                class="border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 rounded-md shadow-sm block w-full mt-1">
                        </div>

                        <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-600">
                            Submit Registration
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>

</x-app-layout>