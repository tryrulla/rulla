<?php

return [

    'types' => [
        'index' => [
            'title' => 'All Items',
            'system' => '(system base type)'
        ],

        'view' => [
            'properties' => [
                'title' => 'Properties',
                'edit' => 'Edit',

                'parent' => 'Parent',
            ],

            'stored' => [
                'at' => 'Type Stored At',
                'here' => 'Types Stored Here',
                'system' => '(system base type)',
                'via' => 'via',
                'add' => 'Add',
            ],

            'system' => [
                'title' => 'System',
                'text' => 'This is a system base type and can\'t be modified.',
            ]
        ],

        'storage' => [
            'title' => 'Add Storage Type Location',

            'type' => 'Type Stored',
            'location' => 'Storage Location',
        ]
    ]

];
