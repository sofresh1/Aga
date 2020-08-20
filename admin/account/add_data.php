<?PHP
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
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
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

<?php
include_once '../../dbconfig.php';
if(isset($_POST['btn-save']))
{

 
 $username = $_POST['username'];
 $password = $_POST['password'];
 $hashed_password = sha1($password);
 $type = $_POST['type'];
 
        $sql_query = "INSERT INTO account(username,password,type) VALUES('$username','$hashed_password','$type')";
 mysql_query($sql_query);
        
        //bock to home page
        header("Location: index.php");
       
}
?>

 <div id="content">
    <form method="post">
        <table align="center">
        <tr>
            <td align="center"><a href="index.php">back to main page</a></td>
        </tr>
        
        <tr>
            <td>
            Username :
            <input type="email" name="username" placeholder="username" required /></td>
        </tr>
        <tr>
            <td>
            Password :
            <input type="text" name="password" placeholder="password" required /></td>
        </tr>
        <tr>
            <td>
                type<br>
                <div style="padding-left: 12px">
                    <input id="type_A" type="radio" name="type" placeholder="type" value="admin" checked style="height: initial;
        width: initial;" /><label for="type_A">Admin</label><br>
                    <input id="type_CR" type="radio" name="type" placeholder="type" value="controleur" style="height: initial;
        width: initial;"/><label for="type_CR">Controleur/Releveur</label><br>
                    <input id="type_C" type="radio" name="type" placeholder="type" value="client" style="height: initial;
        width: initial;"/><label for="type_C">Client</label>
                </div>
            </td>
        </tr>
        <tr>
        <td><button type="submit" name="btn-save"><strong>SAVE</strong></button></td>
            </tr>
        </table>
    </form>
    </div>
</div>

</center>
</body>