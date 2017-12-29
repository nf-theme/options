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
        $value = get_option($this->name, '');
        $html  = <<<EOF
<div class="form-group {$this->name}">
    <label>{$this->label}</label>
    <input type="text" name="{$this->name}" value="{$value}">
    <button class="msc-upload-btn button btn btn-pirmary">Choose Image</button>
</div>
EOF;
        return $html;
    }
}
