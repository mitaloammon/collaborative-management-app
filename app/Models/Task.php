<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;

use Illuminate\Database\Eloquent\Model;

class Task extends Model
{
        use HasFactory, SoftDeletes;

        protected $fillable = ['project_id', 'assigned_to', 'title', 'description', 'status', 'priority', 'due_date'];

        public function project()
        {
            return $this->belongsTo(Project::class);
        }

        public function assignee()
        {
            return $this->belongsTo(User::class, 'assigned_to');
        }

        public function comments()
        {
            return $this->hasMany(Comment::class);
        }

        public function tags()
        {
            return $this->belongsToMany(Tag::class, 'tag_task')->withTimestamps();
        }
}
