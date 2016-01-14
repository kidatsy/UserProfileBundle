# UserProfileBundle

Installation
============

Step 1: Download the Bundle
---------------------------

Open a command console, enter your project directory and execute the
following command to download the latest stable version of this bundle:

```bash
$ composer require crisistextline/user-profile-bundle
```

This command requires you to have Composer installed globally, as explained
in the [installation chapter](https://getcomposer.org/doc/00-intro.md)
of the Composer documentation.

Step 2: Enable the Bundle
-------------------------

Then, enable the bundle by adding it to the list of registered bundles
in the `app/AppKernel.php` file of your project:

```php
<?php
// app/AppKernel.php

// ...
class AppKernel extends Kernel
{
    public function registerBundles()
    {
        $bundles = array(
            // ...

            new CrisisTextLine\UserProfileBundle\CrisisTextLineUserProfileBundle(),
        );

        // ...
    }

    // ...
}
```

Step 3: Add Routing
-------------------

Add a route to `app/config/routing.yml` with the following:

```yml
crisis_text_line_user_profile:
    resource: "@CrisisTextLineUserProfileBundle/Controller/"
    type:     annotation
    prefix:   /
```

Step 4: Add the UserProfileUserTrait to User entity
---------------------------------------------------

In your User class, add the following:

```php
<?php
// <YourBundle>/User.php

// ...
use FOS\UserBundle\Model\User as BaseUser;
use CrisisTextLine\UserProfileBundle\Entity\UserProfileUserTrait;

// ...
class User extends BaseUser
{
    use UserProfileUserTrait;

    // ...
}
```

Step 5: Override the templates
------------------------------

Override the templates by putting stuff in:

- `app/Resources/CrisisTextLineUserProfileBundle/views/UserProfile`
- `app/Resources/CrisisTextLineUserProfileBundle/views/UserProfileField`
- `app/Resources/CrisisTextLineUserProfileBundle/views/UserProfileValue`

Step 6: Add the JS to your main template
----------------------------------------

Add the following line(s) to the `<head>` of your app's main template:

```html

```
