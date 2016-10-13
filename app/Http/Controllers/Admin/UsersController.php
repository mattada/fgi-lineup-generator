<?php

namespace App\Http\Controllers\Admin;

use Activelogiclabs\Administration\Admin\Core;
use Activelogiclabs\Administration\Admin\FieldComponents\Boolean;
use Activelogiclabs\Administration\Admin\FieldComponents\Relationship;
use Activelogiclabs\Administration\Admin\Route;
use Activelogiclabs\Administration\Http\Controllers\AdministrationController;
use App\Jobs\ImportUser;
use App\Plan;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class UsersController extends AdministrationController
{
    public $model = User::class;
    public $title = 'Users';
    public $icon = 'fa-users';

    public $fieldDefinitions = [
        'plan_id' => [
            'type' => Relationship::class,
            'model' => Plan::class,
            'display' => 'title'
        ],
        'is_admin' => [
            'type' => Boolean::class
        ]
    ];

    public $overviewFields = [
        'name' => 'Name',
        'email' => 'Email',
        'plan_id' => 'Plan',
        'status' => 'Status',
        'is_admin' => 'Admin'
    ];

    public $detailFields = [
        [
            'group_title' => 'User Information',
            'group_type' => Core::GROUP_STANDARD,
            'group_fields' => [
                'name' => 'Name',
                'email' => 'Email',
                'plan_id' => 'Plan',
                'status' => 'Status'
            ]
        ]
    ];

    public $titleButtons = [
        [
            'icon' => 'fa-cloud-download',
            'title' => 'Import Cointent Users',
            'route_uri' => 'users/cointent-import'
        ]
    ];

    public function __construct()
    {
        parent::__construct();

        $this->routes = [
            Route::get('cointent-import', "App\\Http\\Controllers\\Admin\\UsersController@cointentImport"),
            Route::post('cointent-import', "App\\Http\\Controllers\\Admin\\UsersController@processCointentImport")
        ];
    }

    public function cointentImport()
    {
        return Core::view('admin/cointent-import', []);
    }

    public function processCointentImport(Request $request)
    {
        $this->validate($request, [
            'cointent' => 'required'
        ]);

        if (($handle = fopen($request->file('cointent'), 'r')) !== false)
        {
            $headers = [];
            foreach (fgetcsv($handle, ',') as $header) {

                $header = trim($header);

                $headers[] = Str::snake($header);

            }

            $requiredColumns = [
                'plan_id' => 'PlanId',
                'email' => 'Email',
                'active' => 'Active',
                'was_granted' => 'Was Granted',
                'subscription_start_time' => 'Subscription_start_time',
                'has_set_password' => 'Has Set Password'
            ];

            $messages = [];
            if ($missing = array_diff(array_keys($requiredColumns), $headers)) {

                foreach ($missing as $item) {
                    $messages[] = "The {$requiredColumns[$item]} column is missing.";
                }

                return back()->withErrors($messages);
            }

            while (($data = fgetcsv($handle, ',')) !== false)
            {
                $data = array_combine($headers, $data);

                $job = new ImportUser($data);
                dispatch($job);

            }
        }

        Core::setSuccessResponse("Users have been queued for update");

        return redirect(Core::url('users'));
    }
}
