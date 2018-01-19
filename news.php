<?php


include_once('Connection.php');


session_start();


class NewsFactory
{


	public function getById($news_id)
	{
		$connection = Connection::get();


		$query = $connection->query("SELECT * FROM `article` WHERE id = '" . $connection->real_escape_string($news_id) . "'");
		if ($query->num_rows > 0) {
			$news_row = $query->fetch_object();
			return new News($news_row);
		}


		return null;
	}


	public function getLatestNews()
	{
		$connection = Connection::get();


		$query = $connection->query("SELECT * FROM `article`");
		$result = [];
		while ($news_row = $query->fetch_object()) {
			$news = new News($news_row);
			$result[] = $news;
		}


		return $result;
	}


}


class News
{


	private $_row;


	public function __construct($row)
	{
		$this->_row = $row;
	}


	public function getId()
	{
		return $this->_row->id;
	}


	public function getTitle()
	{
		return $this->_row->title;
	}


	public function getSubText()
	{
		return $this->_row->subtext;
	}


	public function getMainText()
	{
		return $this->_row->maintext;
	}


	public function getAuthorName()
	{
		return $this->_row->authorname;
	}


	public function getAuthorAvatar()
	{
		return $this->_row->authoravatar;
	}


	public function getAuthorAge()
	{
		return $this->_row->authorage;
	}


	public function getAuthorText()
	{
		return $this->_row->authortext;
	}


	public function getImage()
	{
		return $this->_row->newsimg;
	}


	public function getDate()
	{
		return $this->_row->date;
	}




	public function addComment($comment)
	{


		$connection = Connection::get();


		if (isset($_SESSION['username'], $_SESSION['password'])) {
			if (!empty($comment)) {
				$commentquery = $connection->query("INSERT INTO article_comments (username, comment, news_id) VALUES ('" . $_SESSION['username'] . "', '" . $comment . "', '" . $this->_row->id . "')");
			}
		} else {
			echo "spast";
		}


	}


	public function getComments()
	{
		$connection = Connection::get();


		$commentsquery = $connection->query("SELECT * FROM article_comments WHERE news_id = '" . $connection->real_escape_string($this->_row->id) . "' ORDER BY id DESC");


		$comments = [];
		while ($row = $commentsquery->fetch_object()) {
			$comments[] = $row;
		}


		return $comments;


	}


}