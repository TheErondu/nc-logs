<?php
namespace App\Enums;

enum IssueStatus: int {
    case WAITING = 1;
    case OPEN = 2;
    case CLOSED = 3;
    case CONTESTED = 4;
    case ESCALATED = 5;
}
