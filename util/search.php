

<div class="card mt-2">
  <div class="card-header">
    Recherche par Critere
  </div>
  <div class="card-body">
	<form  method="GET" action="<?php echo $_SERVER["PHP_SELF"]."#result"; ?>">
	<div class="row">
		<style type="text/css">
			.col-md-6{
				height:60px;
			}
		</style>
	<div class="form-group col-md-6">
		<label>Immatriculation</label>
		<input class="form-control" type="text" name="imma">
	</div>
	<div class="form-group col-md-6">
		<label>Nombre de forfaits de la caisse</label>
		<input class="form-control" type="text" name="nforfait"><br><br>
	</div>
	<div class="form-group col-md-6">
		<label>Caisse etrangere</label>
		<select class="form-control" name="caisse">
			<option></option>
			<option>INSS DE LIEIDA</option>
			<option>INSS DE MALAGA</option>
			<option>INSS DE BARCELONA</option>
		</select>
	</div>
		</div>

		<button class="btn btn-secondary mt-2" type="submit" value="<?php echo (isset($_GET['id'])?$_GET['id']:"") ?>" name="<?php echo (isset($_GET['id'])?"id":"") ?>">Rechercher</button>
	</form>
  </div>
</div>