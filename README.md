# The simple flash message

This is the simplest and easiest package to use in a Laravel application.

## Example

It can be called with the fewest number of codes.

```php
class UserController
{
    public function store()
    {
        // …

        flash('User successfully registered!');

        return redirect()->back();
    }
}
```

What Laraflash has is just a level.<br>
It does not depend on the View implementation and can be handled freely.<br>
This example is for bootstrap.

```blade
@if (flash()->hasMessage())
  <div class="alert alert-{{ flash()->getLevel() }}">
    {{ flash()->getMessage() }}
  </div>
@endif
```

## Installation
You can install with this command.
```bash
composer require tokiya/laraflash
```

## Usage

If nothing is specified, the default is "success.

```php
class UserController
{
    public function store()
    {
        // …

        flash('User successfully registered!');

        return redirect()->back();
    }
}
```
Of course, it can be explicitly stated.
```php
class UserController
{
    public function store()
    {
        // …

        flash('User successfully registered!')->success();

        return redirect()->back();
    }
}
```
You may want to isolate the message. We can make this happen.

```php
class UserController
{
    public function store()
    {
        // …

        $flash = flash();
        if (...) {
            $flash->success('Pattern 1 message.');
        } else {
            $flash->success('Pattern 2 message.');
        }

        return redirect()->back();
    }
}
```

There are four levels.
- success
- warning
- error
- info

```php
flash('User successfully registered!')->success();
flash('Unregistered information is available.')->warning();
flash('User registration failed.')->error();
flash('A notice exists.')->info();
```

However, the level of freedom frees you from restrictions.<br>
However, it is not suitable for development by multiple people.<br>
This is because of the possibility of disorder.
```php
flash('Please check now.!')->urgent(); // By John

flash('Please check now.!')->emergency(); // By Mary
```

If you want to use a customized level while still maintaining order, change the default level.
```php
flash()->customizeErrorKey('danger')->error();
```
or
```php
class MyFlash extends Flash
{
    protected array $level_keys = [
        'success' => 'success',
        'warning' => 'warning',
        'error'   => 'danger',
        'info'    => 'info',
    ];
}
```

## Want to make it simpler?
There is a better way for you lazy people.<br>
Because it's a hassle to set up a message each time, isn't it?<br>
Once a default message is set, it is never needed again.<br>
However, I am sorry. It needs to be explicit at all levels.<br>
```php
flash()->setDefaultSuccessMessage('Successfully saved!')
    ->setDefaultErrorMessage('Failed to save.');
```

```php
flash()->success(); // Successfully saved!
flash()->error(); //Failed to save. 
```

## License
The MIT License (MIT).
