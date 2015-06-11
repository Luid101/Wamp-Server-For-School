<?php
//[modif oto]
// Nombreuses modifications
// liens symboliques à la place des copies de fichiers
// Croisements des tableaux des extensions PHP et des fichiers dll dans ext
// Affichage triangle si fichier dll existe et pas de ligne extension dans php.ini
// Affichage carré rouge si ligne extension dans php.ini et pas de fichier dll
// Mêmes principes pour les modules Apache lignes LoadModule et fichier *.so
// Créations éventuelles des sous menus Projets et Virtual Hosts
// Ajout de variables pour le chemin de l'éditeur de texte
// Ajout de variables pour les deux services wampapache et wampmysqld
// Attention : Les ajouts de variables susmentionnés nécessitent
//  les modifications des fichiers wampserver.conf, wampmanager.tpl,
//  config.inc.php, scripts/refresh et scripts/wampserver.lib.php
// Ajout des flags FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES dans file(...)
//  pour éviter les suppressions des fins de lignes après.
// Remplacement de or die(...) par error_log(...)

require 'config.inc.php';
require ('wampserver.lib.php');

// ************************ 
//   gestion de la langue


// on recupere la langue courante
if (isset($wampConf['language']))
	$lang = $wampConf['language'];
else 
  $lang = $wampConf['defaultLanguage'];

// on inclus le fichier correspondant
if (is_file($langDir.$lang.'.lang'))
	require($langDir.$lang.'.lang');
else
	require($langDir.$wampConf['defaultLanguage'].'lang');

// on inclus les fichiers de langue de modules par defaut
if ($handle = opendir($langDir.$modulesDir))
{
	while (false !== ($file = readdir($handle)))
	{
		if ($file != "." && $file != ".." && preg_match('|_'.$wampConf['defaultLanguage'].'|',$file))
			include($langDir.$modulesDir.$file);
	}
	closedir($handle);
}

// on inclus les fichiers de langue de modules correspondant à la langue courante
if ($handle = opendir($langDir.$modulesDir))
{
	while (false !== ($file = readdir($handle)))
	{
		if ($file != "." && $file != ".." && preg_match('|_'.$lang.'|',$file))
			include($langDir.$modulesDir.$file);
	}
	closedir($handle);
}

// ************************
// on inclus le fichier de template
require($templateFile);

// ************************
// on gere le mode online /offline
if ($wampConf['status'] == 'online')
{
	$tpl = str_replace('images_off.bmp', 'images_on.bmp',$tpl);
  $tpl = str_replace($w_serverOffline, $w_serverOnline,$tpl);
  $tpl = str_replace('onlineOffline.php on', 'onlineOffline.php off', $tpl);
  $tpl = str_replace($w_putOnline,$w_putOffline,$tpl);
}

// ************************
// chargement du menu des langues disponibles
if ($handle = opendir($langDir))
{
	while (false !== ($file = readdir($handle)))
	{
		if ($file != "." && $file != ".." && preg_match('|\.lang|',$file))
		{
			if ($file == $lang.'.lang')
				$langList[$file] = 1;
			else
				$langList[$file] = 0;
		}
	}
	closedir($handle);
}

$langText = ";WAMPLANGUAGESTART
";
ksort($langList);
foreach ($langList as $langname=>$langstatus)
{
  $cleanLangName = str_replace('.lang','',$langname);
  if ($langList[$langname] == 1)
    $langText .= 'Type: item; Caption: "'.$cleanLangName.'"; Glyph: 13; Action: multi; Actions: lang_'.$cleanLangName.'
';
  else
    $langText .= 'Type: item; Caption: "'.$cleanLangName.'"; Action: multi; Actions: lang_'.$cleanLangName.'
';

}

foreach ($langList as $langname=>$langstatus)
{
  $cleanLangName = str_replace('.lang','',$langname);
  $langText .= '[lang_'.$cleanLangName.']
Action: run; FileName: "'.$c_phpCli.'";Parameters: "-c . changeLanguage.php '.$cleanLangName.'";WorkingDir: "'.$c_installDir.'/scripts"; Flags: waituntilterminated
Action: run; FileName: "'.$c_phpCli.'";Parameters: "-c . refresh.php";WorkingDir: "'.$c_installDir.'/scripts"; Flags: waituntilterminated
Action: resetservices
Action: readconfig;

';
    
}

