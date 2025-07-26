<!DOCTYPE html>
<html>
<head>
    <title>Login</title>
</head>
<body>
<h2>Login</h2>

@if (session('status'))
    <p>{{ session('status') }}</p>
@endif

@if ($errors->any())
    <ul>
        @foreach ($errors->all() as $error)
            <li style="color:red">{{ $error }}</li>
        @endforeach
    </ul>
@endif

<form method="POST" action="{{ route('login') }}">
    @csrf

    <label for="email">Email:</label>
    <input type="email" name="email" value="{{ old('email') }}" required><br>

    <label for="password">Password:</label>
    <input type="password" name="password" required><br>

    <label>
        <input type="checkbox" name="remember"> Remember Me
    </label><br>

    <button type="submit">Login</button>
</form>

<p><a href="{{ route('password.request') }}">Forgot your password?</a></p>
<p><a href="{{ route('register') }}">Don't have an account? Register</a></p>
</body>
</html>
