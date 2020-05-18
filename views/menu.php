<?php
require_once "../models/modelo-rol.php";

?>

<header>
    <meta http-equiv="Content-Type" content="text/html; charset=gb18030">
    <div class="container">
        <nav class="navbar navbar-inverse sub-navbar navbar-fixed-top">
            <div class="container">
                <div class="navbar-header">
                    <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#subenlaces">
                        <span class="sr-only">Interruptor de Navegación</span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                    </button>
                    <a id="navImgJalisco" class="navbar-brand" href="home.php"><img src="../images/jalisco-logo.png" height="30"></a>
                    <a id="navLetrasSiiga" class="navbar-brand" href="home.php">SIIGES</a>
                </div>
                <div class="collapse navbar-collapse" id="subenlaces">
                    <ul class="nav navbar-nav navbar-right">

                        <?php if(Rol::ROL_GESTOR == $_SESSION["rol_id"]): ?>
                        <li class="dropdown">
                            <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false">RVOE<span class="caret"></span></a>
                            <ul class="dropdown-menu" role="menu">
                                <li><a href="mis-solicitudes.php">Mis solicitudes</a></li>
                            </ul>
                        </li>
                        <?php endif; ?>
                        <?php if(Rol::ROL_REPRESENTANTE_LEGAL == $_SESSION["rol_id"]): ?>
                        <li class="dropdown">
                            <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false">RVOE<span class="caret"></span></a>
                            <ul class="dropdown-menu" role="menu">
                                <li><a href="institucion-planteles.php">Mi institución</a></li>
                                <li><a href="mis-solicitudes.php">Mis solicitudes</a></li>
                                <li><a href="usuarios.php">Mis usuarios</a></li>
                            </ul>
                        </li>
                        <li class="dropdown">
                            <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false">Control Escolar<span class="caret"></span></a>
                            <ul class="dropdown-menu" role="menu">
                                <li><a href="ce-planteles-institucion.php">Mis programas de Estudio</a></li>
                            </ul>
                        </li>
                        <li class="dropdown">
                            <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false"><span class="glyphicon glyphicon-stats"></span>Reportes<span class="caret"></span></a>
                            <ul class="dropdown-menu" role="menu">
                                <li><a href="reportes-revoe-ies.php">Reportes RVOE</a></li>
                            </ul>
                        </li>
                        <?php endif; ?>

                        <?php if(Rol::ROL_EVALUADOR == $_SESSION["rol_id"]): ?>
                        <li class="dropdown">
                            <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false">RVOE<span class="caret"></span></a>
                            <ul class="dropdown-menu" role="menu">
                                <li><a href="curriculum.php">Curriculum</a></li>
                                <li><a href="evaluaciones-evaluador.php">Mis evaluaciones</a></li>
                            </ul>
                        </li>
                        <?php endif;?>

                        <?php if(Rol::ROL_JEFE_EVALUACION == $_SESSION["rol_id"] ): ?>
                        <li class="dropdown">
                            <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false">RVOE<span class="caret"></span></a>
				            <ul class="dropdown-menu" role="menu">
				                  <li><a href="solicitudes.php">Solicitudes</a></li>
				            </ul>
				        </li>
				        <?php endif;?>

				        <?php if( Rol::ROL_INSPECTOR == $_SESSION["rol_id"]): ?>
				        <li class="dropdown">
				            <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false">RVOE<span class="caret"></span></a>
							<ul class="dropdown-menu" role="menu">
								<li><a href="inspecciones-inspector.php">Mis Inspecciones</a></li>
						    </ul>
				        </li>
						<?php endif;?>

						<?php if(Rol::ROL_JEFE_INSPECCION == $_SESSION["rol_id"] ): ?>
				        <li class="dropdown">
				            <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false">RVOE<span class="caret"></span></a>
				            <ul class="dropdown-menu" role="menu">
				    	        <li><a href="solicitudes.php">Solicitudes</a></li>
				                <li><a href="inspecciones.php">Inspecciones</a></li>
				            </ul>
				        </li>
				        <?php endif;?>

                        <?php if(Rol::ROL_CONTROL_ESCOLAR_IES == $_SESSION["rol_id"] ): ?>
				        <li class="dropdown">
				            <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false">Control Escolar<span class="caret"></span></a>
				            <ul class="dropdown-menu" role="menu">
                      <li><a href="ce-planteles-institucion.php">Mis Programas de Estudios</a></li>
				    	        <li><a href="ce-validacion-ies.php">Validaci&oacuten de alumnos</a></li>
				            </ul>
				        </li>
				        <?php endif;?>

                        <?php if(Rol::ROL_CONTROL_DOCUMENTAL == $_SESSION["rol_id"] ): ?>
				        <li class="dropdown">
				            <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false">RVOE<span class="caret"></span></a>
				            <ul class="dropdown-menu" role="menu">
				    	        <li><a href="solicitudes.php">Solicitudes</a></li>
				            </ul>
				        </li>
				        <?php endif;?>

                        <?php if(Rol::ROL_SICYT_LECTURA == $_SESSION["rol_id"] || Rol::ROL_SICYT_EDITAR == $_SESSION["rol_id"] ): ?>
				        <li class="dropdown">
				            <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false">RVOE<span class="caret"></span></a>
				            <ul class="dropdown-menu" role="menu">
				    	        <li><a href="solicitudes.php">Solicitudes</a></li>
				            </ul>
				        </li>
				        <li class="dropdown">
				            <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false"><span class="glyphicon-status"></span>Reportes<span class="caret"></span></a>
				            <ul class="dropdown-menu" role="menu">
				    	        <li><a href="reportes-rvoe.php">Reportes RVOE</a></li>
				            </ul>
				        </li>
				        <?php endif;?>

                        <?php if(Rol::ROL_ADMIN == $_SESSION["rol_id"] ): ?>
				        <li class="dropdown">
				            <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false"><span class="glyphicon glyphicon-cog"></span>RVOE<span class="caret"></span></a>
				            <ul class="dropdown-menu" role="menu">
				    	        <li><a href="planteles.php">Planteles</a></li>
				    	        <li><a href="usuarios.php">Usuarios</a></li>
				    	        <li><a href="solicitudes.php">Solicitudes</a></li>
				    	        <li><a href="noticias.php">Noticias</a></li>
				    	        <li><a href="notificaciones.php">Notificaciones</a></li>
				    	        <li><a href="alta-pagos.php">Pagos</a></li>
				    	        <li><a href="alta-modulos-roles.php">Accesos</a></li>
                      <li><a href="preguntas_evaluacion.php">Preguntas Evalución</a></li>
				            </ul>
				        </li>
                        <li class="dropdown">
				            <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false"><span class="glyphicon-status"></span>Reportes<span class="caret"></span></a>
				            <ul class="dropdown-menu" role="menu">
				    	        <li><a href="reportes-rvoe.php">Reportes RVOE</a></li>
				            </ul>
				        </li>
                        <?php endif;?>

                        <?php if(Rol::ROL_CONTROL_ESCOLAR_SICYT == $_SESSION["rol_id"] || (Rol::ROL_ADMIN == $_SESSION["rol_id"] )): ?>
				        <li class="dropdown">
				            <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false"><span class="glyphicon glyphicon-cog"></span>Control Escolar<span class="caret"></span></a>
				            <ul class="dropdown-menu" role="menu">
                      <li><a href="ce-instituciones.php">Instituciones</a></li>
				    	        <li><a href="ce-validacion.php">Validación CE</a></li>
				            </ul>
				        </li>
				        <?php endif;?>

                        <li><a id="navCerrar" href="../logout.php"><span class="glyphicon glyphicon-log-out"></span>Cerrar sesi&oacute;n</a></li>

                    </ul>
                </div>
            </div>
        </nav>
    </div>
</header>
