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
              <li class="active"><a href= "#"><span>Clients</span></a></li>
              <li><a href="../abonnement"><span>Abonnements</span></a></li>
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

 $nom = $_POST['nom'];
 $n_tel = $_POST['n_tel'];
 $sex= $_POST['sex'];
 $account= $_POST['account'];

 
        $sql_query = "INSERT INTO client(nom,n_tel,sex,account) VALUES('$nom','$n_tel','$sex','$account')";
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
            <input type="text" name="nom" placeholder="nom" required /></td>
        </tr>
        <tr>
            <td>
            N_Tel :
            <input type="text" name="n_tel" placeholder="n_tel" required /></td>
        </tr>

            <td>
            Id_Account :
            <input type="text" name="account" placeholder="account" required /></td>
        <tr>
            <td>
                Sex<br>
                <div style="padding-left: 12px">
                    <input id="sexe_h" type="radio" name="sex" placeholder="sex" value="m" checked style="height: initial;
        width: initial;" /><label for="sexe_h">Homme</label><br>
                    <input id="sexe_f" type="radio" name="sex" placeholder="sex" value="f" style="height: initial;
        width: initial;"/><label for="sexe_f">Femme</label>
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