<?php include "functions.php"; ?>
<!doctype html>
<html lang="sk" ng-app>

<head>
    <meta charset="utf-8">

    <title><?php echo $vars['title']?></title>
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
    <?php render_menu($menu); ?>
    <div id="wrapper">
      <?php
      render_file('op-main.md');
      render_events('next');
      render_file('op-more.md');
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
