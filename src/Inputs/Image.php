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
        $value = get_option($this->name, get_template_directory_uri() . '/vendor/nf/option/assets/images/img-default.png');
        $html  = <<<EOF
<div class="card nto-image" id="nto-image-{$this->name}" style="width: 20rem;">
    <input type="hidden" name="{$this->name}" value="{$value}" required>
    <img class="card-img-top" src="{$value}" alt="{$this->name}">
    <div class="card-body">
        <h4 class="card-title">{$this->label}</h4>
        <p class="card-text">{$this->description}</p>
        <a href="#" class="nto-image-upload-btn btn btn-primary" data-input="{$this->name}">Select File</a>
    </div>
</div>

EOF;
        return $html;
    }
}
