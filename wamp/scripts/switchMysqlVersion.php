<?php
//[modif oto]
// Mise � jour dynamique ancienne version MySQL utilis�e

require 'wampserver.lib.php';
require 'config.inc.php';

$newMysqlVersion = $_SERVER['argv'][1];

//on charge le fichier de conf de la nouvelle version
require $c_mysqlVersionDir.'/mysql'.$newMysqlVersion.'/'.$wampBinConfFiles;

//[modif oto ] - Renseigne ancienne version MySQL
$mysqlConf['mysqlLastKnown'] = $wampConf['mysqlVersion'];
$mysqlConf['mysqlVersion'] = $newMysqlVersion;

wampIniSet($configurationFile, $mysqlConf);

?>