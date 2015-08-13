# Wamp Server for Handling School Utilities.

### What is this program?
Good question. It is a bunch of PHP code that me and a friend put together to help our school handle mundane tasks. 
It helps with three things: showing announcements, student polling and room booking. The program allows students and teachers to log
into its server. Once logged in it gives them specific options depending on if they are teachers or students (e.g. Teachers can 
create announcements but students can't.)  

### How does it "show announcements"?
Firstly it allows teachers who have signed into the program to post announcements online. 
The teachers have the option of specifying when they want the announcement to start and stop as well as which days they want the
announcements to be shown on.
Those announcements can be shown to students (in classic scrolling news fashion of course) on a screen. Although it has to be done
from the page of a teacher that is logged in. Teachers also have all the basic CRUD(Create, Read, Update, Delete) ability for all
announcements that they create. These options can be accessed from links on a dashboard they will be shown once they log in.

### How does it "book rooms"?
Like the above it's an option only available to teachers who are signed in.  It allows 
teachers to select days they want to book a room and the room they want to book. And it saves it into it's database.  

### How does "student polling" work?
Student polling is more of a two sided affair. The teachers make the polls and the students answer them. Students have
the option to answer all polls that they haven’t already answered. The teachers see the results of of all the polls they
created. The polling system also gives teachers the full CRUD(Create, Read, Update, Delete) options. 


### How to get this code working:
The first thing you'll need is a web development environment like [WAMP server](http://www.wampserver.com/en/),
[XAMPP server](https://www.apachefriends.org/index.html) or if you want something you can run off a USB key,
[UwAmp server](http://www.uwamp.com/en/). The next thing you will need is the files from this repository. So download them.
Then follow the instructions below:

1. Extract the contents of the "www" folder into your localhost folder on your server. 
2. Then go to the folder "db_file" and extract the database "login_register" into your server's built sql database. 
3. If you did all that well then you should be golden. 

##### However if you are not Golden then you might need to change the username and password in the PHP code that the program uses to access the database.

Follow the steps below:

1. To do that go to the folder that contains the files you copied from the "www" folder.
2. Open up the file called "db.php".
3. On line 6 you can change "$mysql_username = 'root';" to what ever your database username is.
4. On line 7 you can change "$mysql_password = '';" to what ever your database password is.
5. And then you should be GOLDEN!

The database should be pretty easy to use once you have everything setup. You just have to register and sign in to use it. However I might be posting a tutorial on it later on.

##**Disclaimer**

I am NOT liable for any damages the miss use of this program may cause to any device you use it on. (Relax its just a fromality :D)
