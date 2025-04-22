<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <title>Document</title>
    <style>
        h1{
            font-size: 46px;
            font-weight: 700;
            line-height: 75px;
            font-family: inherit;
        }
        h2{
            font-size: 26px;
            font-weight: 700;
            line-height: 55px;
            font-family: inherit;
        }
    </style>    
</head>
<body>
    
    <div class="container pt-5">
        <h1>Project Dashboard</h1>
    
        {{-- Summary Statistics Panel --}}
        <div class="row">
            <div class="col-md-3">
                <div class="card">
                    <div class="card-header">Total Submitted Projects</div>
                    <div class="card-body">
                        {{ $totalProjects }} ({{ number_format($totalProjects ? ($totalProjects / $totalProjects) * 100 : 0, 2) }}%)
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card">
                    <div class="card-header">Total Pending Projects</div>
                    <div class="card-body">
                        {{ $totalPending }} ({{ number_format($pendingPercent, 2) }}%)
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card">
                    <div class="card-header">Total Rejected Projects</div>
                    <div class="card-body">
                        {{ $totalRejected }} ({{ number_format($rejectedPercent, 2) }}%)
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card">
                    <div class="card-header">Total Approved Projects</div>
                    <div class="card-body">
                        {{ $totalApproved }} ({{ number_format($approvedPercent, 2) }}%)
                    </div>
                </div>
            </div>
        </div>
    
        {{-- Project List View --}}
        <h2 class="mt-4">Project List</h2>
        <table class="table table-striped table-responsive">
            <thead>
                <tr>
                    <th>Project Title</th>
                    <th>Submitter</th>
                    <th>Submission Date</th>
                    <th>Status</th>
                    <th>Last Updated</th>
                    @if(Auth::user()->is_admin)  <!-- Admin actions -->
                    <th>Actions</th>
                    @endif
                </tr>
            </thead>
            <tbody>
                @foreach($projects as $project)
                    <tr>
                        <td>{{ $project->title }}</td>
                        <td>{{ $project->user->name }}</td>
                        <td>{{ $project->created_at->format('Y-m-d H:i:s') }}</td>
                        <td>
                            <span class="badge 
                                @if($project->status == 'pending') bg-warning text-dark
                                @elseif($project->status == 'approved') bg-success
                                @elseif($project->status == 'rejected') bg-danger
                                @endif">
                                {{ ucfirst($project->status) }}
                            </span>

                        </td>
                        <td>{{ $project->updated_at->format('Y-m-d H:i:s') }}</td>
    
                        @if(Auth::user()->is_admin)  <!-- Admin actions -->
                        <td>
                            <form action="{{ route('dashboard.updateStatus', $project->id) }}" method="POST">
                                @csrf
                                @method('PUT')
    
                                @if($project->status != 'approved')
                                    <button type="submit" name="status" value="approved" class="btn btn-success btn-sm">Approve</button>
                                @endif
                                
                                @if($project->status != 'rejected')
                                    <button type="submit" name="status" value="rejected" class="btn btn-danger btn-sm" data-toggle="modal" data-target="#rejectionReasonModal{{ $project->id }}">Reject</button>
                                @endif
                            </form>
                        </td>
                        @endif
                    </tr>
                @endforeach
            </tbody>
        </table>
    
        <!-- Pagination Links -->
        {{ $projects->links() }}
    </div>
</body>
</html>