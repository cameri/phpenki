<?php 
session_start(); 
$theme = $_SESSION["theme"];
?>

<html>
<head>
<?php
$dir = $_GET["dir"];
?>
<script type="text/javascript">
var theme = "<?php echo($theme);?>"

var Branches = new Array()
var Checkboxes = new Array()
var xmlHttp
var xmlDoc
var cur_id
var cur_dir

function GetXmlHttpObject(){ 
 var objXMLHttp=null
 if (window.XMLHttpRequest){
  objXMLHttp=new XMLHttpRequest()
 }
 else if (window.ActiveXObject){
  objXMLHttp=new ActiveXObject("Microsoft.XMLHTTP")
 }
 return objXMLHttp
}

function RefreshTree(){
 var Branches = new Array()
 StartTree('<?php echo($dir); ?>', 'branch')
}

/**************************
*****TREE CONSTRUCTION*****
**************************/
function AlterBranch(id){
 if(Branches[id]["opened"] == false){
  AddBranch(id)
 }
 else{
  RemoveBranch(id)
 }
}

function RemoveBranch(id){
 var x
 for (x in Branches){
  if(Branches[x] != null){
   if(Branches[x]["parent"] == id){
    if(Branches[x]["type"]=="folder"){
     RemoveBranch(x)
    }
    x = null
   }
  }
 }
 Branches[id]["opened"] = false
 document.getElementById(id + "_img").src="themes/" + theme + "/images/tree_dir_close.gif"
 document.getElementById(id).innerHTML=""
}

function AddBranch(id){ 
 cur_id = id
 cur_dir = Branches[id]["name"]
 xmlHttp=GetXmlHttpObject()
 if (xmlHttp==null){
  alert ("Browser does not support HTTP Request")
  return
 }
 Branches[id]["opened"] = true
 var url="getbranch.php"
 url=url+"?dir="+ Branches[id]["name"]
 xmlHttp.onreadystatechange=FillBranch
 xmlHttp.open("GET",url,true)
 xmlHttp.send(null)
}

function StartTree(dir, id){ 
 cur_id = id
 cur_dir = dir
 xmlHttp=GetXmlHttpObject()
 if (xmlHttp==null){
  alert ("Browser does not support HTTP Request")
  return
 }
 //Branches[id]["opened"] = true
 var url="getbranch.php"
 url=url+"?dir="+ dir
 xmlHttp.onreadystatechange=FillBranch
 xmlHttp.open("GET",url,true)
 xmlHttp.send(null)
}

