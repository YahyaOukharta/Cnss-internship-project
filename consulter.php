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
</head>
<body>
<div class="file_list" style="width:30%;float:left;">
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

<div class="search" style="width:70%;height:140px;border: 1px solid black;margin-left: 30%;margin-top: 20px;">
	<h4>Recherche par critere</h4>
	<?php //include("util/search.php") ?>
<form method="GET" action="<?php echo $_SERVER["PHP_SELF"]; ?>">
	<label>Immatriculation</label>
	<input type="text" name="imma">
	<label>Caisse etrangere</label>
	<select name="caisse">
		<option></option>
		<option>INSS DE LIEIDA</option>
		<option>INSS DE MALAGA</option>
		<option>INSS DE BARCELONA</option>
	</select>
	<button type="submit" value="<?php echo (isset($_GET['id'])?$_GET['id']:"") ?>" name="<?php echo (isset($_GET['id'])?"id":"") ?>">Rechercher</button>
</form>
</div>

	<?php if(isset($_GET['id'])){  
		$lines = get_file_lines($con, $_GET['id']);
		//print_r(filter_lines($lines, $_GET));
		if(!isset($_GET['ano'])){
	?>

		<p>Details du fichier / / / <a href='?id=<?php echo $_GET['id']; ?>&ano=1'>Anomalies du fichier</a></p>
		
		<table>
			<thead>
			<?php 
				$parsed_header = parse_csv_line($lines[0]['contenu_ligne'],";"); // premiere ligne = entête
				//print_r($parsed_header);
				echo "<th>Num. ligne</th>";
				foreach ($parsed_header as $th) 
					echo "<th>".$th."</th>";
			?>
			</thead>
			<tbody>
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
		<table>
			<thead>
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
</body>
</html>