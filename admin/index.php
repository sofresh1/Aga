<?PHP
require_once("../security.php");

if(!isset($_SESSION)) 
{ 
  session_start(); 
}

if(!CheckLogin())
{
  header("Location: ../login.php");
  exit;
}

if(!empty($_SESSION['usertype']) and $_SESSION['usertype']!="admin"){
  header("Location: ../index.php");
  exit;
}

if(!isset($_SESSION)) 
{ 
  session_start(); 
}
      //on prend ID du client connecte
$username = $_SESSION['username'];
$sql_query_1="SELECT idUser,nom FROM account LEFT JOIN user ON user.account = account.idAccount WHERE account.username = '$username' ";
$result_set_1=mysql_query($sql_query_1);
$idClient;
$nomClient;
while($row=mysql_fetch_row($result_set_1))
{
  $idClient = $row[0];
  $nomClient = $row[1];
}
?>

<!doctype html>
<html lang=''>
<head>
 <meta charset='utf-8'>
 <meta http-equiv="X-UA-Compatible" content="IE=edge">
 <meta name="viewport" content="width=device-width, initial-scale=1">
 <link rel="stylesheet" href="../public/css/style.css">
 <body background="img/22.png"> 


   <script src="http://code.jquery.com/jquery-latest.min.js" type="text/javascript"></script>
   <script src="script.js"></script>
   <title>CSS MenuMaker</title>
 </head>
 <body>

  <center>

   <div id="header">
    <div id="content">
     <div id='cssmenu'>
     <a href="../"><img src="../public/img/logo-white.png" style="width: 50px; height: 50px; float: left; margin-left: 30px" /></a>
    
      <form id='logout' action='../logout-submit.php' method='post' accept-charset='UTF-8'>
        <input type="submit" class="login-button" value="Deconnecter"></input>
      </form>
      <ul>
        <li><a href="account/"><span>Accounts</span></a></li>
        <li><a href="user/"><span>Users</span></a></li>
        <li><a href="client/"><span>Clients</span></a></li>
        <li><a href="abonnement/"><span>Abonnements</span></a></li>
        <li><a href="facture/"><span>Factures</span></a></li>
        <li><a href="distributeur/"><span>Distributeurs</span></a></li>
        <li class='last'><a href="tranche/"><span>Tranches</span></a></li>
      </ul>
    </div>
  </div>
</div>

<div id="body">
  <div id="content">

    <div style="padding-bottom: 15px;">
      <t1>Bonjour <strong><?php  echo $nomClient; ?></strong><t1>
      </div>

    </div>
  </div>
</center>


</body>
<img src="AGAI.PNG"/>