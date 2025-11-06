<x-app-layout>
    <div class="container my-5">
        <div class="row justify-content-center">
            <div class="col-lg-7 col-md-8">
                <div class="card shadow-lg border-0 rounded-4">
                    <div class="card-body p-5">
                        <h2 class="text-center mb-4 fw-bold">Edit Lowongan Kerja</h2>

                        <form action="{{ route('jobs.update', $job->id) }}" method="POST" enctype="multipart/form-data">
                            @csrf
                            @method('PUT')

                            <div class="mb-3">
                                <label for="title" class="form-label fw-semibold">Judul Lowongan</label>
                                <input type="text" name="title" id="title" value="{{ $job->title }}" class="form-control">
                            </div>

                            <div class="mb-3">
                                <label for="description" class="form-label fw-semibold">Deskripsi</label>
                                <textarea name="description" id="description" rows="4" class="form-control">{{ $job->description }}</textarea>
                            </div>

                            <div class="mb-3">
                                <label for="location" class="form-label fw-semibold">Lokasi</label>
                                <input type="text" name="location" id="location" value="{{ $job->location }}" class="form-control">
                            </div>

                            <div class="mb-3">
                                <label for="company" class="form-label fw-semibold">Nama Perusahaan</label>
                                <input type="text" name="company" id="company" value="{{ $job->company }}" class="form-control">
                            </div>

                            <div class="mb-3">
                                <label for="salary" class="form-label fw-semibold">Gaji</label>
                                <input type="number" name="salary" id="salary" value="{{ $job->salary }}" class="form-control">
                            </div>

                            <div class="mb-3">
                                <label for="logo" class="form-label fw-semibold">Logo Perusahaan (opsional)</label>
                                @if ($job->logo)
                                    <div class="mb-2">
                                        <img src="{{ asset('storage/' . $job->logo) }}" alt="Logo" class="w-20 h-20 object-contain rounded-md border">
                                    </div>
                                @endif
                                <input type="file" name="logo" id="logo" class="form-control">
                            </div>

                            <div class="mb-3">
                                <label for="job_type" class="form-label fw-semibold">Jenis Pekerjaan</label>
                                <select name="job_type" id="job_type" class="form-select">
                                    <option value="Full-time" {{ $job->job_type == 'Full-time' ? 'selected' : '' }}>Full-time</option>
                                    <option value="Part-time" {{ $job->job_type == 'Part-time' ? 'selected' : '' }}>Part-time</option>
                                </select>
                            </div>

                            <div class="d-flex justify-content-start gap-2 mt-4">
                                <button type="submit" class="btn btn-primary px-4">Simpan Perubahan</button>
                                <a href="{{ route('jobs.index') }}" class="btn btn-secondary px-4">Batal</a>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
