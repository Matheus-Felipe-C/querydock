<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Model;

#[Fillable(['course_id', 'title', 'description', 'difficulty', 'topic', 'starter_code', 'expected_answer'])]
class Question extends Model
{
    public function course()
    {
        return $this->belongsTo(Course::class);
    }
}
