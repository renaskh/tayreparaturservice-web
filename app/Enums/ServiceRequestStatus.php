<?php

namespace App\Enums;

enum ServiceRequestStatus: string
{
    case New = 'new';
    case InReview = 'in_review';
    case Contacted = 'contacted';
    case InProgress = 'in_progress';
    case Completed = 'completed';
    case Cancelled = 'cancelled';

    public function label(): string
    {
        return __('admin.request_statuses.'.$this->value);
    }
}
