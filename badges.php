<?php 
include_once('Connection.php');
class Profile
{
	private $_userData = [];
	public function getUserById($userid)
	{
		if (!isset($this->_userData[$userid])) {
			$connection = Connection::get();
			$query = $connection->query("SELECT * FROM users WHERE id ='" . $connection->real_escape_string($userid) . "'");
			if ($query->num_rows > 0) {
				$user_var = $query->fetch_object();
				$this->_userData[$userid] = $user_var;
			}
		}
		return $this->_userData[$userid];
	}
	public function getUserBadges($userid)
	{
		$connection = Connection::get();
		$query = $connection->query("SELECT * FROM badges WHERE userid = '" . $connection->real_escape_string($userid) . "'");
		$result = [];
		while ($badges_row = $query->fetch_object()) {
			$badges = new Badges($badges_row);
			$result[] = $badges;
		}
		return $result;
	}
}
class Badges
{
	private $_row;
	public function __construct($row)
	{
		$this->_row = $row;
	}
	public function getBadge()
	{
		return $this->_row->badgeimg;
	}
	public function getBadgeDesc()
	{
		return $this->_row->badgedesc;
	}
}