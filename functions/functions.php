<?php 
require_once('Facebook/HttpClients/FacebookHttpable.php');
require_once('Facebook/HttpClients/FacebookCurl.php');
require_once('Facebook/HttpClients/FacebookCurlHttpClient.php');

// added in v4.0.0

require_once('Facebook/Entities/AccessToken.php');
require_once('Facebook/Entities/SignedRequest.php');

require_once('Facebook/FacebookSession.php');
require_once('Facebook/FacebookRedirectLoginHelper.php');
require_once('Facebook/FacebookRequest.php');
require_once('Facebook/FacebookResponse.php');
require_once('Facebook/FacebookSDKException.php');
require_once('Facebook/FacebookRequestException.php');
require_once('Facebook/FacebookOtherException.php');
require_once('Facebook/FacebookAuthorizationException.php');


require_once('Facebook/GraphObject.php');
require_once('Facebook/GraphSessionInfo.php');

// added in v4.0.5
use Facebook\HttpClients\FacebookHttpable;
use Facebook\HttpClients\FacebookCurl;
use Facebook\HttpClients\FacebookCurlHttpClient;

// added in v4.0.0
use Facebook\FacebookSession;
use Facebook\FacebookRedirectLoginHelper;
use Facebook\FacebookRequest;
use Facebook\FacebookResponse;
use Facebook\FacebookSDKException;
use Facebook\FacebookRequestException;
use Facebook\FacebookOtherException;
use Facebook\FacebookAuthorizationException;
use Facebook\GraphObject;
use Facebook\GraphSessionInfo;

function get_friends(){
	$session = $_SESSION['session'];
	$request     = new FacebookRequest($session, 'GET', '/me/friends?limit=10');
    $response   = $request->execute();
    $friends      = $response->getGraphObject()->asArray();
    return $friends['data'];
}

function get_friend_youtube($user_id,$method="feed",$filter="link",$limit="1000"){
	$session = $_SESSION['session'];
	$request  = new FacebookRequest($session, 'GET', "/$user_id/feed?fields=$filter&limit=$limit");
	$response = $request->execute();
	$links    = $response->getGraphObject()->asArray();
	$videos = array();
	foreach ($links['data'] as $link) {
		$link = (array)$link;
		if(isset($link[$filter])){
			if($id = get_youtube_id(@$link[$filter])){
				$videos [] = $id;
			}
		}
	}
	return $videos;
}

function get_youtube_id($link){
	$videos ="";
	if (preg_match('/youtube\.com\/watch\?v=([^\&\?\/]+)/', $link, $id)) {
	    $videos = $id[1];
	} else if (preg_match('/youtube\.com\/embed\/([^\&\?\/]+)/', $link, $id)) {
	    $videos = $id[1];
	} else if (preg_match('/youtube\.com\/v\/([^\&\?\/]+)/', $link, $id)) {
	    $videos = $id[1];
	} else if (preg_match('/youtu\.be\/([^\&\?\/]+)/', $link, $id)) {
	    $videos = $id[1];
	} else {
	}
	return $videos;
}

function get_playlists_friends($mysqli,$playlist_id){
	$user_id = $_SESSION['fbid'];
	if ($stmt = $mysqli->query("SELECT user_playlist.friend_id FROM playlists,user_playlist  WHERE playlists.user_id ='{$user_id}' AND user_playlist.user_id = '{$user_id}' AND playlists.id = '{$playlist_id}' ")) {
	    return $stmt;

	}
	return FALSE;
}

function get_playlists($mysqli){
	$user_id = $_SESSION['fbid'];
	if ($stmt = $mysqli->query("SELECT playlists.id,playlists.name FROM playlists  WHERE playlists.user_id ='{$user_id}'")) {
	    return $stmt;

	}
	return FALSE;
}

function new_playlist($mysqli,$name){
	$user_id = $_SESSION['fbid'];
	if ($insert_stmt = $mysqli->prepare("INSERT INTO playlists (name,user_id) VALUES (?,?)")) {
        $insert_stmt->bind_param('ss', $name, $user_id);
        $insert_stmt->execute();
        return $insert_stmt->insert_id;
    } else {
        return FALSE;
    }

    return FALSE;
}
function create_playlist($mysqli, $playlist_id, $users) {
	$user_id = $_SESSION['fbid'];
	$query = "INSERT INTO user_playlist (user_id,playlist_id,friend_id) VALUES (?,?,?)";
	$stmt = $mysqli->prepare($query);
	$stmt ->bind_param("sis", $user_id,$playlist_id,$user);
	$mysqli->query("START TRANSACTION");
	foreach ($users as $user) {
	    $stmt->execute();
	}
	$stmt->close();
	$mysqli->query("COMMIT");
    return FALSE;
}