$tpl = str_replace(';WAMPLANGUAGESTART',$langText,$tpl);

// ************************
// chargement du menu d'extensions de PHP
$myphpini = @file($c_phpConfFile) or die ("php.ini file not found");

//on recupere la conf courante
foreach($myphpini as $line) {
  $extMatch = array();
  if(preg_match('/^(;)?extension\s*=\s*"?([a-z0-9_]+)\.dll"?/i', $line, $extMatch)) {
    $ext_name = $extMatch[2];
    if($extMatch[1] == ';') {
      $ext[$ext_name] = '0';
    } else {
      $ext[$ext_name] = '1';
    }
  }
}

// on recupere la liste d'extensions presentes dans le répertoire ext
if ($handle = opendir($phpExtDir)) 
{
  while (false !== ($file = readdir($handle))) 
  {
    if ($file != "." && $file != ".." && strstr($file,'.dll')) 
      $extDirContents[] = str_replace('.dll','',$file);
  }
  closedir($handle);
}

// on croise les deux tableaux
foreach ($extDirContents as $extname)
{
  if (!array_key_exists($extname,$ext))
    $ext[$extname] = -1; //[modif oto] - dll file exists but not extension line in php.ini
}
foreach ($ext as $extname=>$value)
{
  if (!in_array($extname,$extDirContents))
    $ext[$extname] = -2; //[modif oto] - extension line in php.ini but not dll file
}

ksort($ext);

//on construit le menu correspondant
$extText = ';WAMPPHP_EXTSTART
';
foreach ($ext as $extname=>$extstatus)
{
  if ($ext[$extname] == 1)
    $extText .= 'Type: item; Caption: "'.$extname.'"; Glyph: 13; Action: multi; Actions: php_ext_'.$extname.'
';
  elseif($ext[$extname] == -1)
  {
   	//[modif oto] - Warning icon to indicate problem with this extension: No extension line in php.ini
    $extText .= 'Type: item; Caption: "'.$extname.'"; Action: multi; Actions: php_ext_'.$extname.' ; Glyph: 19;  
';
	}
  elseif($ext[$extname] == -2)
  {
   	//[modif oto] - Square red icon to indicate problem with this extension: no dll file in ext directory
    $extText .= 'Type: item; Caption: "'.$extname.'"; Action: multi; Actions: php_ext_'.$extname.' ; Glyph: 11;  
';
	}
  else
  {
    $extText .= 'Type: item; Caption: "'.$extname.'"; Action: multi; Actions: php_ext_'.$extname.'
';
	}
}

foreach ($ext as $extname=>$extstatus)
{
  if ($ext[$extname] == 1)
    $extText .= '[php_ext_'.$extname.']
Action: service; Service: '.$c_apacheService.'; ServiceAction: stop; Flags: waituntilterminated
Action: run; FileName: "'.$c_phpCli.'";Parameters: "-c . switchPhpExt.php '.$extname.' off";WorkingDir: "'.$c_installDir.'/scripts"; Flags: waituntilterminated
Action: run; FileName: "'.$c_phpCli.'";Parameters: "-c . refresh.php";WorkingDir: "'.$c_installDir.'/scripts"; Flags: waituntilterminated
Action: run; FileName: "net"; Parameters: "start '.$c_apacheService.'"; ShowCmd: hidden; Flags: waituntilterminated
Action: resetservices;
Action: readconfig;
';
  else
    $extText .= '[php_ext_'.$extname.']
Action: service; Service: '.$c_apacheService.'; ServiceAction: stop; Flags: waituntilterminated
Action: run; FileName: "'.$c_phpCli.'";Parameters: "-c . switchPhpExt.php '.$extname.' on";WorkingDir: "'.$c_installDir.'/scripts"; Flags: waituntilterminated
Action: run; FileName: "'.$c_phpCli.'";Parameters: "-c . refresh.php";WorkingDir: "'.$c_installDir.'/scripts"; Flags: waituntilterminated
Action: run; FileName: "net"; Parameters: "start '.$c_apacheService.'"; ShowCmd: hidden; Flags: waituntilterminated
Action: resetservices
Action: readconfig;
';
}

