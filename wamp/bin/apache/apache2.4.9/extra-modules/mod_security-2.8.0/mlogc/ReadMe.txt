16 April 2014                          Apache Lounge Distribution

                           mlogc-2.8.0 build with curl-7.31.0 pcre-8.34 for Apache 2.4.x Win32 VC11

# Original source by: Ivan Ristic <ivanr@webkreator.com>
# Original Home: http://www.modsecurity.org/

# Win32 VC11 binary by: Steffen
# Mail: info@apachelounge.com
# Home: http://www.apachelounge.com/



The program mlogc (short for ModSecurity Log Collector) can be used to transport audit logs 
in real time to a remote logging server.

# Notes:

- The config file defaults to ..\conf\mlogc.conf


# Install:

- Copy mlogc.exe and libcurl.dll to .../Apache24/bin


# Configuration: 

  See the file install and  mlogc-default.conf and/or 
  the mod_security handbook at http://blog.ivanristic.com/modsecurity-handbook/


# A config example:

  Add to your mod_security configuration in conf/httpd.conf:

  SecDataDir logs
  SecAuditEngine RelevantOnly
  SecAuditLogRelevantStatus "^(?:5|4\d[^4])"
  SecAuditLogType Concurrent
  SecAuditLogParts ABCDEFGHZ
  SecAuditLogStorageDir logs/data/
  SecAuditLog "|bin/mlogc.exe"

  Create conf/mlogc.conf :

  CollectorRoot       "C:/Apache2/logs" (change to your installation)
  ConsoleURI          "https://REMOTE_ADDRESS:8888/rpc/auditLogReceiver" (change to your needs)
  SensorUsername      "USERNAME"
  SensorPassword      "PASSWORD"
  LogStorageDir       "data"
  TransactionLog      "mlogc-transaction.log"
  QueuePath           "mlogc-queue.log"
  ErrorLog            "mlogc-error.log"
  LockFile            "mlogc.lck"
  KeepEntries         0
  ErrorLogLevel       2
  MaxConnections      10
  MaxWorkerRequests   1000
  TransactionDelay    50
  StartupDelay        5000
  CheckpointInterval  15
  ServerErrorTimeout  60



Enjoy,

Steffen