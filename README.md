# Shop Packages Maatwebsite/excel

[![GitHub Stars](https://img.shields.io/github/stars/IlyasKohistani/laravel-Inventory-management.svg)](https://github.com/IlyasKohistani/laravel-Inventory-management/stargazers) [![GitHub Issues](https://img.shields.io/github/issues/IlyasKohistani/laravel-Inventory-management.svg)](https://github.com/IlyasKohistani/laravel-Inventory-management/issues) [![Current Version](https://img.shields.io/badge/version-1.0.0-green.svg)](https://github.com/IlyasKohistani/laravel-Inventory-management)

A simple inventory management project built with Laravel and Maatwebsite/Excel package. It has a beautiful dashbaord with graphical data. A good example of using [Laravel Maatwebsite/excel package](https://laravel-excel.com/) imports, exports, validations and much more. You are 100% allowed to use this webpage for both personal and commercial use, but NOT to claim it as your own.

![Snapshot](https://github.com/IlyasKohistani/laravel-Inventory-management/blob/master/public/images/snapshot.png)

---

## Buy me a coffee

Whether you use this project, have learned something from it, or just like it, please consider supporting it by buying me a coffee, so I can dedicate more time on open-source projects like this :)

<a href="https://www.buymeacoffee.com/ilyaskohistani" target="_blank"><img src="https://www.buymeacoffee.com/assets/img/custom_images/orange_img.png" alt="Buy Me A Coffee" style="height: auto !important;width: auto !important;" ></a>

---

## Features

-   Authentication
-   4 different static roles Owner, Viewer, Editor, Approval
-   4 different users with roles Owner, Viewer, Editor, Approval
-   Import from Excel file with heading and custom validation to database
-   Export templates based on database fields with title and heading
-   Manage products
-   Manage products in inventory
-   Request for products from inventory
-   Grant requested products from inventory
-   See latest transactions

---

## Setup

-   After you clone this repo to your desktop, go to its root directory using `cd laravel-Inventory-management` command on your cmd or terminal.
-   run `composer install` on your cmd or terminal to install dependencies.
-   Copy .env.example file to .env on the root folder using `copy .env.example .env` if using command prompt Windows or `cp .env.example .env` if using terminal, Ubuntu.
-   Open your .env file and change the database name (DB_DATABASE) to whatever you have, Username (DB_USERNAME), and Password (DB_PASSWORD) fields correspond to your configuration.
-   Run `php artisan key:generate` to generate new key.
-   Run `php artisan migrate:fresh --seed` to publishe all our schema to the database and seed your database.
-   Run `php artisan serve` to start project.
-   Open http://localhost:8000/ in your browser.

---

## Users
You can use below users to login in the system and see different roles. Password is "12345678" for all of below users. You can manage all users, roles, categories, products data from seeder files under `database/seeders` directory and then run `php artisan db:seed` it will update your new data but you lose all previous data.

- owner@example.com
- viewer@example.com
- approval@example.com
- editor@example.com

## Usage

After you are done with the setup open http://localhost:8000/ in your browser. You can find import and export option at top of the page in the navigation bar. You can find import and export codes in the app directory inside import and export directories. You can play with it and change anything you want. Enjoy!

---

## License

> You can check out the full license [here](https://github.com/IlyasKohistani/laravel-Inventory-management/blob/master/LICENSE)
> This project is licensed under the terms of the **MIT** license.