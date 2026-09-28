<?php

namespace App\Models;

use App\Enums\SubmissionStatus;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use \Illuminate\Database\Eloquent\Relations\BelongsTo as BelongsTo;

class Submission extends Model
{
    use HasFactory;

    protected $fillable = [
        'quiz_id',
        'user_id',
        'attempt_number',
        'auto_score',
        'score',
        'graded_by',
        'graded_at',
        'status',
        'started_at',
        'completed_at'
    ];

    protected function casts(): array
    {
        return [
            'status' => SubmissionStatus::class,
            'auto_score' => 'float',
            'score' => 'float',
            'started_at' => 'datetime',
            'completed_at' => 'datetime',
            'graded_at' => 'datetime',
        ];
    }

    public function quiz(): BelongsTo
    {
        return $this->belongsTo(Quiz::class);
    }

    public function student(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function grader(): BelongsTo
    {
        return $this->belongsTo(User::class, 'graded_by');
    }

    public function isGraded(): bool
    {
        return $this->graded_by !== null;
    }

    public function completionSeconds(): ?int
    {
        if (!$this->started_at || $this->completed_at) {
            return null;
        }

        return $this->started_at->diffInSeconds($this->completed_at);
    }
}
