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
// init app with app id and secret
FacebookSession::setDefaultApplication(APPID, APPSECRET);

// login helper with redirect_uri
$helper = new FacebookRedirectLoginHelper('http://localhost/sw');

// see if a existing session exists
if (isset($_SESSION) && isset($_SESSION['fb_token_sw'])) {
    // create new session from saved access_token
    $session = new FacebookSession($_SESSION['fb_token_sw']);
    // validate the access_token to make sure it's still valid
    try {
        if (!$session->validate()) {
            $session = null;
        }
    }
    catch (Exception $e) {
        // catch any exceptions
        $session = null;
    }
    
} else {
    // no session exists
    
    try {
        $session = $helper->getSessionFromRedirect();
    }
    catch (FacebookRequestException $ex) {
        // When Facebook returns an error
    }
    catch (Exception $ex) {
    // When validation fails or other local issues
        echo $ex->getMessage();
    }
    
}

// see if we have a session
if (isset($session)) {
    $_SESSION['fb_token_sw'] = $session->getToken();
    $session = new FacebookSession($session->getToken());  
    $_SESSION['session'] = $session;  
    $request  = new FacebookRequest($session, 'GET', '/me');
    $response = $request->execute();
    $videos   = array();

    $user_profile     = $response->getGraphObject()->asArray();
    $_SESSION['fbid'] = $user_profile['id'];


   
    // foreach ($friends_list as $friend) {
    //     $friend   = (array) $friend;
    //     $request  = new FacebookRequest($session, 'GET', "/" . $friend['id'] . "/feed?fields=source&limit=1000");
    //     $response = $request->execute();
    //     $links    = $response->getGraphObject()->asArray();
    //     if (!empty($links['data'])) {
    //         foreach ($links['data'] as $link) {
    //             $link = (array) $link;
    //             if (!empty($link['source']) || isset($link['source'])) {
    //                 if (preg_match('/youtube\.com\/watch\?v=([^\&\?\/]+)/', $link['source'], $id)) {
    //                     $videos[] = $id[1];
    //                 } else if (preg_match('/youtube\.com\/embed\/([^\&\?\/]+)/', $link['source'], $id)) {
    //                     $videos[] = $id[1];
    //                 } else if (preg_match('/youtube\.com\/v\/([^\&\?\/]+)/', $link['source'], $id)) {
    //                     $videos[] = $id[1];
    //                 } else if (preg_match('/youtu\.be\/([^\&\?\/]+)/', $link['source'], $id)) {
    //                     $videos[] = $id[1];
    //                 } else {
    //                 }
    //             }
                
                
    //         }
    //     }
    //     $request  = new FacebookRequest($session, 'GET', "/" . $friend['id'] . "/links?fields=link&limit=1000");
    //     $response = $request->execute();
    //     $links    = $response->getGraphObject()->asArray();
    //     if (!empty($links['data'])) {
    //         foreach ($links['data'] as $link) {
    //             $link = (array) $link;
                
    //             if (!empty($link['link']) || isset($link['link'])) {
    //                 if (preg_match('/youtube\.com\/watch\?v=([^\&\?\/]+)/', $link['link'], $id)) {
    //                     $videos[] = $id[1];
    //                 } else if (preg_match('/youtube\.com\/embed\/([^\&\?\/]+)/', $link['link'], $id)) {
    //                     $videos[] = $id[1];
    //                 } else if (preg_match('/youtube\.com\/v\/([^\&\?\/]+)/', $link['link'], $id)) {
    //                     $videos[] = $id[1];
    //                 } else if (preg_match('/youtu\.be\/([^\&\?\/]+)/', $link['link'], $id)) {
    //                     $videos[] = $id[1];
    //                 } else {
    //                     // not an youtube video
    //                 }
    //             }
    //         }
            
            
            
            
    //     }
    // }
    
    
    
    
    
    
    $request     = new FacebookRequest($session, 'GET', '/me/likes/636247346470177');
    $response    = $request->execute();
    $graphObject = $response->getGraphObject()->asArray();
    if (isset($graphObject["data"])) {
        $like_count = count($graphObject["data"]);
        if ($like_count > 0)
            $fblike = true;
    } else {
        $fblike = false;
    }
    
    $loginUrl = $helper->getLoginUrl(array(
        'email',
        'user_friends',
        'user_likes',
        'read_stream'
    ));
    
    
    
    // print profile data
    
    //print logout url using session and redirect_uri (logout.php page should destroy the session)
    //echo '<a href="' . $helper->getLogoutUrl( $session, 'http://yourwebsite.com/app/logout.php' ) . '">Logout</a>';
    
    
} else {
    // show login url
    //echo '<a href="' . $helper->getLoginUrl( array( 'email', 'user_friends' ) ) . '">Login</a>';
    
    $loginUrl = $helper->getLoginUrl(array(
        'email',
        'user_friends',
        'user_likes',
        'read_stream'
    ));
}