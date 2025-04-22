<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Project extends Model
{
    use HasFactory;

    protected $fillable = [
        'title', 'description', 'file_path', 'user_id', 'status', 'rejection_reason'
    ];

    // Define possible project statuses
    const STATUS_PENDING = 'pending';
    const STATUS_APPROVED = 'approved';
    const STATUS_REJECTED = 'rejected';
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}