function FillBranch(){
 var XMLtxt
 var x
 var count = 0
 var strHTML = ""
 var strName
 var strType
 var strImg
 var my_id

 if (xmlHttp.readyState==4 || xmlHttp.readyState=="complete"){
  XMLtxt = new XML(xmlHttp.responseText)
  strHTML += "<table class=\"tree\" cellpadding=\"0\" cellspacing=\"0\">"

  for each(x in XMLtxt.branch){
   try{

    my_id = cur_id + "_" + count
    count++
    strName = x.name
    strType = x.type
    strImg = x.itype
    
    Branches[my_id] = new Array()
    Branches[my_id]["parent"] = cur_id
    Branches[my_id]["opened"] = false
    Branches[my_id]["type"] = strType
    if(strType=="folder"){
     Branches[my_id]["name"] = cur_dir + strName + "/"
    }
    else{
     Branches[my_id]["name"] = cur_dir + strName
    }
    try{
     Branches[my_id]["checked"] = Branches[cur_id]["checked"]
    }
    catch(err){
     Branches[my_id]["checked"] = false
    }

    if(strType=="folder"){
     strHTML += "<tr>"
     if(strImg=="tri"){
      strHTML += "<td width=\"16\"><img src=\"themes/" + theme + "/images/tree_tri.gif\" /></td>"
     }
     else{
      strHTML += "<td width=\"16\"><img src=\"themes/" + theme + "/images/tree_el.gif\" /></td>"
     }
     strHTML += "<td width=\"16\"><img id=\"" + my_id + "_img\" src=\"themes/" + theme + "/images/tree_dir_close.gif\" onclick=\"AlterBranch('" + my_id + "')\" /></td>"
     if(Branches[my_id]["checked"]){
      strHTML += "<td width=\"16\"><img id=\"" + my_id + "_chk\" src=\"themes/" + theme + "/images/tree_checked.gif\" onclick=\"AlterCheck('" + my_id + "')\" /></td>"
     }
     else{
      strHTML += "<td width=\"16\"><img id=\"" + my_id + "_chk\" src=\"themes/" + theme + "/images/tree_unchecked.gif\" onclick=\"AlterCheck('" + my_id + "')\" /></td>"
     }
     strHTML += "<td width=\"16\"><img src=\"themes/" + theme + "/images/tree_folder.gif\" /></td>"
     strHTML += "<td class=\"tree_dir\" align=\"left\">" + strName + "</td>"
     strHTML += "</tr>"
     strHTML += "<tr>"
     if(strImg=="tri"){
      strHTML += "<td class=\"tree_vert\" width=\"16\"></td>"
     }
     else{
      strHTML += "<td width=\"16\"></td>"
     }
     strHTML += "<td colspan=\"4\"><div id=\"" + my_id + "\"></div></td>"
     strHTML += "</tr>"
    }
    else{
     strHTML += "<tr>"
     if(strImg=="tri"){
      strHTML += "<td width=\"16\"><img src=\"themes/" + theme + "/images/tree_tri.gif\" /></td>"
     }
     else{
      strHTML += "<td width=\"16\"><img src=\"themes/" + theme + "/images/tree_el.gif\" /></td>"
     }
     strHTML += "<td width=\"16\"><img src=\"themes/" + theme + "/images/tree_horz.gif\" /></td>"
     if(Branches[my_id]["checked"]){
      strHTML += "<td width=\"16\"><img id=\"" + my_id + "_chk\" src=\"themes/" + theme + "/images/tree_checked.gif\" onclick=\"AlterCheck('" + my_id + "')\" /></td>"
     }
     else{
      strHTML += "<td width=\"16\"><img id=\"" + my_id + "_chk\" src=\"themes/" + theme + "/images/tree_unchecked.gif\" onclick=\"AlterCheck('" + my_id + "')\" /></td>"
     }
     strHTML += "<td width=\"16\"><img src=\"themes/" + theme + "/images/tree_file.gif\" /></td>"
     strHTML += "<td class=\"tree_file\" align=\"left\">" + strName + "</td>"
     strHTML += "</tr>"
    }
   }
   catch(err){
   
   }
  }
  strHTML = strHTML + "</table>"
  document.getElementById(cur_id).innerHTML = strHTML
  document.getElementById(cur_id + "_img").src="themes/" + theme + "/images/tree_dir_open.gif"
 } 
}

/**************************
*****CHECKBOX HANDLING*****
**************************/
function AlterCheck(id){
 if(!Branches[id]["checked"]){
  AddCheck(id)
 }
 else{
  RemoveCheck(id)
 }
}

function RemoveCheck(id){
 var x
 document.getElementById(id + "_chk").src="themes/" + theme + "/images/tree_unchecked.gif"
 Branches[id]["checked"] = false
 for (x in Branches){
  if(Branches[x] != null){
   if(Branches[id]["parent"] == x){
    RemoveCheck(x)
   }
  }
 }
}

function AddCheck(id){
 var x
 document.getElementById(id + "_chk").src="themes/" + theme + "/images/tree_checked.gif"
 Branches[id]["checked"] = true
 if(Branches[id]["type"]=="folder"){
  for (x in Branches){
   if(Branches[x] != null){
    if(Branches[x]["parent"] == id){
     AddCheck(x)
    }
   }
  }
 }
}

function UncheckAll(){
 var x
 for (x in Branches){
  if(Branches[x] != null){
   if(Branches[x]["checked"]){
    RemoveCheck(x)
   }
  }
 }
}

function CheckAll(){
 var x
 for (x in Branches){
  if(Branches[x] != null){
   if(!Branches[x]["checked"]){
    AddCheck(x)
   }
  }
 }
}

function getChecks(){
  var x
  var dirs = ""
  for (x in Checkboxes)
   {
    if(Checkboxes[x] != null){
     dirs = dirs + Checkboxes[x] + ",\n"
    }
   }
  return(dirs)
}
</script>

<link rel="stylesheet" type="text/css" href="themes/<?php echo($theme); ?>/treeview.css" />

</head>
<body>
<?php
 echo("<div class=\"top_dir\" width=\"100%\">http://" . dirname($_SERVER['HTTP_HOST'] . $_SERVER['SCRIPT_NAME']) . "/" . $dir . "</div>");
 echo("<div id=\"branch\"></div>");
?>

<script type="text/javascript">
 RefreshTree()
</script>
</body>
</html>