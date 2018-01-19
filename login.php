<?php
include_once('Connection.php');
class Login
{
	private $_errors = [
		"emptyerror" => "Bitte fülle alle Felder aus!",
		"loginerror" => "Dein Passwort oder dein Benutzername ist falsch, bitte korrigiere deine Angaben!"
	];
	public function __construct()
	{
		@session_start();
	}
	public function login($username, $password)
	{
		$connection = Connection::get();
		if (!empty($username) && !empty($password)) {
			$password = md5($password);
			$check = $connection->query("SELECT * FROM users WHERE username = '" . $connection->real_escape_string($username) . "' AND password = '" . $password . "'");
			if ($check->num_rows > 0) {
				$check = $check->fetch_object();
				if ($username == $check->username AND $password == $check->password) {
					$_SESSION["username"] = $check->username;
					$_SESSION["password"] = $check->password;
				}
			} else {
				echo $this->_errors["loginerror"];
			}
		} elseif (empty($username) || empty($password)) {
			echo $this->_errors["emptyerror"];
		}
	}
}
