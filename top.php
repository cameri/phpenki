<?php 
session_start(); 
?>

<html>
<head>
<script type="text/javascript">
function UncheckAll(){
 parent.treeview.UncheckAll()
}
function CheckAll(){
 parent.treeview.CheckAll()
}
function RefreshTree(){
 parent.treeview.RefreshTree()
}
</script>

<link rel="stylesheet" type="text/css"
href="themes/<?php echo($_SESSION['theme']);?>/topview.css" />
</head>
<body>
 <table cellpadding="0" cellspacing="0" border="0">
  <tr><td>
   
  </td></tr>
  <tr><td>
   <table class="toolbar" cellspacing="1"><tr>
    <td class="toolbutton" onclick="UncheckAll()">Uncheck All</td>
    <td class="toolbutton" onclick="CheckAll()">Check All</td>
    <td class="toolbutton" onclick="RefreshTree()">Refresh Tree</td>
   </tr></table>
  </td></tr>
 </table>
</body>
</html>