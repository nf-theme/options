<?php

namespace NightFury\Option\Inputs;

use NightFury\Option\Abstracts\Input;

class Textarea extends Input
{
    /**
     * {@inheritDoc}
     */
    public $type = Input::TEXTAREA;

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
        if ($this->required) {
            $html = <<<EOF
<div class="form-group {$this->name}">
    <label>{$this->label}</label>
    <textarea class="form-control" name="{$this->name}">{$value}</textarea>
</div>
EOF;
        } else {
            $html = <<<EOF
<div class="form-group {$this->name}">
    <label>{$this->label}</label>
    <input class="form-control" name="{$this->name}">{$value}</textarea>
</div>
EOF;
        }
        return $html;
    }
}
