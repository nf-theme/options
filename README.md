# The option plugin
 > It's an extension for our theme https://github.com/hieu-pv/nf-theme 
 
- [Installation](#installation)
- [Configuration](#configuration)
- [Option Scheme](#scheme)
- [Translation](#translation)

 
<a name="installation"></a>
## Installation

### Step 1: Install Through Composer
```
composer require nf/option
```

<a name="configuration"></a>

### Step 2: Add the Service Provider

Open `config/app.php` and register the required service provider.

```php
  'providers'  => [
        // .... Others providers 
        \NightFury\Option\ThemeOptionServiceProvider::class,
    ],
```

<a name="scheme"></a>

### Step 3: Register your option scheme

> {tip} You can add your option scheme to `functions.php`

> For each scheme you added it create new section in Theme Configuration page.

All supported type can be found here [https://github.com/hieu-pv/nf-theme-option/tree/master/src/Inputs](https://github.com/hieu-pv/nf-theme-option/tree/master/src/Inputs)

```php

use NightFury\Option\Abstracts\Input;
use NightFury\Option\Facades\ThemeOptionManager;

ThemeOptionManager::add([
    'name'   => 'General',
    'fields' => [
        [
            'label'    => 'Text',
            'name'     => 'theme_option_text', // the key of option
            'type'     => Input::TEXT,
            'required' => true,
        ],
        [
            'label'    => 'Textarea',
            'name'     => 'theme_option_textarea',
            'type'     => Input::TEXTAREA,
            'required' => true,
        ],
        [
            'label'    => 'Email',
            'name'     => 'theme_option_email',
            'type'     => Input::EMAIL,
            'required' => true,
        ],
        [
            'label'       => 'Gallery',
            'name'        => 'theme_option_gallery',
            'type'        => Input::GALLERY,
            'description' => 'We can select multi file. Drag and Drop to re-order content'
        ],
        [
            'label'       => 'Gallery With Meta Field',
            'name'        => 'theme_option_gallery_with_meta',
            'type'        => Input::GALLERY,
            'description' => 'Gallery with meta field, for now we support text and textarea on meta field.',
            'meta'        => [
                [
                    'label' => 'Text',
                    'name'  => 'meta_text',
                    'type'  => Input::TEXT,
                ],
                [
                    'label' => 'Textarea',
                    'name'  => 'meta_textarea',
                    'type'  => Input::TEXTAREA,
                ],
            ],
        ], [
            'label'       => 'Image',
            'name'        => 'theme_option_image',
            'type'        => Input::IMAGE,
            'description' => 'Choose your image by clicking the button bellow',
        ],
        [
            'label'   => 'Select',
            'name'    => 'theme_option_select',
            'type'    => Input::SELECT,
            'options' => [
                [
                    'value'    => 'first',
                    'label'    => 'First Value',
                    'selected' => true,
                ],
                [
                    'value'    => 'second',
                    'label'    => 'Second Value',
                    'selected' => false,
                ],
            ],
        ],
    ],
]);


```

### Step 4: Get your option value

we can get the value of option as usually via `get_option` function

> {tip} for gallery value is a decoded string

```php
get_option('{option_name}');

```

<a name="translation"></a>

## Translation

if you want to customize configuration page

```
php command nfoption:publish
```

It will create new file `resources/views/vendor/option/admin.blade.php` in your theme then you can update content of the configuration page