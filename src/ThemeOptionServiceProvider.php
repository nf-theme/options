<?php

namespace NightFury\Option;

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

        ThemeOptionManager::add([
            'name'   => 'General',
            'fields' => [
                [
                    'label' => 'Text',
                    'name'  => 'theme_option_text',
                    'type'  => Input::TEXT,
                ],
                [
                    'label' => 'Email',
                    'name'  => 'theme_option_email',
                    'type'  => Input::EMAIL,
                ],
                [
                    'label'       => 'Image',
                    'name'        => 'theme_option_image',
                    'type'        => Input::IMAGE,
                    'description' => 'Some quick example text to build on the card title and make up the bulk of the card\'s content.',
                ],
                 [
                    'label'       => '2nd Image',
                    'name'        => 'theme_option_image_2nd',
                    'type'        => Input::IMAGE,
                    'description' => 'Some quick example text to build on the card title and make up the bulk of the card\'s content.',
                ],
                [
                    'label'   => 'Select',
                    'name'    => 'theme_option_select',
                    'type'    => Input::SELECT,
                    'options' => [
                        [
                            'value'    => 'first',
                            'label'    => 'First Value',
                            'selected' => true,
                        ],
                        [
                            'value'    => 'second',
                            'label'    => 'Second Value',
                            'selected' => false,
                        ],
                    ],
                ],
            ],
        ]);

        ThemeOptionManager::add([
            'name'   => 'Advanced',
            'fields' => [
                [
                    'label' => 'Advanced Text',
                    'name'  => 'advanced_theme_option_text',
                    'type'  => Input::TEXT,
                ],
                [
                    'label' => 'Advanced Email',
                    'name'  => 'advanced_theme_option_email',
                    'type'  => Input::EMAIL,
                ],
                [
                    'label'   => 'Advanced Select',
                    'name'    => 'advanced_theme_option_select',
                    'type'    => Input::SELECT,
                    'options' => [
                        [
                            'value'    => 'first',
                            'label'    => 'First Value',
                            'selected' => false,
                        ],
                        [
                            'value'    => 'second',
                            'label'    => 'Second Value',
                            'selected' => false,
                        ],
                    ],
                ],
            ],
        ]);

        add_action('admin_enqueue_scripts', [$this, 'load_custom_wp_admin_style']);
    }

    public function registerAdminMenu()
    {
        $option = new Option;
        $option->register();
    }

    public function load_custom_wp_admin_style()
    {
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

    }

    public function registerAdminPostAction()
    {
        add_action('admin_enqueue_scripts', function () {
            wp_enqueue_media();
        });
        add_action('admin_post_nto_save', [$this, 'save']);
    }

    public function save()
    {

        $k = ThemeOptionManager::getPages()->search(function ($item) {
            return $item->name == Request::get('page');
        });
        if ($k === false) {
            throw new \Exception("Request invalid", 1);
        }

        $page = ThemeOptionManager::getPage(Request::get('page'));

        foreach ($page->fields as $field) {
            if (Request::has($field->name) && Request::get($field->name) != '') {
                update_option($field->name, Request::get($field->name), true);
            }
        }
        update_option(Manager::NTO_SAVED_SUCCESSED, 'should_flash', false);
        $redirect_url = ThemeOptionManager::getTabUrl(Request::get('page'));
        wp_redirect($redirect_url);
    }
}
