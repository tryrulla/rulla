<?php

use Rulla\Items\Fields\FieldType;

return [
    'instances' => [
        'index' => [
            'title' => 'All Items',
            'add' => 'Add',
        ],

        'create' => [
            'title' => 'Create new Item',

            'form' => [
                'tag' => 'Tag',
                'type' => 'Type',
                'location' => 'Location (optional)',
            ],

            'fields' => [
                'title' => 'Fields',
                'none' => 'There are no fields available for this item type.',
            ],

            'submit' => 'Submit',
        ],

        'edit' => [
            'title' => 'Edit Item',

            'form' => [
                'tag' => 'Tag',
                'type' => 'Type',
                'location' => 'Location (optional)',
            ],

            'fields' => [
                'title' => 'Fields',
                'none' => 'There are no fields available for this item type.',
            ],

            'submit' => 'Submit',
        ],

        'view' => [
            'edit' => 'Edit',
            'checkout' => 'Checkout',
            'return' => 'Return',
            'add-fault' => 'Record Fault',

            'details' => [
                'title' => 'Details',
                'tag' => 'Tag',
                'type' => 'Type',
                'location' => 'Location',
            ],

            'fields' => [
                'title' => 'Fields'
            ],

            'checkouts' => [
                'title' => 'Latest checkouts',
                'id' => 'ID',
                'start_time' => 'Checked out at',
                'return_time' => 'Returned at',
                'user' => 'User',
            ],

            'faults' => [
                'title' => 'Latest faults',
            ],
        ],
    ],

    'faults' => [
        'title' => 'Fault',
        'latest-faults' => 'Latest Faults',
        'assigned-faults' => 'Assigned Faults',
        'create' => 'Create Item Fault',
        'edit' => 'Edit Item Fault',

        'fields' => [
            'id' => 'ID',
            'item' => 'Item',
            'type' => 'Item Type',

            'status' => 'Status',
            'open' => 'Open',
            'closed' => 'Closed',

            'assignee' => 'Assignee',

            'title' => 'Title',
            'description' => 'Description',
        ],
    ],

    'checkouts' => [
        'title' => 'Checkout',
        'latest-checkouts' => 'Latest Checkouts',
        'create' => 'New Checkout',
        'edit' => 'Edit Checkout',

        'checkout-to' => [
            'title' => 'Checkout To',
            'help' => 'At least one is required.',
        ],

        'fields' => [
            'id' => 'ID',
            'item' => 'Item',
            'user' => 'User',
            'location' => 'Location',

            'due_date' => 'Due Date',
            'created_at' => 'Checked Out At',
            'returned_at' => 'Returned At',
        ],
    ],

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

            'instances' => [
                'title' => 'Instances',
                'add' => 'Add',
            ],

            'locatedHere' => [
                'title' => 'Items here',
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

            'delete' => 'Delete',
            'deleted' => 'Successfully deleted type storage record.',
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
        ],

        'apply_to' => [
            'create' => [
                'title' => 'Add Field Applying Location',

                'field' => 'Field',
                'type' => 'Type',
                'apply_to' => 'Apply to',

                'submit' => 'Submit',
            ],

            'delete' => 'Delete',
            'deleted' => 'Successfully deleted FieldAppliesTo record.',
        ]
    ]

];
