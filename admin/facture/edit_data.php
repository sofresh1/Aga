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
 $sql_query="SELECT * FROM facture WHERE idFacture=".$_GET['edit_id'];
 $result_set=mysql_query($sql_query);
  $fetched_row=mysql_fetch_array($result_set);
}
if(isset($_POST['btn-update']))
{
 // variables for input data
 $n_facture= $_POST['n_facture'];
 $mois = $_POST['mois'];
 $annee = $_POST['annee'];
 $valeur_compteur = $_POST['valeur_compteur'];
 $ecart = $_POST['ecart'];
 $montant = $_POST['montant'];
  $statut = $_POST['statut'];
 $estimated = $_POST['estimated'];
 $abonnement = $_POST['abonnement'];
 // variables for input data
 
 // sql query for update data into database
 $sql_query = "UPDATE facture SET n_facture='$n_facture',mois='$mois',annee='$annee',valeur_compteur=$valeur_compteur,ecart=$ecart,montant=$montant,statut='$statut',estimated='$estimated',abonnement='$abonnement' WHERE idFacture=".$_GET['edit_id'];
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
              <li><a href="../client"><span>Clients</span></a></li>
              <li><a href="../abonnement"><span>Abonnements</span></a></li>
              <li class="active"><a href="#"><span>Factures</span></a></li>
              <li><a href="../distributeur"><span>Distributeurs</span></a></li>
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
    n-facture :
    <input type="text" name="n_facture" placeholder="n_facture" value="<?php echo $fetched_row['n_facture']; ?>" required /></td>
    </tr>
    <tr>
            <td>
            Mois :
            <input type="number" name="mois" placeholder="mois" min="0" max="12" value="<?php echo $fetched_row['mois']; ?>" required /></td>
          </tr>
          <tr>
            <td>
            Annee :
            <input type="number" name="annee" placeholder="annee" min="1990" value="<?php echo $fetched_row['annee']; ?>" required /></td>
          </tr>
    <tr>
    <td>
    Valeur_Compteur :
    <input type="number" name="valeur_compteur" placeholder="valeur_compteur" value="<?php echo $fetched_row['valeur_compteur']; ?>" required /></td>
    </tr>
    <tr>
            <td>
            Ecart :
            <input type="number" name="ecart" placeholder="ecart" min="0" value="<?php echo $fetched_row['ecart']; ?>" required /></td>
          </tr>
     <tr>
            <td>
            Montant :
            <input type="number" name="montant" placeholder="montant" value="<?php echo $fetched_row['montant']; ?>" required /></td>
        </tr>
        <tr>
            <td>
                Statut<br>
                <div style="padding-left: 12px">
                    <input id="status_b" type="radio" name="statut" value="brouillon" <?php if($fetched_row['statut']=='brouillon') echo "checked" ?> style="height: initial;
        width: initial;" /><label for="status_b">Brouillon</label><br>
                    <input id="status_p" type="radio" name="statut" value="payee" <?php if($fetched_row['statut']=='payee') echo "checked" ?> style="height: initial;
        width: initial;"/><label for="status_p">Payee</label><br>
        <input id="status_i" type="radio" name="statut" value="impayee" <?php if($fetched_row['statut']=='impayee') echo "checked" ?> style="height: initial;
        width: initial;"/><label for="status_i">Impayee</label>
                </div>
            </td>
        </tr>
             <tr>
            <td>
                estimated<br>
                <div style="padding-left: 12px">
                    <input id="estimated_T" type="radio" name="estimated" value="1" <?php if($fetched_row['estimated']=='1') echo "checked" ?> style="height: initial;
        width: initial;" /><label for="estimated_T">TRUE</label><br>
                    <input id="estimated_F" type="radio" name="estimated" value="0" <?php if($fetched_row['estimated']=='0') echo "checked" ?> style="height: initial;
        width: initial;"/><label for="estimated_F">FALSE</label><br>
        </div>
        </td>
        </tr>
      
        <tr>
            <td>

              <label for="abonnement">Abonnement</label>
              <select id="abonnement" name="abonnement" required>
                  <?php
                     $sql_query="SELECT * FROM abonnement";
                     $result_set=mysql_query($sql_query);
                     while($row=mysql_fetch_row($result_set))
                     {
                      ?>
                      <option value="<?php echo $row[0]; ?>" <?php if($row[0]==$fetched_row['abonnement']) echo 'selected="selected"' ?> ><?php echo $row[3]; ?></option>
                      <?php
                     }
                 ?></select>
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