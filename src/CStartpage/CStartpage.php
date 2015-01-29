<?php 

// CStartpage.php 

// Some functions to return data to the first page. 

class CStartpage {
	private $db;

	public function __construct($db) {
		$this->db = new CDatabase($db);
	}

	public function getLatestVideos() {
		$sql = "SELECT v.*, u.acronym FROM video AS v JOIN user AS u ORDER BY v.created DESC LIMIT 0, 20";
		$res = $this->db->ExecuteSelectQueryAndFetchAll($sql);
		// echo '<pre>';
		// print_r($res);
		// echo '</pre>';
		$html = "<div id='rolling-videos'>\n";
		$html .= "<div id='slide'>\n";
		foreach($res as $video) {
			$html .= "<div class='rolling-video'><figure><a href='video.php?v=" . $video->url . "'><img class='thumbnail' src='img.php?src={$video->src}png&amp;width=100' alt='' /></a><figcaption class='small grey'>" . $video->title. "</figcaption></figure></div>\n";
		}
		$html .= "</ul>\n";
		$html .= "</div>\n";
		return $html;
	}
}