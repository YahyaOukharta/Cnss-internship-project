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
<h1>Consulter les fichiers</h1>
<div>
	<ul>
		<?php 
		if($files = get_all_files($con))
			foreach ($files as $file) 
				echo "<li>"."<a href='?id=".$file['id']."'>".$file['nom']."</a>"."</li>"; // ajouter code_etat
		?>
	</ul>
	<?php if(isset($_GET['id'])){  
		$lines = get_file_lines($con, $_GET['id']);
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
						echo "<tr>";
							$parsed_line = parse_csv_line($lines[$i]['contenu_ligne'],";");
							echo "<th>".$i."</th>";
							foreach ($parsed_line as $td)
								echo "<td>".$td."</td>";
						echo "</tr>";
					}
					$i++;
				}
			?>
			</tbody>
		</table>
	<?php 
		}else{	
			echo "<p><a href='?id=".$_GET['id']."'>Details du fichier</a> / / / Anomalies du fichier</p>";
			check_anomalies($con,$lines);
			}
	}
	?>
</div>
</body>
</html>