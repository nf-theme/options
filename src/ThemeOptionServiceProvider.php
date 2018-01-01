<?php

namespace NightFury\Option;

use Illuminate\Support\Collection;
use Illuminate\Support\ServiceProvider;
use NF\Facades\Request;
use NightFury\Option\Abstracts\Input;
use NightFury\Option\Facades\ThemeOptionManager;
use NightFury\Option\Manager;
use NightFury\Option\Pages\Option;

class ThemeOptionServiceProvider extends ServiceProvider
{
    public function register()
    {
        $this->app->singleton('ThemeOption', function ($app) {
            return new Manager;
        });

        if (is_admin()) {
            $this->registerAdminMenu();
            $this->registerAdminPostAction();
        }
    }

    public function registerAdminMenu()
    {
        $option = new Option;
        $option->register();
    }

    public function registerAdminPostAction()
    {
        add_action('admin_enqueue_scripts', function () {
            wp_enqueue_media();
        });

        add_action('admin_enqueue_scripts', function () {
            wp_enqueue_style(
                'template-style',
                asset('app.css'),
                false
            );
            wp_enqueue_script(
                'template-scripts',
                asset('app.js'),
                'jquery',
                '1.0',
                true
            );

        });
        add_action('admin_post_nto_save', [ThemeOptionManager::class, 'save']);
    }
}
