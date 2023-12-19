<?php

namespace App\Services;

use App\Enums\IssueStatus;
use App\Models\Issue;

class IssueService
{
    public function getCountByStatus(IssueStatus $status): int
    {
        return Issue::where('status', $status->value)->count();
    }

    public function getRaisedIssues($userId, $perPage = 10)
    {
        return Issue::where('user_id', $userId)->orderBy('id', 'desc')->paginate($perPage);
    }

    public function getAllIssues($perPage = 10)
    {
        return Issue::orderBy('id', 'DESC')->paginate($perPage);
    }
}
