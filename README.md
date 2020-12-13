# instantpaste

This webapp provides a hastle free way to share text and files on your network. No buttons, QR-codes, logins etc.

But be warned the data is transferred to a server and everyone in your network can access and manipulate this data. 

DO NOT SHARE SENSITIVE DATA especially in public networks

# Setup

1. Just like a normal laravel webapp
2. php artisan storage:link
3. php artisan websockets:serve
4. php artisan queue:work
5. npm run prod
