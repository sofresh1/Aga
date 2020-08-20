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

if(!empty($_SESSION['usertype']) and $_SESSION['usertype']!="controleur"){
	header("Location: ../index.php");
	exit;
}

if(!isset($_SESSION)) 
{ 
	session_start(); 
}

$message = "";
// changer la mot de passe du client
if (isset($_POST["btn-change-pwd"])) {

	$username = $_SESSION['username'];
	$type = $_SESSION['usertype'];
	$password = $_POST["password"];
	$newpassword = $_POST["newpassword"];
	$confirmnewpassword = $_POST["confirmnewpassword"];

	//CheckLoginInDB
	if(CheckLoginInDB($username,sha1($password),$type))
	{
	       //newpassword = confirmnewpassword
		if ( $newpassword==$confirmnewpassword)
	    	{ 
 				$hashed_newpassword=sha1($newpassword);
	    		//executer requete sql pour changer le pwd
	    		$sql_query = "UPDATE account SET password='$hashed_newpassword' WHERE username='$username'";
	    		mysql_query($sql_query);
	    		$message = "change password success";
	    	} else {
	    		$message = "confirm new password failed";
	    	}
	     

	} else {
		$message = "change password failed";
	}
	
}

?>

<!DOCTYPE html>
<html>
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<title></title>
	<link rel="stylesheet" href="../public/css/style.css" type="text/css" />
	<script src="../public/js/jquery.min.js" type="text/javascript"></script>

