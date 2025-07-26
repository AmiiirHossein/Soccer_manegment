<!DOCTYPE html>
<html>
<head>
    <title>Register</title>
</head>
<body>
<h2>Register</h2>

@if ($errors->any())
    <ul>
        @foreach ($errors->all() as $error)
            <li style="color:red">{{ $error }}</li>
        @endforeach
    </ul>
@endif

<form method="POST" action="{{ route('register') }}">
    @csrf

    <label for="name">Name:</label><br>
    <input type="text" name="name" value="{{ old('name') }}" required><br><br>

    <label for="email">Email:</label><br>
    <input type="email" name="email" value="{{ old('email') }}" required><br><br>

    <label for="password">Password:</label><br>
    <input type="password" name="password" required><br><br>

    <label for="password_confirmation">Confirm Password:</label><br>
    <input type="password" name="password_confirmation" required><br><br>

    <button type="submit">Register</button>
</form>

<p><a href="{{ route('login') }}">Already have an account? Login</a></p>
</body>
</html>
