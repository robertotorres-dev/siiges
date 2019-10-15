<!-- CARD USUARIO LATERAL -->
<aside class="col-sm-12 col-md-12 col-lg-3">
	<div class="">
			<fieldset class="border" align="center">
				<legend class="legend-circular" align="center"><img id="fotografia" class="legend-circular" src=""></legend>
				<div class="card">
					<div class="card-body text-center">
						<input type="hidden" id="id" name="id" value="<?= $_SESSION["id"] ?>">
						<h6 id="usuario" class="card-subtitle mb-2"><?= $_SESSION["usuario"] ?></h6>
						<h4 id="lblPuesto" class="card-title"></h4>
						<h5 id="lblNombre" class="card-subtitle mb-2 text-muted"></h5>
						<h6 id="lblCorreo" class="card-subtitle mb-2"></h6>
						<a href="editar-perfil.php" class="btn btn-primary btn-sm btn-block">Editar Perfil</a>
					</div>
				</div>
			</fieldset>
	</div>
</aside>
