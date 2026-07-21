<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

#[Fillable(['course_id', 'title', 'description', 'difficulty', 'topics', 'starter_code', 'expected_answer'])]
class Question extends Model
{
    use HasFactory;
    
    public function course()
    {
        return $this->belongsTo(Course::class);
    }

    public function dataset()
    {
        return $this->belongsTo(Dataset::class);
    }

    public function quizzes()
    {
        return $this->belongsToMany(Quiz::class)
            ->withPivot('weight', 'position')
            ->withTimestamps();
    }

    public function casts()
    {
        return [
            "topics" => "array",
        ];
    }

    /**
     * Dynamically fall back to the dataset SQL script if starter code is empty.
     */
    protected function starterCode()
    {
        return Attribute::make(
            get: function (?string $value) {
                if (!empty($value)) {
                    return $value;
                }

                // If the question has a dataset, grab its script instead.
                return $this->dataset?->sql_script ?? '';
            }
        );
    }
}
