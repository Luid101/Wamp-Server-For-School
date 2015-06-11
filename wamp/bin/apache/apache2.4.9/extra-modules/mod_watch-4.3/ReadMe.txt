8 July 2013                              Apache Lounge Distribution

                                     mod_watch 4.3P for Apache 2.4.x Win32

# Original source by: Anthony Howe
# Patched and VC11 binary by: Steffen
# Mail: info@apachelounge.com
# Home: http://www.apachelounge.com/


# More Info: See included index.html

# Install:

- Copy mod_watch.so to your modules folder


- Create a folder named watch in your Apache dir, eg. c:/apache24/watch

# Add to your httpd.conf

LoadModule watch_module modules/mod_watch.so


# Configuration:

Add the following to httpd.conf:


<IfModule mod_watch.c>

# Allows the URL used to query virtual host data:
<Location /watch-info>
        SetHandler watch-info
        Require local
</Location>

<LocationMatch "^/~.+/watch-info$">
	SetHandler watch-info
        Require local
</LocationMatch>

# allows the URL used to query virtual host data:
<Location /watch-list>
	SetHandler watch-list
        Require local
</Location>

# Shows page with collected info:
<Location /watch-table>
	SetHandler watch-table
        Require local
</Location>

# flushing of the watch table:
<Location /watch-flush>
        SetHandler watch-flush
        Require local
</Location>

WatchStateDirectory c:/apache24/watch
# Remember to substitute this folder with your actual path

</IfModule>

Note: Edit the Require's above to your needs


With the above, to test the module go to http://localhost/watch-table
You should see a page with the monitoring info 



Enjoy,


Steffen