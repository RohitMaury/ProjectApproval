<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <title>Document</title>
    <style>
        h2{
            font-size: 26px;
            line-height: 35px;
            font-weight: 700;
            font-family: inherit;
        }
    </style>
</head>
<body>
    
    <div class="container mt-4">
        <h2 class="mb-4">Project Approval Dashboard</h2>
    
        <div class="table-responsive">
            <table class="table table-bordered align-middle">
                <thead class="table-dark">
                    <tr>
                        <th>Project ID</th>
                        <th>Title</th>
                        <th>Description</th>
                        <th>Submitted By</th>
                        <th>Current Status</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($projects as $project)
                    <tr>
                        <td>{{ $project->id }}</td>
                        <td>{{ $project->title }}</td>
                        <td>{{ Str::limit($project->description, 50) }}</td>
                        <td>{{ $project->user->name }} ({{ $project->user->email }})</td>
                        <td>
                            <span class="badge bg-{{ $project->status === 'approved' ? 'success' : ($project->status === 'rejected' ? 'danger' : 'warning') }}">
                                {{ ucfirst($project->status) }}
                            </span>
                        </td>
                        <td>
                            <form action="{{ route('projects.changeStatus', $project->id) }}" method="POST" class="d-flex">
                                @csrf
                                @method('PATCH')
                                <select name="status" class="form-select me-2" onchange="this.form.submit()">
                                    <option disabled selected>Change Status</option>
                                    <option value="approved">Approve</option>
                                    <option value="rejected">Reject</option>
                                    <option value="pending">Mark as Pending</option>
                                </select>
                            </form>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</body>
</html>