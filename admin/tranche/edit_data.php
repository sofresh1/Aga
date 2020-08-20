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
 $sql_query="SELECT * FROM tranche WHERE idTranche=".$_GET['edit_id'];
 $result_set=mysql_query($sql_query);
  $fetched_row=mysql_fetch_array($result_set);
}
if(isset($_POST['btn-update']))
{
 // variables for input data

 $nomtranche = $_POST['nomtranche'];
 $seuiltranche = $_POST['seuiltranche'];
 $valtranche = $_POST['valtranche'];
 $distributeur = $_POST['distributeur'];
 // variables for input data
 
 // sql query for update data into database
 $sql_query = "UPDATE tranche SET nomtranche='$nomtranche',seuiltranche='$seuiltranche',valtranche='$valtranche',distributeur='$distributeur' WHERE idTranche=".$_GET['edit_id'];
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
              <li><a href=" ../client"><span>Clients</span></a></li>
              <li><a href="../abonnement"><span>Abonnements</span></a></li>
              <li><a href="../facture"><span>Factures</span></a></li>
              <li><a href="../distributeur"><span>Distributeurs</span></a></li>
              <li class='last active'><a href="#"><span>Tranches</span></a></li>
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
    Nom_Tranche :
    <input type="text" name="nomtranche" placeholder="nomtranche" value="<?php echo $fetched_row['nomtranche']; ?>" required /></td>
    </tr>
    <tr>
    <td>
    Seuil_Tranche :
    <input type="number" name="seuiltranche" placeholder="seuiltranche" value="<?php echo $fetched_row['seuiltranche']; ?>" required /></td>
    </tr>
    <tr>
    <td>
    Val_Tranche :
    <input type="number" name="valtranche" placeholder="valtranche" value="<?php echo $fetched_row['valtranche']; ?>" required /></td>
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