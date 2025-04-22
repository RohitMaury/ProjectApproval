<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Project;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use App\Mail\ProjectStatusMail;


class ProjectController extends Controller
{
    public function create()
    {
        return view('projects.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'file' => 'nullable|file|max:2048',
        ]);

        $path = null;
        if ($request->hasFile('file')) {
            $path = $request->file('file')->store('projects', 'public');
        }

        Project::create([
            'title' => $validated['title'],
            'description' => $validated['description'],
            'file_path' => $path,
            'user_id' => Auth::id(),
        ]);

        return redirect()->back()->with('success', 'Project submitted successfully!');
    }

    public function approve($id)
{
    $project = Project::findOrFail($id);

    // Check if the authenticated user is an admin
    if (auth()->user()->role !== 'admin') {
        abort(403, 'Only admins can approve projects.');
    }

    // Call the stored procedure
    DB::select("CALL sp_approve_project(?)", [$id]);

    // Send email notification to the project owner
    Mail::to($project->user->email)->queue(new ProjectStatusMail($project, 'approved'));

    return response()->json(['message' => 'Project approved successfully']);
}
public function changeStatus(Request $request, $id)
{
    $request->validate([
        'status' => 'required|in:approved,rejected,pending',
    ]);

    $project = Project::findOrFail($id);

    // Authorization check using Policy
    $this->authorize('approve', $project);

    // Call the stored procedure
    $result = DB::select("CALL sp_approve_project(?, ?, ?)", [
        $project->id,
        $request->status,
        auth()->id()
    ]);

    // Send email to the project owner
    Mail::to($project->user->email)->queue(
        new ProjectStatusMail($project, $request->status)
    );

    return response()->json([
        'message' => "Project status updated to '{$request->status}' successfully.",
        'status' => $request->status
    ]);
    // return view('admin.project', compact('projects'));

}
public function adminProjects()
{
    $projects = Project::with('user')->get();
    return view('admin.project', compact('projects'));
}

}
