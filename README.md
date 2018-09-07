# Laravel Blade Helper

[![License](https://poser.pugx.org/bhuvidya/laravel-blade-helper/license?format=flat-square)](https://packagist.org/packages/bhuvidya/laravel-blade-helper)
[![Total Downloads](https://poser.pugx.org/bhuvidya/laravel-blade-helper/downloads?format=flat-square)](https://packagist.org/packages/bhuvidya/laravel-blade-helper)
[![Latest Stable Version](https://poser.pugx.org/bhuvidya/laravel-blade-helper/v/stable?format=flat-square)](https://packagist.org/packages/bhuvidya/laravel-blade-helper)
[![Latest Unstable Version](https://poser.pugx.org/bhuvidya/laravel-blade-helper/v/unstable?format=flat-square)](https://packagist.org/packages/bhuvidya/laravel-blade-helper)


A Laravel 5 package to ease the creation of Blade directives.

**Please note that this package was tested on Laravel 5.6 - I cannot guarantee it will work on earlier versions. Sorry.**

**BIG KUDOS** to Liam (https://github.com/ImLiam) who proposed this as a pull request on the Laravel Framework (https://github.com/laravel/framework/pull/24923). I really liked the concept so I put his code into a 
package for others to use if they wanna. This README draws on his explanations in the pull request.


## Installation

Add `bhuvidya/laravel-blade-helper` to your app:

    $ composer require "bhuvidya/laravel-blade-helper"
    

**If you're using Laravel 5.5 or higher, you don't have to edit `app/config/app.php`.**

Otherwise, edit `app/config/app.php` and add the service provider:

    'providers' => [
        'BhuVidya\BladeHelper\BladeHelperServiceProvider',
    ]


### Configuration

The package comes with its own configuration file, which you can install and tweak in your application:

```
artisan vendor:publish --provider='BhuVidya\BladeHelper\BladeHelperServiceProvider' --tag=config
```

This will install the config file to your app's config directory. It's contents are:

```
return [
    /*
    |--------------------------------------------------------------------------
    | Service instance "name"
    |--------------------------------------------------------------------------
    */
    'instance' => 'bhuvidya.blade_helper',

    /*
    |--------------------------------------------------------------------------
    | You can elect to register an alias for the facade automatically, and give
    | it your own custom class name. Set to false to not register.
    |--------------------------------------------------------------------------
    */
    'facade' => 'BladeHelper',
];
```

As you can see, it's possible to customise the service container instance name, and (probably a bit more useful),
get the facade to be loaded automatically, and with your own class name if so desired.


## Usage

Basically this helper provides a neat level of abstraction to the "define a custom Blade directive" process. It's 
benfit is in allowing the connected function (or closure) to have a well-defined parameter list, without
having to do the cruft coding around parsing the raw expression string passed in from Laravel core. This allows you to
quickly turn an external function into a Blade directive.

For example, to turn the php function `join` into a directive:

```
// Define the helper directive
BladeHelper::helper('join');

// Use it in a view
@join('|', ['Hello', 'world'])

// Get the compiled result
<?php echo join('|', ['Hello', 'world']); ?>

// See what's echoed
"Hello|world"
```

Admittedly a contrived example, but it gives you the idea.

The second argument can also take a callback. The advantage of a callback here over the Blade::directive(...) method is that the closure can have specific parameters defined instead of just the raw expression passed through. This has several good things that solve a [previous idea](https://github.com/laravel/ideas/issues/1104) Liam brought up:

* Type hint the arguments for the callback
* Manipulate and use the individual arguments when the directive is called, instead of the raw expression as a string
* Define a directive without having to only use it as a proxy to a helper function or class in another part of the application

```
// Define the helper directive
BladeHelper::helper('example', function($a, $b, $c = 'give', $d = 'you') {
    return "$a $b $c $d up";
});

// Use it in a view
@example('Never', 'gonna')

// Get the compiled result
<?php echo \Illuminate\Support\Facades\Blade::getHelper('example', 'Never', 'gonna'); ?>

// See what's echoed
"Never gonna give you up"
```

By default, all of the helper directives will echo out their contents to the view when used. This can be disabled by passing false as the third argument.

```
// Define the helper directive
BladeHelper::helper('log', null, false);

// Use it in a view
@log('View loaded...')

// Get the compiled result
<?php log('View loaded...'); ?>

// Nothing is echoed
```

In the [pull request](https://github.com/laravel/framework/pull/24923) there was some discussion around whether directives should be used just for code structure,
and not presentation. Personally I like custom directives even for "presentation" or "convenience" usage because:

1. It makes template files cleaner, and easier to read
1. Having the code in one place makes it easier to change in the future


As a last example, here is a wrapper for the logic around a FontAwesome 4 icon. There's a bit of boilerplate around it you probably don't want to remember to write every time, and you wouldn't want to `@include` it every time. While it could be a regular function and operate just the same, this is one of those things you'd probably want that bit of syntactic sugar around because of how often it can be used - nor would there be any advantage of it being a regular function or helper as you'd never get any use of it outside views. Also, if you ever decided to tweak the html of the `<i>` element (maybe adding a new `aria` attribute), then you only have to do it in one place.

```
BladeHelper::helper('fa', function(string $iconName, string $text = null, $classes = '') {
    if (is_array($classes)) {
        $classes = join(' ', $classes);
    }

    $text = $text ?? $iconName;

    return "<i class='fa fa-{$iconName} {$classes}' aria-hidden='true' title='{$text}'></i><span class='sr-only'>{$text}</span>";
});
```

