@php
use Illuminate\Support\Facades\Storage;
@endphp


<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Daftar Lowongan') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    @if(session('success'))
                        <div class="mb-4 p-4 bg-green-100 border border-green-400 text-green-700 rounded">
                            {{ session('success') }}
                        </div>
                    @endif
                    
                    @if(session('error'))
                        <div class="mb-4 p-4 bg-red-100 border border-red-400 text-red-700 rounded">
                            {{ session('error') }}
                        </div>
                    @endif

                    <div class="flex items-center justify-between mb-6">
                        <p class="text-lg font-medium text-gray-700">Kelola lowongan kerja yang tersedia.</p>

                        @auth
                            @if (Auth::user()->role === 'admin')
                                <a href="{{ route('jobs.create') }}"
                                   class="inline-flex items-center rounded-md bg-blue-600 px-4 py-2 text-sm font-semibold text-white shadow hover:bg-blue-700">
                                    Tambah Lowongan
                                </a>
                            @endif
                        @endauth
                    </div>

                    @auth
                        @if (Auth::user()->role === 'admin')
                            <div class="mb-6 p-6 border rounded-lg bg-gradient-to-r from-green-50 to-blue-50">
                                <h2 class="text-lg font-semibold text-gray-800 mb-4">Import Lowongan</h2>
                                
                                <form action="{{ route('jobs.import') }}" method="POST" enctype="multipart/form-data" class="space-y-4">
                                    @csrf
                                    <div>
                                        <label class="block text-sm font-medium text-gray-700 mb-2">
                                            Upload File Excel (.xlsx)
                                        </label>
                                        <input type="file" 
                                               name="file" 
                                               accept=".xlsx,.xls"
                                               required 
                                               class="block w-full text-sm text-gray-900 border border-gray-300 rounded-lg cursor-pointer bg-white focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent p-2">
                                    </div>

                                    <div class="mb-4">
                                        <a href="{{ Storage::url('templates/template_lowongan.xlsx') }}" 
                                        download
                                        class="inline-flex items-center rounded-md bg-blue-600 px-4 py-2 text-sm font-semibold text-white hover:bg-blue-700">
                                            Download Template Import
                                        </a>
                                    </div>

                                    <div class="flex items-center gap-3">
                                        <button type="submit" 
                                                class="inline-flex items-center rounded-md bg-green-600 px-4 py-2 text-sm font-semibold text-white hover:bg-green-700">
                                            Import Data
                                        </button>
                                    </div>
                                </form>
                            </div>
                        @endif
                    @endauth

                    <div class="overflow-x-auto">
                        <table class="min-w-full divide-y divide-gray-200">
                            <thead class="bg-gray-50">
                                <tr>
                                    <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Judul</th>
                                    {{-- <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Deskripsi</th> --}}
                                    <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Perusahaan</th>
                                    {{-- <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Lokasi</th> --}}
                                    <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Gaji</th>
                                    {{-- <th class="px-4 py-3 text-center text-xs font-medium text-gray-500 uppercase tracking-wider">Logo</th> --}}
                                    <th class="px-4 py-3 text-center text-xs font-medium text-gray-500 uppercase tracking-wider">Aksi</th>
                                </tr>
                            </thead>

                            <tbody class="divide-y divide-gray-200 bg-white">
                                @forelse ($jobs as $job)
                                    <tr>
                                        <td class="px-4 py-3 text-sm text-gray-700">{{ $job->title }}</td>
                                        {{-- <td class="px-4 py-3 text-blue-600 underline text-sm">
                                            <a href="{{ route('jobs.show', $job->id) }}">
                                                {{ $job->title }}
                                            </a>
                                        </td> --}}

                                        {{-- <td class="px-4 py-3 text-sm text-gray-700">{{ $job->description }}</td> --}}
                                        <td class="px-4 py-3 text-sm text-gray-700">{{ $job->company }}</td>
                                        {{-- <td class="px-4 py-3 text-sm text-gray-700">{{ $job->location }}</td> --}}
                                        <td class="px-4 py-3 text-sm text-gray-700">
                                            {{ $job->salary ? 'Rp ' . number_format($job->salary, 0, ',', '.') : '-' }}
                                        </td>

                                        {{-- <td class="px-4 py-3 text-sm text-gray-700 text-center align-middle">
                                            @if ($job->logo)
                                                <img src="{{ asset('storage/' . $job->logo) }}" 
                                                     alt="Logo {{ $job->company }}" 
                                                     class="mx-auto object-contain"
                                                     style="max-height:100px; max-width:120px;">
                                            @else
                                                <span class="text-gray-400 text-xs">No Logo</span>
                                            @endif
                                        </td> --}}

                                        <td class="px-4 py-3 text-sm text-gray-700 align-middle text-center">
                                            <div class="flex flex-col sm:flex-row items-start justify-center gap-2">

                                                @auth
                                                    @if (Auth::user()->role === 'admin')
                                                        <a href="{{ route('jobs.edit', $job->id) }}" 
                                                           class="bg-amber-600 hover:bg-amber-700 text-white text-xs px-3 py-1 rounded-md w-20 text-center">
                                                            Edit
                                                        </a>

                                                        <form action="{{ route('jobs.destroy', $job->id) }}" 
                                                              method="POST" 
                                                              onsubmit="return confirm('Hapus data ini?')">
                                                            @csrf
                                                            @method('DELETE')
                                                            <button type="submit"
                                                                class="bg-red-600 hover:bg-red-700 text-white text-xs px-3 py-1 rounded-md w-20 text-center">
                                                                Hapus
                                                            </button>
                                                        </form>
                                                    @endif
                                                @endauth

                                                @auth
                                                    @if (Auth::user()->role === 'jobseeker')
                                                        {{-- <form action="{{ route('apply.store', $job->id) }}" 
                                                            method="POST" 
                                                            enctype="multipart/form-data"
                                                            class="flex flex-col items-start gap-1">
                                                            @csrf
                                                            <input type="file" name="cv" required class="text-xs border border-gray-300 rounded-md">
                                                            <button type="submit"
                                                                class="bg-green-600 hover:bg-green-700 text-white text-xs px-3 py-1 rounded-md">
                                                                Lamar
                                                            </button>
                                                        </form> --}}

                                                        <a href="{{ route('jobs.show', $job->id) }}"
                                                            class="bg-indigo-600 hover:bg-indigo-700 text-white text-xs px-3 py-1 rounded-md w-24 text-center">
                                                            Lihat Detail
                                                        </a>
                                                    @endif
                                                @endauth
                                            </div>
                                        </td>
                                    </tr>

                                @empty
                                    <tr>
                                        <td colspan="6" class="px-4 py-6 text-center text-sm text-gray-500">
                                            Belum ada lowongan yang tersedia.
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>