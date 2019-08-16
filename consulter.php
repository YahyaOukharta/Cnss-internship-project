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


<div class="row">

<div class="col-md-5 py-2">
		<h1>Consulter les fichiers</h1>
	<ul>
		<?php 
		if($files = get_all_files($con))
			foreach ($files as $file) {
				$etat = ($file['code_etat']==2?"non verifié":($file['code_etat']==1?"incorrect":"correct"));
				echo "<li>"."<a href='?id=".$file['id']."'>".$file['nom']."</a>  ".$etat."</li>"; // ajouter code_etat
			}
		?>
	</ul>
</div>

<div class="search col-md-7">
	<?php include("util/search.php") ?>
</div>
</div>
</div>
	<div class="container">
	<?php if(isset($_GET['id'])){  
		$lines = get_file_lines($con, $_GET['id']);
		//print_r(filter_lines($lines, $_GET));
		if(!isset($_GET['ano'])){
	?>
		<p>Details du fichier / / / <a href='?id=<?php echo $_GET['id']; ?>&ano=1'>Anomalies du fichier</a></p>
		
		<table class="table-striped table-bordered" id="result">
			<thead class="sticky-top table-dark">
			<?php 
				$parsed_header = parse_csv_line($lines[0]['contenu_ligne'],";"); // premiere ligne = entête
				//print_r($parsed_header);
				echo "<th>Num. ligne</th>";
				foreach ($parsed_header as $th) 
					echo "<th>".$th."</th>";
			?>
			</thead>
			<tbody class="table-hover">
			<?php
				$i=0;
				foreach ($lines as $line) {
					if($i > 0){
						$parsed_line = parse_csv_line($lines[$i]['contenu_ligne'],";");
						if(filter_line($parsed_line, $_GET)){ // filtering using the get requests
							echo "<tr>";
								echo "<th>".$i."</th>";
								foreach ($parsed_line as $td)
									echo "<td>".$td."</td>";
							echo "</tr>";
						}
					}
					$i++;
				}
			?>
			</tbody>
		</table>
	<?php 
		}
		else{	
			echo "<p><a href='?id=".$_GET['id']."'>Details du fichier</a> / / / Anomalies du fichier</p>";

			$code_etat = select_data($con, "Fichier", ["code_etat"], "id = {$_GET['id']}")[0]['code_etat'];
			if($code_etat == '2')
				check_anomalies($con,$lines,$_GET['id']);
	?>
		<table class="table table-hover table-bordered">
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

	<?php
		}
	}
	?>
	</div>
</div>
</div>

</script>
</body>
</html>