$tpl = str_replace(';WAMPPHP_EXTSTART',$extText,$tpl);

// ************************
// menu de configuration de PHP
$myphpini = parse_ini_file($c_phpConfFile);

// on recupere les valeurs dans le php.ini
foreach($phpParams as $next_param_name=>$next_param_text)
{
  if (isset($myphpini[$next_param_text]))
  {
    if ($myphpini[$next_param_text] == 1)
      $params_for_wampini[$next_param_name] = '1';
    else
      $params_for_wampini[$next_param_name] = '0';
  }
  else //[modif oto] - Paramètre dans $phpParams n'existe pas dans php.ini
    $params_for_wampini[$next_param_name] = -1;
}

$phpConfText = ";WAMPPHP_PARAMSSTART
";
foreach ($params_for_wampini as $paramname=>$paramstatus)
{
  if ($params_for_wampini[$paramname] == 1)
    $phpConfText .= 'Type: item; Caption: "'.$paramname.'"; Glyph: 13; Action: multi; Actions: '.$phpParams[$paramname].'
';
  elseif ($params_for_wampini[$paramname] == 0) //[modif oto] - Pas d'affichage des paramètres inexistants dans php.ini
    $phpConfText .= 'Type: item; Caption: "'.$paramname.'"; Action: multi; Actions: '.$phpParams[$paramname].'
';
}

foreach ($params_for_wampini as $paramname=>$paramstatus)
{
  if ($params_for_wampini[$paramname] == 1)
  $phpConfText .= '['.$phpParams[$paramname].']
Action: service; Service: '.$c_apacheService.'; ServiceAction: stop; Flags: waituntilterminated
Action: run; FileName: "'.$c_phpCli.'";Parameters: "switchPhpParam.php '.$phpParams[$paramname].' off";WorkingDir: "'.$c_installDir.'/scripts"; Flags: waituntilterminated
Action: run; FileName: "'.$c_phpCli.'";Parameters: "-c . refresh.php";WorkingDir: "'.$c_installDir.'/scripts"; Flags: waituntilterminated
Action: run; FileName: "net"; Parameters: "start '.$c_apacheService.'"; ShowCmd: hidden; Flags: waituntilterminated
Action: resetservices
Action: readconfig;
';
  elseif ($params_for_wampini[$paramname] == 0)  //[modif oto] - Pas d'affichage des paramètres inexistants dans php.ini
  	$phpConfText .= '['.$phpParams[$paramname].']
Action: service; Service: '.$c_apacheService.'; ServiceAction: stop; Flags: waituntilterminated
Action: run; FileName: "'.$c_phpCli.'";Parameters: "switchPhpParam.php '.$phpParams[$paramname].' on";WorkingDir: "'.$c_installDir.'/scripts"; Flags: waituntilterminated
Action: run; FileName: "'.$c_phpCli.'";Parameters: "-c . refresh.php";WorkingDir: "'.$c_installDir.'/scripts"; Flags: waituntilterminated
Action: run; FileName: "net"; Parameters: "start '.$c_apacheService.'"; ShowCmd: hidden; Flags: waituntilterminated
Action: resetservices
Action: readconfig;
';
    
}

$tpl = str_replace(';WAMPPHP_PARAMSSTART',$phpConfText,$tpl);

// ************************
// modules Apache
//[modif oto] - Ajout liste de tous les modules Apache
//Détection des lignes Loadmodule sans fichier /modules/module.so
//    (Affichage avec carré rouge dans menu modules Apache)
//Détection des /modules/module.so sans ligne Loadmodule associée
//    (Affichage avec triangle Attention dans menu modules Apache)
$myhttpd = @file($c_apacheConfFile, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES) or die ("httpd.conf file not found");

$recherche = array("modules/");
$mod_load = array();
foreach($myhttpd as $line)
{
  if (preg_match('|^#LoadModule|',$line))
  {
    $mod_table = explode(' ', $line);
    $mod_name = $mod_table[1];
    $mod[$mod_name] = '0';
		$load_module = str_replace($recherche,'',$mod_table[2]);
		$mod_load[$mod_name] = $load_module;
  }
  elseif (preg_match('|^LoadModule|',$line))
  {    
    $mod_table = explode(' ', $line);
    $mod_name = $mod_table[1];
    $mod[$mod_name] = '1';
		$load_module = str_replace($recherche,'',$mod_table[2]);
		$mod_load[$mod_name] = $load_module;
  }
}

