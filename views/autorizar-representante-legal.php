<!DOCTYPE html>
  <html>
  <head>
  	<meta charset="utf-8">
  	<meta http-equiv="X-UA-Compatible" content="IE=edge">
  	<meta name="viewport" content="width=device-width, initial-scale=1">
  	<title>Menu RVOE (SICyT)</title>

  	<!-- CSS GOB.MX -->
  	<link href="../favicon.ico" rel="shortcut icon">
  	<link href="https://framework-gb.cdn.gob.mx/assets/styles/main.css" rel="stylesheet">
  	<!-- CSS SIIGES -->
  	<link rel="stylesheet" type="text/css" href="../css/estilos.css">
  	<!-- CSS DATATABLES -->
  	<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.19/css/jquery.dataTables.css">
  </head>

  <body class="">
  	<!-- HEADER Y BARRA DE NAVEGACION -->
  	<?php require_once "menu.php"; ?>

  	<!-- CUERPO DEL FORMULARIO -->
  	<div class="container">
  		<section class="main row margin-section-formularios">
  			<div class="col-sm-12 col-md-12 col-lg-12">
  				<ol class="breadcrumb">
  					<li><a href="#"><i class="icon icon-home"></i></a></li>
  					<li><a href="#">SIIGES</a></li>
  					<li class="active">Menú autorizaciones SICyT</li>
  				</ol>

  				<h2>Menú autorizaciones SICyT</h2>
  				<hr class="red">

  				<!-- INICIA DATA TABLE -->
  				<table id="my_table" class="table table-striped">
  					<thead>
  						<tr>
  							<th>ID</th>
  							<th>Tipo de trámite</th>
                <th>Institución que solicita</th>
  							<th>Fecha del trámite</th>
  							<th>Responsable del trámite</th>
  							<th>Status</th>
  							<th>Observaciones</th>
                <th>Acciones</th>
  						</tr>
  					</thead>
  					<tbody>
  						<tr>
  							<td>1117586</td>
  							<td>Aprobar al Representante Legal</td>
  							<td>Universidad de Guadalajara</td>
  							<td>10/05/2017</td>
  							<td>Secretario General SICyT</td>
                <td>En espera</td>
                <td>Retrasado por 3 días</td>
  							<td>
  								<a href="edicion-solicitud.php"><span id="" title="Ver petición a detalle" class="glyphicon glyphicon-eye-open col-sm-1 size_icon"></span></a>
  								<a href="#" data-toggle="modal" data-target="#modalStatus"><span id="" title="Cambiar Status" class="glyphicon glyphicon-edit col-sm-1 size_icon"></span></a>
  								<a href="#" data-toggle="modal" data-target="#modalEliminar"><span id="" title="Eliminar petición" class="glyphicon glyphicon-trash col-sm-1 size_icon"></span></a>
  							</td>
  						</tr>
  					</tbody>
            <tbody>
              <tr>
                <td>1117677</td>
                <td>Aprobar Acta Constitutiva</td>
                <td>Universidad Lamar</td>
                <td>12/08/2018</td>
                <td>Gerente General</td>
                <td>Aprobado</td>
                <td>Sin Observaciones</td>
                <td>
                  <a href="edicion-solicitud.php"><span id="" title="Ver petición a detalle" class="glyphicon glyphicon-eye-open col-sm-1 size_icon"></span></a>
                  <a href="#" data-toggle="modal" data-target="#modalStatus"><span id="" title="Cambiar Status" class="glyphicon glyphicon-edit col-sm-1 size_icon"></span></a>
                  <a href="#" data-toggle="modal" data-target="#modalEliminar"><span id="" title="Eliminar petición" class="glyphicon glyphicon-trash col-sm-1 size_icon"></span></a>
                </td>
              </tr>
            </tbody>
  				</table>
  			</div>

  			<!-- MODAL DE CONFIRMACION DE ELIMINAR -->
  			<div class="modal fade" id="modalEliminar" tabindex="-1" role="dialog" aria-labelledby="exampleModalLongTitle" aria-hidden="true">
  				<div class="modal-dialog" role="document">
  					<div class="modal-content">
  						<div class="modal-header">
  							<h5 class="modal-title" id="exampleModalLongTitle">Eliminar registro</h5>
  							<button type="button" class="close" data-dismiss="modal" aria-label="Close">
  								<span aria-hidden="true">&times;</span>
  							</button>
  						</div>
  						<div class="modal-body text-center">
  							¿Está seguro de que quiere eliminar el registro seleccionado?<br>
  							<div class="small text-center">
  								Una vez eliminado deberá contactar al Administrador en caso de querer recuperarlo
  							</div>
  						</div>
  						<div class="modal-footer">
  							<button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
  							<button type="button" class="btn btn-primary">Aceptar</button>
  						</div>
  					</div>
  				</div>
  			</div>

        <!-- MODAL DE CAMBIAR STATUS -->
        <div class="modal fade" id="modalStatus" tabindex="-1" role="dialog" aria-labelledby="exampleModalLongTitle" aria-hidden="true">
          <div class="modal-dialog" role="document">
            <div class="modal-content">
              <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLongTitle">Cambio de Status</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true">&times;</span>
                </button>
              </div>
              <div class="modal-body text-center">
                Seleccione el nuevo Status que se le dará a este trámite:<br>
                <div class="form-group">
                <select id="" class="form-control">
                  <option>Seleccione un Status</option>
                  <option>APROBADO</option>
                  <option>EN ESPERA</option>
                  <option>OTRO STATUS</option>
                  <option>...</option>
                </select>
              </div>
              </div>
              <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
                <button type="button" class="btn btn-primary">Aceptar</button>
              </div>
            </div>
          </div>
        </div>

  		</section>
  	</div>


  	<!-- JS GOB.MX -->
  	<script src="https://framework-gb.cdn.gob.mx/gobmx.js"></script>
  	<!-- JS JQUERY -->
  	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
  	<!-- JS DATATABLES -->
  	<script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/1.10.19/js/jquery.dataTables.js"></script>

  	<!-- SECCION PARA SCRIPTS -->
  	<script type="text/javascript">
  		$(document).ready( function () {
  			$('#my_table').DataTable();
  		} );
  	</script>

  </body>
  </html>
