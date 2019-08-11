<?php
	function check_anomalies($con,$lines){
		$code_rejet = "";
		//print_r($lines);
		//foreach ($lines as $line) {

			//nom prenom et imma 
			$p_line = parse_csv_line($lines[2]['contenu_ligne'], ";");
			print_r($p_line);
			if(check_nom_prenom_imma($con,$p_line))
				$code_rejet.="0";
			return $code_rejet;
	}

	function check_nom_prenom_imma($con,$p_line)
	{
		$condition = "nom = '{$p_line[0]}' 
					and prenom = '{$p_line[1]}' 
					and immatriculation = '{$p_line[2]}'";
		if(!select_data($con, "Assuré", ["*"], $condition))
			return false;
		return true;
	}
?>