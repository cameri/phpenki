<?php
  $dir = $_GET["dir"];
  $id = $_GET["id"];
  $theme = $_GET["theme"];
  $count = 0;
  $dircount = 0;
  $filecount = 0;
  $dirs = null;
  $files = null;

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
    echo("<table class=\"tree\" cellpadding=\"0\" cellspacing=\"0\" border=\"0\">");
    if($dircount > 0){
     sort($dirs);
     for ($x = 0; $x < $dircount; $x++){
      echo("<tr>");
      if($dircount + $filecount == $count + 1){
       echo("<td class=\"tree_el\" style=\"width: 16px\"></td>");
      }
      else{
       echo("<td class=\"tree_tri\" style=\"width: 16px\"></td>");
      }
      echo("<td class=\"tree_ico_plus\" width=\"16\" id=\"" . $id . ($x + 1) . "_tab\" onclick=\"AlterBranch('" . $dir . $dirs[$x] . "/','" . $id . ($x + 1) . "')\" align=\"center\"><img id=\"" . $id . ($x + 1) . "_img\" src=\"themes/" . $theme ."/images/tree_dir_close.gif\" /></td>");
      echo("<td class=\"tree_dir\" align=\"left\">$dirs[$x]</td>");
      echo("</tr>");
      echo("<tr>");
      if($dircount + $filecount == $count + 1){
       echo("<td style=\"width: 16px\"></td>");
      }
      else{
       echo("<td class=\"tree_vert\" style=\"width: 16px\"></td>");
      }
      echo("<td colspan=\"2\"><div id=\"" . $id . ($x + 1) . "\"></div></td>");
      echo("</tr>");
      $count++;
     }
    }
    echo("\n");
    if($filecount > 0){
     sort($files);
     for ($x = 0; $x < $filecount; $x++){
      echo("<tr>");
      if($dircount + $filecount == $count + 1){
       echo("<td class=\"tree_el\" style=\"width: 16px\"></td>");
      }
      else{
       echo("<td class=\"tree_tri\" style=\"width: 16px\"></td>");
      }
      echo("<td class=\"tree_horz\" style=\"width: 16px\"></td>");
      echo("<td class=\"tree_file\">" . $files[$x] . "</td>");
      echo("</tr>");
      $count++;
     }
    }
    echo("</table>");
   }
   closedir($handle);
  }
?>