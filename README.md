
## Installation and Setup

Clone the repository from GitHub:

```bash
git clone https://github.com/kishorpun67/chat-application.git
```

 Install Dependencies
```bash
composer install
npm install
```
Run Migrations the Database
```bash
php artisan migrate
```

Start the WebSocket Server
```bash
php artisan reverb:start
```

Start the queue
```bash
php artisan queue:work
```
Start the Application
```bash
php artisan serve
```

The application will run on `http://127.0.0.1:8000`.


## License

This project is licensed under the [MIT License](https://opensource.org/licenses/MIT).


