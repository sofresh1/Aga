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
              <li><a href=" ../account"><span>Accounts</span></a></li>
              <li><a href="../user/"><span>Users</span></a></li>
              <li><a href=" ../client"><span>Clients</span></a></li>
              <li><a href=" ../abonnement"><span>Abonnements</span></a></li>
              <li><a href="../facture/"><span>Factures</span></a></li>
              <li class="active"><a href="#"><span>Distributeurs</span></a></li>
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

$Nom = $_POST['Nom'];
 $Adresse = $_POST['Adresse'];
 $Agence = $_POST['Agence'];
 $N_Tel = $_POST['N_Tel'];
 $freq_visite = $_POST['freq_visite'];

        $sql_query = "INSERT INTO  distributeur (nom, adresse, agence, n_tel, freq_visite) VALUES ('$Nom','$Adresse','$Agence','$N_Tel', '$freq_visite')";
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
    Nom :
    <input type="text" name="Nom" placeholder="Nom" required /></td>
    </tr>
    <tr>
    <td>
    Adresse :
    <input type="text" name="Adresse" placeholder="Adresse" required /></td>
    </tr>
    <tr>
    <td>
    Agence :
    <input type="text" name="Agence" placeholder="Agence" required /></td>
    </tr>
    <tr>
    <td>
    N_Tel :
    <input type="text" name="N_Tel" placeholder="N_Tel" required /></td>
    </tr>
    <tr>
    <td>
    Nombre de Visite / mois :
    <input type="number" name="freq_visite" placeholder="freq_visite" min="1" max="6" required /></td>
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