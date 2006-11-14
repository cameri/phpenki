<?php
session_start(); 
$_SESSION['theme']="default";
?>

<html>

<frameset rows="75, *, 100">

<frame src="top.php" noresize="noresize">
<frameset cols="200,*">
<frame name="treeview" src="tree.php?dir=demodir/">
<frame name="bodyview" src="body.php">
</frameset>
<frame src="" noresize="noresize">
</frameset>

</html>

