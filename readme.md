# Laravel View JSON
Print view data in the browser. For debugging purpose.

## Why?
When working on large projects, it sometimes is hard to know what data is exactly passed to the view. With this package you can output all data as JSON.

## Getting started
Require this package with composer. It is recommended to only require the package for development.
```
composer require frewillems/laravel-view-json --dev
```

Laravel 5.5 uses Package auto-discovery so doesn't require you to manually add the ServiceProvider. 

This package will only be enabled when `APP_DEBUG` is `true`.

### Older Laravel versions
If you don't/can't use auto-discovery, add the ServiceProvider to the providers array in `config/app.php`.
```
FreWillems\ViewJson\ViewJsonServiceProvider::class
```

## Usage
Add `?view=json` to any url and you will get all the view data in JSON format.