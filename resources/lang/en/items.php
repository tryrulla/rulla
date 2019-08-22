<?php

use Rulla\Items\Fields\FieldType;

return [

    'types' => [
        'index' => [
            'title' => 'All Types',
            'add' => 'Add',
            'system' => '(system base type)',
        ],

        'view' => [
            'details' => [
                'title' => 'Details',
                'parent' => 'Parent',
            ],

            'children' => [
                'title' => 'Child types',
                'add' => 'Add',
            ],

            'fields' => [
                'title' => 'Fields',
                'edit' => 'Edit',
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

        'edit' => [
            'title' => 'Edit Type',

            'form' => [
                'name' => 'Name',
                'parent_id' => 'Parent',
            ],

            'fields' => [
                'title' => 'Fields',
            ]
        ],

        'create' => [
            'title' => 'Create new Type',

            'fields' => [
                'name' => 'Name',
                'parent' => 'Parent',
            ],

            'submit' => 'Submit',
        ],

        'storage' => [
            'title' => 'Add Storage Type Location',

            'type' => 'Type Stored',
            'location' => 'Storage Location',

            'submit' => 'Submit',
        ],
    ],

    'fields' => [
        'index' => [
            'title' => 'All Fields',
            'system' => '(system field)'
        ],

        'view' => [
            'details' => [
                'title' => 'Details',
                'type' => 'Type',
            ],

            'values' => [
                'title' => 'All set values',
                'add' => 'Add',
            ],

            'applies' => [
                'title' => 'Applies to',
                'add' => 'Add',
            ]
        ],

        'modes' => [
            'item' => 'Item',
            'type' => 'Type',
        ],

        'types' => [
            FieldType::string()->getValue() => 'String',
            FieldType::number()->getValue() => 'Integer',
        ]
    ]

];
