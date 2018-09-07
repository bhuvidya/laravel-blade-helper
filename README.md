# Laravel Blade Helper

[![License](https://poser.pugx.org/bhuvidya/laravel-blade-helper/license?format=flat-square)](https://packagist.org/packages/bhuvidya/laravel-blade-helper)
[![Total Downloads](https://poser.pugx.org/bhuvidya/laravel-blade-helper/downloads?format=flat-square)](https://packagist.org/packages/bhuvidya/laravel-blade-helper)
[![Latest Stable Version](https://poser.pugx.org/bhuvidya/laravel-blade-helper/v/stable?format=flat-square)](https://packagist.org/packages/bhuvidya/laravel-blade-helper)
[![Latest Unstable Version](https://poser.pugx.org/bhuvidya/laravel-blade-helper/v/unstable?format=flat-square)](https://packagist.org/packages/bhuvidya/laravel-blade-helper)


A Laravel 5 package to abstract the "create Blade directive" process

**Please note that this package was tested on Laravel 5.6 - I cannot guarantee it will work on earlier versions. Sorry.**

First of all, BIG KUDOS to Liam (https://github.com/ImLiam) who proposed this as a pull request on the Laravel Framework (see here: https://github.com/laravel/framework/pull/24923). I really liked the concept so I put his code into a 
package for others to use if they wanna.

Basically this helper provides a neat level of abstraction to the "define a custom Blade directive" process
TODO...so you don't have to parse the raw expression passed to directives, you can use a well-defined parameter list.

In the pull request there was some discussion around whether directives should be used just for code structure,
and not presentation. Personally I like custom directives even for "presentation" or "convenience" uses because:

1 It makes the template files cleaner, and easier to read
1 Having the code in one place makes it easier to change



## Installation

Add `bhuvidya/laravel-blade-helper` to your app:

    $ composer require "bhuvidya/laravel-blade-helper"
    

**If you're using Laravel 5.5 or higher, you don't have to edit `app/config/app.php`.**

Otherwise, edit `app/config/app.php` and add the service provider:

    'providers' => [
        'BhuVidya\BladeHelper\BladeHelperServiceProvider',
    ]



## Usage


TODO
