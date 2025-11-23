<!DOCTYPE html>
<html>
<head>
    <title>Status Lamaran</title>
</head>
<body>
    <h2>Halo {{ $user->name }},</h2>

    <p>Pekerjaan yang Anda lamar: <b>{{ $job->title }}</b></p>

    @if ($status == 'Accepted')
        <p style="color: green;">Selamat! Lamaran Anda telah <strong>DITERIMA</strong>.</p>
        <p>Tim HR akan menghubungi Anda untuk proses selanjutnya.</p>
    @else
        <p style="color: red;">Maaf, lamaran Anda <strong>TIDAK LOLOS</strong> seleksi.</p>
        <p>Terima kasih telah melamar di perusahaan kami.</p>
    @endif

    <br>
    <p>Salam,</p>
    <p><b>Tim {{ config('app.name') }}</b></p>
</body>
</html>