// on recupère la liste des modules présents dans le répertoire /modules/
$modDirContents = array();
if ($handle = opendir($c_apacheConfFile = $c_apacheVersionDir.'/apache'.$wampConf['apacheVersion'].'/modules/')) 
{
  while (false !== ($file = readdir($handle))) 
  {
    if ($file != "." && $file != ".." && strstr($file,'.so')) 
			$modDirContents[] = $file;
  }
  closedir($handle);
}
//[modif oto] - On croise les tableaux
$exceptions = array('php5_module');
//Détection présence du module xxxxxx.so demandé par Loadmodule
foreach ($mod as $modname=>$value) 
{
	if(in_array($modname,$exceptions))
		continue;
	if(!in_array($mod_load[$modname], $modDirContents))
		$mod[$modname] = -1 ;
}
//Détection de Loadmodule dans httpd.conf pour chaque module dans /modules/
foreach($modDirContents as $module)
{
	if(!in_array($module, $mod_load))
	{
		$modname = str_replace(array("mod_",".so"),array("","_module"),$module);
		$mod[$modname] = -2 ;
	}
}
ksort($mod);

$httpdText = ";WAMPAPACHE_MODSTART
";

foreach ($mod as $modname=>$modstatus)
{
  if ($modstatus == 1)
    $httpdText .= 'Type: item; Caption: "'.$modname.'"; Glyph: 13; Action: multi; Actions: apache_mod_'.$modname.'
';
	elseif ($modstatus == -1)
		$httpdText .= 'Type: item; Caption: "'.$modname.'"; Action: multi; Actions: apache_mod_'.$modname.' ; Glyph: 11;
';
	elseif ($modstatus == -2)
		$httpdText .= 'Type: item; Caption: "'.$modname.'"; Action: multi; Actions: apache_mod_'.$modname.' ; Glyph: 19;
';
  else
    $httpdText .= 'Type: item; Caption: "'.$modname.'"; Action: multi; Actions: apache_mod_'.$modname.'
';

}

foreach ($mod as $modname=>$modstatus)
{
  if ($mod[$modname] == 1)
    $httpdText .= '[apache_mod_'.$modname.']
Action: service; Service: '.$c_apacheService.'; ServiceAction: stop; Flags: waituntilterminated
Action: run; FileName: "'.$c_phpCli.'";Parameters: "switchApacheMod.php '.$modname.' on";WorkingDir: "'.$c_installDir.'/scripts"; Flags: waituntilterminated
Action: run; FileName: "'.$c_phpCli.'";Parameters: "-c . refresh.php";WorkingDir: "'.$c_installDir.'/scripts"; Flags: waituntilterminated
Action: run; FileName: "net"; Parameters: "start '.$c_apacheService.'"; ShowCmd: hidden; Flags: waituntilterminated
Action: resetservices
Action: readconfig;
';
  else
    $httpdText .= '[apache_mod_'.$modname.']
Action: service; Service: '.$c_apacheService.'; ServiceAction: stop; Flags: waituntilterminated
Action: run; FileName: "'.$c_phpCli.'";Parameters: "switchApacheMod.php '.$modname.' off";WorkingDir: "'.$c_installDir.'/scripts"; Flags: waituntilterminated
Action: run; FileName: "'.$c_phpCli.'";Parameters: "-c . refresh.php";WorkingDir: "'.$c_installDir.'/scripts"; Flags: waituntilterminated
Action: run; FileName: "net"; Parameters: "start '.$c_apacheService.'"; ShowCmd: hidden; Flags: waituntilterminated
Action: resetservices
Action: readconfig;
';
    
}

$tpl = str_replace(';WAMPAPACHE_MODSTART',$httpdText,$tpl);

// ************************
// alias Apache
if ($handle = opendir($aliasDir)) 
{
  while (false !== ($file = readdir($handle))) 
  {
    if ($file != "." && $file != ".." && strstr($file,'.conf')) 
      $aliasDirContents[] = $file;
  }
  closedir($handle);
}

