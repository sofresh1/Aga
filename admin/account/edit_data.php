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

if(!CheckLogin())
{
    header("Location: ../../login.php");
    exit;
}
if(isset($_GET['edit_id']))
{
   $sql_query="SELECT * FROM account WHERE idAccount=".$_GET['edit_id'];
   $result_set=mysql_query($sql_query);
   $fetched_row=mysql_fetch_array($result_set);
}
if(isset($_POST['btn-update']))
{
    
    $sql_query="SELECT * FROM account WHERE idAccount=".$_GET['edit_id'];
   $result_set=mysql_query($sql_query);
   $fetched_row=mysql_fetch_array($result_set);

   if($fetched_row['type'] == "admin"){

    $count = 0;
    $sql_query="SELECT count(*)  FROM account WHERE type='admin'";
    $result_set=mysql_query($sql_query);
    while($row=mysql_fetch_row($result_set))
    {
        $count = $row[0];
    }

    $username = $_POST['username'];
    $password = $_POST['password'];
    $type = $_POST['type'];

    if ($count == 1 && $type != "admin") {
    
        echo "<script>alert('You must keep at least one administrator')</script>";
   
    }else {
      
 $sql_query = "UPDATE account SET username='$username',password='$password',type='$type' WHERE idAccount=".$_GET['edit_id'];
    mysql_query($sql_query);
    //back to home page
      header("Location: index.php");

      
      
   }

   }

}
?>

<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />

    <link rel="stylesheet" href="../../public/css/style.css" type="text/css" />
  <script src="../public/js/jquery.min.js" type="text/javascript"></script>
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
    <form method="post"><
        <table align="center">
            <tr>
                <td align="center"><a href="index.php">back to main page</a></td>
            </tr>

            <tr>
                <td>
                Username :
                <input type="email" name="username" placeholder="username" value="<?php echo $fetched_row['username']; ?>" required /></td>
            </tr>
            <tr>
                <td>
                Password :
                <input type="text" name="password" placeholder="password" value="<?php echo $fetched_row['password']; ?>" required />
                *the password have to be scrypted using SHA1
                </td>
            </tr>
            <tr>
                <td>
                    Role<br>
                    <div style="padding-left: 12px">
                        <input id="type_A" type="radio" name="type" value="admin" <?php if($fetched_row['type']=='admin') echo "checked" ?> style="height: initial;
                        width: initial;" /><label for="type_A">Admin</label><br>
                        <input id="type_CR" type="radio" name="type" value="controleur" <?php if($fetched_row['type']=='controleur') echo "checked" ?> style="height: initial;
                        width: initial;"/><label for="type_CR">Controleur/Releveur</label><br>
                        <input id="type_C" type="radio" name="type" value="client" <?php if($fetched_row['type']=='client') echo "checked" ?> style="height: initial;
                        width: initial;"/><label for="type_CR">Client</label>
                    </div>
                </td>
            </tr>
            <tr>
                <td>
                    <button type="submit" name="btn-update"><strong>UPDATE</strong></button>
                </td>
            </tr>
        </table>
    </form>
</div>
</div>

</center>
</body>
</html>