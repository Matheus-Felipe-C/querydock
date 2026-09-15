<?php

namespace App\Models;

use Attribute;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Casts\Attribute as CastsAttribute;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

#[Fillable(['course_id', 'title', 'instructions', 'time_limit'])]
class Quiz extends Model
{
    use HasFactory;

    protected $appends = [
        'updated_at_human',
    ];

    protected function updatedAtHuman(): CastsAttribute
    {
        return CastsAttribute::make(
            get: fn () => $this->updated_at?->diffForHumans(['short' => true])
        );
    }

    public function scopeFilter(Builder $query, array $filters): Builder
    {
        return $query
            ->when($filters['search'] ?? null, function ($query, $search) {
                $query->where(function ($q) use ($search) {
                    $q->where('title', 'like', "%{$search}%")
                    ->orWhere('instructions', 'like', "%{$search}%");
                });
            })
            ->when($filters['status'] ?? null, function($query, $status) {
                $query->where('status', $status);
            })
            ->when($filters['sort'] ?? null, function($query, $sort) {
                match($sort) {
                    'oldest' => $query->orderBy('created_at', 'asc'),
                    default => $query->orderBy('created_at','desc'),
                };
            }, function($query) {
                $query->latest();
            });
    }
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

    public function submissions(): HasMany
    {
        return $this->hasMany(Submission::class);
    }
}