$myreplace = $myreplacemenu = $mydeletemenu = '';
foreach ($aliasDirContents as $one_alias)
{
  $mypattern = ';WAMPADDALIAS';
  $newalias_dir = str_replace('.conf','',$one_alias);
  $alias_contents = @file_get_contents ($aliasDir.$one_alias);
  preg_match('|^Alias /'.$newalias_dir.'/ "(.+)"|',$alias_contents,$match);
  if (isset($match[1]))
    $newalias_dest = $match[1]; 
  else
    $newalias_dest = NULL;
  
    $myreplace .= 'Type: submenu; Caption: "http://localhost/'.$newalias_dir.'/"; SubMenu: alias_'.str_replace(' ','_',$newalias_dir).'; Glyph: 3
';

  $myreplacemenu .= '
[alias_'.str_replace(' ','_',$newalias_dir).']
Type: separator; Caption: "'.$newalias_dir.'"
Type: item; Caption: "Edit alias"; Glyph: 6; Action: multi; Actions: edit_'.str_replace(' ','_',$newalias_dir).'
Type: item; Caption: "Edit .htaccess"; Glyph: 6; Action: run; FileName: "'.$c_editor.'"; parameters: "'.$newalias_dest.'.htaccess"
Type: item; Caption: "Delete alias"; Glyph: 6; Action: multi; Actions: delete_'.str_replace(' ','_',$newalias_dir).'
';

  $mydeletemenu .= '
[delete_'.str_replace(' ','_',$newalias_dir).']
Action: service; Service: '.$c_apacheService.'; ServiceAction: stop; Flags: waituntilterminated
Action: run; FileName: "'.$c_phpExe.'";Parameters: "-c . deleteAlias.php '.str_replace(' ','-whitespace-',$newalias_dir).'";WorkingDir: "'.$c_installDir.'/scripts"; Flags: waituntilterminated
Action: run; FileName: "'.$c_phpCli.'";Parameters: "refresh.php";WorkingDir: "'.$c_installDir.'/scripts"; Flags: waituntilterminated
Action: run; FileName: "net"; Parameters: "start '.$c_apacheService.'"; ShowCmd: hidden; Flags: waituntilterminated
Action: resetservices
Action: readconfig;
[edit_'.str_replace(' ','_',$newalias_dir).']
Action: run; FileName: "'.$c_editor.'"; parameters:"'.$c_installDir.'/alias/'.$newalias_dir.'.conf"; Flags: waituntilterminated
Action: service; Service: '.$c_apacheService.'; ServiceAction: restart;
';

}

$tpl = str_replace($mypattern,$myreplace.$myreplacemenu.$mydeletemenu,$tpl);

// ************************
// versions de PHP
$phpVersionList = listDir($c_phpVersionDir,'checkPhpConf');

$myPattern = ';WAMPPHPVERSIONSTART';
$myreplace = $myPattern."
";
$myreplacemenu = '';    
foreach ($phpVersionList as $onePhp)
{
  $phpGlyph = '';
  $onePhpVersion = str_ireplace('php','',$onePhp);
  //on verifie si le PHP est compatible avec la version d'apache courante
  if (isset($phpConf))
    $phpConf = NULL;
  include $c_phpVersionDir.'/php'.$onePhpVersion.'/'.$wampBinConfFiles;
  $apacheVersionTemp = $wampConf['apacheVersion'];
  while (!isset($phpConf['apache'][$apacheVersionTemp]) && $apacheVersionTemp != '')
  {
    $pos = strrpos($apacheVersionTemp,'.');
    $apacheVersionTemp = substr($apacheVersionTemp,0,$pos);
  }
  
  // PHP incompatible avec la version courante d'apache
  $incompatiblePhp = 0;
  if ($apacheVersionTemp == '')
  {
    $incompatiblePhp = 1;
    $phpGlyph = '; Glyph: 19';
  }
    
  if ($onePhpVersion === $wampConf['phpVersion'])
    $phpGlyph = '; Glyph: 13';
    
    $myreplace .= 'Type: item; Caption: "'.$onePhpVersion.'"; Action: multi; Actions:switchPhp'.$onePhpVersion.$phpGlyph.'
';
  if ($incompatiblePhp == 0)
  {
  $myreplacemenu .= '[switchPhp'.$onePhpVersion.']
Action: service; Service: '.$c_apacheService.'; ServiceAction: stop; Flags: ignoreerrors waituntilterminated
Action: run; FileName: "'.$c_phpCli.'";Parameters: "switchPhpVersion.php '.$onePhpVersion.'";WorkingDir: "'.$c_installDir.'/scripts"; Flags: waituntilterminated
Action: run; FileName: "'.$c_phpCli.'";Parameters: "-c . refresh.php";WorkingDir: "'.$c_installDir.'/scripts"; Flags: waituntilterminated
Action: run; FileName: "net"; Parameters: "start '.$c_apacheService.'"; ShowCmd: hidden; Flags: waituntilterminated
Action: resetservices
Action: readconfig;
';
  }
  else
  {
  $myreplacemenu .= '[switchPhp'.$onePhpVersion.']
Action: run; FileName: "'.$c_phpExe.'";Parameters: "msg.php 1";WorkingDir: "'.$c_installDir.'/scripts"; Flags: waituntilterminated
';
  }
    
}
$myreplace .= 'Type: separator;
Type: item; Caption: "Get more..."; Action: run; FileName: "'.$c_navigator.'"; Parameters: "http://www.wampserver.com/addons_php.php";
';

