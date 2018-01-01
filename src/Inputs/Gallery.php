<?php

namespace NightFury\Option\Inputs;

use Illuminate\Support\Collection;
use NightFury\Option\Abstracts\Input;

class Gallery extends Input
{
    /**
     * {@inheritDoc}
     */
    public $type = Input::GALLERY;

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

    /**
     * List of items
     *
     * @var \Illuminate\Support\Collection
     */
    public $items;

    /**
     * @param \Illuminate\Support\Collection $items
     *
     * @return self
     */
    public function setItems(\Illuminate\Support\Collection $items)
    {
        $this->items = $items;

        return $this;
    }

    public function render()
    {
        $value = get_option($this->name, get_template_directory_uri() . '/vendor/nf/option/assets/images/img-default.png');
        if ($value === false) {
            $this->items = new Collection();
        } else {
            $this->items = new Collection(json_decode($value, true));
        }
        $html = <<<EOF
<div class="card nto-gallery" id="nto-image-{$this->name}">
    <input type="hidden" name="{$this->name}" value="" required>
    {$this->renderGallery()}
    <div class="card-body">
        <h4 class="card-title">{$this->label}</h4>
        <p class="card-text">{$this->description}</p>
        <a href="#" class="nto-gallery-upload-btn btn btn-primary" data-input="{$this->name}">Select File</a>
        <a href="#" class="nto-gallery-remove btn btn-secondary" data-input="{$this->name}">Remove all file</a>
    </div>
</div>

EOF;
        return $html;
    }

    private function renderGallery()
    {
        $default_img = get_template_directory_uri() . '/vendor/nf/option/assets/images/3x4.png';
        $html        = '<ul class="nto-items" data-img="' . $default_img . '">';
        foreach ($this->items as $item) {
            $html .= '<li class="nto-gallery-item"><img src="' . $default_img . '" style="background-image: url(\'' . $item['url'] . '\')" data-src="' . $item['url'] . '"></li>';
        }
        $html .= '</ul>';
        return $html;
    }

    public function getValue()
    {
        return $this->items->toJson();
    }
}
