<?php include "functions.php"; ?>
<!doctype html>
<html lang="sk" ng-app>

<head>
    <meta charset="utf-8">

    <title><?php echo $vars['title']?></title>
    <!--<script>
        (function (i, s, o, g, r, a, m) {
            i['GoogleAnalyticsObject'] = r;
            i[r] = i[r] || function () {
                (i[r].q = i[r].q || []).push(arguments)
            }, i[r].l = 1 * new Date();
            a = s.createElement(o),
                m = s.getElementsByTagName(o)[0];
            a.async = 1;
            a.src = g;
            m.parentNode.insertBefore(a, m)
        })(window, document, 'script', '//www.google-analytics.com/analytics.js', 'ga');

        ga('create', 'UA-62510970-1', 'auto');
        ga('send', 'pageview');
    </script>-->
    <meta name="description" content="<?php echo $vars['desc']?>">
    <meta name="author" content="<?php echo $vars['author']?>">
    <meta name="keywords" content="<?php echo $vars['keywords']?>">
    <!--[if IE]><link rel="shortcut icon" href="img/favicon.ico"><![endif]-->
    <link rel="icon" type="image/png" href="<?php echo $vars['favicon']?>" />
    <link rel="stylesheet" href="<?php echo $vars['style']?>">
<meta property="og:title" content="<?php echo $vars['title']?>" />
<meta property="og:type" content="<?php echo $vars['type']?>" />
<meta property="og:url" content="<?php echo $vars['url']?>" />
<meta property="og:image" content="<?php echo $vars['cover_dir'].$vars['next_quiz'].'jpg'?>" />
<meta property="og:description" content="<?php echo $vars['desc']?>" />
<meta property="fb:admins" content="<?php echo $vars['fb_admins']?>" />
<meta property="fb:app_id" content="<?php echo $vars['fb_appid']?>" />
<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.2.2/jquery.min.js"></script>
<link href="./css/slimbox2.css" rel="stylesheet">
<script src="./js/slimbox2.js"></script>
    <!--[if lt IE 9]>
  <script src="http://html5shiv.googlecode.com/svn/trunk/html5.js"></script>
  <![endif]-->
</head>
<body>
<!--<script>
  window.fbAsyncInit = function() {
    FB.init({
      appId      : '551176055061249',
      xfbml      : true,
      version    : 'v2.5'
    });
  };

  (function(d, s, id){
     var js, fjs = d.getElementsByTagName(s)[0];
     if (d.getElementById(id)) {return;}
     js = d.createElement(s); js.id = id;
     js.src = "//connect.facebook.net/en_US/sdk.js";
     fjs.parentNode.insertBefore(js, fjs);
   }(document, 'script', 'facebook-jssdk'));
</script>-->
    <?php render_menu($menu); ?>
    <div id="wrapper">
      <?php
      render_file('main.md');
      render_events('next');
      render_file('rules.md');
      ?>
    </div>
<div
  class="fb-like"
  data-share="true"
  data-width="450"
  data-show-faces="true">
</div>

</body>

</html>
