NET STOP wampapache
.\bin\apache\apache2.4.9\bin\httpd.exe -k uninstall -n wampapache
NET STOP wampmysqld 
.\bin\mysql\mysql5.6.17\bin\mysqld.exe --remove wampmysqld
wampmanager.exe -quit -id={wampserver}