<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Project;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use App\Http\Requests\StoreProjectRequest;
use App\Http\Requests\ForwardProjectRequest;
use App\Services\ProjectService;

class ProjectController extends Controller
{
    protected $projectService;

    public function __construct(ProjectService $projectService)
    {
        $this->projectService = $projectService;
    }
    /**
     * Display a listing of the user's projects.
     */
    

    /**
     * Show the form for creating a new project.
     */
    public function create()
    {
        $engineers = User::where('role', 'engineer')->where('id', '!=', Auth::id())->get();
        return view('projects.create', compact('engineers'));
    }

    /**
     * Store a newly created project in storage.
     */
    public function store(StoreProjectRequest $request)
    {
        try {
            $project = $this->projectService->storeProject(
                $request->validated(),
                $request->file('file')
            );

            return response()->json([
                'success' => true,
                'message' => 'تم إرسال المشروع بنجاح!',
                'project' => [
                    'title' => $project->title,
                    'receiver_name' => $project->receiver->name,
                    'created_at' => $project->created_at->format('Y-m-d H:i'),
                    'file_url' => $project->file_path ? asset('storage/' . $project->file_path) : null,
                ],
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'حدث خطأ أثناء إرسال المشروع: ' . $e->getMessage(),
            ], 500);
        }
    }

    /**
     * Display all received projects.
     */
    public function receivedProjects()
    {
        $projects = Project::with(['sender', 'receiver'])
                           ->whereNull('parent_id')
                           ->orderBy('created_at', 'desc')
                           ->get();
        return view('projects.received', compact('projects'));
    }
    /**
     * Display the history of a specific project.
     */
    public function history($id)
    {
        $project = Project::with(['sender', 'receiver', 'children.sender', 'children.receiver'])->findOrFail($id);
        return view('projects.project_history', compact('project'));
    }

    /**
     * Forward an existing project to another user.
     */
    
    public function forwardProject(ForwardProjectRequest $request)
    {
        try {
            $this->projectService->forwardProject($request->validated());

            return response()->json([
                'success' => true,
                'message' => 'تم إعادة إرسال المشروع بنجاح!',
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'حدث خطأ أثناء إرسال المشروع: ' . $e->getMessage(),
            ], 500);
        }
    }

    /**
     * Remove the specified project from storage.
     */
    public function destroy($id)
    {
        $project = Project::findOrFail($id);

        if ($project->file_path) {
            Storage::disk('public')->delete($project->file_path);
        }

        $project->delete();

        return response()->json([
            'success' => true,
            'message' => 'تم حذف المشروع بنجاح!',
        ]);
    }
}