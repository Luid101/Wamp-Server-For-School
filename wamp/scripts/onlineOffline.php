<?php
//[modif oto]
// Pour tenir compte des différences de configuration Apache 2.2 et 2.4
// et du support ou non d'IPv6

require ('wampserver.lib.php');

require 'config.inc.php';

//[modif oto] - Test of Apache version for cohabition of Apache 2.4 and Apache 2.2
if(substr($wampConf['apacheVersion'],0,3) == "2.4") {
$onlineText = "#   onlineoffline tag - don't remove
    Require all granted";
    
$offlineText = "#   onlineoffline tag - don't remove
    Require local"; 
}
else {
$onlineText = "#   onlineoffline tag - don't remove
    Order Allow,Deny
    Allow from all";
    
$offlineText = "#   onlineoffline tag - don't remove
    Order Deny,Allow
    Deny from all
    Allow from localhost ".(test_IPv6() ? "::1 " : "")."127.0.0.1"; 
}

$httpConfFileContents = file_get_contents($c_apacheConfFile) or die ("httpd.conf file not found");

// on modifie le fichier httpd.conf 
if ($_SERVER['argv'][1] == 'off')
{
    
    $wampIniNewContents['status'] = 'offline';
    $httpConfFileContents = str_replace($onlineText,$offlineText,$httpConfFileContents);
    $fpHttpd = fopen($c_apacheConfFile,"w");
    fwrite($fpHttpd,$httpConfFileContents);
    fclose($fpHttpd);
}

if ($_SERVER['argv'][1] == 'on')
{
    $wampIniNewContents['status'] = 'online';
    $httpConfFileContents = str_replace($offlineText,$onlineText,$httpConfFileContents);
    $fpHttpd = fopen($c_apacheConfFile,"w");
    fwrite($fpHttpd,$httpConfFileContents);
    fclose($fpHttpd);
}


//on enregistre la nouvelle configuration
wampIniSet($configurationFile, $wampIniNewContents);
?>