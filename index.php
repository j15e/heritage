<?php
require('lib/config.php');
require('lib/db/mysql.php');
//$db = new database;
//$db->connect($_config['db_host'],$_config['db_username'],$_config['db_password'],$_config['db_database'], $_config['db_persistant']);
require('lib/functions.php');
if($_GET['set_lang'] == ''){
	require('languages/french.php');
	$_language = 'fr';
} elseif($_GET['set_lang'] == 'en') {
	require('languages/english.php');
	$_language = 'en';	
}
require('lib/templates.php');
require('lib/misc.php');
if(1==$output){
	if(isset($current_page)) $current_page = ' | '.$current_page;
	$template['index'] = new template('index');
	$template['index']->replace_tags(array(
		'current_page' => $current_page,	
		'javascript_on_load' => $javascript_on_load,
		'misc' => $template["misc"]->template_return(),
		));
	$template['index'] ->template_output();
} else {
	$template['misc'] ->template_output();
}
?>