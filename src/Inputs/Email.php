<?php

namespace NightFury\Option\Inputs;

use NightFury\Option\Abstracts\Input;

class Email extends Input
{
    /**
     * {@inheritDoc}
     */
    public $type = Input::EMAIL;

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
    <input type="email" class="form-control input-value" name="{$this->name}" value="{$value}">
</div>
EOF;
        return $html;
    }

    public function renderMetaField()
    {
        $html = <<<EOF
<div class="form-group {$this->name}">
    <label>{$this->label}</label>
    <input type="email" class="form-control" name="{$this->name}">
</div>
EOF;
        return $html;
    }
}
