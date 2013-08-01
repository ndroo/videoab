<?php

// Modify include path to include path to library
ini_set('include_path', ini_get('include_path') . PATH_SEPARATOR . '../libs');

require_once('Zend/Loader.php');
Zend_Loader::loadClass('Zend_Db');
Zend_Loader::loadClass('Zend_Db_Table');
Zend_Loader::loadClass('Zend_Form');
Zend_Loader::loadClass('Zend_Form_Element_Select');
Zend_Loader::loadClass('Zend_View');
Zend_Loader::loadClass('Zend_Filter_Input');
Zend_Loader::loadClass('Zend_Validate_EmailAddress');
Zend_Loader::loadClass('Zend_Validate_Identical');
Zend_Loader::loadClass('Zend_Validate_StringLength');
Zend_Loader::loadClass('Zend_Validate_Hostname');
Zend_Loader::loadClass('Zend_Session');
Zend_Loader::loadClass('Zend_Session_Namespace');
Zend_Loader::loadClass('Zend_Locale');

// Create the Smarty object
require('Smarty/Smarty.class.php');
$smarty = new Smarty();
$smarty->template_dir = '../public_templates/';
$smarty->compile_dir = '../public_templates_c/';
$smarty->config_dir = '../config/';
$smarty->cache_dir = '../public_cache/';

// Include configuration settings
require('../config/settings.php');

//create the vab database object
include("vab/database.class.php");

//create database object if not already existing
if (!isset($GLOBALS['db'])) {
	    $GLOBALS['db'] = new Database();
}

