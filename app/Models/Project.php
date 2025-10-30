<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;

use Illuminate\Database\Eloquent\Model;

class Project extends Model
{
    use HasFactory, SoftDeletes;

        protected $fillable = ['owner_id', 'name', 'description', 'status', 'due_date'];

        public function owner()
        {
            return $this->belongsTo(User::class, 'owner_id');
        }

        public function members()
        {
            return $this->belongsToMany(User::class, 'project_user')->withTimestamps();
        }

        public function tasks()
        {
            return $this->hasMany(Task::class);
        }
}
