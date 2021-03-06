<?php
/**
 * Get a web file (HTML, XHTML, XML, image, etc.) from a Google Forms.  Return an array containing the HTTP server response header fields and content.
 */

/** INCLUDES **/

include_once "libs/Parsedown.php";
include_once "libs/ParsedownExtra.php";
include_once "variables.php";
/** MENU **/



/** Funkcie **/

function get_google_form( $url )
{
    $options = array(
        CURLOPT_RETURNTRANSFER => true,     // return web page
        CURLOPT_HEADER         => false,    // don't return headers
        CURLOPT_FOLLOWLOCATION => true,     // follow redirects
        CURLOPT_ENCODING       => "",       // handle all encodings
        CURLOPT_USERAGENT      => "spider", // who am i
        CURLOPT_AUTOREFERER    => true,     // set referer on redirect
        CURLOPT_CONNECTTIMEOUT => 120,      // timeout on connect
        CURLOPT_TIMEOUT        => 120,      // timeout on response
        CURLOPT_MAXREDIRS      => 10,       // stop after 10 redirects
    );

    $ch      = curl_init( $url );
    curl_setopt_array( $ch, $options );
    $content = curl_exec( $ch );
    $err     = curl_errno( $ch );
    $errmsg  = curl_error( $ch );
    $header  = curl_getinfo( $ch );
    curl_close( $ch );

    $header['errno']   = $err;
    $header['errmsg']  = $errmsg;
    $header['content'] = $content;

    return $header;
}

function render_old_google_form($url,$formid,$formtitle){
    $content = '<h2 id="'.$formid.'">'.$formtitle.'</h2>';
    $gform = get_google_form($url);

    $dom = new DOMDocument();
$dom->loadHTML($gform['content']); // Returned $data from CURL request

    $forms = $dom->getElementsByTagName('form');

    foreach($forms as $form){
    $content .= $dom->saveHTML($form);
    }
    if (!empty(filter_events('next'))){ echo $content;};
}
function render_new_google_form($url,$formid,$formtitle,$height){
    $content = '<h2 id="'.$formid.'">'.$formtitle.'</h2>';
    $content .= '<iframe src="'.$url.'" width="760" height="'.$height.'" frameborder="0" marginheight="0" marginwidth="0">'.$strings['loading'].'</iframe>';
    if (!empty(filter_events('next'))){ echo $content;};

}

function render_menu($menuitems){
    $result = '<span id="menu-button"><a href="#menu"></a></span>';
    $result .= '<ul id="menu">';
    foreach ($menuitems as $item){
        $result .= '<li><a href="'.$item["link"].'" title="'.$item["desc"].'">'.$item["name"].'</a></li>';
    }
    $result .= '</ul>';
    echo $result;
}
function render_file($page){
  if (isset($_GET['page'])) $page = $_GET['page'];
  switch (true){
      case strpos($page,'.php'):
          include_once($page);
          break;
      case strpos($page,'.md'):
          $markdown = file_get_contents($page);
          $Parsedown = new ParsedownExtra();
          echo $Parsedown->text($markdown);
          break;
  }
}

function filter_events($filter){
  $next_events = array();
  $past_events = array();
  $list_events = scandir('events/');
  foreach (array_slice($list_events,2) as $event){
    $date = substr($event,0,10);
    //echo $date.'<br />';
    $today = strtotime(date('Y-m-d'));
    if (strtotime($date) >= $today) $next_events[] = $event;
    if (strtotime($date) < $today) $past_events[] = $event;
  }
  if ($filter == 'next') return $next_events;
  if ($filter == 'past') return $past_events;

}

function render_events($filter,$render_md,$sort){
  global $strings;
  $events = filter_events($filter);
  if ($sort == 'desc') {rsort($events);}
  if ($sort == 'asc') {sort($events);}
  if (!empty($events) && $filter == 'next'){ echo '<h2 id="najblizsia-hra">'.$strings['events_next'].'</h2>';}
  if (!empty($events) && $filter == 'past'){ echo '<h2 id="najblizsia-hra">'.$strings['events_past'].'</h2>';}
  foreach ($events as $event){
    $path = 'events/'.$event.'/';
    echo '<div class="event">';
    if (file_exists($path.'img.jpg')){echo '<img src="'.$path.'img.jpg" />';}
    if (file_exists($path.'event.md') && $render_md){render_file($path.'event.md');}
    if (!empty($events) && $filter == 'next') {echo '<p><a class="op-button" href="#registracia">'.$strings['register_to_event'].'</a></p>';}
    echo '</div>';
  }
}
function next_event_pic(){
  $events = filter_events('next');
  if (!empty($events)){ return 'events/'.$events[0].'/img.jpg';} else { return 'img/default-cover.jpg';}
}

function render_picfolder($path){
  if (file_exists($path.'/desc.md')){render_file($path.'/desc.md');}
  $pics = array_diff(scandir($path), array('..', '.','orig','desc.md'));
  natsort($pics);
  $pics = array_reverse($pics,true);
  foreach ($pics as $picture){
    $picname = preg_replace('/\\.[^.\\s]{3,4}$/', '', $picture);
    echo '<p class="archive"><a rel="lightbox-mudrosti" title="'.$picname.'" href="'.$path.'/'.$picture.'"><img src="'.$path.'/'.$picture.'" /></a></p>';
}
}
?>
