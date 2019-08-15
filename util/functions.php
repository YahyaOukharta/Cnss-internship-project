<?php
	function fname_split($fname){
		$split_name = explode("_",explode(".",$fname)[0]);
		
		//echo "<br><br>";print_r($split_name);
		
		if(count($split_name) != 4)
			return false;
		else if($split_name[0] != "FO")		//type de remboursement
			return false;
		else if($split_name[1] != "INSS")   //caisse etrangere 
			return false;
		else if($split_name[2] != "201500") //Année d'arrêt de la créance/00 remboursement par forfait
			return false;
		else if(strlen($split_name[3]) != 8 && !$time=strtotime($split_name[3])) // date correcte yyyymmjj
			return false;	
		
		return $split_name;
	}

	function csv_to_array($path,$delimiter,$maxlinelen)
	{
		$result = array();
		if($f=fopen($path,"r"))
		{
			while($line = fgetcsv($f,$maxlinelen,$delimiter))
				array_push($result, $line);
			fclose($f);
		}
		return $result;
	}

	function parse_csv_line($line,$delimiter){
		return explode($delimiter, $line);
	}

	function filter_line($line,$filters){ //2 : imma  7 : caisse etrangere
			if(empty($filters['imma']) || $line[2] == $filters['imma'])
				if(empty($filters['caisse']) || $line[7] == $filters['caisse'])
					if(empty($filters['nforfait']) || $line[9] == $filters['nforfait'])
						return true;		
			return false;
	}
?>