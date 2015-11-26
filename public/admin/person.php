<?php
require_once('../../init.php');

class Person extends \Controllers\Controller {
	public function get() {
		$token = $_GET['token'];
		$id = $_GET['id'];
		$conn = new \Conn();
		$auth = \Models\Auth::get($conn, $token);
		if ($auth['scope'] == 'sudo') {
			$person = \Models\People::get($conn, $id);
			
			$stmt = $conn->prepare("SELECT * FROM `talks` WHERE `person_id`=?");
			$stmt->execute(array($id));
			$talks = $stmt->fetchAll(\PDO::FETCH_ASSOC);
			
			$sessions = \Models\Sessions::all_with_id_as_key($conn);

			$this->smarty->assign('person', $person);
			$this->smarty->assign('talks', $talks);
			$this->smarty->assign('token', $token);
			$this->smarty->assign('sessions', $sessions);
			$this->smarty->display('admin/person.edit.tpl');
		} else {
			throw new \UnauthorizedException();
		}
	}
	public function patch() {
		$token = $_GET['token'];
		$id = $_GET['id'];
		$conn = new \Conn();
		$logger = new \Models\Logging($conn, $_SERVER);
		$auth = \Models\Auth::get($conn, $token);
		if ($auth['scope'] == 'sudo') {
			$first_name = $_POST['first_name'];
			$last_name = $_POST['last_name'];
			$email = $_POST['email'];
			$occupation = $_POST['occupation'];
			$resume = $_POST['resume'];
			$room = $_POST['room'];
			\Models\People::update_($conn, $id, $first_name, $last_name, $email, $occupation, $resume, $room);
			
			$logger->info('person.update', json_encode(array('id' => $id, 'operator' => 'sudo')));

			header('Location: person.php?token=' . $token . '&id=' . $id . '&mode=edit');
		} else {
			throw new \UnauthorizedException();
		}
	}
	/*
	 * 新增一個 person
	 * 根據 session 決定是否新增預設的空白talk
	 */
	public function post() {
		$token = $_GET['token'];
		$conn = new \Conn();
		$logger = new \Models\Logging($conn, $_SERVER);
		$auth = \Models\Auth::get($conn, $token);
		
		if ($auth['scope'] == 'sudo') {
			$session    = $_POST['session'];
			$first_name = $_POST['first_name'];
			$last_name  = $_POST['last_name'];
			$email      = $_POST['email'];
			try {
				if (empty($first_name) || empty($last_name)) {
					throw new \Exception('Name is required');
				}
				// 插入 person
				$person_id = \Models\People::insert($conn, $first_name, $last_name, $email);

				// 產生密碼(token), 加入至 `Auth` 中
				$auth_token = self::generatorPassword(8);
				\Models\Auth::insert($conn, 'people', $person_id, $auth_token);

				// 插入新的 talk
				if ($session == 'Plenary' || $session == 'Parallel' || $session == 'Poster') {
					$stmt = $conn->prepare("INSERT INTO `talks` (`person_id`, `session`, `session_id`) VALUES (?,?,?)");
					$stmt->execute(array($person_id, $session, 0));
				}

				$logger->info('person.create', json_encode(array('id' => $person_id, 'operator' => 'sudo')));

			} catch (\Exception $e) {
			}
			header('Location: ' . TOP . '/admin/people.php?token='.$token);
		} else {
			throw new \UnauthorizedException();
		}
	}
	private function generatorPassword($password_len) {
		$password = '';
		$word = 'abcdefghijkmnpqrstuvwxyzABCDEFGHIJKLMNPQRSTUVWXYZ23456789';
		$len = strlen($word);
		for ($i = 0; $i < $password_len; $i++) {
			$password .= $word[rand() % $len];
		}
		return $password;
	}
	public function delete() {
		$token = $_GET['token'];
		$conn = new \Conn();
		$logger = new \Models\Logging($conn, $_SERVER);
		$auth = \Models\Auth::get($conn, $token);
		if ($auth['scope'] == 'sudo') {
			$person_id = $_GET['person_id'];
			\Models\People::delete($conn, $person_id);
			
			$logger->info('person.delete', json_encode(array('id' => $person_id, 'operator' => 'sudo')));

			header('Location: ' . TOP . '/admin/people.php?token='.$token);
		} else {
			throw new \UnauthorizedException();
		}
	}
}
new Person;
