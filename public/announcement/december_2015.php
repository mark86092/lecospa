<?php
require_once('../../init.php');
class Index extends \Controllers\Controller {
	function get() {
		$this->smarty->assign('scope', __CLASS__);
		$this->smarty->display('announcement/december_2015.html');
	}
}
new Index;
