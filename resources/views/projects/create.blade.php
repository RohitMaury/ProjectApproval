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
    <div class="container">
        <div class="text-center mr-0 ">
            <a href="{{ route('dashboard.index') }}">Check Project Statuse</a>
        </div>
    </div>

    <div class="container mt-5">
        <h2>Submit a New Project</h2>
    
        @if (session('success'))
            <div class="alert alert-success mt-2">{{ session('success') }}</div>
        @endif
    
        <form id="projectForm" method="POST" action="{{ route('projects.store') }}" enctype="multipart/form-data" novalidate>
            @csrf
    
            <div class="mb-3">
                <label class="form-label">Title</label>
                <input type="text" name="title" class="form-control" required>
                <div class="invalid-feedback">Please provide a title.</div>
            </div>
    
            <div class="mb-3">
                <label class="form-label">Description</label>
                <textarea name="description" class="form-control" rows="5" required></textarea>
                <div class="invalid-feedback">Please provide a description.</div>
            </div>
    
            <div class="mb-3">
                <label class="form-label">Upload File (optional)</label>
                <input type="file" name="file" class="form-control">
            </div>
    
            <button type="submit" class="btn btn-primary">Submit Project</button>
        </form>
    </div>
  
    
    @section('scripts')
    <script>
    document.getElementById('projectForm').addEventListener('submit', function (event) {
        let form = this;
        if (!form.checkValidity()) {
            event.preventDefault();
            event.stopPropagation();
        }
        form.classList.add('was-validated');
    });
    </script>
</body>
</html>