DBD MODULES - Two Apache modules to allow Apache 2.4 to access databases using DBD.

    mod_log_dbd     - Log web requests to an SQL database
    mod_vhost_dbd   - Override the document root directory from an SQL database

Release History
    Version 1.0.6 February 19, 2012 - log_dbd error msg fix & vhost_dbd runs before mod_rewrite (if present)
    Version 1.0.5 May 17, 2009 - fix mod_vhost_dbd  issue #2  - Some DBD drivers depend on output-argument initial values; set the result pointer to NULL before calling apr_dbd_pselect, and set the row pointer to NULL before the first call to apr_dbd_get_row.
    Version 1.0.4 August 2, 2008 - mod_vhost_dbd retains environment vars correctly on APR 1.3+.
    Version 1.0.3 January 1, 2008 - mod_log_dbd better fallback file when DBDPrepareSQL is used.
    Version 1.0.2 November 26, 2007 - mod_log_dbd fallback file initialized correctly

DBD MODULES are hosted at Google:   http://dbd-modules.googlecode.com/

The source code is at:
    http://code.google.com/p/dbd-modules/downloads

The build instructions for Windows or Linux are at:
    http://code.google.com/p/dbd-modules/wiki/Building

The configuration instructions are at:
    http://code.google.com/p/dbd-modules/wiki/mod_vhost_dbd
    http://code.google.com/p/dbd-modules/wiki/mod_log_dbd


Tom