<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Daftar Pelamar') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <div class="flex items-center justify-between mb-6">
                        <p class="text-lg font-medium text-gray-700">
                            Kelola daftar pelamar yang tersedia.
                        </p>
                    </div>

                    <div class="flex justify-end mb-4 gap-3">
                        <form action="{{ route('applications.export') }}" method="GET" class="flex gap-3 items-center">
                            <select name="job_id" class="border border-gray-300 rounded-md pl-3 pr-8 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-green-500 focus:border-transparent">
                                <option value="">Semua Lowongan</option>

                                @foreach ($applications->pluck('job')->unique() as $job)
                                    <option value="{{ $job->id }}">
                                        {{ $job->title }}
                                    </option>
                                @endforeach
                            </select>

                            <button type="submit"
                                class="bg-green-600 hover:bg-green-700 text-white px-4 py-2 text-sm font-semibold rounded-md shadow">
                                Export ke Excel
                            </button>
                        </form>
                    </div>


                    <div class="overflow-x-auto">
                        <table class="min-w-full divide-y divide-gray-200">
                            <thead class="bg-gray-50">
                                <tr>
                                    <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Nama Pelamar</th>
                                    <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Lowongan</th>
                                    <th class="px-4 py-3 text-center text-xs font-medium text-gray-500 uppercase tracking-wider">CV</th>
                                    <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                                    <th class="px-4 py-3 text-center text-xs font-medium text-gray-500 uppercase tracking-wider">Aksi</th>
                                </tr>
                            </thead>

                            <tbody class="divide-y divide-gray-200 bg-white">
                                @forelse ($applications as $app)
                                    <tr>
                                        <td class="px-4 py-3 text-sm text-gray-700">{{ $app->user->name }}</td>
                                        <td class="px-4 py-3 text-sm text-gray-700">{{ $app->job->title }}</td>


                                        <td class="px-4 py-3 text-sm text-gray-700 align-middle text-center">
                                            <a href="{{ asset('storage/' . $app->cv) }}" target="_blank"
                                                class="inline-flex items-center rounded-md border border-transparent bg-indigo-600 px-3 py-1 text-xs font-semibold text-white hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-indigo-600 focus:ring-offset-2">
                                                Lihat CV
                                            </a>

                                            <a href="{{ asset('storage/' . $app->cv) }}" download
                                                class="inline-flex items-center rounded-md bg-green-600 px-3 py-1 text-xs font-semibold text-white hover:bg-green-700 ml-2">
                                                Download
                                            </a>
                                        </td> 
                                        
                                        <td class="px-4 py-3 text-sm">
                                            <span
                                                class="inline-flex items-center rounded-md px-2 py-1 text-xs font-medium
                                                {{ $app->status === 'Pending' ? 'bg-yellow-100 text-yellow-700' : ($app->status === 'Accepted' ? 'bg-green-100 text-green-700' : 'bg-red-100 text-red-700') }}">
                                                {{ $app->status }}
                                            </span>
                                        </td>
                                        
                                        <td class="px-4 py-3 text-sm text-gray-700 align-middle text-center">
                                            <div class="flex flex-col sm:flex-row items-start justify-center gap-2">
                                                <form action="{{ route('applications.update', $app->id) }}" method="POST">
                                                    @csrf
                                                    @method('PUT')
                                                    <input type="hidden" name="status" value="Accepted">
                                                    <button type="submit"
                                                        class="inline-flex items-center rounded-md border border-transparent bg-green-600 px-3 py-1 text-xs font-semibold text-white hover:bg-green-700 ">
                                                        Terima
                                                    </button>
                                                </form>

                                                <form action="{{ route('applications.update', $app->id) }}" method="POST">
                                                    @csrf
                                                    @method('PUT')
                                                    <input type="hidden" name="status" value="Rejected">
                                                    <button type="submit"
                                                        class="inline-flex items-center rounded-md border border-transparent bg-red-600 px-3 py-1 text-xs font-semibold text-white hover:bg-red-700">
                                                        Tolak
                                                    </button>
                                                </form>
                                            </div>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="5" class="px-4 py-6 text-center text-sm text-gray-500">
                                            Belum ada pelamar yang daftar.
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
