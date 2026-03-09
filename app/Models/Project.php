<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Project extends Model
{
    protected $fillable = ['title', 'file_path', 'sender_id', 'receiver_id','parent_id'];
    public function sender()
    {
        return $this->belongsTo(User::class, 'sender_id');
        
    }

    public function receiver()
    {
        return $this->belongsTo(User::class, 'receiver_id');
    }
    public function children()
    {
        return $this->hasMany(Project::class, 'parent_id');
    }
}

