<?php
include_once '../../dbconfig.php';
require_once("../../security.php");

if(!isset($_SESSION)) 
{ 
  session_start(); 
}

if(!CheckLogin())
{
  header("Location: ../../login.php");
  exit;
}

if(!empty($_SESSION['usertype']) and $_SESSION['usertype']!="admin"){
  header("Location: ../../index.php");
  exit;
}


// delete condition
if(isset($_GET['delete_id']))
{
 $sql_query="DELETE FROM account WHERE idAccount=".$_GET['delete_id'];
 mysql_query($sql_query);
 header("Location: $_SERVER[PHP_SELF]");
}
// delete condition

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
  <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
  <title>CRUD Operations With PHP and MySql - By Cleartuts</title>
  <link rel="stylesheet" href="../../public/css/style.css" type="text/css" />
  <script src="../public/js/jquery.min.js" type="text/javascript"></script>

  <script type="text/javascript">
    function edt_id(id)
    {
     if(confirm('Sure to edit ?'))
     {
      window.location.href='edit_data.php?edit_id='+id;
    }
  }
  function delete_id(id,type)
  {
    if(type == "admin")
    {
      <?php
      $count = 0;
      $sql_query="SELECT count(*)  FROM account WHERE type='admin'";
      $result_set=mysql_query($sql_query);
      while($row=mysql_fetch_row($result_set))
      {
       $count = $row[0];
     }

     if ($count>1) {
      ?>
      if(confirm('Sure to Delete ?'))
      {
       window.location.href='index.php?delete_id='+id;
     }
     <?php
   } else {
      ?>
        alert('You must keep at least one administrator');
      <?php
   }
   ?>
 } else {
  if(confirm('Sure to Delete ?'))
      {
       window.location.href='index.php?delete_id='+id;
     }
 }
}
</script>

</head>
<body>
  <center>
    <div id="header">
     <div id="content">
      <div id='cssmenu'>
     <a href="../../"><img src="../../public/img/logo-white.png" style="width: 50px; height: 50px; float: left; margin-left: 30px" /></a>
    
        <form id='logout' action='../../logout-submit.php' method='post' accept-charset='UTF-8'>
          <input type="submit" class="login-button" value="Deconnecter"></input>
        </form>
        <ul>
          <li class="active"><a href="#"><span>Accounts</span></a></li>
          <li><a href="../user/"><span>Users</span></a></li>
          <li><a href="../client/"><span>Clients</span></a></li>
          <li><a href="../abbonement/"><span>Abonnements</span></a></li>
          <li><a href="../facture/"><span>Factures</span></a></li>
          <li><a href="../distributeur/"><span>Distributeurs</span></a></li>
          <li class='last'><a href="../tranche/"><span>Tranches</span></a></li>
        </ul>
      </div>
    </div>
  </div>
  <div id="body">
   <div id="content">
    <table align="center">
      <tr>
        <th colspan="4"><a href="add_data.php">add data here.</a></th>
      </tr>

      <th>id</th>
      <th>username</th>
      <th>password</th>
      <th>type</th>


      <th colspan="2">Operations</th>
    </tr>
    <?php
    $sql_query="SELECT * FROM account";
    $result_set=mysql_query($sql_query);
    while($row=mysql_fetch_row($result_set))
    {
      ?>
      <tr>
        <td><?php echo $row[0]; ?></td>
        <td><?php echo $row[1]; ?></td>
        <td><?php echo $row[2]; ?></td>
        <td><?php echo $row[3]; ?></td>

        <td align="center"><a href="javascript:edt_id('<?php echo $row[0]; ?>')"><img src="../../public/img/pen.png" align="EDIT" /></a></td>
        <td align="center"><a href="javascript:delete_id('<?php echo $row[0]; ?>','<?php echo $row[3]; ?>')"><img src="../../public/img/trash.png" align="DELETE" /></a></td>
      </tr>
      <?php
    }
    ?>
  </table>
</div>
</div>

</center>
</body>
</html>