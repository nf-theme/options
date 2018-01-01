# The option plugin
 > It's an extension for our theme https://github.com/hieu-pv/nf-theme 
 
#### Installation
##### Step 1: Install Through Composer
```
composer require nf/option
```
##### Step 2: Add the Service Provider
Open `config/app.php` and register the required service provider.

```php
  'providers'  => [
        // .... Others providers 
        \NightFury\Option\ThemeOptionServiceProvider::class,
    ],
```

##### Step 3: Register your option scheme

> {tip} You can add your option scheme to `functions.php`

> {tip} For each scheme you added it create new section in Theme Configuration page.


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
            'name'     => 'theme_option_text',
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
            'description' => 'Some quick example text to build on the card title and make up the bulk of the card\'s content.',
        ], [
            'label'       => 'Image',
            'name'        => 'theme_option_image',
            'type'        => Input::IMAGE,
            'description' => 'Some quick example text to build on the card title and make up the bulk of the card\'s content.',
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

##### Step 4: Get your option value

we can get the value of option as usually via `get_option` function

> {tip} for gallery value is a decoded string

```php
get_option('{option_name}');

```