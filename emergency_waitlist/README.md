[Design de la base de données](\doc\db.md)

[Schéma de la base de données](\db\schema.sql)

[Exemples de données (SQL)](\db\seed.sql)

# Developper
Requirments:
    <li>Postgres
    <li>PHP

## Step 1
First create the database with <code>createdb emergency_waitlist<code>

## Step 2
Execute both sql files on the database<br> 
<a href='\db\schema.sql'>schema</a> <br>
<a href='\db\seed.sql'>seed</a>

## Step 3
Run the php server.<br>
In the command line, in folder /emergency_waitlist/public, execute <code>php -S localhost:8080</code>

## Step 4
Now you can access the web app by going to localhost:8080 on your browser.<br>
Login as an admin with Username: admin and Password: admin <br>
Create a patient by entering a name and injury then clicking on "Enter waitlist" <br>

