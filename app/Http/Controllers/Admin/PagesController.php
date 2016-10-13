<?php

namespace App\Http\Controllers\Admin;

use Activelogiclabs\Administration\Admin\Core;
use Activelogiclabs\Administration\Admin\FieldComponent;
use Activelogiclabs\Administration\Admin\FieldComponents\Boolean;
use Activelogiclabs\Administration\Admin\FieldComponents\Image;
use Activelogiclabs\Administration\Admin\FieldComponents\Select;
use Activelogiclabs\Administration\Admin\FieldComponents\Wysiwyg;
use Activelogiclabs\Administration\Http\Controllers\AdministrationController;
use App\Content;
use Illuminate\Http\Request;

use App\Http\Requests;
use Illuminate\Support\Facades\Input;

class PagesController extends AdministrationController
{
    public $model = Content::class;
    public $title = "Pages";
    public $icon = "fa-file-text";

    public $fieldDefinitions = [
        'content' => [
            'type' => Wysiwyg::class
        ],
        'preview' => [
            'type' => Wysiwyg::class
        ],
        'thumbnail' => [
            'type' => Image::class,
            'storage_path' => 'public/uploads/images'
        ],
        'subscription_group' => [
            'type' => Select::class,
            'options' => [
                'fgi' => "FGI",
                'euro' => "Euro",
                'pro' => 'Pro'
            ]
        ],
        'section' => [
            'type' => Select::class,
            'options' => [
                'breaking' => 'Breaking News',
                'expert' => 'Expert Columns',
                'fantasy_focus' => 'Fantasy Focus',
                'featured_video' => 'Featured Video',
                'golfer-of-the-week' => 'Golfer of the Week',
                'preview' => 'Preview',
                'strategy' => 'Strategy'
            ]
        ],
        'featured' => [
            'type' => Boolean::class
        ],
        'dropdown_menu' => [
            'type' => Select::class,
            'options' => [
                'pga_tools' => 'PGA Tools',
                'euro_tools' => 'EURO Tools',
                'pga_euro' => 'PGA EURO',
                'general' => 'General'
            ]
        ],
        'homepage_sidebar' => [
            'type' => Boolean::class
        ]
    ];

    public $overviewFields = [
        'title' => 'Title',
        'author' => 'Author',
        'updated_at' => 'Last Updated'
    ];

    public $detailGroups = [
        [
            'group_title' => 'Content Info',
            'group_type' => Core::GROUP_STANDARD,
            'group_fields' => [
                'title' => 'Title',
                'thumbnail' => 'Thumbnail',
                'author' => 'Author',
                'subscription_group' => 'Subscription Group',
                'section' => 'Section',
                'featured' => 'Featured',
                'dropdown_menu' => 'Dropdown Menu',
                'homepage_sidebar' => "Homepage Sidebar"
            ]
        ],
        [
            'group_title' => 'Content',
            'group_type' => Core::GROUP_WYSIWYG,
            'field' => 'content'
        ],
        [
            'group_title' => 'Preview',
            'group_type' => Core::GROUP_WYSIWYG,
            'field' => 'preview'
        ]
    ];

    public function index(Request $request)
    {
        $search = $request->input('search');
        $content = Content::select(array_add(array_keys($this->overviewFields), 'id', 'id'))->where('title', 'like', "%{$search}%")->where('type', 'page')->orderBy('title')->paginate();

        $data = FieldComponent::buildComponents($this->model, $this->buildFields($this->overviewFields), $this->fieldDefinitions, $content->getCollection()->toArray());

        $links = $content->appends( Input::except('page') );

        return Core::view( 'admin.content', [
            'title' => $this->title,
            'slug' => $this->slug,
            'detail_url' => Core::url($this->slug . "/detail"),
            'import_url' => Core::url($this->slug . "/import_data"),
            'export_url' => Core::url($this->slug . "/export_data"),
            'sort_url' => Core::url($this->slug . "/overview/sort"),
            'overviewFields' => $this->buildFields($this->overviewFields),
            'overviewTitleButtons' => $this->buildTitleButtons($this->titleButtons),
            'data' => $data,
            'page_links' => $links,
            'title_buttons' => $this->titleButtons,
            'enable_adding_records' => $this->enableAddingRecords,
            'enable_exporting_records' => $this->enableExportingRecords,
            'enableDetailView' => $this->enableDetailView
        ]);
    }
}
