<?php 
require_once "vendor\autoload.php";
use DirUtils\Walker;

class ScriptSrc extends Walker
{
  function __construct() {
    $this->echo=false;
    $this->retbuf='';
  }

  function action($rel)
  {
    echo "pass $rel\n";
    if(basename($rel)!='package.json') return false;
    $json=json_decode(file_get_contents($this->full));
    if(@$json->main) {
      $jsfn=dirname($this->full).'/'.$json->main;
      $jsstr="<script src=\"$jsfn\"></script>";
      if($this->echo)
        echo $jsstr,"\n";
      else
        $this->retbuf.=$jsstr;
    }
  }

  function printheaders()
  {
    foreach(array('node_modules','bower_modules') as $dn) {
      $fn="{$dn}_autoload_cached.html";
      if(is_file($fn))
        $mtime=filemtime($fn);
      if(is_dir($dn)) {
        $ctime=filectime($dn);
        
      }
    }
  }

  function echo()
  {
    $this->echo=true;
    foreach(array('node_modules','bower_modules') as $dn)
      $this->walk($dn);
  }
}

$ss=new ScriptSrc();
//$ss->printheaders();

$ss->echo();


