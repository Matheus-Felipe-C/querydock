<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

#[Fillable(['course_id', 'title', 'instructions', 'time_limit'])]
class Quiz extends Model
{
    use HasFactory;

    public function course()
    {
        return $this->belongsTo(Course::class);
    }

    public function questions()
    {
        return $this->belongsToMany(Question::class)
            ->withPivot(
                'weight', 
                'position',
                'is_bonus',
                'is_optional',
                )
            ->withTimestamps();
    }
}
