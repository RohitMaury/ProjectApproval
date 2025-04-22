<?php
namespace App\Policies;

use App\Models\User;
use App\Models\Project;

class ProjectPolicy
{
    /**
     * Allow only admins to approve projects.
     */
    public function approve(User $user, Project $project)
    {
        return $user->role === 'admin';
    }
}
