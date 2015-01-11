<?php 

// get route from request URI, e.g. /foo/bar/1 -> array('foo','bar','1')
function get_route() {
  $requestURI = explode('/', $_SERVER['REQUEST_URI']);
  $scriptName = explode('/', $_SERVER['SCRIPT_NAME']);
  for ($i = 0; $i < sizeof($scriptName); $i++)
    if ($requestURI[$i] === $scriptName[$i])
      unset($requestURI[$i]);
  $route = array_values($requestURI);
  if (empty($route[0]))
    $route = array('home');
  return $route;
}

?>