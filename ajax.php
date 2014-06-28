<?php
if(!empty($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest') {
	include("includes/db.php");
	include("functions/functions.php");
	include('functions/fb.php');
	switch ($_POST['action']) {
		case 'save':
			$playlist_id = new_playlist($mysqli,$_POST['name']);
			create_playlist($mysqli,$playlist_id,$_POST['friends']);
			$json = array('saved'=>true);
			break;
		case 'select-playlist':
			$playlist_friends = get_playlists_friends($mysqli, $_POST['id']);
			while($row = mysqli_fetch_assoc($playlist_friends)) {
				$json[] = get_friend_youtube($row['friend_id']);
			}
			$json = array_merge($json[0],$json[1]);

		break;
		default:
		break;
	}
	header('Content-Type: application/json; charset=utf-8');
	echo json_encode($json);
}
else{
	echo "STOP HACKING";
}
?>