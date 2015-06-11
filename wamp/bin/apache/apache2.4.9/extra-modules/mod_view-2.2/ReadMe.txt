8 July 2013                              Apache Lounge Distribution

                                      mod_view 2.2 for Apache 2.4.x Win32

# Win32 VC11 binary by: Steffen
# Mail: info@apachelounge.com
# Home: http://www.apachelounge.com/



# Install:

- Copy mod_view.so to your modules folder


# Add to your httpd.conf

LoadModule view_module modules/mod_view.so

# Configuration: See Manual.doc

# To Test:

Add the following example configuration to httpd.conf:

<IfModule mod_view.c>

    # Map a URI to some where else in the file system.
    Alias /log /apache24/logs

    # When the resulting pathanme matches, check for special query
    # arguments. The combination of these two directives allows for
    # a URL like:
    #
    #   http://www.domain.com/log/error_log?tail=20&refresh=15
    #
    # View a URI to some where else in the file system.
    # Only view access_log, error_log, php.log, but not
    # suexec_log, ssl_request_log, etc. and other files
    # within /apache24/logs.

    AliasMatch "^/log/(access|error|php)([._]log)?" "/apache24/logs/$1$2"
    <Directory /apache24/logs>
        ViewEnable on
        Require local
    </Directory>
</IfModule>

Edit the Require to your needs

With the above example configuration, test the module specifying a URL of the form: 
http://localhost/log/access_log?tail=20&refresh=20

You should see the last 20 lines of the access_log file every 20 seconds. 



Enjoy,


Steffen