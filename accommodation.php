<?php
require_once('init.php');
class Accommodation extends View {
	function get() {
		$this->smarty->assign('scope', __CLASS__);
		$this->smarty->display('accommodation.html');
	}
}
new Accommodation;
