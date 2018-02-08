<?php 
require_once "vendor\autoload.php";
use DirUtils\Walker;

class foobar extends Walker
{
  function action($rel,$full)
  {
    if(basename($rel)!='package.json') return;
    $json=json_decode(file_get_contents($full));
    if(@$json->main)
      echo dirname($full).'/'.$json->main,"\n";
  }
}

$foobar=new foobar();
$foobar->walk('node_modules');
