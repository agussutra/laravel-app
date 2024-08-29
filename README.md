# Laravel Test Omni Hotelier
 
1. setup laravel project with following requirements:
- Has basic authentication to access the Dashboard
- Has authentication for api
2. Create CRUD interface also acessible via api for user data followed by Unit test
3. Log every http request sent to the app
4. Send email for email confirmation after new user created. (Implement queue)
5. Create an api endpoint for mass user creation in single call. The endpoint must be capable to handle upto 1000 email & password in request body.


## Prerequisites
 make you sure install [Node.js](https://nodejs.org/) and [npm](https://www.npmjs.com/)

 ```bash
    node -v
    composer -v
    php -v
```

### Laravel Run
```bash
    composer i 
    php artisan serve
    php artisan migrate --seed
```
### Inertia React Run
 ```bash
    npm i && npm run dev
```

### Library
React Hot Toast
