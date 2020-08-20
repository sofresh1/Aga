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
 $sql_query="SELECT * FROM distributeur WHERE idDistributeur=".$_GET['edit_id'];
 $result_set=mysql_query($sql_query);
  $fetched_row=mysql_fetch_array($result_set);
}
if(isset($_POST['btn-update']))
{
 // variables for input data
$nom = $_POST['nom'];
 $Adresse = $_POST['Adresse'];
 $Agence = $_POST['Agence'];
 $N_Tel = $_POST['N_Tel'];
 $freq_visite = $_POST['freq_visite'];
 
 // variables for input data
 
 // sql query for update data into database
 $sql_query = "UPDATE distributeur SET nom='$nom',adresse='$Adresse',agence='$Agence',n_tel='$N_Tel',freq_visite=$freq_visite WHERE idDistributeur=".$_GET['edit_id'];
        mysql_query($sql_query);
 // sql query for update data into database 

        //bock to home page
        header("Location: index.php");
}
?>

<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>CRUD Operations With PHP and MySql - By Cleartuts</title>
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
 <div id="content">
    <form method="post"><
    <table align="center">
    <tr>
    <td align="center"><a href="index.php">back to main page</a></td>
    </tr>
    <tr>
    <td>
    Nom :
    <input type="text" name="nom" placeholder="nom" value="<?php echo $fetched_row['nom']; ?>" required /></td>
    </tr>
    <tr>
    <td>
    Adresse :
    <input type="text" name="Adresse" placeholder="Adresse" value="<?php echo $fetched_row['adresse']; ?>" required /></td>
    </tr>
    <tr>
    <td>
    Agence :
    <input type="text" name="Agence" placeholder="Agence" value="<?php echo $fetched_row['agence']; ?>" required /></td>
    </tr>
    <tr>
    <td>
    N_Tel :
    <input type="text" name="N_Tel" placeholder="N_Tel" value="<?php echo $fetched_row['n_tel']; ?>" required /></td>
    </tr>
    <tr>
    <td>
    Nombre de Visite / mois :
    <input type="number" name="freq_visite" placeholder="freq_visite" value="<?php echo $fetched_row['freq_visite']; ?>" min="1" max="6" required /></td>
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