<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <title>Document</title>
</head>
<body>
    <form method="POST" action="{{ route('register') }}" class="w-50 mx-auto mt-5 border p-4 shadow rounded">
        @csrf
        <h3 class="mb-4 text-center">Register</h3>
    
        <div class="mb-3">
            <label for="name" class="form-label">Name</label>
            <input type="text" name="name" class="form-control" placeholder="Enter your name" required>
        </div>
    
        <div class="mb-3">
            <label for="email" class="form-label">Email address</label>
            <input type="email" name="email" class="form-control" placeholder="Enter your email" required>
        </div>
    
        <div class="mb-3">
            <label for="password" class="form-label">Password</label>
            <input type="password" name="password" class="form-control" placeholder="Enter password" required>
        </div>
    
        <div class="mb-3">
            <label for="password_confirmation" class="form-label">Confirm Password</label>
            <input type="password" name="password_confirmation" class="form-control" placeholder="Confirm password" required>
        </div>
    
        <button type="submit" class="btn btn-primary w-100">Register</button>
    
        <div class="text-center mt-3">
            <a href="{{ route('login') }}">Already have an account? Login</a>
        </div>
    </form>
    
</body>
</html>