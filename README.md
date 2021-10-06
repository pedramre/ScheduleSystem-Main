
## PHP-Laravel Technical Test

### Introduction

Create a simple schedule system for workers, that will be based on one of the PHP frameworks (slim/laravel/Yii).
The system will be built with a headless approach when the client-side can be based on Angular/React/Vue.
The system will have a Job, Schedule, User, Role entities.
There will be two roles admin/worker, the worker can send a schedule request, admin can approve or decline it.
The mainboard will display the current week with a list of jobs and schedules

### Advantage

Also it will be a big advantage, if you use the socket.io to push the request from worker dashboard to admin dashboard on real time
**Note:** This test does **NOT** assess your Front-end/UI skills. Wherever UI is needed, simple HTML elements without styles suffice. Try to make the simplest UI that works.

### Sample Image
like on this image: https://ps.w.org/shiftcontroller/assets/screenshot-1.png?rev=1986582

### Help For Install

##### Run Laravel and Vue Js 
- `composer update`
- `npm install`

you should run `php artisam migrate --seed` for sample users, roles, permissions  

- for run on local use these command
    - `php artisan serve`
    - `npm run watch`

open panel on localhost:8000 in your browser

admin login address: /admin/login

## Run Socket Serve
- first, install `ioredis` and `socket.io` for node js server
- then run this command
    - `node socket.js`

## Sample Accounts
- Admin
    - email: `admin@mail.com` and password: `123456`
- Worker
    - email: `worker@mail.com` and password: `123456`    
