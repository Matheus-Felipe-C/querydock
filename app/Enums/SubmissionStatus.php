<?php

namespace App\Enums;

enum SubmissionStatus: string
{
    case inProgress = 'in_progress';
    case Completed = 'completed';

    public function label(): string
    {
        return match ($this) {
            self::inProgress => 'In Progress',
            self::Completed => 'Completed',
        };
    }
}
