

<div class="card mt-2">
  <div class="card-header">
    Recherche par Critere
  </div>
  <div class="card-body">
	<form  method="GET" action="consulter.php">
	<div class="row">
		<style type="text/css">
			.col-md-6{
				height:60px;
			}
		</style>
		<div class="form-group col-md-6">
			<label>Motif paiement</label>
			<select class="form-control" name="motif">
				<option></option>
				<option>Forfait</option>
				<option>Cas par cas</option>
			</select>
		</div>

		<div class="form-group col-md-6">
			<label>Caisse etrangere</label>
			<input class="form-control" type="text" name="caisse">
		</div>
	</div>

		<!-- <button class="btn btn-secondary mt-2" type="submit" value="<?php //echo (isset($_GET['id'])?$_GET['id']:"") ?>" name="<?php //echo (isset($_GET['id'])?"id":"") ?>">Rechercher</button> -->
		<button class="btn btn-secondary mt-2" type="submit" value="" name="">Rechercher</button>
	</form>
  </div>
</div>