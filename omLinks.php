<?php
/*
Plugin Name: omLinks
Description: Replace urls in post to links
Version: 1.0
Author: Roman Ozana <ozana@omdesign.cz>
Author URI: http://www.omdesign.cz/
*/
class omLinks {
  
  public function __construct() {
    add_filter('the_content', array(&$this, 'processContent'), 9);
  }

  /**
   * @param string $content
   * @return string mixed
   */
  public function processContent($content) {
    return preg_replace_callback(
      '#(?<=^|[\s([<:\x17])((?:https?://|ftp://)(?:www\.|)([0-9.A-Za-z\x{C0}-\x{2FF}\x{370}-\x{1EFF}-][/\dA-Za-z\x{C0}-\x{2FF}\x{370}-\x{1EFF}+\.~%&?@=_:;\#,\x{ad}-]{1,1000}[/\dA-Za-z\x{C0}-\x{2FF}\x{370}-\x{1EFF}+~%?@=_\#]))#u',
      array($this, 'processUrl'),
      $content
    );
  }

  /**
   * @param $matches
   * @return string
   */
  public function processUrl($matches) {
    $url = reset($matches);
    return sprintf('<a href="%s" title="" rel="nofolow" class="auto">%s</a>', $url, $url);
  }
}

$omLinks = new omLinks();