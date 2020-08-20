<?php
	include_once 'dbconfig.php';

	$idFacture;
	if(isset($_GET['id'])){
		$idFacture = $_GET['id'];
	}

	$n_facture; 
	$mois; 
	$annee; 
	$valeur_compteur; 
	$consomation; 
	$montant; 
	$statut; 
	$estimated; 
	$idAbonnement;
	$adresse;
	$idClient;
	$nom_client; 
	$n_tel_client; 
	$idDistributeur; 
	$nom_distributeur; 
	$agence_distributeur; 
	$n_tel_distributeur; 
	$adresse_distributeur; 

	$sql_query_last_mount_compteur = "SELECT f.n_facture, f.mois, f.annee, f.valeur_compteur, f.ecart, f.montant, f.statut, f.estimated, f.abonnement, a.adresse, a.client, c.nom as nom_client, c.n_tel as n_tel_client, a.distributeur, d.nom as nom_distributeur, d.n_tel as n_tel_distributeur , d.agence as agence_distributeur, d.adresse as adresse_distributeur FROM facture as f, abonnement as a,client as c , distributeur as d WHERE d.idDistributeur = a.distributeur AND f.abonnement = a.idAbonnement AND c.idClient = a.client AND f.idFacture = ".$idFacture;
		$result_set_last_mount_compteur=mysql_query($sql_query_last_mount_compteur);
		while($row=mysql_fetch_row($result_set_last_mount_compteur))
		{
			$n_facture = $row[0]; 
			$mois = $row[1];
			$annee = $row[2];
			$valeur_compteur = $row[3];
			$consomation = $row[4];
			$montant = $row[5];
			$statut = $row[6];
			$estimated = $row[7];
			$idAbonnement = $row[8];
			$adresse = $row[9];
			$idClient = $row[10];
			$nom_client = $row[11];
			$n_tel_client = $row[12];
			$idDistributeur = $row[13];
			$nom_distributeur = $row[14];
			$n_tel_distributeur = $row[15];
			$agence_distributeur = $row[16];
			$adresse_distributeur = $row[17];
		}
?>
<!doctype html>
<html>
	<head>
		<meta charset="utf-8">
		<title>Facture</title>
		<link rel="stylesheet" href="public/css/facture-style.css">	

		<script src="public/js/jquery.min.js" type="text/javascript"></script>
		<script src="public/js/highcharts.js"></script>
		<script src="public/js/exporting.js"></script>

	</head>
	<body>
		<header>
			<h1>Facture</h1>
			<address contenteditable>
				<p><?php echo $nom_distributeur;?></p>
				<p><?php echo "Agence :".$agence_distributeur;?></p>
				<p><?php echo "Adresse :".$adresse_distributeur;?></p>
			</address>
			<span><img alt="" src="public/img/logo.png"><input type="file" accept="image/*"></span>
		</header>
		<article>
			<h1>Recipient</h1>
			<address contenteditable>
				<p>A <?php echo $nom_client; ?></p>
				<br>
				<p><?php echo $adresse;?></p>
				<p><?php echo $n_tel_client;?></p>
			</address>

			<table class="meta">
				<tr>
					<th><span contenteditable>Facture #</span></th>
					<td><span contenteditable><?php echo $n_facture;?></span></td>
				</tr>
				<tr>
					<th><span contenteditable>Date</span></th>
					<td><span contenteditable><?php echo $mois." - ".$annee;?></span></td>
				</tr>
				<tr>
					<th><span contenteditable>Montant (HT)</span></th>
					<td><span><?php echo $montant;?></span><span id="prefix" contenteditable> Dh</span></td>
				</tr>
			</table>
			<table class="inventory">
				<thead>
					<tr>
						<th><span contenteditable>Valeur conteur</span></th>
						<th><span contenteditable>Quantité consommée </span></th>
						<th><span contenteditable>Prix</span></th>
					</tr>
				</thead>
				<tbody>
					<tr>
						<td><span contenteditable><?php echo $valeur_compteur;?></span></td>
						<td><span contenteditable><?php echo $consomation;?></span><span id="prefix" contenteditable> m3</span></td>
						<td><span><?php echo $montant;?></span><span data-prefix>Dh</span></td>
					</tr>
				</tbody>
			</table>
			<table class="balance">
				<tr>
					<th><span contenteditable>Total (HT)</span></th>
					<td><span><?php echo $montant;?></span><span data-prefix>Dh</span></td>
				</tr>
				<tr>
					<th><span contenteditable>TVA (7%)</span></th>
					<td><span><?php echo $montant*0.07;?></span><span data-prefix>Dh</span></td>
				</tr>
				<tr>
					<th><span contenteditable>Montant (TTC)</span></th>
					<td><?php echo $montant*1.07;?></span><span data-prefix>Dh</span></td>
				</tr>
			</table>

		</br>


								
						<?php

						 $sql_query="SELECT mois,annee,ecart FROM facture WHERE abonnement=".$idAbonnement." and statut != 'brouillon' AND annee <= ".$annee." AND mois <= ".$mois." order by annee asc, mois asc";
						 $result_set=mysql_query($sql_query);
						 $array_factures= array();
						while($row=mysql_fetch_row($result_set))
							{
								array_push($array_factures,  array('date' => $row[0]."-".$row[1], 'valeur' => $row[2]));
								
							}
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
							        tooltip: {},
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

		</article>

	</body>
</html>