</head>
<body>
<center>
	<?php
	include_once '../dbconfig.php';
	include_once '../prediction.php';

	//prendre le mois  de la nouvelle facture à créer
	$idAbonnement;
	if(isset($_GET['idAbonnement'])){
		$idAbonnement = $_GET['idAbonnement'];
	}

	$mois_array=array();
	$annee_array=array();
	$sql_query_date = "SELECT mois,annee from facture WHERE annee = (SELECT MAX(annee) FROM facture WHERE abonnement = ".$idAbonnement.") AND abonnement = ".$idAbonnement;
	$result_set_date=mysql_query($sql_query_date);
	while($row=mysql_fetch_row($result_set_date))
	{
		array_push($mois_array, $row[0]);
		array_push($annee_array, $row[1]);
	}

	$mois;
	$annee;
	$n_facture;

	if(count($mois_array) != 0){
		$mois = max($mois_array);
		$mois = $mois+1;
	} else {
		$mois = date('m');
	}

	if(count($annee_array) != 0){
		$annee = max($annee_array);
	} else {
		$annee = date('Y');
	}

	

	if($mois == 13){
		$mois = 1;
		$annee = $annee + 1;
	}

	$n_facture =$idAbonnement.$mois.$annee ;

	$last_mount_compteur=0;
	//prendre la valeur du conmpteur du mois dernier
	$sql_query_last_mount_compteur = "SELECT MAX(valeur_compteur)  FROM facture WHERE `abonnement` = ".$idAbonnement;
	$result_set_last_mount_compteur=mysql_query($sql_query_last_mount_compteur);
	while($row=mysql_fetch_row($result_set_last_mount_compteur))
	{
		$last_mount_compteur = $row[0];
	}

	if(isset($_POST['btn-save']))
	{
		

		$n_facture = $_POST['n_facture'];
		$valeur_compteur = $_POST['valeur_compteur'];
		$montant = '0';
		$statut = $_POST['statut'];
		$abonnement = $_POST['abonnement'];

		

		//calculer l'ecart entre le mois courant et le mois dernier
		$ecart = $valeur_compteur - $last_mount_compteur;


		//prendre l'ID distributeur
		$idDistributeur;
		$sql_query_last_mount_compteur = "SELECT distributeur FROM abonnement WHERE idAbonnement = ".$abonnement;
		$result_set_last_mount_compteur=mysql_query($sql_query_last_mount_compteur);
		while($row=mysql_fetch_row($result_set_last_mount_compteur))
		{
			$idDistributeur = $row[0];
		}

		//calcul montant
		$tranche_array = array();
		$sql_query_tranches = "SELECT seuiltranche, valtranche FROM tranche LEFT JOIN distributeur ON idDistributeur = distributeur WHERE distributeur = ".$idDistributeur." ORDER BY seuiltranche ASC";
		$result_set_tranches=mysql_query($sql_query_tranches);
		while($row=mysql_fetch_row($result_set_tranches))
		{
			$tranche_array[$row[0]] = $row[1];
		}

		$found = 0;
		$max_valtranche = 0;
		foreach ($tranche_array as $seuiltranche => $valtranche){
		    if($seuiltranche >= $ecart){
				$found = 1;
		    	$montant = $valtranche * $ecart;
		    	BREAK;
		    }
		    if($max_valtranche < $valtranche)
			 {
			 	$max_valtranche = $valtranche;
			 }
		}

		if($found == 0){
			$montant = $max_valtranche * $ecart;
		}

		//creation facture du mois courant
		$sql_query = "INSERT INTO facture (n_facture,mois,annee,valeur_compteur,ecart,montant,statut,abonnement,estimated) VALUES('$n_facture','$mois','$annee','$valeur_compteur','$ecart','$montant','$statut','$abonnement',0)";
		mysql_query($sql_query);

		//----------------- PREDICTION --------------

		$freq_visite=0;
		//prendre freq_visite du distributeur
		$sql_query_freq_visite = "SELECT freq_visite  FROM abonnement left join distributeur ON `idDistributeur` = `distributeur` WHERE `idAbonnement` = ".$abonnement;
		$result_set_freq_visite=mysql_query($sql_query_freq_visite);
		while($row=mysql_fetch_row($result_set_freq_visite))
		{
			$freq_visite = $row[0];
		}

		
		//estimation des n mois suivant
		$loop_mois = $mois;
		$loop_annee = $annee;
		$loop_ecart = 0;
		$loop_valeur_compteur = $valeur_compteur;
		if($freq_visite != 1){
			for ($x = 1; $x < $freq_visite; $x++) {

				$loop_mois = $loop_mois+1;

				if($loop_mois == 13){
					$loop_mois = 1;
					$loop_annee = $loop_annee + 1;
				}

				$ecart_array=array();
				$sql_query_ecart = "SELECT ecart from facture WHERE abonnement = ".$idAbonnement;
				$result_set_ecart=mysql_query($sql_query_ecart);
				while($row=mysql_fetch_row($result_set_ecart))
				{
					array_push($ecart_array, $row[0]);
				}



				$loop_ecart = prediction($ecart_array);
				$loop_valeur_compteur = $loop_valeur_compteur + $loop_ecart;

				$found = 0;
				$max_valtranche = 0;
				foreach ($tranche_array as $seuiltranche => $valtranche){
				    if($seuiltranche >= $ecart){
						$found = 1;
				    	$loop_montant = $valtranche * $loop_ecart;
				    	BREAK;
				    }
				    if($max_valtranche < $valtranche)
					 {
					 	$max_valtranche = $valtranche;
					 }
				}

				if($found == 0){
					$loop_montant = $max_valtranche * $loop_ecart;
				}

				$loop_n_facture =$idAbonnement.$loop_mois.$loop_annee ;

				//estimation facture
				$sql_query = "INSERT INTO facture (n_facture,mois,annee,valeur_compteur,ecart,montant,statut,abonnement,estimated) VALUES('$loop_n_facture".$x."','$loop_mois','$loop_annee','$loop_valeur_compteur','$loop_ecart','$loop_montant','$statut','$abonnement',1)";
				mysql_query($sql_query);

			}

			//incrementer la date pour la nouvelle facture à creer
			$mois = $loop_mois+1;
			$annee = $loop_annee;

			if($mois == 13){
				$mois = 1;
				$annee = $annee + 1;
			}

			//prendre la valeur du conmpteur du mois dernier apres prediction
			$sql_query_last_mount_compteur = "SELECT MAX(valeur_compteur)  FROM facture WHERE `abonnement` = ".$idAbonnement;
			$result_set_last_mount_compteur=mysql_query($sql_query_last_mount_compteur);
			while($row=mysql_fetch_row($result_set_last_mount_compteur))
			{
				$last_mount_compteur = $row[0];
			}

		}
	

        //bock to home page
        //header("Location: /controleur/index.php");
	}

	

	?>



		<div id="header">
			<div id="content">
				<div id='cssmenu'>
     <a href="../"><img src="../public/img/logo-white.png" style="width: 50px; height: 50px; float: left; margin-left: 30px" /></a>
    
					<form id='logout' action='../logout-submit.php' method='post' accept-charset='UTF-8'>
						<input type="submit" class="login-button" value="Deconnecter"></input>
					</form>
			        <!-- Trigger/Open The Modal -->
					<button id="myBtn" class="login-button">Change Password</button>
				</div>
			</div>
		</div>
		
		<div id="content">
	


					<!-- The Modal -->
					<div id="myModal" class="modal">

						<!-- Modal content -->
						<div class="modal-content">
							<span class="close">×</span>
							<form method="post" action="#">
								<table align="center">
									<tr>
										<td><input type="text" name="password" placeholder="current password" required /></td>
									</tr>
									<tr>
										<td><input type="text" name="newpassword" placeholder="new password" required /></td>
									</tr>
									<tr>
										<td><input type="text" name="confirmnewpassword" placeholder="confirm new password" required /></td>
									</tr>
									<tr>
										<td><button type="submit" name="btn-change-pwd"><strong>Change password</strong></button></td>
									</tr>
								</table>
							</form>
						</div>

					</div>

					<script>
							// Get the modal
							var modal = document.getElementById('myModal');

							// Get the button that opens the modal
							var btn = document.getElementById("myBtn");

							// Get the <span> element that closes the modal
							var span = document.getElementsByClassName("close")[0];

							// When the user clicks the button, open the modal 
							btn.onclick = function() {
								modal.style.display = "block";
							}

							// When the user clicks on <span> (x), close the modal
							span.onclick = function() {
								modal.style.display = "none";
							}

							// When the user clicks anywhere outside of the modal, close it
							window.onclick = function(event) {
								if (event.target == modal) {
									modal.style.display = "none";
								}
							}
					</script>

		
			<form method="post">
				<table align="center">
					<tr>
						<td align="center" colspan="6"><a href="index.php">back to main page</a></td>
					</tr>
					<tr>
						<td>
							Numero facture :
							<input type="text" name="n_facture" placeholder="n_facture" value="<?php echo $n_facture;?>" required readonly/></td>
					</tr>
					<tr>
		            <td>
		            Mois :
		            <input type="number" name="mois" placeholder="mois" min="0" max="12" value="<?php echo $mois;?>" required readonly/></td>
		          </tr>
		          <tr>
		            <td>
		            Annee :
		            <input type="number" name="annee" placeholder="annee" min="1990" value="<?php echo $annee;?>" required readonly/></td>
		          </tr>
					<tr>
						<td>
							Valeur du compteur :
							<input type="number" name="valeur_compteur" placeholder="valeur_compteur" min="<?php echo $last_mount_compteur;?>" required /></td>
					</tr>
					
					<input type="hidden" name='statut' value="brouillon" required>

					<tr>
						<td>
							<label for="abonnement">Abonnement</label>
							<input type="text" name='abonnement' value="<?php  
							if(isset($_GET['idAbonnement'])){
								echo $_GET['idAbonnement'];
							} 
							?>" required readonly/>
						</td>
					</tr>

					<tr>
						<td><button type="submit" name="btn-save"><strong>SAVE</strong></button></td>
					</tr>
				</table>
			</form>
	

	</div>

</center>

</body>
</html>