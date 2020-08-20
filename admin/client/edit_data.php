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
 $sql_query="SELECT * FROM client WHERE idClient=".$_GET['edit_id'];
 $result_set=mysql_query($sql_query);
  $fetched_row=mysql_fetch_array($result_set);
}
if(isset($_POST['btn-update']))
{
 // variables for input data
 $nom = $_POST['nom'];

 $n_tel = $_POST['n_tel'];
 $sex = $_POST['sex'];
  $account = $_POST['account'];
 // variables for input data
 
 // sql query for update data into database
 $sql_query = "UPDATE client SET nom='$nom',n_tel='$n_tel',sex='$sex',account='$account' WHERE idClient=".$_GET['edit_id'];
        mysql_query($sql_query);
 // sql query for update data into database 

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
    
     <tr>
            <td>
            N_Tel :
            <input type="text" name="n_tel" placeholder="n_tel" value="<?php echo $fetched_row['n_tel']; ?>" required /></td>
        </tr>
         <tr>
            <td>
            Id_Account :
            <input type="text" name="account" placeholder="account" value="<?php echo $fetched_row['account']; ?>" required /></td>
        </tr>
        <tr>
            <td>
                Sex<br>
                <div style="padding-left: 12px">
                    <input id="sexe_h" type="radio" name="sex" placeholder="sex" value="m" <?php if($fetched_row['sex']=='m') echo "checked" ?> style="height: initial; width: initial;" /><label for="sexe_h">Homme</label><br>
                    <input id="sexe_f" type="radio" name="sex" placeholder="sex" value="f" <?php if($fetched_row['sex']=='f') echo "checked" ?> style="height: initial; width: initial;"/><label for="sexe_f">Femme</label>
                </div>
            </td>
        </tr>
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