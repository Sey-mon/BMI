<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Admin Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <h3 class="text-lg font-medium mb-4">Welcome to Admin Dashboard</h3>
                    
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                        <div class="bg-blue-100 p-6 rounded-lg">
                            <h4 class="text-xl font-semibold text-blue-800">Total Users</h4>
                            <p class="text-3xl font-bold text-blue-600">{{ \App\Models\User::count() }}</p>
                        </div>
                        
                        <div class="bg-green-100 p-6 rounded-lg">
                            <h4 class="text-xl font-semibold text-green-800">Admin Users</h4>
                            <p class="text-3xl font-bold text-green-600">{{ \App\Models\User::where('role', 'admin')->count() }}</p>
                        </div>
                        
                        <div class="bg-yellow-100 p-6 rounded-lg">
                            <h4 class="text-xl font-semibold text-yellow-800">Regular Users</h4>
                            <p class="text-3xl font-bold text-yellow-600">{{ \App\Models\User::where('role', 'user')->count() }}</p>
                        </div>
                    </div>

                    <div class="mt-8">
                        <a href="{{ route('admin.users') }}" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                            Manage Users
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
