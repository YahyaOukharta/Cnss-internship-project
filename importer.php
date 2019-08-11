
<!DOCTYPE html>
<html>
<head>
	<title>Importer un fichier .csv</title>
</head>
<body>
	<h1>Importer un fichier .csv</h1>
	<form method="POST" action="util/uploadcsv.php" enctype="multipart/form-data">
		<input type="file" name="uploadedFile">
		<input type="submit" name="upload" value="Importer">
	</form>
</body>
</html>