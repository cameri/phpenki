<?php
 $dir = $_GET["dir"];
 $count = 0;
 $dircount = 0;
 $filecount = 0;
 $dirs = null;
 $files = null;
 if($dir != "" && substr($dir,0,1) != "/"){
  if ($handle = opendir($dir)) {
   while (false !== ($file = readdir($handle))){
    if($file != "." && $file != ".."){
     if (is_dir($dir . $file)){
      $dirs[$dircount] = $file;
      $dircount++;
     }
     else{
      $files[$filecount] = $file;
      $filecount++;
     }
    }
   }
   if($dircount + $filecount > 0){
    echo("<branches>");
    if($dircount > 0){
     sort($dirs);
     for ($x = 0; $x < $dircount; $x++){
      echo("<branch>");
      echo("<name>" . $dirs[$x] . "</name>");
      echo("<type>folder</type>");
      if($dircount + $filecount == $count + 1){
       echo("<itype>el</itype>");
      }
      else{
       echo("<itype>tri</itype>");
      }
      echo("</branch>");
      $count++;
     }
    }
    if($filecount > 0){
     sort($files);
     for ($x = 0; $x < $filecount; $x++){
      echo("<branch>");
      echo("<name>" . $files[$x] . "</name>");
      echo("<type>file</type>");
      if($dircount + $filecount == $count + 1){
       echo("<itype>el</itype>");
      }
      else{
       echo("<itype>tri</itype>");
      }
      echo("</branch>");
      $count++;
     }
    }
    echo("</branches>");
   }
   closedir($handle);
  }
 }
 else{
  echo("No Directory Selected");
 }
?>