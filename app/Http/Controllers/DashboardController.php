<?php

namespace App\Http\Controllers;

use App\Models\Project;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth'); // Ensure the user is logged in
    }

    public function index()
    {
        // Get the statistics
        $totalProjects = Project::count();
        $totalPending = Project::where('status', Project::STATUS_PENDING)->count();
        $totalRejected = Project::where('status', Project::STATUS_REJECTED)->count();
        $totalApproved = Project::where('status', Project::STATUS_APPROVED)->count();

        $pendingPercent = $totalProjects ? ($totalPending / $totalProjects) * 100 : 0;
        $rejectedPercent = $totalProjects ? ($totalRejected / $totalProjects) * 100 : 0;
        $approvedPercent = $totalProjects ? ($totalApproved / $totalProjects) * 100 : 0;

        // Fetch the list of projects (with pagination)
        $projects = Project::latest()->paginate(10);

        return view('dashboard.index', compact(
            'totalProjects', 'totalPending', 'totalRejected', 'totalApproved', 
            'pendingPercent', 'rejectedPercent', 'approvedPercent', 'projects'
        ));
    }

    public function updateStatus(Request $request, $projectId)
    {
        // Find the project
        $project = Project::findOrFail($projectId);

        // Update the project status
        $project->status = $request->status;

        // If the project is rejected, store the rejection reason
        if ($request->status == Project::STATUS_REJECTED) {
            $project->rejection_reason = $request->reason;
        } else {
            $project->rejection_reason = null;
        }

        // Save the project
        $project->save();

        return redirect()->route('dashboard.index')->with('success', 'Project status updated.');
    }
    
}
