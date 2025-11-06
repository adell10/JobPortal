<x-app-layout>
    <div class="container my-5">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h2 class="fw-semibold text-dark">Daftar Lowongan Kerja</h2>
            <a href="{{ route('jobs.create') }}" class="btn btn-primary">
                + Tambah Lowongan
            </a>
        </div>

        @if ($jobs->count() > 0)
            <div class="row g-4">
                @foreach ($jobs as $job)
                    <div class="col-md-3 col-sm-6">
                        <div class="card h-100 shadow-sm border-0 p-3 hover-shadow transition">
                            @if ($job->logo)
                                <img src="{{ asset('storage/' . $job->logo) }}" 
                                    class="card-img-top p-2" 
                                    alt="Logo {{ $job->company }}"
                                    style="height: 120px; object-fit: contain;">
                            @else
                                <div class="bg-light text-center p-5 text-muted" style="height: 120px;">
                                    No Logo
                                </div>
                            @endif

                            <div class="card-body">
                                <h5 class="card-title text-truncate">{{ $job->title }}</h5>
                                <h6 class="card-subtitle mb-2 text-muted text-truncate">{{ $job->company }}</h6>

                                <span class="badge bg-info text-dark mb-2">{{ $job->job_type }}</span>

                                <p class="card-text mb-1"><strong>Lokasi:</strong> {{ $job->location }}</p>
                                <p class="card-text">
                                    <strong>Gaji:</strong>
                                    {{ $job->salary ? 'Rp ' . number_format($job->salary, 0, ',', '.') : 'Tidak disebutkan' }}
                                </p>
                            </div>

                            <div class="card-footer bg-white border-0 d-flex justify-content-end gap-2 mt-auto">
                                <a href="{{ route('jobs.edit', $job->id) }}" class="btn btn-warning btn-sm">
                                    Edit
                                </a>

                                <form action="{{ route('jobs.destroy', $job->id) }}" method="POST"
                                    onsubmit="return confirm('Hapus data ini?')" class="d-inline">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-danger btn-sm">
                                        Hapus
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        @else
            <p class="text-center text-muted mt-5">Belum ada lowongan yang tersedia.</p>
        @endif
    </div>
</x-app-layout>
