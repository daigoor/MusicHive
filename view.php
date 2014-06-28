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
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>MusicHive</title>

    <!-- Bootstrap Core CSS -->
    <link href="http://netdna.bootstrapcdn.com/bootstrap/3.0.3/css/bootstrap.min.css" rel="stylesheet" type="text/css">

    <!-- Fonts -->
    <link href="http://netdna.bootstrapcdn.com/font-awesome/4.0.3/css/font-awesome.min.css" rel="stylesheet" type="text/css">
    <link href='http://fonts.googleapis.com/css?family=Lora:400,700,400italic,700italic' rel='stylesheet' type='text/css'>
    <link href='http://fonts.googleapis.com/css?family=Montserrat:400,700' rel='stylesheet' type='text/css'>

    <!-- Custom Theme CSS -->
    <link href="css/grayscale.css" rel="stylesheet">
    <link href="css/select2.css" rel="stylesheet">

</head>

<body id="page-top" data-spy="scroll" data-target=".navbar-custom">
        <script src="https://connect.facebook.net/en_US/all.js"></script>
    <nav class="navbar navbar-custom navbar-fixed-top" role="navigation">
        <div class="container">
            <div class="navbar-header page-scroll">
                <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-main-collapse">
                    <i class="fa fa-bars"></i>
                </button>
                <a class="navbar-brand" href="#page-top">
                    <i class="fa fa-play-circle"></i>  <span class="light">Music</span> Hive
                </a>
            </div>

            <!-- Collect the nav links, forms, and other content for toggling -->
            <div class="collapse navbar-collapse navbar-right navbar-main-collapse">
                <ul class="nav navbar-nav">
                    <!-- Hidden li included to remove active class from about link when scrolled up past about section -->
                    <li class="hidden">
                        <a href="#page-top"></a>
                    </li>
                    <li class="page-scroll">
                        <a href="#start">Create Play List</a>
                    </li>
                    <li>
                        <a href="#" onclick="javascript:invite_friends();return false;">Bring Your Friends</a>
                    </li>

                </ul>
            </div>
            <!-- /.navbar-collapse -->
        </div>
        <!-- /.container -->
    </nav>

    <section class="intro">
        <div class="intro-body">
            <div class="container">
                <div class="row">
                    <div class="col-md-8 col-md-offset-2">
                        <div class="row">
                            <div class="col-md-9">
                                 <div id="player"></div>
                            </div>
                            <div class="col-md-3">
                                <div class="panel panel-default">
                                  <div class="panel-heading">Your playlists</div>
                                  <div class="panel-body">
                                  <?php $playlists = get_playlists($mysqli); ?>
                                    <?php foreach ($playlists as $playlist): ?>
                                     <button type="button" class="btn btn-default btn-block select_playlist" name="<?php echo $playlist['id'];?>"><?php
                                     echo $playlist['name'];?>
                                    </button>
                                    <?php endforeach ?>
                                  </div>
                                </div>
                            </div>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </section>

    <section id="start" class="container content-section text-center">
        <div class="row">
        <form id="playlist-form" method="post" action="#">
            <div class="col-lg-8 col-lg-offset-2">
                <h2>Name it</h2>
                <input type="text" style="width:300px;min-height: 26px;" id="name" name="name"/>
                <h2>Choose Your friends</h2>
                <input type="hidden" id="select" name="friends[]"/>
                <input type="hidden" id="action" name="action" value="save"/>
                <p></p>
                <ul class="list-inline banner-social-buttons">
                    <li><button id="save-btn" class="btn btn-default btn-lg"><i class="fa fa-save fa-fw"></i> <span class="network-name">Save</span></button>
                    </li>
                </ul>
                <div id="message" style="display:none;">Saved...</div>
                <div id="loading" style="display:none;"><i class="fa fa-spinner fa-spin"></i> </div>
            </div>
            </form>
        </div>
    </section>

    <div id="map"></div>

    <!-- Core JavaScript Files -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.10.2/jquery.min.js"></script>
    <script src="http://netdna.bootstrapcdn.com/bootstrap/3.0.3/js/bootstrap.min.js"></script>
    <script src="http://cdnjs.cloudflare.com/ajax/libs/jquery-easing/1.3/jquery.easing.min.js"></script>

    <!-- Google Maps API Key - You will need to use your own API key to use the map feature -->
    <script type="text/javascript" src="https://maps.googleapis.com/maps/api/js?key=AIzaSyCRngKslUGJTlibkQ3FkfTxj3Xss1UlZDA&sensor=false"></script>

    <!-- Custom Theme JavaScript -->
    <script src="js/grayscale.js"></script>

    <script src="js/select2.js"></script>
    <script type="text/javascript">
    $(document).ready(function () {
        $( "#save-btn" ).click(function(event) {
            event.preventDefault();
            $.ajax({
            dataType: "JSON",
            type:"POST",
            url:"ajax.php",
            data:$('#playlist-form').serialize(),
            beforeSend : function(data){
                $("#loading").show();
                $("#message").hide();
            }
            ,
            success: function(data)
            {
               if(data.saved){
                  $("#loading").hide();
                  $("#message").show();
               }
            }
        });
        });
    });
    </script>
    <script>
      $(function(){

        // display logs
        function log(text) {
          $('#logs').append(text + '<br>');
        }

        $('#select').select2({
            data:[
            <?php $friends = get_friends(); ?>
                <?php foreach ($friends as $friend) { ?>
                    <?php $friend = (array)$friend; ?>
                {id:<?php echo $friend['id'];?>,text:"<?php echo $friend['name'];?>"},
              <?php  } ?>

            ],
            multiple: true,
            width: "300px"
        })


      });
    </script>

      <script>


          var tag = document.createElement('script');
          tag.src = "https://www.youtube.com/iframe_api";
          var firstScriptTag = document.getElementsByTagName('script')[0];
          firstScriptTag.parentNode.insertBefore(tag, firstScriptTag);
          var player;
          function onYouTubePlayerAPIReady() {
            player = new YT.Player('player', {
              height: '390',
              width: '100%',
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
      <script>
      FB.init({
        appId: '264080490446089',
        frictionlessRequests: true
      });

      
      function invite_friends() {
        FB.ui({method: 'apprequests',
          message: 'Dude, I need your music'
        }, requestCallback);
      }
      function requestCallback(response) {
      }
        </script>
</body>

</html>
