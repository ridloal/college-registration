<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4">
                <!-- Registration Card -->
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6 bg-white border-b border-gray-200">
                        <h3 class="text-lg font-semibold mb-2">Registration</h3>
                        <p class="text-gray-600">Manage student registrations</p>
                        <a href="#" class="mt-4 text-center block bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-600">
                            Registrations
                        </a>
                    </div>
                </div>

                <!-- Students Card -->
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6 bg-white border-b border-gray-200">
                        <h3 class="text-lg font-semibold mb-2">Students</h3>
                        <p class="text-gray-600">Manage enrolled students</p>
                        <a href="#" class="mt-4 text-center block bg-green-500 text-white px-4 py-2 rounded hover:bg-green-600">
                            Students
                        </a>
                    </div>
                </div>

                <!-- Faculty Card -->
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6 bg-white border-b border-gray-200">
                        <h3 class="text-lg font-semibold mb-2">Faculty</h3>
                        <p class="text-gray-600">Manage faculties.</p>
                        <a href="#" class="mt-4 text-center block bg-yellow-500 text-white px-4 py-2 rounded hover:bg-yellow-600">
                            Faculties
                        </a>
                    </div>
                </div>

                <!-- Settings Card -->
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6 bg-white border-b border-gray-200">
                        <h3 class="text-lg font-semibold mb-2">Settings</h3>
                        <p class="text-gray-600">Manage system settings</p>
                        <a href="#" class="mt-4 text-center block bg-purple-500 text-white px-4 py-2 rounded hover:bg-purple-600">
                            Settings
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>