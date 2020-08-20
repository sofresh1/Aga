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

    <?php
    include_once '../../dbconfig.php';
    if(isset($_POST['btn-save']))
    {

      echo '<script type="text/javascript">alert(btn-save); </script>';

      $n_facture = $_POST['n_facture'];
      $mois = $_POST['mois'];
      $annee = $_POST['annee'];
      $valeur_compteur = $_POST['valeur_compteur'];
      $ecart = $_POST['ecart'];
      $montant = $_POST['montant'];
      $statut = $_POST['statut'];
      $estimated = $_POST['estimated'];
      $abonnement = $_POST['abonnement'];

      $sql_query = "INSERT INTO facture (n_facture,mois,annee,valeur_compteur,ecart,montant,statut,estimated,abonnement) VALUES('$n_facture','$mois','$annee','$valeur_compteur','$ecart','$montant','$statut','$estimated','$abonnement')";

      echo '<script type="text/javascript">alert(' . $sql_query . '); </script>';

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
            n_facture :
            <input type="text" name="n_facture" placeholder="n_facture" required /></td>
          </tr>
          <tr>
            <td>
            Mois :
            <input type="number" name="mois" placeholder="mois" min="0" max="12" required /></td>
          </tr>
          <tr>
            <td>
            Annee :
            <input type="number" name="annee" placeholder="annee" min="1990" required /></td>
          </tr>
          <tr>
            <td>
            Valeur_Compteur :
            <input type="text" name="valeur_compteur" placeholder="valeur_compteur" required /></td>
          </tr>
           <tr>
            <td>
            Ecart :
            <input type="number" name="ecart" placeholder="ecart" min="0" required /></td>
          </tr>
          <tr>
            <td>
            Montant :
            <input type="text" name="montant" placeholder="montant" required /></td>
          </tr>
          <tr>
            <td>
              Statut<br>
              <div style="padding-left: 12px">
                <input id="status_b" type="radio" name="statut" value="brouillon" checked style="height: initial;
                width: initial;" /><label for="status_b">Brouillon</label><br>
                <input id="status_p" type="radio" name="statut" value="payee" style="height: initial;
                width: initial;"/><label for="status_p">Payee</label><br>
                <input id="status_i" type="radio" name="statut" value="impayee" style="height: initial;
                width: initial;"/><label for="status_i">Impayee</label>
              </div>
            </td>
          </tr>

          <tr>
            <td>
              estimated<br>
              <div style="padding-left: 12px">
                <input id="estimated_T" type="radio" name="estimated" value="1" checked style="height: initial;
                width: initial;" /><label for="estimated_T">TRUE</label><br>
                <input id="estimated_F" type="radio" name="estimated" value="0" style="height: initial;
                width: initial;"/><label for="estimated_F">FALSE</label><br>
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
                    <option value="<?php echo $row[0]; ?>"><?php echo $row[3]; ?></option>
                    <?php
                  }
                  ?></select>
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
  </html>