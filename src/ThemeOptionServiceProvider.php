<?php

namespace NightFury\Option;

use Illuminate\Support\ServiceProvider;
use NightFury\Option\Console\PublishCommand;
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

    public function registerCommand()
    {
        return [
            PublishCommand::class,
        ];
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
        if ($this->app->app_config['is_plugin'] === true) {
            add_action('admin_enqueue_scripts', function () {
                wp_enqueue_style(
                    $this->app->app_config['plugin_name'].'plugin-style',
                    wp_slash(plugin_dir_url(dirname(__FILE__)) . 'assets/dist/app.css'),
                    false
                );
                wp_enqueue_script(
                    $this->app->app_config['plugin_name'].'plugin-scripts',
                    wp_slash(plugin_dir_url(dirname(__FILE__)) . 'assets/dist/app.js'),
                    'jquery',
                    '1.0',
                    true
                );

            });
        } else {
            add_action('admin_enqueue_scripts', function () {
                wp_enqueue_style(
                    'template-style',
                    wp_slash(get_stylesheet_directory_uri() . '/vendor/nf/option/assets/dist/app.css'),
                    false
                );
                wp_enqueue_script(
                    'template-scripts',
                    wp_slash(get_stylesheet_directory_uri() . '/vendor/nf/option/assets/dist/app.js'),
                    'jquery',
                    '1.0',
                    true
                );

            });
        }
        add_action('admin_post_nto_save', [ThemeOptionManager::class, 'save']);
        add_action('wp_ajax_nto_remove', [ThemeOptionManager::class, 'remove']);
    }
}
