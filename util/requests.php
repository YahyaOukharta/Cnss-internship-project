<?php 
	function insert_data($con,$table,$fields,$values){ //fields and values are arrays 
		$fields = implode(',',$fields);
		$values = '\''.implode("','",$values).'\'';
		
		$sql = "INSERT into $table ($fields) VALUES ($values);";
		//echo $sql."<br><br>";
		if(!mysqli_query($con,$sql))
			echo mysqli_error($con);
		else 
			return true; // data inserted
	}

	function select_data($con,$table,$fields,$conditions){ //fields and values are arrays 
		$data = array();
		$fields = implode(',',$fields);
		
		$sql = "SELECT $fields FROM $table WHERE $conditions;";
		//echo $sql."<br><br>";
		if(!$result = mysqli_query($con,$sql))
			echo mysqli_error($con);
		else 
			if(mysqli_num_rows($result)){
				while($row = mysqli_fetch_assoc($result))
					array_push($data, $row);
				return $data;
			}
			else 
				return false;
	}

	function update_data($con,$table,$field,$value,$conditions){ // 1 field A value
		
		$sql = "UPDATE $table SET $field = $value WHERE $conditions;";
		//echo $sql."<br><br>";
		if(!mysqli_query($con,$sql))
			echo mysqli_error($con);
		else 	
			return true; // data inserted
	}	

	function store_csv_array($con,$fname,$data)
	{
		$file_id = select_data($con, "Fichier", ["id"], 'nom = "'.$fname.'"')[0]['id'];
		$i = 0;
		foreach ($data as $line) {
				$fields = ["id_fichier", "num_ligne", "contenu_ligne"];
				$parsed_line = mysqli_real_escape_string($con,implode(';',$line));
				$values = [$file_id, $i,$parsed_line];
				if(!insert_data($con, "Det_fichier", $fields, $values))
					return false;
			$i++;
		}		
	}

	function get_all_files($con){
		return select_data($con, "Fichier", ["*"], 1);
	}

	function get_file_lines($con,$file_id){
		return select_data($con, "Det_fichier", ["*"], "id_fichier ='".$file_id."' LIMIT 15"); // limit 
	}
?>