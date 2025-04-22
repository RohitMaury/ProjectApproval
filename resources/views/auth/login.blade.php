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
    
    <form method="POST" action="{{ route('login') }}" class="w-50 mx-auto mt-5 border p-4 rounded shadow">
        @csrf
    
        <h3 class="text-center mb-4">Login</h3>
    
        <div class="mb-3">
            <label for="email" class="form-label">Email address</label>
            <input type="email" name="email" id="email" class="form-control" placeholder="Enter your email" required autofocus>
        </div>
    
        <div class="mb-3">
            <label for="password" class="form-label">Password</label>
            <input type="password" name="password" id="password" class="form-control" placeholder="Enter your password" required>
        </div>
    
        <div class="d-grid">
            <button type="submit" class="btn btn-primary">Login</button>
        </div>
        <div class="text-center mt-3">
            <a href="{{ route('register') }}">Create Accounts?</a>
        </div>
    </form>
    
</body>
</html>