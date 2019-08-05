# WorshipHHN
A worship service planer and organizer

Eventually here will include instructions for a "composer" installation. But for now only a zip file installation is explained.

This software is designed to work on an apache, maria database and php environment.  A good such environment is XAMPP. see https://www.apachefriends.org/index.html. Perl however is not needed but doesn't harm anything.
1. Download the latest version zip file
2. Install all the files found in the zip file onto your server.
3. Make sure your server has all the PHP modules you need by looking at the requirements.php page. Here is how mine looks http://jesusislord.se/whhn/requirements.php
4. Create a database and user. Set the protected/config/db.php file to show all the necessary connections to your database.
5. Install the initialize.sql onto your database to create all the tables and a startup of data for the tables.
6. Your login will be username=creator, password=password0123
