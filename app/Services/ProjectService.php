<?php

namespace App\Services;

use App\Models\Project;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Http\UploadedFile;

class ProjectService
{
    /**
     * Store a newly created project in storage.
     *
     * @param array $data
     * @param UploadedFile|null $file
     * @return Project
     */
    public function storeProject(array $data, ?UploadedFile $file): Project
    {
        $filePath = null;
        if ($file) {
            // Using hashName() to generate a unique hash for the file, preventing duplication and standardizing paths
            $filePath = Storage::disk('public')->putFileAs('projects', $file, $file->hashName());
        }

        return Project::create([
            'title' => $data['title'],
            'sender_id' => Auth::id(),
            'receiver_id' => $data['receiver_id'],
            'file_path' => $filePath,
        ]);
    }

    /**
     * Forward an existing project to another user.
     *
     * @param array $data
     * @return Project
     */
    public function forwardProject(array $data): Project
    {
        $originalProject = Project::findOrFail($data['project_id']);

        return Project::create([
            'title' => $originalProject->title,
            'sender_id' => Auth::id(),
            'receiver_id' => $data['receiver_id'],
            'file_path' => $originalProject->file_path,
            'parent_id' => $originalProject->id,
        ]);
    }
}
