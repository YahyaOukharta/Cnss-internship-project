<?php
	function check_anomalies($con,$lines,$file_id){
		$code_rejet = "";
		//print_r($lines);
		$anomalie = false;
		$i = 0;
		foreach ($lines as $line)
		{
			if($i > 0){
				$p_line = parse_csv_line($line['contenu_ligne'], ";");//parse line 
				//print_r($p_line);
				//process line
				$code_rejet =get_code_rejet($con, $p_line);
				if(!empty($code_rejet)) $anomalie = true;
				//insert code rejet into database
				$line_content = mysqli_real_escape_string($con,$line['contenu_ligne']);
				update_data($con, "Det_fichier", "code_rejet",$code_rejet, 
					"contenu_ligne = '{$line_content}' and id_fichier = '{$file_id}'");
			}
			$i++;
		}
		if($anomalie == false)
			update_data($con, "Fichier","code_etat",0, " id = {$file_id}"); // 0 = correct
		else
			update_data($con, "Fichier","code_etat",1, " id = {$file_id}"); // 1 = incorrect

		header("location: consulter.php?id={$file_id}&ano=1");

	}

	function check_nom_prenom_imma($con,$p_line)
	{
		$condition = "nom = '{$p_line[0]}' 
					and prenom = '{$p_line[1]}' 
					and immatriculation = '{$p_line[2]}'";
		if(!select_data($con, "Assure", ["*"], $condition))
			return false;
		return true;
	}
	function check_fod($p_line){ //existe ou pas dans le fichier csv 
		if(empty($p_line[4]))
			return false;	
		return true;
	}
	function check_date_debut_fin($p_line){
		$date_debut = $p_line[5];
		$date_fin = $p_line[6];
		$p_debut = date_parse_from_format("d/m/Y", $date_debut);
		$p_fin = date_parse_from_format("d/m/Y", $date_fin);
		
		$month_diff = $p_fin['month'] - $p_debut['month'];
		if($month_diff >= 12 || $month_diff < 0 )
			return false;
		if($p_debut['year'] != $p_fin['year'])
			return false; 
		return $month_diff;
	}
	function check_nbr_forfait($p_line){
		if((int)$p_line[9] != check_date_debut_fin($p_line))
			return false;
		return true;
	}
	function check_caisse($con,$p_line)
	{
		$condition = "nom = '{$p_line[7]}'";
		if(!select_data($con, "Caisse_etrangere", ["*"], $condition))
			return false;
		return true;
	}
	function check_facture($p_line)
	{
		if(empty($p_line[8]))
			return false;	
		return true;
	}
	function check_annee_apurement($p_line){
		$annee_debut = date_parse_from_format("d/m/Y", $p_line[5])['year'];
		if($annee_debut != $p_line[10])
			return false;
		return true;
	}

	function get_code_rejet($con,$p_line){
		$code_rejet = "";
		if(!check_nom_prenom_imma($con,$p_line)) // assuré invalide (inexistant dans la base) : 1
			$code_rejet.="1";
		if(!check_fod($p_line))  			//fod inexistant : 2
			$code_rejet.="2";
		if(!check_date_debut_fin($p_line))  //date debut et/ou date fin invalides
			$code_rejet.="3";
		if(!check_nbr_forfait($p_line))		//nombre de forfait invalide
			$code_rejet.="4";
		if(!check_caisse($con,$p_line))		//caise etrangere incorrecte
			$code_rejet.="5";
		if(!check_facture($p_line))			//facture inexistante
			$code_rejet.="6";
		if(!check_annee_apurement($p_line)) //annee apurement invalide
			$code_rejet.="7";

		return $code_rejet;
	}

	function code_rejet_to_motifs($con,$code)
	{
		$motifs= array();

		for($i = 0;$i < strlen($code); $i++) {
			array_push($motifs,select_data($con, "Motif_rejet", ["motif"], "id = {$code[$i]}")[0]["motif"]);
		}
		return implode(", ", $motifs);
	}
?>