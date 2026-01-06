# Home Organisation-Tool
Its a website that combines a task system with the possibility to track your household items with PHP for the backend and CSS & HTML for the frontend. 
It also has implemented own written PHP framework for my own education.

## Technologies

- PHP
- HTML
- CSS
- SQLite
- Composer
- PHP-Unit

## Features

What you can do with it:
- functional register, login and logout
- set task timers for all kinds of tasks and delete them if completed
- completed tasks are shown in the archive

- also, the possibility to create a bunch of rooms with descriptions so the tasks can be combined with the rooms

- Items can be registered and must be combined with the rooms
- as an example the sponge is stored in the kitchen, so I connect it with the kitchen in this tool

 - for your own rules, you have an FAQ to fill out or a preset one on the homepage

 - your own account details can be shown or changed in the account settings

## Current Status

The project is still in progress.
-> now I updated the SQL-Requests with my OrmService

## Running the Project

1. clone the repository
2. install dependencies (composer)
4. connect with SQLite
5. run the application
-> php -S localhost:8000 -t public
