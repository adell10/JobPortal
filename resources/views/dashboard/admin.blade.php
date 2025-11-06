<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Admin Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6 text-center">
                <h3 class="text-2xl font-semibold mb-3 text-gray-800">
                    Selamat datang, Admin! 
                </h3>
                

                <a href="{{ route('jobs.index') }}" class="btn btn-success btn-lg px-4 py-2"
                    style="background-color:#4f46e5; border:none;">
                    Kelola Lowongan Pekerjaan
                </a>
            </div>
        </div>
    </div>
</x-app-layout>
