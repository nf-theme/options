<?php

namespace NightFury\Option\Inputs;

use NightFury\Option\Abstracts\Input;

class Image extends Input
{
    /**
     * {@inheritDoc}
     */
    public $type = Input::IMAGE;

    /**
     * {@inheritDoc}
     */
    public $label = '';

    /**
     * {@inheritDoc}
     */
    public $name = '';

    /**
     * {@inheritDoc}
     */
    public $description = '';

    /**
     * {@inheritDoc}
     */
    public $required = false;

    public function render()
    {
        if ($this->app_config['is_plugin'] === true) {
            $default_value = wp_slash(plugin_dir_url(dirname(dirname(__FILE__))) . 'assets/images/img-default.png');
        } else {
            $default_value = get_template_directory_uri() . '/vendor/nf/option/assets/images/img-default.png';
        }
        $value       = get_option($this->name, $default_value);
        $default_img = get_template_directory_uri() . '/vendor/nf/option/assets/images/3x4.png';
        $html        = <<<EOF
<div class="card nto-image" id="nto-image-{$this->name}">
    <input type="hidden" class="input-value" name="{$this->name}" value="{$value}" required>
    <img class="card-img-top" src="{$default_img}" style="background-image: url('{$value}')" data-src="{$value}" alt="{$this->name}">
    <div class="card-body">
        <h4 class="card-title">{$this->label}</h4>
        <p class="card-text">{$this->description}</p>
        <a href="#" class="nto-image-upload-btn btn btn-primary" data-input="{$this->name}">Select File</a>
        <a href="#" class="nto-image-remove btn btn-secondary" data-input="{$this->name}">Delete file</a>
    </div>
</div>

EOF;
        return $html;
    }
}
