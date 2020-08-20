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
              <li><a href="../abonnement"><span>Abonnements</span></a></li>
              <li><a href="../facture"><span>Factures</span></a></li>
              <li><a href="../distributeur"><span>Distributeurs</span></a></li>
              <li class='last active'><a href="#"><span>Tranches</span></a></li>
        </ul>
    </div>
    </div>
</div>
<div id="body">



<?php
include_once '../../dbconfig.php';
if(isset($_POST['btn-save']))
{


 $nomtranche = $_POST['nomtranche'];
 $seuiltranche = $_POST['seuiltranche'];
 $valtranche = $_POST['valtranche'];
 $distributeur = $_POST['distributeur'];

 
        $sql_query = "INSERT INTO tranche(nomtranche,seuiltranche,valtranche,distributeur) VALUES('$nomtranche','$seuiltranche','$valtranche','$distributeur')";
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
            Nom_tranche :
            <input type="text" name="nomtranche" placeholder="nomtranche" required /></td>
        </tr>
        <tr>
            <td>
            Seuil_Tranche :
            <input type="number" name="seuiltranche" placeholder="seuiltranche" required /></td>
        </tr>
        <tr>
            <td>
            Val_Tranche :
            <input type="number" name="valtranche" placeholder="valtranche" required /></td>
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
      

        
        <tr>
        <td><button type="submit" name="btn-save"><strong>SAVE</strong></button></td>
            </tr>
        </table>
    </form>
    </div>
</div>

</center>
</body>