<?php
date_default_timezone_set('America/Los_Angeles');
mysql_connect("localhost", "user", "pass") or die("error connect");
mysql_select_db("db");

$user = '';
$api = file_get_contents("http://gdata.youtube.com/feeds/api/users/" . $user . "/uploads?v=2&alt=jsonc&start-index=101&max-results=50");
$data = json_decode($api);
$data = $data->data->items;
//print_r($data);
foreach ($data as $key => $row) {
	$title = htmlspecialchars(addslashes($row->title));
	$description = htmlspecialchars(addslashes($row->description));
	$time = $row->uploaded;
	$thumb = $row->thumbnail->hqDefault;
	$view = $row->viewCount;
	$duration = $row->duration;

	$aaa = new DateTime($time);
	$dbtime = $aaa->format("Y-m-d");
	$datei = strtotime($dbtime);	
	$video = "http://www.youtube.com/watch?v=".$row->id;
	$sql = "INSERT INTO `table_videos`(server_id, video_type, title, description, player_type, active, category, thumb1, video, view, createdon, duration) 
	VALUES('2', 'youtube', '$title', '$description', 'Normal', 'Yes', '1', '$thumb', '$video' ,$view, $datei, $duration)";
	$q = mysql_query($sql);
	echo mysql_error();
}


$api = file_get_contents("http://vimeo.com/api/v2/uclaanderson/all_videos.json");

$data = json_decode($api);
//print_r($data); 
$data = $data;
//print_r($data);
foreach ($data as $key => $row) {
	$title = $row->title;
	$description = $row->description;
	$time = $row->upload_date;
	$thumb = $row->thumbnail_medium;
	$view = $row->stats_number_of_plays;
	$duration = $row->duration;

	$aaa = new DateTime($time);
	$dbtime = $aaa->format("Y-m-d");
	$datei = strtotime($dbtime);	
	$video = $row->url;
	$sql = "INSERT INTO `table_videos`(server_id, video_type, title, description, player_type, active, category, thumb1, video, view, createdon, duration) 
	VALUES('3', 'vimeo', '$title', '$description', 'Normal', 'Yes', '1', '$thumb', '$video' ,$view, $datei, $duration)";
	mysql_query($sql);
}

?>