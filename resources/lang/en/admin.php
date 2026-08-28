<?php

return [
    'permissions' => [
        'manage' => 'Manage creator codes',
    ],
    'nav' => 'Creator codes',
    'title' => 'Creator codes',
    'created' => 'Creator added.',
    'updated' => 'Creator updated.',
    'deleted' => 'Creator deleted.',
    'add' => 'Add a creator',
    'edit' => 'Edit creator',
    'fields' => [
        'pseudo' => 'Username',
        'code' => 'Code',
        'percentage' => 'Percentage',
        'status' => 'Status',
        'neos' => 'Neos paid',
    ],
    'status' => [
        'enabled' => 'Active',
        'disabled' => 'Inactive',
    ],
    'help' => [
        'pseudo' => 'Must match the creator Azuriom account.',
        'code' => 'Code entered by the player in the shop.',
        'percentage' => 'The creator receives this % of purchased neos, extra. Nothing is taken from the buyer.',
    ],
    'errors' => [
        'user' => 'No Azuriom account with this username.',
        'duplicate_user' => 'This player already has a creator code.',
    ],
    'empty' => 'No creators yet.',
    'logs' => [
        'creatorcodes-creators' => [
            'created' => 'Created creator code',
            'updated' => 'Updated creator code',
            'deleted' => 'Deleted creator code',
        ],
    ],
];
