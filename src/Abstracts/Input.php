<?php

namespace NightFury\Option\Abstracts;

use NightFury\Option\Constracts\InputInterface;

abstract class Input implements InputInterface
{
    const TEXT   = 'text';
    const EMAIL  = 'email';
    const SELECT = 'select';
    const IMAGE  = 'image';
    /**
     * Input type
     *
     * @var string
     */
    public $type;

    /**
     * Input label
     *
     * @var string
     */
    public $label = '';

    /**
     * Input name
     *
     * @var string
     */
    public $name = '';

    /**
     * Input description
     *
     * @var string
     */
    public $description = '';

    /**
     * Determine that value is required or not
     *
     * @var boolean
     */
    public $required = false;

}
