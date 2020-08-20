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

?>

<!DOCTYPE html>
<html>
<head>
	<title></title>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<link rel="stylesheet" href="../public/css/style.css" type="text/css" />
	
			<script src="../public/js/jquery.min.js" type="text/javascript"></script>

			<script src="../public/js/highcharts.js"></script>
			<script src="../public/js/exporting.js"></script>
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
            <td align="center" colspan="6"><a href="index.php">back to abonnement page</a><br><br>Statistiques</td>
            </tr>
            </table>
		
			<?php

			if(!isset($_SESSION)) 
			{ 
				session_start(); 
			}
			if(isset($_GET['idAbonnement']))
			{
			 $sql_query="SELECT mois,annee,ecart FROM facture WHERE abonnement=".$_GET['idAbonnement']." and statut != 'brouillon' order by annee asc, mois asc";
			 $result_set=mysql_query($sql_query);
			 $array_factures= array();
			while($row=mysql_fetch_row($result_set))
				{
					array_push($array_factures,  array('date' => $row[0]."-".$row[1], 'valeur' => $row[2]));
					
				}}
			?>

<div id="container" style="min-width: 310px; height: 400px; margin: 0 auto"></div>


<script type="text/javascript">
	$(function () {
	    $('#container').highcharts({
	        chart: {
	            type: 'column'
	        },
	        title: {
	            text: 'Evolution de la consomation d eau'
	        },
	        subtitle: {
	            text: ''
	        },
	        xAxis: {
	            categories: [
	            <?php 
		         	$i=0;
					foreach ($array_factures as $elmt)	{
					echo "'".$elmt["date"]."'";
					$i++;
					if ($i != count($array_factures))
						echo ",";
					}
				 ?>
	                
	            ],
	            crosshair: true
	        },
	        yAxis: {
	            min: 0,
	            title: {
	                text: 'Volume (m3)'
	            }
	        },
	        tooltip: {
	            headerFormat: '<span style="font-size:10px">{point.key}</span><table>',
	            pointFormat: '<tr><td style="color:{series.color};padding:0">{series.name}: </td>' +
	                '<td style="padding:0"><b>{point.y:.1f} m3</b></td></tr>',
	            footerFormat: '</table>',
	            shared: true,
	            useHTML: true
	        },
	        plotOptions: {
	            column: {
	                pointPadding: 0.2,
	                borderWidth: 0
	            }
	        },
	        series: [{
	            name: 'Consomation',
	            data: [
					<?php 
		         	$i=0;
					foreach ($array_factures as $elmt)	{
					echo $elmt["valeur"];
					$i++;
					if ($i != count($array_factures))
						echo ",";
					}
				 ?>
	            ]

	        }]
	    });
	});
</script>

	</div>
</div>

</center>
</body>
</html>