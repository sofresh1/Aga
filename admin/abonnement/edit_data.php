<?php
include_once '../../dbconfig.php';
include_once '../../log.php';
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
 $sql_query="SELECT * FROM abonnement WHERE idAbonnement=".$_GET['edit_id'];
 $result_set=mysql_query($sql_query);
  $fetched_row=mysql_fetch_array($result_set);
}
if(isset($_POST['btn-update']))
{
 // variables for input data
 
 $adresse = $_POST['adresse'];
 $file = $_POST['file'];
 $n_contrat = $_POST['n_contrat'];
$client = $_POST['client'];
$distributeur = $_POST['distributeur'];
 // variables for input data
 
 // sql query for update data into database
 $sql_query = "UPDATE abonnement SET adresse='$adresse',file='$file',n_contrat='$n_contrat',client='$client',distributeur='$distributeur' WHERE idAbonnement=".$_GET['edit_id'];
        mysql_query($sql_query);
 // sql query for update data into database 

      insertLog($_SESSION['username'] , $_SESSION['usertype'] , $sql_query);

        //bock to home page
        header("Location: index.php");
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
              <li><a href="../account/"><span>Accounts</span></a></li>
              <li><a href="../user/"><span>Users</span></a></li>
              <li><a href="../client/"><span>Clients</span></a></li>
              <li class="active"><a href="#"><span>Abonnements</span></a></li>
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
    Adresse :
    <input type="text" name="adresse" placeholder="adresse" value="<?php echo $fetched_row['adresse']; ?>" required /></td>
    </tr>
    <tr>
    <td>
    File :
    <input type="text" name="file" placeholder="file" value="<?php echo $fetched_row['file']; ?>" required /></td>
    </tr>
    <tr>
    <td>
    N_Contrat :
    <input type="text" name="n_contrat" placeholder="n_contrat" value="<?php echo $fetched_row['n_contrat']; ?>" required /></td>
    </tr>
      <tr>
    <td>
    Id_Client :
    <input type="number" name="client" placeholder="client" value="<?php echo $fetched_row['client']; ?>" required /></td>
    </tr>
    <tr>
            <td>
              <label for="distributeur">Distributeur</label>
              <select id="distributeur" name="distributeur" required>
                  <?php
                     $sql_query="SELECT * FROM distributeur";
                     $result_set=mysql_query($sql_query);
                     while($row=mysql_fetch_row($result_set))
                     {
                      ?>
                      <option value="<?php echo $row[0]; ?>"><?php echo $row[1]; ?></option>
                      <?php
                     }
                 ?></select>
            </td>
        </tr>>
        
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