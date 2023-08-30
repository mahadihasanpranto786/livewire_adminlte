# Livewire Installations and AdminLTE Mastering

Last updated: August 9th, 2023

## Table of Contents

- [Installations](#installations)
  - [Step One - Livewire Install](#step-one---livewire-install)
  - [Step Two - Livewire AdminLTE Mastering](#step-two---livewire-adminlte-mastering)
  - [Step Three - Make Livewire Components and Load the View](#step-three---make-livewire-components-and-load-the-view)
  - [Step Four - Disabling Browser Reload with Turbolinks](#step-four---disabling-browser-reload-with-turbolinks)

## Installations

### Step One - Livewire Install

To install Livewire, follow these steps:

```shell
composer require livewire/livewire
php artisan livewire:publish --config
php artisan livewire:publish --assets
```
After publishing the config and assets, if you haven't configured the path in `config/livewire.php`:

```php
// Change this
'asset_url' => null

// To this
'asset_url' => env('APP_URL')

// Change this
'app_url' => null

// To this
'app_url' => env('APP_URL')
```
## Step Two - Livewire AdminLTE Mastering

To integrate AdminLTE with Livewire, follow these steps:

1. Install AdminLTE using Composer:

```shell
composer require "almasaeed2010/adminlte=~3.2"
```

## After Installation

After successfully installing Livewire and AdminLTE, proceed with the following steps to integrate AdminLTE into your project:

1. **Copy Assets**: Copy all the required plugins, images, and CSS files from the AdminLTE package and place them into your project's main custom directory.

2. **Customize Views**: Customize the different sections of the `index.html` template, including Nav-Header, Side-bar, Main-Section, and Footer-Section, to match the design and requirements of your project.

3. **Include in Master Layout**: Incorporate the customized sections from the `index.html` template into your project's `master_layout.blade.php` file. This master layout will act as the foundational structure for your Livewire components and views.

4. **Link Master Layout**: In the `config/livewire` configuration file, update the `'layout'` option. Change it from `'layouts.app'` to `'backend.master_layout'` to establish the connection with your customized master layout.

By following these steps, you will seamlessly integrate AdminLTE with Livewire, creating a cohesive and visually appealing user interface for your application.

## Step Three - Make Livewire Components and Load the View into `backend/DashboardController.php`

To create Livewire components and load views into your project, follow these steps:

1. **Generate Livewire Component**: Generate a Livewire component using the following Artisan command:

```shell
php artisan make:livewire DashboardComponent
 ```
2.This command generates two files:

    livewire/DashboardComponent.php
    livewire/dashboard-component.blade.php
```
 php artisan make:controller DashboardController -r
```
 ##### 1. Create the View: Also, create a view named `backend/dashboard.blade.php` that corresponds to the route associated with your DashboardController.
 ##### 2. Link Components and Views: In your routes file (web.php), link the Livewire components and the corresponding views. Also, set up the routes and routes names as needed.
 ##### 3. Test the Components: You can now test your Livewire components by navigating to the associated route in your browser. Verify that the components are rendering as expected and functioning correctly.

 ### Step Four: Disabling Browser Reload with [Turbolinks](https://github.com/turbolinks/turbolinks)

To disable browser reload and integrate Turbolinks with your Livewire project, follow these steps:

1. **Install Turbolinks Package**:
   - Use the following npm commands to install Turbolinks and build your assets:

```shell
npm install --save turbolinks
npm run dev
```
   1. Add Turbolinks Script:
        Add the following code to `resources/js/app.js`:

```
import Turbolinks from "turbolinks";
Turbolinks.start();
or

const Turbolinks = require("turbolinks")
Turbolinks.start()
```
```
php artisan optimize:clear
```
