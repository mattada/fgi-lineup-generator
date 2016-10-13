<?php

namespace App\Http\Controllers\Admin;

use Activelogiclabs\Administration\Admin\Core;
use Activelogiclabs\Administration\Admin\FieldComponents\Label;
use Activelogiclabs\Administration\Admin\FieldComponents\Wysiwyg;
use Activelogiclabs\Administration\Http\Controllers\AdministrationController;
use App\Contact;
use Illuminate\Http\Request;

use App\Http\Requests;

class ContactsController extends AdministrationController
{
    public $model = Contact::class;
    public $title = "Contacts";
    public $icon = "fa-question-circle";

    public $fieldDefinitions = [
        'comment' => [
            'type' => Label::class
        ],
        'first_name' => [
            'type' => Label::class
        ],
        'last_name' => [
            'type' => Label::class
        ],
        'email' => [
            'type' => Label::class
        ]
    ];

    public $overviewFields = [
        'first_name' => 'First Name',
        'last_name' => 'Last Name',
        'email' => 'Email'
    ];

    public $detailGroups = [
        [
            'group_title' => 'Contact Information',
            'group_type' => Core::GROUP_STANDARD,
            'group_fields' => [
                'first_name' => 'First Name',
                'last_name' => 'Last Name',
                'email' => 'Email'
            ]
        ],
        [
            'group_title' => 'Message',
            'group_type' => Core::GROUP_FULL,
            'field' => 'comment'
        ]
    ];

}
