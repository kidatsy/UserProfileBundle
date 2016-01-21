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

Step 4: Tell the bundle how to resolve the User Entity
----------------------------------------------------

Add the following to `app/config/config.yml`, with the specifics of your own User Entity class:

```yml
doctrine:
    # ...
    orm:
        # ...
        resolve_target_entities:
            CrisisTextLine\UserProfileBundle\Model\UserProfileUserInterface: <YourBundle>\Entity\<YourUserEntity>
```

Step 5: Add User Role information to config.yml
-----------------------------------------------

Add information about any specific roles you would like the bundle to access for access control to Sections and Fields by adding the roles and human-friendly strings to `app/config/config.yml` like so:

```yml
crisis_text_line_user_profile:
    roles_names:
        - { role: "ROLE_USER", name: "User" }
        - { role: "ROLE_SUPER_ADMIN", name: "Super Admin" }
        # ...
```

Step 6: Add UserProfileUserTrait and UserProfileUserInterface to your User entity
---------------------------------------------------

In your User class, add the following:

```php
<?php
// <YourBundle>/User.php

// ...
use FOS\UserBundle\Model\User as BaseUser;
use CrisisTextLine\UserProfileBundle\Entity\UserProfileUserTrait;
use CrisisTextLine\UserProfileBundle\Model\UserProfileUserInterface;

// ...
class User extends BaseUser implements UserProfileUserInterface
{
    use UserProfileUserTrait;

    // ...
}
```

Step 7: Run a Migration (if need be)
------------------------------------

If you're using the Doctrine Migrations bundle, make a new migration via `php app/console doctrine:migrations:diff` and run it. Otherwise, update your DB accordingly.

Step 8: Override the templates
------------------------------

If you'd like to override the base Twig template to fit into your own front-end environment, create a new `app/Resources/CrisisTextLineUserProfileBundle/views/base.html.twig` with the following:

```twig
{% extends <Your Base Twig Template> %}

{% block userprofiles %}
{% endblock %}
```

You can override specific templates for each entity by putting replacements into the following:

- `app/Resources/CrisisTextLineUserProfileBundle/views/UserProfile`
- `app/Resources/CrisisTextLineUserProfileBundle/views/UserProfileField`

Step 9: Add the JS to your main template
----------------------------------------

Add the following line(s) to the `<head>` of your app's main template:

```html

```
