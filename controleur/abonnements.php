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
	<title></title>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<link rel="stylesheet" href="../public/css/style.css" type="text/css" />
	<script src="../public/js/jquery.min.js" type="text/javascript"></script>
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

				<table align="center">
				<tr>
						<td align="center" colspan="6"><a href="index.php">back to main page</a></td>
					</tr>
					<tr>
						<td align="center" colspan="6">Abonnements</td>
					</tr>
					<tr>
						<th>n_contrat</th>
						<th>adresse</th>
						<th></th>
					</tr>
					<?php
					if(!isset($_SESSION)) 
					{ 
						session_start(); 
					}

					if(isset($_GET['idClient'])){
						$sql_query="SELECT * FROM abonnement where client=".$_GET['idClient'];
						$result_set=mysql_query($sql_query);
						while($row=mysql_fetch_row($result_set))
						{
							?>
							<tr>
								<td><?php echo $row[3]; ?></td>
								<td><?php echo $row[1]; ?></td>

								<td align="center"><a href="createfacture.php?idAbonnement=<?php echo $row[0]; ?>"><img src="../public/img/add.png" align="EDIT" /></a></td>

							</tr>
							<?php
						}
					}
					?>
				</table>

</div>
		</center>
		
	</body>
	</html>
