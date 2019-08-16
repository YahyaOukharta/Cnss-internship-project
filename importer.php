
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
		<form method="POST" action="util/uploadcsv.php" enctype="multipart/form-data">
			<input type="file" name="uploadedFile">
			<input type="submit" name="upload" value="Importer">
		</form>
	</div>
</body>
</html>