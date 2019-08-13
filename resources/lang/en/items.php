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

            'stored_at' => [
                'title' => 'Type Stored At'
            ],

            'system' => [
                'title' => 'System',
                'text' => 'This is a system base type and can\'t be modified.',
            ]
        ]
    ]

];
