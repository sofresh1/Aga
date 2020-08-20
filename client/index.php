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

if(!empty($_SESSION['usertype']) and $_SESSION['usertype']!="client"){
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

			//on prend ID du client connecte
$username = $_SESSION['username'];
$sql_query_1="SELECT idClient,nom FROM account LEFT JOIN client ON client.account = account.idAccount WHERE account.username = '$username' ";
$result_set_1=mysql_query($sql_query_1);
$idClient;
$nomClient;
while($row=mysql_fetch_row($result_set_1))
{
	$idClient = $row[0];
	$nomClient = $row[1];
}
			//on prend les abonnements du client
$sql_query="SELECT abonnement.n_contrat, abonnement.adresse ,distributeur.nom,distributeur.agence,distributeur.n_tel,abonnement.idAbonnement FROM abonnement LEFT JOIN distributeur ON abonnement.distributeur = distributeur.idDistributeur WHERE abonnement.client = $idClient order by distributeur.nom desc";
$result_set=mysql_query($sql_query);
?>
<!DOCTYPE html>
<html>
<head>
	<title></title>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<title></title>
	<link rel="stylesheet" href="../public/css/style.css" type="text/css" />
	<script src="../public/js/jquery.min.js" type="text/javascript"></script>

	<script type="text/javascript">
		function show_factures(id)
		{
			if(confirm('Sure to show factures ?'))
			{
				window.location.href='factures.php?idAbonnement='+id;
			}
		}
	}
</script>
</head>
<body>
	<center>
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

		<div id="body">
			<div id="content">



				<div style="padding-bottom: 15px;">
					<t1>Bonjour <strong><?php  echo $nomClient; ?></strong><t1>
						<br>
						<div><t1><strong><?php  echo $message; ?></strong><t1></div>
					</div>


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

					<div id="MessageModal" class="modal">

						<!-- Modal content -->
						<div class="modal-content">
							<span class="messageClose">×</span>
							<p style="color: red"> Vous avez plus de 12 factures impayée. Vous risquez une coupure d'eau</p>
						</div>

					</div>
		
<table align="center">
	<tr>
		<td align="center" colspan="6">Abonnements</td>
	</tr>
	<th>n_contrat</th>
	<th>adresse</th>
	<th>nom</th>
	<th>agence</th>
	<th>n_tel</th>
	<th></th>
</tr>
<?php


while($row=mysql_fetch_row($result_set))
{
	?>
	<tr>
		<td><?php echo $row[0]; ?></td>
		<td><?php echo $row[1]; ?></td>
		<td><?php echo $row[2]; ?></td>
		<td><?php echo $row[3]; ?></td>
		<td><?php echo $row[4]; ?></td>

		<td align="center">
			<a href="factures.php?idAbonnement=<?php echo $row[5]; ?>"><img src="../public/img/find.png" align="EDIT" /></a>
			<a href="statistics.php?idAbonnement=<?php echo $row[5]; ?>"><img src="../public/img/statistics.png" align="EDIT" />
		</td>

	</tr>
	<?php
}
?>
</table>
</div>
</div>

</center>
</body>
</html>