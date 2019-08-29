<?php 
	include("util/db.php");
	include("util/requests.php");
	include("util/functions.php");
	include("util/anomalies.php");

?>
<!DOCTYPE html>
<html>
<head>
	<title>Consulter les fichiers</title>
	<link href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">

</head>
<body>
<?php include('util/navbar.php'); ?>
<div class="container">
	<div  style="padding-top:25px;">
		<h1>Consulter les fichiers</h1>
		<div class="row">
			<div class="search col-md-7">
				<?php include("util/search.php") ?>
			</div>
			<div class="col-md-5 py-2">
				<h3>Liste des fichiers</h4>
				<ul>
					<?php 
					if($files = get_all_files($con))
						$flag = 0;
						foreach ($files as $file) {
							if(filter_file($file,$_GET)){
								$etat = ($file['code_etat']==2?"non verifié":($file['code_etat']==1?"incorrect":"correct"));
								echo "<li>"."<a href='?id=".$file['id']."'>".$file['nom']."</a> -- ".$file['nbr_lignes']."lignes -- ".$etat."</li>"; // ajouter code_etat
								$flag = 1;
							}
						}
						if($flag == 0)
							echo "<p>Aucun fichier correspondant aux criteres demandés</p>";
					?>
				</ul>
		</div>


</div>
</div>
</div>

<!-- 	<div class="containeer">
 -->	<?php if(isset($_GET['id'])){  
		$lines = get_file_lines($con, $_GET['id']);
		//print_r(filter_lines($lines, $_GET));
		if(!isset($_GET['ano'])){
	?>
	<br>
		<div style="width:97%;margin:1.5%">
		<p>Details du fichier / / / <a href='?id=<?php echo $_GET['id']; ?>&ano=1#ano'>Anomalies du fichier</a></p>
		
		<table class="table-striped table-bordered text-center" id="result" >
			<thead class="sticky-top table-dark">
			<?php 
				$parsed_header = parse_csv_line($lines[0]['contenu_ligne'],";"); // premiere ligne = entête
				//print_r($parsed_header);
				echo "<th>Num. ligne</th>";
				foreach ($parsed_header as $th) 
					echo "<th>".$th."</th>";
			?>
			</thead>
			<style type="text/css">
				.table-hover tr{
					height:20px;
				}
			</style>
			<tbody class="table-hover">
			<?php
				$i=0;
				foreach ($lines as $line) {
					if($i > 0){
						$parsed_line = parse_csv_line($lines[$i]['contenu_ligne'],";");
						//if(filter_line($parsed_line, $_GET)){ // filtering using the get requests
							echo "<tr>";
								echo "<th>".$i."</th>";
								foreach ($parsed_line as $td)
									echo "<td>".$td."</td>";
							echo "</tr>";
						//}
					}
					$i++;
				}
			?>
			</tbody>
		</table>
		</div>
		

	<?php 
		}
		else{	
			echo "<div id='ano' style='width:97%;margin:1.5%'>";
			echo "<br><p><a href='?id=".$_GET['id']."'>Details du fichier</a> / / / Anomalies du fichier</p>";

			$code_etat = select_data($con, "Fichier", ["code_etat"], "id = {$_GET['id']}")[0]['code_etat'];
			if($code_etat == '2')
				check_anomalies($con,$lines,$_GET['id']);
	?>

		<table class="table table-hover table-bordered" >
			<thead class="sticky-top table-dark">
				<th>Num. ligne</th>
				<th>Anomalies</th>
			</thead>
			<tbody>
			<?php 
				$i=0;
				foreach ($lines as $line) {
					if($i > 0){
						echo "<tr>";
						echo "<th>".$i."</th>";
						echo "<td>".code_rejet_to_motifs($con, $line['code_rejet'])."</td>";
						echo "</tr>";
					}
					$i++;
				}
			?>
			</tbody>
		</table>
	</div>
	<?php
		}
	}
	?>
<!-- 	</div>
 -->

</body>
</html>