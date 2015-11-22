<?php
require_once('../../init.php');

class Sessions extends \Controllers\Controller {
	public function get() {
		$token = $_GET['token'];
		$conn = new \Conn();
		$auth = \Models\Auth::get($conn, $token);
		if ($auth['scope'] == 'sudo') {
			$sessions = \Models\Sessions::all($conn);

			foreach ($sessions as &$session) {
				$session['title'] = \Models\Sessions::get_property($conn, $session['id'], 'title');
				$session['abbreviation'] = \Models\Sessions::get_property($conn, $session['id'], 'abbreviation');
				$session['organizers'] = \Models\Sessions::get_properties($conn, $session['id'], 'organizer');
				foreach ($session['organizers'] as &$organizer) {
					$organizer['content'] = \Models\People::get($conn, $organizer['value']);
				}
				$session['speakers'] = \Models\Sessions::get_people($conn, $session['id']);
			}
			$this->smarty->assign('sessions', $sessions);
			$this->smarty->assign('token', $token);
			$this->smarty->display('admin/sessions.html');
		} else {
			throw new \UnauthorizedException();
		}
	}
}
new Sessions;