$tpl = str_replace($myPattern,$myreplace.$myreplacemenu,$tpl);

// ************************
// versions de Apache

$apacheVersionList = listDir($c_apacheVersionDir,'checkApacheConf');

$myPattern = ';WAMPAPACHEVERSIONSTART';
$myreplace = $myPattern."
";
$myreplacemenu = '';    

foreach ($apacheVersionList as $oneApache)
{
  $apacheGlyph = '';
  $oneApacheVersion = str_ireplace('apache','',$oneApache);

	//on verifie si le apache est compatible avec la version d'apache courante
  if (isset($phpConf))
    $phpConf = NULL;
  include $c_phpVersionDir.'/php'.$wampConf['phpVersion'].'/'.$wampBinConfFiles;
  $apacheVersionTemp = $oneApacheVersion;
  while (!isset($phpConf['apache'][$apacheVersionTemp]) && $apacheVersionTemp != '')
  {
    $pos = strrpos($apacheVersionTemp,'.');
    $apacheVersionTemp = substr($apacheVersionTemp,0,$pos);
  }
    
  // apache icompatible avec la version courante de PHP
  $incompatibleApache = 0;
  if ($apacheVersionTemp == '')
  {
    $incompatibleApache = 1;
    $apacheGlyph = '; Glyph: 19';
  }

  if (isset($apacheConf))
    $apacheConf = NULL;
  include $c_apacheVersionDir.'/apache'.$oneApacheVersion.'/'.$wampBinConfFiles;
    
  if ($oneApacheVersion === $wampConf['apacheVersion'])
    $apacheGlyph = '; Glyph: 13';
    
  $myreplace .= 'Type: item; Caption: "'.$oneApacheVersion.'"; Action: multi; Actions:switchApache'.$oneApacheVersion.$apacheGlyph.'
';

  if ($incompatibleApache == 0)
  {
    $myreplacemenu .= '[switchApache'.$oneApacheVersion.']
Action: service; Service: '.$c_apacheService.'; ServiceAction: stop; Flags: ignoreerrors waituntilterminated
Action: run; FileName: "'.$c_apacheExe.'"; Parameters: "'.$c_apacheServiceRemoveParams.'"; ShowCmd: hidden; Flags: ignoreerrors waituntilterminated
Action: closeservices; Flags: ignoreerrors
Action: run; FileName: "'.$c_phpCli.'";Parameters: "switchApacheVersion.php '.$oneApacheVersion.'";WorkingDir: "'.$c_installDir.'/scripts"; Flags: waituntilterminated
Action: run; FileName: "'.$c_phpCli.'";Parameters: "switchPhpVersion.php '.$wampConf['phpVersion'].'";WorkingDir: "'.$c_installDir.'/scripts"; Flags: waituntilterminated
Action: run; FileName: "'.$c_apacheVersionDir.'/apache'.$oneApacheVersion.'/'.$apacheConf['apacheExeDir'].'/'.$apacheConf['apacheExeFile'].'"; Parameters: "'.$apacheConf['apacheServiceInstallParams'].'"; ShowCmd: hidden; Flags: waituntilterminated
Action: run; FileName: "net"; Parameters: "start '.$c_apacheService.'"; ShowCmd: hidden; Flags: waituntilterminated
Action: run; FileName: "'.$c_phpCli.'";Parameters: "-c . refresh.php";WorkingDir: "'.$c_installDir.'/scripts"; Flags: waituntilterminated
Action: resetservices
Action: readconfig;
';
  }
  else
  {
    $myreplacemenu .= '[switchApache'.$oneApacheVersion.']
Action: run; FileName: "'.$c_phpExe.'";Parameters: "msg.php 2";WorkingDir: "'.$c_installDir.'/scripts"; Flags: waituntilterminated
';
  }
}
$myreplace .= 'Type: separator;
Type: item; Caption: "Get more..."; Action: run; FileName: "'.$c_navigator.'"; Parameters: "http://www.wampserver.com/addons_apache.php";
';

