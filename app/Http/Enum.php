<?php

namespace App\Http;

class Enum
{
    const SCHEDULE_STATUS_PENDING = 'pending';
    const SCHEDULE_STATUS_ACCEPT = 'accept';
    const PERMISSIONS = [
        'schedule' => [
            'list', 'create', 'edit', 'delete', 'publish', 'unpublish',
        ],
        'user' => [
            'list', 'edit',
        ],
        'job' => [
            'list', 'create', 'edit', 'delete',
        ],
        'role' => [
            'list', 'create', 'edit', 'delete',
        ],
    ];
}
