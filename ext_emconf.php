<?php

########################################################################
# Extension Manager/Repository config file for ext "cdnfiles".
#
# Auto generated 24-02-2010 16:33
#
# Manual updates:
# Only the data in the array - everything else is removed by next
# writing. "version" and "dependencies" must not be touched!
########################################################################

$EM_CONF[$_EXTKEY] = array(
	'title' => 'Replace local files for CDN URLs',
	'description' => 'Replace local files for CDN URLs',
	'category' => 'plugin',
	'shy' => 0,
	'version' => '0.9.0',
	'dependencies' => '',
	'conflicts' => '',
	'priority' => '',
	'loadOrder' => '',
	'module' => '',
	'state' => 'stable',
	'uploadfolder' => 0,
	'createDirs' => '',
	'modify_tables' => '',
	'clearcacheonload' => 0,
	'lockType' => '',
	'author' => 'Fernando Arconada',
	'author_email' => 'fernando.arconada@gmail.com',
	'author_company' => '',
	'CGLcompliance' => '',
	'CGLcompliance_note' => '',
	'constraints' => array(
		'depends' => array(
			'php' => '5.3.0-0.0.0',
			'typo3' => '4.3.0-0.0.0',
		),
		'conflicts' => array(
		),
		'suggests' => array(
		),
	),
	'_md5_values_when_last_written' => 'a:8:{s:21:"class.tx_cdnfiles.php";s:4:"f378";s:42:"class.tx_cdnfiles_specialconfiguration.php";s:4:"ce5b";s:21:"ext_conf_template.txt";s:4:"211c";s:17:"ext_localconf.php";s:4:"0315";s:14:"lib/sfYaml.php";s:4:"2b71";s:20:"lib/sfYamlDumper.php";s:4:"2819";s:20:"lib/sfYamlInline.php";s:4:"7b7e";s:20:"lib/sfYamlParser.php";s:4:"748a";}',
	'suggests' => array(
	),
);

?>