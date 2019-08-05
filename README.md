# WorshipHHN
A worship service planer and organizer

Eventually here will include instructions for a "composer" installation. But for now only a zip file installation is explained.

This software is designed to work on a XAMPP. see https://www.apachefriends.org/index.html
Download the latest version zip file
Install all the files in the zip file onto your server.
Make sure your server has all the PHP modules you need by looking at the requirements.php page. Here is how mine looks http://jesusislord.se/whhn/requirements.php
Create a database and user. Set the protected/config/db.php file to show all the necessary connections to your database.
Install the initialize.sql onto your database to create all the tables and a startup of data for the tables.
Your login will be username=creator, password=password0123
