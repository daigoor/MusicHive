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