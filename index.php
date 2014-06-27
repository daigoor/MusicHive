<?php
header('P3P: CP="IDC DSP COR ADM DEVi TAIi PSA PSD IVAi IVDi CONi HIS OUR IND CNT"');
include('includes/db.php');
include('functions/fb.php');
include('functions/functions.php');
?>
<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">
    <link rel="icon" href="../../favicon.ico">

    <title>Just A Weird App</title>

    <!-- Bootstrap core CSS -->
    <link href="css/bootstrap.min.css" rel="stylesheet">

    <!-- Custom styles for this template -->
    <link href="css/style.css" rel="stylesheet">

    <!-- HTML5 shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!--[if lt IE 9]>
      <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
      <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->
  </head>

  <body>

    <div class="container">
     <?php echo $_SESSION['fbid']; ?>
     <?php $q = get_playlists_friends($mysqli,1); ?>
<?php  while ($row = mysqli_fetch_assoc($q)) {
 var_dump($row);
}?>
      <div class="jumbotron">
        <h1>Just A Weird App</h1>
        <?php  $videos  = get_friend_youtube($_SESSION['session'],"10154268085775048");?>
        <p>
       <div id="player"></div>
        <script>
          var tag = document.createElement('script');
          tag.src = "https://www.youtube.com/iframe_api";
          var firstScriptTag = document.getElementsByTagName('script')[0];
          firstScriptTag.parentNode.insertBefore(tag, firstScriptTag);
          var player;
          function onYouTubePlayerAPIReady() {
            player = new YT.Player('player', {
              height: '390',
              width: '640',
             loadPlaylist:{
                listType:'playlist',
                index:parseInt(0),
                suggestedQuality:'small'
             },
              events: {
                'onReady': onPlayerReady,
                'onStateChange': onPlayerStateChange
              }
            });
          }
          function onPlayerReady(event) {
            event.target.loadPlaylist([<?php echo '"'.implode('","',  $videos ).'"' ?>]);
          }
          var done = false;
          function onPlayerStateChange(event) {
            if (event.data == YT.PlayerState.PLAYING && !done) {
             // setTimeout(stopVideo, 60000);
              done = true;
            }
          }
          function stopVideo() {
            player.stopVideo();
          }
        </script>
        </p>
        <p><a class="btn btn-lg btn btn-primary" href="<?php echo $loginUrl;?>" role="button">Login</a></p>
      </div>

     


    </div> <!-- /container -->


    <!-- Bootstrap core JavaScript
    ================================================== -->
    <!-- Placed at the end of the document so the pages load faster -->
  </body>
</html>