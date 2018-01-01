<?php

namespace NightFury\Option\Pages;

use NF\Facades\App;
use NF\Facades\Request;
use NF\Facades\Storage;
use NightFury\Option\Abstracts\AdminPage;
use NightFury\Option\Manager;

class Option extends AdminPage
{
    public $page_title = 'Theme Configuration';

    public $menu_title = 'Theme Configuration';

    public $menu_slug = Manager::MENU_SLUG;

    public function render()
    {
        $manager      = App::make('ThemeOption');
        $pages        = $manager->getPages();
        $current_page = $manager->getPage(Request::get('tab'));
        $should_flash = false;
        if (get_option(Manager::NTO_SAVED_SUCCESSED) !== false) {
            $should_flash = true;
            delete_option(Manager::NTO_SAVED_SUCCESSED);
        }
        if (Storage::has('resources/views/vendor/option/admin.blade.php')) {
            echo \NF\View\Facades\View::render('vendor.option.admin', compact('manager', 'pages', 'current_page', 'should_flash'));
        } else {
            echo \NightFury\Option\Facades\View::render('admin', compact('manager', 'pages', 'current_page', 'should_flash'));
        }
    }
}
