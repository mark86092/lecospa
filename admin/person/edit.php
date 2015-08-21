<?php
namespace Admin\People;
require_once('../../init.php');

class Edit extends \View {
	public function get() {
		$token = $_GET['token'];
		$id = $_GET['id'];
		$conn = \db::get();
		$auth = \Models\Auth::get($conn, $token);
		if ($auth['scope'] == 'sudo') {
			$info = \Models\People::get($conn, $id);
			$this->smarty->assign('person', $info);
			$this->smarty->assign('token', $token);
			$this->smarty->assign('id', $id);
			$this->smarty->display('admin/person/edit.html');
		} else {
			$this->smarty->display('person/main-noauth.html');
		}
		$conn->close();
	}
	public function post() {
		$token = $_GET['token'];
		$id = $_GET['id'];
		$conn = \db::get();
		$auth = \Models\Auth::get($conn, $token);
		if ($auth['scope'] == 'sudo') {
			$first_name = $_POST['inputfirstname'];
			$last_name = $_POST['inputlastname'];
			$email = $_POST['inputemail'];
			$title = $_POST['inputtitle'];
			$abstract = $_POST['inputabstract'];
			$address_datetime = $_POST['inputaddressdatetime'];
			$occupation = $_POST['inputoccupation'];
			$resume = $_POST['inputresume'];
			$room = $_POST['inputroom'];
			$session_code = $_POST['inputsessioncode'];
			$type = $_POST['inputtype'];
			\Models\People::update_($conn, $id, $first_name, $last_name, $email, $title, $abstract, $address_datetime, $occupation, $resume, $room, $session_code, $type);

			$info = \Models\People::get($conn, $id);
			$this->smarty->assign('person', $info);
			$this->smarty->assign('token', $token);
			$this->smarty->assign('id', $id);
			$this->smarty->display('admin/person/edit.html');
		} else {
			$this->smarty->display('person/main-noauth.html');
		}
		$conn->close();
	}
}
new Edit;
