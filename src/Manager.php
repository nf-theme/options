<?php

namespace NightFury\Option;

use Illuminate\Http\Request as OriginRequest;
use Illuminate\Support\Collection;
use NF\Facades\Log;
use NF\Facades\Request;
use NightFury\Option\Abstracts\Input;
use NightFury\Option\Abstracts\Page;
use NightFury\Option\Inputs\Email;
use NightFury\Option\Inputs\File;
use NightFury\Option\Inputs\Gallery;
use NightFury\Option\Inputs\Image;
use NightFury\Option\Inputs\Select;
use NightFury\Option\Inputs\Text;
use NightFury\Option\Inputs\Textarea;

class Manager
{
    const MENU_SLUG           = 'nf-theme-option';
    const NTO_SAVED_SUCCESSED = 'nto_saved_successed';

    public $pages;

    public function add($data)
    {
        $page = new Page();
        $page->setName($data['name']);
        $fields = new Collection();
        foreach ($data['fields'] as $data) {
            $field = $this->prase($data);
            if ($field->is(Input::GALLERY) && isset($data['meta']) && is_array($data['meta'])) {
                $field->enable_meta = true;
                foreach ($data['meta'] as $meta_field_data) {
                    $meta_field = $this->prase($meta_field_data);
                    $field->addMetaField($meta_field);
                }
            }
            $fields->push($field);
        }
        $page->setFields($fields);
        if ($this->pages == null) {
            $this->pages = new Collection([$page]);
        } else {
            $this->pages->push($page);
        }
    }

    private function prase($field)
    {
        switch ($field['type']) {
            case Input::TEXT:
                $input              = new Text();
                $input->label       = isset($field['label']) ? $field['label'] : $input->label;
                $input->name        = isset($field['name']) ? $field['name'] : $input->name;
                $input->description = isset($field['description']) ? $field['description'] : $input->description;
                $input->required    = isset($field['required']) ? $field['required'] : $input->required;
                break;
            case Input::TEXTAREA:
                $input              = new Textarea();
                $input->label       = isset($field['label']) ? $field['label'] : $input->label;
                $input->name        = isset($field['name']) ? $field['name'] : $input->name;
                $input->description = isset($field['description']) ? $field['description'] : $input->description;
                $input->required    = isset($field['required']) ? $field['required'] : $input->required;
                break;
            case Input::EMAIL:
                $input              = new Email();
                $input->label       = isset($field['label']) ? $field['label'] : $input->label;
                $input->name        = isset($field['name']) ? $field['name'] : $input->name;
                $input->description = isset($field['description']) ? $field['description'] : $input->description;
                $input->required    = isset($field['required']) ? $field['required'] : $input->required;
                break;
            case Input::SELECT:
                $input              = new Select();
                $input->label       = isset($field['label']) ? $field['label'] : $input->label;
                $input->name        = isset($field['name']) ? $field['name'] : $input->name;
                $input->description = isset($field['description']) ? $field['description'] : $input->description;
                $input->options     = isset($field['options']) ? $field['options'] : $input->options;
                $input->required    = isset($field['required']) ? $field['required'] : $input->required;
                break;
            case Input::IMAGE:
                $input              = new Image();
                $input->label       = isset($field['label']) ? $field['label'] : $input->label;
                $input->name        = isset($field['name']) ? $field['name'] : $input->name;
                $input->description = isset($field['description']) ? $field['description'] : $input->description;
                $input->required    = isset($field['required']) ? $field['required'] : $input->required;
                break;
            case Input::GALLERY:
                $input              = new Gallery();
                $input->label       = isset($field['label']) ? $field['label'] : $input->label;
                $input->name        = isset($field['name']) ? $field['name'] : $input->name;
                $input->description = isset($field['description']) ? $field['description'] : $input->description;
                $input->required    = isset($field['required']) ? $field['required'] : $input->required;
                break;
            case Input::FILE:
                $input              = new File();
                $input->label       = isset($field['label']) ? $field['label'] : $input->label;
                $input->name        = isset($field['name']) ? $field['name'] : $input->name;
                $input->description = isset($field['description']) ? $field['description'] : $input->description;
                $input->required    = isset($field['required']) ? $field['required'] : $input->required;
                break;
            default:
                throw new \Exception("Can not prase input field", 1);
                break;
        }
        return $input;
    }

    public function getTabUrl($name)
    {
        return get_admin_url() . 'admin.php?page=' . self::MENU_SLUG . '&tab=' . str_slug($name);
    }

    /**
     * Retrievie the list of pages
     *
     * @return \Illuminate\Support\Collection
     */
    public function getPages()
    {
        return $this->pages;
    }

    /**
     * Get page by slug
     *
     * @return array
     */

    public function getPage($slug)
    {
        if (!isset($slug)) {
            if ($this->getPages()->count() == 0) {
                throw new \Exception("Page not found", 1);
            }
            return $this->getPages()->first();
        }
        $k = $this->getPages()->search(function ($item) use ($slug) {
            return str_slug($item->name) == str_slug($slug);
        });
        if ($k === false) {
            throw new \Exception("Page not found", 1);
        }
        return $this->getPages()->get($k);
    }

    /**
     * Determine page by slug
     *
     * @return boolean
     */

    public function isPage($name)
    {
        if (Request::has('tab')) {
            return Request::get('tab') === str_slug($name);
        } else {
            return str_slug($this->getPages()->first()->name) === str_slug($name);
        }
    }

    /**
     * Save data from request
     *
     * @return void
     */
    public function save()
    {
        $k = $this->getPages()->search(function ($item) {
            return $item->name == Request::get('page');
        });
        if ($k === false) {
            throw new \Exception("Request invalid", 1);
        }

        $page = $this->getPage(Request::get('page'));

        foreach ($page->fields as $field) {
            switch ($field->type) {
                case Input::GALLERY:
                    if (Request::get($field->name) != '') {
                        $items = json_decode(stripslashes(Request::get($field->name)), true);
                        $field->setItems(new Collection($items));
                        $field->save();
                    }
                    break;
                case Input::FILE:
                    if(!empty($_FILES[$field->name])) {
                        $uploadedfile = $_FILES[$field->name];
                        $upload_overrides = array( 'test_form' => false );
                        $movefile = wp_handle_upload( $uploadedfile, $upload_overrides );

                        if ( $movefile && ! isset( $movefile['error'] ) ) {
                            $field->value = $movefile['url'];
                            $field->save();
                        } else {
                            Log::info($movefile['error']);
                        }
                    }
                    break; 
                default:
                    $field->value = Request::get($field->name);
                    $field->save();
                    break;
            }
        }
        update_option(Manager::NTO_SAVED_SUCCESSED, 'should_flash', false);
        $redirect_url = $this->getTabUrl(Request::get('page'));
        wp_redirect($redirect_url);
    }

    /**
     * Remove value of an option
     *
     * @return void
     */
    public function remove()
    {
        $k = $this->getPages()->search(function ($item) {
            return str_slug($item->name) == str_slug(Request::get('page'));
        });
        if ($k === false) {
            throw new \Exception("Request invalid", 1);
        }

        $page = $this->getPage(Request::get('page'));

        foreach ($page->fields as $field) {
            if ($field->name == Request::get('field')) {
                $field->remove();
            }
        }
        $redirect_url = $this->getTabUrl(Request::get('page'));
        wp_send_json(['success' => true, 'redirect_url' => $redirect_url]);
    }
}
