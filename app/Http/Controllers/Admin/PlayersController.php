<?php

namespace App\Http\Controllers\Admin;

use Activelogiclabs\Administration\Admin\Core;
use Activelogiclabs\Administration\Admin\Route;
use Activelogiclabs\Administration\Http\Controllers\AdministrationController;
use App\Player;
use Illuminate\Http\Request;

use App\Http\Requests;
use Illuminate\Support\Str;

class PlayersController extends AdministrationController
{
    public $model = Player::class;
    public $title = "Players";
    public $icon = "fa-flag";

    public $fieldDefinitions = [];
    public $routes;

    public function __construct()
    {
        parent::__construct();

        $this->routes = [
            Route::get("draft-kings-import", "App\\Http\\Controllers\\Admin\\PlayersController@draftKingImport"),
            Route::post("draft-kings-import", "App\\Http\\Controllers\\Admin\\PlayersController@processDraftKingsImport")
        ];
    }

    public $overviewFields = [
        'name' => 'Name',
        'salary' => 'Salary',
        'zach_prediction' => "Zach's Prediction",
        'jeff_prediction' => "Jeff's Prediction",
        'updated_at' => 'Last Updated'
    ];

    public $detailFields = [
        [
            "group_title" => "Ownership Percentage Predictions",
            "group_type" => Core::GROUP_STANDARD,
            "group_fields" => [
                'name' => 'Name',
                'salary' => 'Salary',
                'zach_prediction' => "Zach's Prediction",
                'jeff_prediction' => "Jeff's Prediction"
            ]
        ]
    ];

    public $titleButtons = [
        [
            "icon" => "fa-cloud-download",
            "title" => "Import DraftKings File",
            "route_uri" => "players/draft-kings-import"
        ]
    ];

    public function draftKingImport()
    {
        return Core::view("admin/draft_kings_import", []);
    }

    public function processDraftKingsImport(Request $request)
    {
        $this->validate($request, [
            'draftKings' => 'required'
        ]);

        if (($handle = fopen($request->file('draftKings'), 'r')) !== false) {

            $headers = [];
            foreach (fgetcsv($handle, ',') as $header) {

                $header = trim($header);

                if (Str::contains($header, 'ID')) {
                    $header = 'draft_kings_' . $header;
                }

                $headers[] = Str::lower($header);

            }

            $requiredColumns = [
                'name' => 'Name',
                'salary' => 'Salary',
                'draft_kings_id' => 'ID'
            ];

            $messages = [];
            if ($missing = array_diff(array_keys($requiredColumns), $headers)) {

                foreach ($missing as $item) {
                    $messages[] = "The {$requiredColumns[$item]} column is missing.";
                }

                return back()->withErrors($messages);
            }

            Player::truncate();

            while (($data = fgetcsv($handle, ',')) !== false) {
                Player::create(array_combine($headers, $data));
            }
        }

        return redirect(Core::url('players'));
    }

}
