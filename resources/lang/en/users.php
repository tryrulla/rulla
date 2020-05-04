<?php

return [
    'profile' => [
        'users' => 'Users',

        'index' => [
            'title' => 'All Users',
        ],

        'view' => [
            'edit' => 'Edit',

            'details' => [
                'title' => 'Details',
                'id' => 'User ID',
                'email' => 'Email',
                'name' => 'Name',
                'groups' => 'Groups',
            ],
        ],

        'edit' => [
            'title' => 'Editing user :name',

            'form' => [
                'name' => 'Name',
            ],

            'submit' => 'Submit',
        ],
    ],

    'groups' => [
        'groups' => 'Groups',
        'all-groups' => 'All Groups',
        'create' => 'New Group',
        'edit' => 'Edit Group',

        'fields' => [
            'id' => 'ID',
            'name' => 'Name',
        ],
    ],
];
