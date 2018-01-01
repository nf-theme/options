<?php

namespace NightFury\Option\Inputs;

use NightFury\Option\Abstracts\Input;

class Text extends Input
{
    /**
     * {@inheritDoc}
     */
    public $type = Input::TEXT;

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
    <input type="text" class="form-control" name="{$this->name}" value="{$value}" required>
</div>
EOF;
        } else {
            $html = <<<EOF
<div class="form-group {$this->name}">
    <label>{$this->label}</label>
    <input type="text" class="form-control" name="{$this->name}" value="{$value}">
</div>
EOF;
        }
        return $html;
    }
}
