<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

#[Fillable(['issuer', 'client_id'])]
class LtiPlatform extends Model
{
    use HasFactory;

    public function users()
    {
        return $this->hasMany(User::class, 'lti_platform_id');
    }

    public function courses()
    {
        return $this->hasMany(Course::class, 'lti_platform_id');
    }
}