$tpl = str_replace($myPattern,$myreplace.$myreplacemenu,$tpl);

// ************************
// versions de MySQL
$mysqlVersionList = listDir($c_mysqlVersionDir,'checkMysqlConf');

$myPattern = ';WAMPMYSQLVERSIONSTART';
$myreplace = $myPattern."
";
$myreplacemenu = '';    
foreach ($mysqlVersionList as $oneMysql)
{
  $oneMysqlVersion = str_ireplace('mysql','',$oneMysql);
  if (isset($mysqlConf))
    $mysqlConf = NULL;
  include $c_mysqlVersionDir.'/mysql'.$oneMysqlVersion.'/'.$wampBinConfFiles;
  if ($oneMysqlVersion === $wampConf['mysqlVersion'])
    $myreplace .= 'Type: item; Caption: "'.$oneMysqlVersion.'"; Action: multi; Actions:switchMysql'.$oneMysqlVersion.'; Glyph: 13
';
  else
    $myreplace .= 'Type: item; Caption: "'.$oneMysqlVersion.'"; Action: multi; Actions:switchMysql'.$oneMysqlVersion.'
';

  $myreplacemenu .= '[switchMysql'.$oneMysqlVersion.']
Action: service; Service: '.$c_mysqlService.'; ServiceAction: stop; Flags: ignoreerrors waituntilterminated
Action: run; FileName: "'.$c_mysqlExe.'"; Parameters: "'.$c_mysqlServiceRemoveParams.'"; ShowCmd: hidden; Flags: ignoreerrors waituntilterminated
Action: closeservices;
Action: run; FileName: "'.$c_phpCli.'";Parameters: "switchMysqlVersion.php '.$oneMysqlVersion.'";WorkingDir: "'.$c_installDir.'/scripts"; Flags: waituntilterminated 
Action: run; FileName: "'.$c_mysqlVersionDir.'/mysql'.$oneMysqlVersion.'/'.$mysqlConf['mysqlExeDir'].'/'.$mysqlConf['mysqlExeFile'].'"; Parameters: "'.$mysqlConf['mysqlServiceInstallParams'].'"; ShowCmd: hidden; Flags: waituntilterminated
Action: run; FileName: "net"; Parameters: "start '.$c_mysqlService.'"; ShowCmd: hidden; Flags: waituntilterminated
Action: run; FileName: "'.$c_phpCli.'";Parameters: "-c . refresh.php";WorkingDir: "'.$c_installDir.'/scripts"; Flags: waituntilterminated
Action: resetservices; 
Action: readconfig;

';

}
$myreplace .= 'Type: separator;
Type: item; Caption: "Get more..."; Action: run; FileName: "'.$c_navigator.'"; Parameters: "http://www.wampserver.com/addons_mysql.php";
';

$tpl = str_replace($myPattern,$myreplace.$myreplacemenu,$tpl);

