<!-- resources/views/pages/auth/verify.blade.php -->

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Verifikasi</title>
</head>
<body>
    <h1>Verifikasi Kode</h1>
    <form action="{{ url('auth/verify') }}" method="POST">
        @csrf
        <label for="verification_code">Kode Verifikasi:</label>
        <input type="text" name="verification_code" id="verification_code" required>
        <button type="submit">Verifikasi</button>
    </form>

    <!-- Menampilkan pesan kesalahan -->
    @if($errors->any())
        <div style="color: red;">
            @foreach ($errors->all() as $error)
                <p>{{ $error }}</p>
            @endforeach
        </div>
    @endif
</body>
</html>
