<?php
session_start();
define('ROOT', __DIR__);
require_once(ROOT . '/db.php');
require_once(ROOT . '/libs/Smarty.class.php');

function my_autoloader($class) {
	include(strtolower(str_replace("\\", "/", $class)) . '.php');
}
spl_autoload_register('my_autoloader');

/*
 * Web path
 */
if (__DIR__ == '/var/www/lecospa.test.mar98.tk') {
	define('TOP', 'http://lecospa.test.mar98.tk/');
} else {
	define('TOP', 'http://lecospa.ntu.edu.tw/symposium/2015/');
}

class View {
	function set_smarty() {
		$this->smarty = new Smarty;
		$this->smarty->template_dir = ROOT . '/templates/';
		$this->smarty->compile_dir  = ROOT . '/templates_c/';
		//$this->smarty->config_dir   = ROOT . '/configs/';
		$this->smarty->cache_dir    = ROOT . '/cache/';
		//$this->smarty->caching = true;
	}
	function View() {
		$this->set_smarty();
		
		/* Implement self define HTTP Method */
		if (array_key_exists('method', $_POST) && $_POST['method'] == 'POST') {
			$this->method = 'POST';
			method_exists($this, 'post') && $this->post();
		} else {
			$this->method = 'GET';
			method_exists($this, 'get') && $this->get();
		}
	}
}