//[modif oto] - Submenu Projects
if(strpos($tpl,";WAMPPROJECTSUBMENU") !== false)
{
	//Add item for submenu
	$myPattern = ';WAMPPROJECTSUBMENU';
	$myreplace = $myPattern."
";
	$myreplacesubmenu = 'Type: submenu; Caption: "My Projects"; Submenu: myProjectsMenu; Glyph: 3
';
	$tpl = str_replace($myPattern,$myreplace.$myreplacesubmenu,$tpl);
	
	//Add submenu
	$myPattern = ';WAMPMENULEFTEND';
	$myreplace = $myPattern."
";
	$myreplacesubmenu = '

[myProjectsMenu]
;WAMPPROJECTMENUSTART
;WAMPPROJECTMENUEND
	
';
	$tpl = str_replace($myPattern,$myreplace.$myreplacesubmenu,$tpl);

	//Construct submenu
	$myPattern = ';WAMPPROJECTMENUSTART';
	$myreplace = $myPattern."
";
	// Place projects into submenu Hosts
	// Folder to ignore in projects
	$projectsListIgnore = array ('.','..');
	// List projects
	$myDir = $wwwDir;
	if(substr($myDir,-1) != "/")
		$myDir .= "/";
	$handle=opendir($myDir);
	$projectContents = array();
	while (($file = readdir($handle))!==false) 
	{
		if (is_dir($myDir.$file) && !in_array($file,$projectsListIgnore)) 
			$projectContents[] = $file;
	}
	closedir($handle);
	$myreplacesubmenuProjects = '';
	if (count($projectContents) > 0)
	{
		for($i = 0 ; $i < count($projectContents) ; $i++)
		{
			$myreplacesubmenuProjects .= 'Type: item; Caption: "'.$projectContents[$i].'"; Action: run; FileName: "'.$c_navigator.'"; Parameters: "http://'.$projectContents[$i].'/"; Glyph: 5
';
		}
	}
	$tpl = str_replace($myPattern,$myreplace.$myreplacesubmenuProjects,$tpl);
}

//[modif oto] - Submenu Virtual Hosts
if(strpos($tpl,";WAMPVHOSTSUBMENU") !== false)
{
	if(in_array("#Include conf/extra/httpd-vhosts.conf", $myhttpd) !== false)
		error_log ("conf/extra/httpd-vhosts.conf file is not included in conf/httpd.conf");
	else
	{
		$c_vhostConfFile = $c_apacheVersionDir.'/apache'.$wampConf['apacheVersion'].'/'.$wampConf['apacheConfDir'].'/extra/httpd-vhosts.conf';
		if(!file_exists($c_vhostConfFile))
			error_log ("file conf/extra/httpd-vhosts.conf does not exists");
		else
		{
			//Add item for submenu
			$myPattern = ';WAMPVHOSTSUBMENU';
			$myreplace = $myPattern."
";
			$myreplacesubmenu = 'Type: submenu; Caption: "My Virtual Hosts"; Submenu: myVhostsMenu; Glyph: 3
';
			$tpl = str_replace($myPattern,$myreplace.$myreplacesubmenu,$tpl);
	
			//Add submenu
			$myPattern = ';WAMPMENULEFTEND';
			$myreplace = $myPattern."
";
			$myreplacesubmenu = '

[myVhostsMenu]
;WAMPVHOSTMENUSTART
;WAMPVHOSTMENUEND
	
';
			$tpl = str_replace($myPattern,$myreplace.$myreplacesubmenu,$tpl);

			//Construct submenu
			$myPattern = ';WAMPVHOSTMENUSTART';
			$myreplace = $myPattern."
";
			// Place projects into submenu Hosts
			$lines = file($c_vhostConfFile, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
			$myreplacesubmenuVhosts = '';
			foreach($lines as $value)
			{
				if(stripos($value, "ServerName") !== false)
				{	
					$value = trim(str_ireplace("ServerName","",$value));
					$myreplacesubmenuVhosts .= 'Type: item; Caption: "'.$value.'"; Action: run; FileName: "'.$c_navigator.'"; Parameters: "http://'.$value.'/"; Glyph: 5
';
				}
			}
			$tpl = str_replace($myPattern,$myreplace.$myreplacesubmenuVhosts,$tpl);
		}
	}
}

// ************************
//on enregistre le fichier ini

$fp = fopen($wampserverIniFile,'w');
fwrite($fp,$tpl);
fclose($fp);

?>