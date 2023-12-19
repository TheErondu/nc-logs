<?php

namespace App\Models;

use App\Enums\IssueStatus;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Issue extends Model
{
    use HasFactory;

    protected $fillable = [
        'status'
    ];

    public function user()
    {
        return $this->belongsTo('App\Models\User', 'user_id');
    }
    public function assigned_enginner()
    {
        return $this->belongsTo('App\Models\User', 'user_id');
    }
    public function store()
    {
        return $this->belongsTo('App\Models\Store', 'store_id');
    }

    public static function mapStatusToLabelClass(int $status)
    {
        switch (IssueStatus::from($status)) {
            case IssueStatus::WAITING:
                return 'issue-waiting';
            case IssueStatus::OPEN:
                return 'issue-open';
            case IssueStatus::CLOSED:
                return 'issue-closed';
            case IssueStatus::CONTESTED:
                return 'issue-contested';
            case IssueStatus::ESCALATED:
                return 'issue-escalated';
            default:
                return 'issue-default';
        }
    }
}
