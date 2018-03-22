<?php

namespace NightFury\Option\Inputs;

use NightFury\Option\Abstracts\Input;

class File extends Input
{
    /**
     * {@inheritDoc}
     */
    public $type = Input::FILE;

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
        $value       = get_option($this->name);
        if(!empty($value)) {
            $hidden = '';
        } else {
            $hidden = 'hidden';
        }
        $html        = <<<EOF
<div class="card nto-image" id="nto-image-{$this->name}">
    <div class="card-body">
        <h4 class="card-title">{$this->label}</h4>
        <div class="alert alert-success {$hidden}">
            <strong>You have successfully installed it before!</strong>
            <p>{$value}</p>
        </div>
        <p class="card-text">{$this->description}</p>
        <input type="file" class="input-value btn btn-primary" name="{$this->name}">
        <a href="#" class="nto-file-remove btn btn-secondary" data-input="{$this->name}">Delete file</a>
    </div>
</div>

EOF;
        return $html;
    }
}
