<?php
global $_LG;
$output=1;
if(empty($_GET['action'])) {
	$current_page = $_LG['index_menu1.1'];
	$template['misc'] = new template('home');
} elseif('documents'==$_GET['action']){
	$current_page = $_LG['index_menu1.2'];
	$template['misc'] = new template('documents');
} elseif('404'==$_GET['action']){
	$template['misc'] = new template('404');
} elseif('preface'==$_GET['action']){
	$current_page = $_LG['index_menu2.1'];
	$template['misc'] = new template('preface');
} elseif('css'==$_GET['action']){
	$current_page = $_LG['index_menu2.2'];
	$template['misc'] = new template('css');
} elseif('javascript'==$_GET['action']){
	$current_page = $_LG['index_menu2.3'];
	$template['misc'] = new template('javascript');
} elseif('php'==$_GET['action']){
	$current_page = $_LG['index_menu2.4'];
	$template['misc'] = new template('php');
	$template['misc']->replace_tags(array(
		'ip' => $_SERVER['REMOTE_ADDR']
		));
} elseif('mysql'==$_GET['action']){
	$current_page = $_LG['index_menu2.5'];
	$template['misc'] = new template('mysql');
} elseif('revision'==$_GET['action']){
	$current_page = $_LG['index_menu2.6'];
	$template['misc'] = new template('revision');
} elseif('test'==$_GET['action']){
	$current_page = 'test';
	$template['misc'] = new template('test');
} elseif('journal1'==$_GET['action']){
	$current_page = 'Premier journal';
	$template['misc'] = new template('journal1');
} elseif('journal2'==$_GET['action']){
	$current_page = 'Deuxième journal';
	$template['misc'] = new template('journal2');
} elseif('journal3'==$_GET['action']){
	$current_page = 'Troisième journal';
	$template['misc'] = new template('journal3');
} elseif('journal4'==$_GET['action']){
	$current_page = 'Quatrième journal';
	$template['misc'] = new template('journal4');
}
if(!isset($template['misc']) & !empty($_GET['action'])){
	header('location:'.$_config['complete_url'].$set_lang.'404.html');
	exit();
}
?>
