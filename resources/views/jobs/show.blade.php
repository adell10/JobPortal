<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Detail Lowongan
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white p-6 rounded-lg shadow-md">

                <h3 class="text-2xl font-bold mb-4">{{ $job->title }}</h3>

                <p class="text-gray-700 mb-2"><strong>Perusahaan:</strong> {{ $job->company }}</p>
                <p class="text-gray-700 mb-2"><strong>Lokasi:</strong> {{ $job->location }}</p>
                <p class="text-gray-700 mb-2"><strong>Gaji:</strong> 
                    {{ $job->salary ? 'Rp ' . number_format($job->salary, 0, ',', '.') : '-' }}
                </p>

                <p class="text-gray-700 mb-4"><strong>Deskripsi:</strong><br>{{ $job->description }}</p>

                @if ($job->logo)
                    <img src="{{ asset('storage/' . $job->logo) }}" 
                        class="w-32 object-contain mb-4">
                @endif

                @auth
                    @if (Auth::user()->role === 'jobseeker')
                        <form action="{{ route('apply.store', $job->id) }}" 
                            method="POST" 
                            enctype="multipart/form-data">
                            @csrf
                            <label class="block mb-2">Upload CV:</label>
                            <input type="file" 
                                name="cv" 
                                required 
                                accept=".pdf"
                                class="mb-2">
                            <p class="text-sm text-gray-600 mb-4">
                                Format: PDF | Maksimal: 2MB
                            </p>

                            <button type="submit"
                                class="bg-green-600 text-white px-3 py-2 rounded-md">
                                Lamar Sekarang
                            </button>
                        </form>
                    @endif
                @endauth

                <a href="{{ route('jobs.index') }}" class="text-blue-500 mt-4 block">Kembali</a>

            </div>
        </div>
    </div>
</x-app-layout>
