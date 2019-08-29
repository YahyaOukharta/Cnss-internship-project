
<!DOCTYPE html>
<html>
<head>
	<title>Importer un fichier .csv</title>
	<link href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
</head>
<body>
	<?php include("util/navbar.php"); ?>
	<div class="container">
		<br>
		<h3>Importer un fichier .csv</h1>
		<br>
		<?php 
			if(isset($_GET['success']))
				echo "<div class='alert alert-success'>Fichier importé avec succès</div>";
			else if(isset($_GET['error'])){
				$errcode = $_GET['error'];
				$errmsg = "";
				if($errcode == '1')
					$errmsg = "Veuillez importer un fichier .csv";
				else if($errcode == '2')
					$errmsg = "Veuillez importer un fichier avec un nom formatté correctement";
				else if($errcode == '3')
					$errmsg = "Error de stockage des lignes";
				else if($errcode == '4')
					$errmsg = "Fichier existe deja";
				echo "<div class='alert alert-danger'>".$errmsg."</div>";
			}
		?>
		<form method="POST" action="util/uploadcsv.php" enctype="multipart/form-data">
			<input type="file" name="uploadedFile">
			<input type="submit" name="upload" value="Importer">
		</form>
	</div>
</body>
</html>