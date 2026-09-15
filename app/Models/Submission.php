<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use \Illuminate\Database\Eloquent\Relations\BelongsTo as BelongsTo;

class Submission extends Model
{
    use HasFactory;

    protected $fillable = ['quiz_id', 'user_id', 'score', 'status', 'started_at', 'completed_at'];

    public function quiz(): BelongsTo
    {
        return $this->belongsTo(Quiz::class);
    }

    public function student(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
