<?php
//[modif oto]
// Variable pour éditeur de texte par défaut
// Variables pour les deux services wampapache et wampmysqld
// Attention : Les ajouts de variables susmentionnés nécessitent
//  les modifications des fichiers wampserver.conf, wampmanager.tpl,
//  config.inc.php, scripts/refresh et scripts/wampserver.lib.php

// Tableau $phpDllToCopy modifié pour tenir compte nouvelles versions PHP

$configurationFile = '../wampmanager.conf';
$templateFile = '../wampmanager.tpl';
$wampserverIniFile = '../wampmanager.ini';
$langDir = '../lang/';
$aliasDir = '../alias/';
$modulesDir = 'modules/';
$logDir = 'logs/';
$wampBinConfFiles = 'wampserver.conf';
$phpConfFileForApache = 'phpForApache.ini';

// on charge la conf locale
$wampConf = @parse_ini_file($configurationFile);


//on renseigne les variables du template avec la conf locale
$c_installDir = $wampConf['installDir'];
$c_wampVersion = $wampConf['wampserverVersion'];
$c_navigator = $wampConf['navigator'];

//[modif oto] Ajout variable editeur de texte à utiliser
$c_editor = $wampConf['editor'];
//[modif oto] Ajout nom des services
$c_apacheService = $wampConf['ServiceApache'];
$c_mysqlService = $wampConf['ServiceMysql'];


$c_phpCliVersion = $wampConf['phpCliVersion'];
$c_mysqlVersion = $wampConf['mysqlVersion'];
$c_mysqlServiceInstallParams = $wampConf['mysqlServiceInstallParams'];
$c_mysqlServiceRemoveParams = $wampConf['mysqlServiceRemoveParams'];
$c_apacheServiceInstallParams = $wampConf['apacheServiceInstallParams'];
$c_apacheServiceRemoveParams = $wampConf['apacheServiceRemoveParams'];
$c_webgrind = "webGrind";


// on construit les variables correspondant aux chemins 
$c_apacheVersionDir = $wampConf['installDir'].'/bin/apache';
$c_phpVersionDir = $wampConf['installDir'].'/bin/php';
$c_mysqlVersionDir = $wampConf['installDir'].'/bin/mysql';
$c_apacheConfFile = $c_apacheVersionDir.'/apache'.$wampConf['apacheVersion'].'/'.$wampConf['apacheConfDir'].'/'.$wampConf['apacheConfFile'];
$c_apacheExe = $c_apacheVersionDir.'/apache'.$wampConf['apacheVersion'].'/'.$wampConf['apacheExeDir'].'/'.$wampConf['apacheExeFile'];
$c_phpConfFile = $c_apacheVersionDir.'/apache'.$wampConf['apacheVersion'].'/'.$wampConf['apacheExeDir'].'/'.$wampConf['phpConfFile'];
$c_mysqlExe = $c_mysqlVersionDir.'/mysql'.$wampConf['mysqlVersion'].'/'.$wampConf['mysqlExeDir'].'/'.$wampConf['mysqlExeFile'];
$c_mysqlConfFile = $c_mysqlVersionDir.'/mysql'.$wampConf['mysqlVersion'].'/'.$wampConf['mysqlConfDir'].'/'.$wampConf['mysqlConfFile'];
$c_phpExe = $c_phpVersionDir.'/php'.$c_phpCliVersion.'/'.$wampConf['phpExeFile'];
$c_phpCli = $c_phpVersionDir.'/php'.$c_phpCliVersion.'/'.$wampConf['phpCliFile'];
$c_mysqlConsole = $c_mysqlVersionDir.'/mysql'.$c_mysqlVersion.'/'.$wampConf['mysqlExeDir'].'/mysql.exe';

$phpExtDir = $c_phpVersionDir.'/php'.$wampConf['phpVersion'].'/ext/';
$helpFile = $c_installDir.'/help/wamp5.chm';
$wwwDir = $c_installDir.'/www';

$phpDllToCopy = array (
	'icudt52.dll', //[modif oto] - Ajouts pour éviter unknown error PHP 5.6.a2
	'icuin52.dll',
	'icuio52.dll',
	'icule52.dll',
	'iculx52.dll',
	'icutest52.dll',
	'icutu52.dll',
	'icuuc52.dll',
	'icudt51.dll', //[modif oto] - Ajouts pour éviter unknown error PHP 5.5.6
	'icuin51.dll',
	'icuio51.dll',
	'icule51.dll',
	'iculx51.dll',
	'icutest51.dll',
	'icutu51.dll',
	'icuuc51.dll',
	'icudt50.dll', //[modif oto] - Ajouts pour éviter unknown error PHP 5.5
	'icuin50.dll',
	'icuio50.dll',
	'icule50.dll',
	'iculx50.dll',
	'icutest50.dll',
	'icutu50.dll',
	'icuuc50.dll',
	'icudt49.dll', //[modif oto] - Ajouts pour éviter unknown error PHP 5.3/5.4
	'icuin49.dll',
	'icuio49.dll',
	'icule49.dll',
	'iculx49.dll',
	'icutest49.dll',
	'icutu49.dll',
	'icuuc49.dll',
	'libeay32.dll',
	'libsasl.dll', //[modif oto] - Ajout pour éviter unknown error
	'libintl.dll',
	'php5isapi.dll',
	'php5nsapi.dll',
	'ssleay32.dll',
	'php5ts.dll',
	'fribidi.dll', //[modif oto] - Ci-contre et dessous pour PHP 5.2.x
	'fdftk.dll',   // Peuvent être supprimés pour PHP 5.3.0 ou plus
	'libmcrypt.dll',
	'libmhash.dll',
	'libmysql.dll',
	'libmysqli.dll',
	'msql.dll',
	'ntwdblib.dll',
	'php5activescript.dll',
	);
                        
$phpParams = array (
	'ze1 compatibility mode'=>'zend.ze1_compatibility_mode',
	'(XDebug) :  Remote debug' => 'xdebug.remote_enable',
	'(XDebug) :  Profiler' => 'xdebug.profiler_enable',
	'(XDebug) :  Profiler Enable Trigger' => 'xdebug.profiler_enable_trigger',
	'short open tag' => 'short_open_tag',
	'asp tags' => 'asp_tags',
	'output buffering' => 'output_buffering',
	'y2k compliance'=>'y2k_compliance',
	'zlib output compression'=>'zlib.output_compression',
	'implicit flush'=>'implicit_flush',
	'allowc call time pass reference'=>'allow_call_time_pass_reference',
	'safe mode'=>'safe_mode',
	'expose PHP'=>'expose_php',
	'display errors'=>'display_errors',
	'display startup errors'=>'display_startup_errors',
	'log errors' => 'log_errors',
	'ignore repeated errors'=>'ignore_repeated_errors',
	'ignore repeated source'=>'ignore_repeated_source',
	'report memleaks'=>'report_memleaks',
	'track errors'=>'track_errors',
	'register globals'=>'register_globals',
	'register long arrays'=>'register_long_arrays',
	'register argc argv'=>'register_argc_argv',
	'magic quotes gpc'=>'magic_quotes_gpc',
	'magic quotes runtime'=>'magic_quotes_runtime',
	'magic quotes sybase'=>'magic_quotes_sybase',
	'enable dl'=>'enable_dl',
	'file uploads'=>'file_uploads',
	'allow url fopen'=>'allow_url_fopen',
	'allow url include' => 'allow_url_include',
	);

?>
