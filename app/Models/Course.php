<?php

namespace App\Models;

use App\Models\LtiPlatform;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

#[Fillable(['lti_context_id', 'lti_platform_id', 'name'])]
class Course extends Model
{
    use HasFactory;

    public function platform()
    {
        return $this->belongsTo(LtiPlatform::class, 'lti_platform_id');
    }

    public function users()
    {
        return $this->belongsToMany(User::class)
            ->withPivot('role')
            ->withTimestamps();
    }

    public function questions()
    {
        return $this->hasMany(Question::class);
    }
}
