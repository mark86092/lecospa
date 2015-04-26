<?php
namespace Models;

class ISpeakers {
	function all($conn) {
		$stmt = $conn->prepare("SELECT `name`, `email`, `slide_file`, `title`, `abstract` FROM `ispeakers`");
		$stmt->execute();
		//$stmt->store_result();
		$stmt->bind_result($name, $email, $slide_file, $title, $abstract);
		$data = array();
		while ($stmt->fetch()) {
			$data[] = array(
				'name' => $name,
				'email' => $email,
				'slide_file' => $slide_file,
				'title' => $title,
				'abstract' => $abstract
			);
		}

		$stmt->close();
		$conn->close();
		return $data;
	}
	function get($conn, $id) {
		$stmt = $conn->prepare("SELECT `name`, `email`, `title`, `slide_file` FROM `ispeakers` WHERE `id` = ?");
		$stmt->bind_param('s', $id);
		$stmt->execute();
		$stmt->bind_result($name, $email, $title, $slide_file);
		$data = null;
		if ($stmt->fetch()) {
			$data = array(
				'name' => $name,
				'email' => $email,
				'title' => $title,
				'slide_file' => $slide_file
			);
		}

		$stmt->close();
		$conn->close();
		return $data;
	}
	function update_slide_file($conn, $id, $slide_file) {
		$stmt = $conn->prepare("UPDATE `ispeakers` SET `slide_file` = ? WHERE `id` = ?");
		$stmt->bind_param('ss', $slide_file, $id);
		$stmt->execute();
		$stmt->close();
		$conn->close();
	}
}