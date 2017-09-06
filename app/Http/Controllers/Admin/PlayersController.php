<?php

namespace App\Http\Controllers\Admin;

use Activelogiclabs\Administration\Admin\Core;
use Activelogiclabs\Administration\Admin\Route;
use Activelogiclabs\Administration\Http\Controllers\AdministrationController;
use App\Player;
use App\Slate;
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
    'position' => 'Position',
    'team' => 'Team',
    'slate_id' => "Slate",
    'updated_at' => 'Last Updated'
  ];

  public $detailFields = [
    [
      "group_title" => "Ownership Percentage Predictions",
      "group_type" => Core::GROUP_STANDARD,
      "group_fields" => [
        'name' => 'Name',
        'salary' => 'Salary',
        'position' => 'Position',
        'team' => 'Team',
        'slate_id' => "slate_id",
      ]
    ]
  ];

  public $titleButtons = [
    [
      "icon" => "fa-cloud-download",
      "title" => "Import DraftKings File",
      "route_uri" => "/admin/players/draft-kings-import"
    ]
  ];

  public function draftKingImport()
  {
    return Core::view("admin/draft_kings_import", ['slates' => Slate::all()]);
  }

  public function processDraftKingsImport(Request $request)
  {
    $this->validate($request, [
      'draftKings' => 'required',
      'slate_id' => 'required'
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
        'position' => 'Position',
        'team' => 'Team',
        'draft_kings_id' => 'ID'
      ];

      $messages = [];
      if ($missing = array_diff(array_keys($requiredColumns), $headers)) {

        foreach ($missing as $item) {
          $messages[] = "The {$requiredColumns[$item]} column is missing.";
        }

        return back()->withErrors($messages);
      }

      Player::where('slate_id', '=', $request->slate_id)->delete();

      // include the slate_id into the headers
      array_push($headers, "slate_id");

      while (($data = fgetcsv($handle, ',')) !== false) {
        // include the slate_id into the player data
        array_push($data, intval($request->slate_id));

        Player::create(array_combine($headers, $data));
      }
    }

    return redirect(Core::url('players'));
  }

}
