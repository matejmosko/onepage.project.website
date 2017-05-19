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

function show_google_form($url,$formid,$formtitle,$nextquiz){
    echo '<h2 id="'.$formid.'">'.$formtitle.'</h2>';
    $gform = get_google_form($url);

    $dom = new DOMDocument();
$dom->loadHTML($gform['content']); // Returned $data from CURL request

    $forms = $dom->getElementsByTagName('form');

    foreach($forms as $form){
    $content = $dom->saveHTML($form);
    }
    echo $content;
    $next = filter_events('next');
echo '<p class="small-img"><img src="events/'.$next[0].'/img.jpg" /></p>';
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
    if (strtotime($date) >= time()) $next_events[] = $event;
    if (strtotime($date) < time()) $past_events[] = $event;
  }
  if ($filter == 'next') return $next_events;
  if ($filter == 'past') return $past_events;

}

function render_events($filter){
  $events = filter_events($filter);
  foreach ($events as $event){
    $path = 'events/'.$event.'/';
echo '<h2 id="najblizsia-hra">Kedy a kde</h2>';
echo '<div class="event">';
    render_file($path.'event.md');
    echo '<img src="'.$path.'img.jpg" />';
    echo '</div>';
  }
}
?>
