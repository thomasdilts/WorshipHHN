# WorshipHHN
A worship service planer and organizer

Eventually here will include instructions for a "composer" installation. But for now only a zip file installation is explained.

This software is designed to work on an apache, maria database and php environment.  A good such environment is XAMPP. see https://www.apachefriends.org/index.html. Perl however is not needed but doesn't harm anything.

1. Download the latest version zip file found at  https://github.com/thomasdilts/WorshipHHN/releases
2. Install all the files found in the zip file onto your server.
3. Make sure your server has all the PHP modules you need by looking at the requirements.php page. Here is how mine looks http://worshiphhn.org/whhn/requirements.php
4. Create a database and user. See below for how to setup WorshipHHN for your database.
5. Install the Example.sql or the Empty.sql onto your database to create all the tables and a startup of data for the tables. You might want to try Example.sql first and then later install Empty.sql to start with an empty database.
6. Your login will be username=Calum, password=1234AAaa  Of course you want to change these as soon as you log in.

Files you must change:
_protected/config/db.php
You must enter your database settings.
```php
<?php

return [
    'class' => 'yii\db\Connection',
    'dsn' => 'mysql:host=localhost;dbname=YOUR-DATABASE-NAME',
    'username' => 'YOUR-DATABASE-USERNAME',
    'password' => 'YOUR-DATABASE-PASSWORD',
    'charset' => 'utf8',
];
```
_protected/config/web.php
The mail system must get your SMTP mail settings: Host, username, password, port and encryption.
```php
        'mailer' => [
            'class' => 'yii\swiftmailer\Mailer',
            // send all mails to a file by default. 
            // You have to set 'useFileTransport' to false and configure a transport for the mailer to send real emails.
            'useFileTransport' => false,
			'transport' => [
             'class' => 'Swift_SmtpTransport',
             'host' => 'YOUR.HOST',  // e.g. smtp.mandrillapp.com or smtp.gmail.com
             'username' => 'YOUR-USERNAME',
             'password' => 'YOUR-PASSWORD', 
             'port' => '587', // Port 25 is a very common port too
             'encryption' => 'tls', // It is often used, check your provider or mail server specs
         ],
        ],
```
plus you might want to change 'language' => 'en' to something else

_protected/config/params.php
adminEmail and senderEmail must get valid emails. showWhhnServerOffer you might want to set to 'false' because otherwise you will get some unwanted information printed on your home page for WorshipHHN
```php
  'adminEmail' => 'thomas@gmail.com', 
  'senderEmail' => 'thomas@gmail.com',
  'showWhhnServerOffer' => 'true',
```

Extremely important is the .htaccess file. If you install the zip file correctly the .htaccess file should be installed. But if you make a mistake, below is the .htaccess file that must be in the root of where you installed WorshipHHN
```txt
RewriteEngine on

# hide files and folders
RedirectMatch 404 /_protected
RedirectMatch 404 /\.git
RedirectMatch 404 /composer\.
RedirectMatch 404 /.bowerrc

# If a directory or a file exists, use the request directly
RewriteCond %{REQUEST_FILENAME} !-f
RewriteCond %{REQUEST_FILENAME} !-d
# Otherwise forward the request to index.php
RewriteRule . index.php
```
