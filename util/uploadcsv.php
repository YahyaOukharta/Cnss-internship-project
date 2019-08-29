<?php 
	include('db.php');
	include('functions.php');
	include('requests.php');


	if(isset($_POST['upload']) && isset($_FILES['uploadedFile'])){
		print_r($_FILES); echo "<br>";

		$file = $_FILES['uploadedFile']; 

		$fname = $file['name'];
		$ftype = $file['type'];

		//echo "<br>".$fname."  ".$ftype;

		if($ftype != "text/csv")
			header("location: ../importer.php?error=1");
			//echo "Veuillez importer un fichier .csv";
		else if(!$split_name = fname_split($fname))
			header("location: ../importer.php?error=2");
			//echo "Veuillez importer un fichier avec un nom formatté correctement";
		else{
			echo "Fichier correct<br>";

			if(!select_data($con, "Fichier", ["nom"], 'nom = "'.$fname.'"')){ // si la requete retourne 0 ligne 
				if(move_uploaded_file($file['tmp_name'], "../uploads/".$fname))
				{
					$data = csv_to_array("../uploads/".$fname,';',250);
					$date_creation = date("Y-m-d"); 
					$fields = array('nom','date_creation','date_modification','nbr_lignes');
					$values = array($fname,$date_creation,$date_creation,count($data)-1);
					insert_data($con,"Fichier", $fields, $values);	
					echo "Fichier ajouté à la base de donnees<br><br>";
					//process csv here
					if(store_csv_array($con,$fname,$data))
						header("location: ../importer.php?success=1");
						//echo "les lignes du .csv on ete stockées avec succes";
					else
						header("location: ../importer.php?error=3");
						//echo "error stocking lines";
				 }
			}else
				header("location: ../importer.php?error=4");
				//echo "Fichier existe deja";
		}
	}
?>