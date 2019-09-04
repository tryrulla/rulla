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
            'edit' => 'Edit',

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
                'none' => 'There are no fields available for this item type.',
            ]
        ],

        'create' => [
            'title' => 'Create new Type',

            'form' => [
                'name' => 'Name',
                'parent' => 'Parent',
            ],

            'fields' => [
                'title' => 'Fields',
                'none' => 'There are no fields available for this item type.',
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
            'system' => '(system field)',
            'add' => 'Add',
        ],

        'view' => [
            'edit' => 'Edit',

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

        'create' => [
            'title' => 'Create new Field',

            'form' => [
                'name' => 'Name',
                'description' => 'Description',
                'type' => 'Value type',
            ],

            'submit' => 'Submit'
        ],

        'edit' => [
            'title' => 'Edit Field',

            'form' => [
                'name' => 'Name',
                'description' => 'Description',
                'type' => 'Value type',
            ],

            'submit' => 'Submit'
        ],

        'modes' => [
            'item' => 'Item',
            'type' => 'Type',
        ],

        'types' => [
            FieldType::string()->getValue() => 'String',
            FieldType::number()->getValue() => 'Integer',
        ],

        'extra_options' => [
            'unit' => 'Unit of Measurement',
            'decimals' => 'Decimals'
        ]
    ]

];
