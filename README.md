# WorshipHHN
A worship service planer and organizer

Eventually here will include instructions for a "composer" installation. But for now only a zip file installation is explained.

This software is designed to work on an apache, maria database and php environment.  A good such environment is XAMPP. see https://www.apachefriends.org/index.html. Perl however is not needed but doesn't harm anything.
1. Download the latest version zip file
2. Install all the files found in the zip file onto your server.
3. Make sure your server has all the PHP modules you need by looking at the requirements.php page. Here is how mine looks http://jesusislord.se/whhn/requirements.php
4. Create a database and user. Set the protected/config/db.php file to show all the necessary connections to your database.
5. Install the initialize.sql onto your database to create all the tables and a startup of data for the tables.
6. Your login will be username=creator, password=password0123  Of course you want to change these as soon as you log in.
7. The users, events, teams, all are there to simply show you how to start. You are welcome to erase them all except the user with the role theCreator. That you really need to keep.


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
adminEmail and senderEmail must get valid emails.
```php
  'adminEmail' => 'thomas@gmail.com', 
	'senderEmail' => 'thomas@gmail.com',
```
