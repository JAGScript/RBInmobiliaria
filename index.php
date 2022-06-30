<?php
	error_reporting(E_ALL ^ E_NOTICE);
	date_default_timezone_set('America/Guayaquil');
	session_start();
	require_once('class/public.class.php');
	require_once('class/private.db.php');
	
	$gbd = new DBConn();
	
	$init = new Init;
	
	$hoy = date("Y-m-d");
?>
<!DOCTYPE html>
<html>
	<head>
		<title>Inmobiliaria RB</title>
		<meta charset="utf-8">
		<script src="js/jquery.js"></script>
		<script src="js/jquery-ui.min.js"></script>
		<script src="js/bootstrap.js"></script>
		<script src="js/bootstrap.min.js"></script>
		<link rel="stylesheet" type="text/css" href="css/bootstrap.css" />
		<link rel="stylesheet" type="text/css" href="css/bootstrap-theme.css" />
		<link rel="stylesheet" href="css/morris.css">
		<script src="js/morris.js"></script>
		<script src="js/raphael-min.js"></script>
		<link href="css/bootstrap-switch.css" rel="stylesheet">
		<script src="js/bootstrap-switch.js"></script>
		<script src="js/typeahead.js"></script>
		<link rel="stylesheet" type="text/css" href="css/jquery.datetimepicker.css"/>
		<link rel="stylesheet" type="text/css" href="css/jquery-ui.css">
		<script src="js/ajaxupload.js"></script>
		<style>
			.content-login{
				border:2px solid #ccc; 
				padding:25px;
				-webkit-box-shadow: 10px 10px 10px 10px #ccc;
				box-shadow: 10px 10px 10px 10px #ccc;
				-webkit-border-radius: 15px;
				border-radius: 15px;
			}
			
			/* make sidebar nav vertical */ 
			@media (min-width: 768px) {
				.sidebar-nav .navbar .navbar-collapse {
					padding: 0;
					max-height: none;
				}
				.sidebar-nav .navbar ul {
					float: none;
				}
				.sidebar-nav .navbar ul:not {
					display: block;
				}
				.sidebar-nav .navbar li {
					float: none;
					display: block;
				}
				.sidebar-nav .navbar li a {
					padding-top: 12px;
					padding-bottom: 12px;
				}
			}
			.nav li:hover > ul {
				display:block;
			}
			
			.nav li ul li {
				position:relative;
			}
			
			.nav li ul li ul {
				right:-140px;
				top:0px;
			}

			.typeahead,
			.tt-query,
			.tt-hint {
				
			}

			.typeahead {
				background-color: #fff;
			}

			.typeahead:focus {
				border: 2px solid #0097cf;
			}

			.tt-query {
				-webkit-box-shadow: inset 0 1px 1px rgba(0, 0, 0, 0.075);
				 -moz-box-shadow: inset 0 1px 1px rgba(0, 0, 0, 0.075);
					  box-shadow: inset 0 1px 1px rgba(0, 0, 0, 0.075);
			}

			.tt-hint {
				color: #999
			}

			.tt-menu {
				width: 100%;
				margin: 12px 0;
				padding: 8px 0;
				background-color: #fff;
				border: 1px solid #ccc;
				border: 1px solid rgba(0, 0, 0, 0.2);
				-webkit-border-radius: 8px;
				 -moz-border-radius: 8px;
					  border-radius: 8px;
				-webkit-box-shadow: 0 5px 10px rgba(0,0,0,.2);
				 -moz-box-shadow: 0 5px 10px rgba(0,0,0,.2);
					  box-shadow: 0 5px 10px rgba(0,0,0,.2);
			}

			.tt-suggestion {
				padding: 3px 20px;
				line-height: 24px;
			}

			.tt-suggestion:hover {
				cursor: pointer;
				color: #fff;
				background-color: #0097cf;
			}

			.tt-suggestion.tt-cursor {
				color: #fff;
				background-color: #0097cf;

			}

			.tt-suggestion p {
				margin: 0;
			}

			.gist {
				font-size: 14px;
			}
			
			input {
				autocomplete: off !important;
			}
		</style>
	</head>
	<body style="background-image: url('img/fondo.png');">
		<div class="contenedor">
			<div class="row">
				<?php if($_SESSION['auth'] == md5('M45T3R')){?>
				<script src="js/menu.js"></script>
				<link rel="stylesheet" type="text/css" href="css/menu.css" />
				<div class="col-md-2">
					<?php if($_SESSION['autentica'] == md5('Inmo2022')){?>
						<div id="cssmenu">
							<ul>
								<li>
									<a href="?modulo=start">
										<span class="glyphicon glyphicon-new-window" aria-hidden="true"></span>&nbsp;&nbsp;&nbsp;&nbsp;
										<span>
											Inicio
										</span>
									</a>
								</li>
								<li>
									<a href="?modulo=listapersona">
										<span class="glyphicon glyphicon-user" aria-hidden="true"></span>&nbsp;&nbsp;&nbsp;&nbsp;
										<span>
											Personas
										</span>
									</a>
								</li>
								<li>
									<a href="?modulo=listapropiedad">
										<span class="glyphicon glyphicon-home" aria-hidden="true"></span>&nbsp;&nbsp;&nbsp;&nbsp;
										<span>
											Propiedades
										</span>
									</a>
								</li>
								<li class="active has-sub">
									<a href="#">
										<span class="glyphicon glyphicon-th" aria-hidden="true"></span>&nbsp;&nbsp;&nbsp;&nbsp;
										<span>Catálogos</span>
									</a>
									<ul>
										<li>
											<a href="?modulo=listaprovincia">
												<span>Provincias</span>
												<span class="glyphicon glyphicon-map-marker pull-right" aria-hidden="true"></span>
											</a>
										</li>
										<li>
											<a href="?modulo=listacanton">
												<span>Cantones</span>
												<span class="glyphicon glyphicon-map-marker pull-right" aria-hidden="true"></span>
											</a>
										</li>
										<li>
											<a href="?modulo=listaparroquia">
												<span>Parroquias</span>
												<span class="glyphicon glyphicon-map-marker pull-right" aria-hidden="true"></span>
											</a>
										</li>
										<li>
											<a href="?modulo=listabarrio">
												<span>Barrios</span>
												<span class="glyphicon glyphicon-map-marker pull-right" aria-hidden="true"></span>
											</a>
										</li>
										<li>
											<a href="?modulo=listatipopropiedad">
												<span>Tipo Propiedad</span>
												<span class="glyphicon glyphicon-inbox pull-right" aria-hidden="true"></span>
											</a>
										</li>
									</ul>
								</li>
								<?php if($_SESSION['EsAdmin'] == md5('Admin2022')){ ?>
								<li class="active has-sub">
									<a href="#">
										<span class="glyphicon glyphicon-lock" aria-hidden="true"></span>&nbsp;&nbsp;&nbsp;&nbsp;
										<span>Seguridad</span>
									</a>
									<ul>
										<li>
											<a href="?modulo=listausuario">
												<span class="glyphicon glyphicon-user" aria-hidden="true"></span>&nbsp;&nbsp;&nbsp;&nbsp;
												<span>Usuarios</span>
											</a>
										</li>
										<li>
											<a href="?modulo=listarol">
												<span class="glyphicon glyphicon-random" aria-hidden="true"></span>&nbsp;&nbsp;&nbsp;&nbsp;
												<span>Roles</span>
											</a>
										</li>
									</ul>
								</li>
								<?php }?>
								<li class="last">
									<a href="control/logout.php">
										<span class="glyphicon glyphicon-log-out" aria-hidden="true"></span>&nbsp;&nbsp;&nbsp;&nbsp;
										<span>Cerrar Sesión</span>
									</a>
								</li>
							</ul>
						</div>
					<?php } ?>
				</div>
				<div class="col-md-10">
					<div class="col-md-12" style="text-align:right;">
						<h4><?php echo $_SESSION['nombre'];?> <a href="control/logout.php"><span title="Cerrar Sessión" class="glyphicon glyphicon-off" aria-hidden="true" style="cursor:pointer" ></span></a></h4>
					</div>
					<div class="row" id="titulopag" style="padding:10px 15px;">
						
					</div>
					<div class="row">
						<div class="col-md-12">
							<?php
								include($init -> subpagePath);
							?>
						</div>
					</div>
				</div>
				<?php }else{?>
				<div class="col-md-12">
					<?php
						include($init -> subpagePath);
					?>
				</div>
				<?php }?>
			</div>
		</div>
		<div class="pie" style="margin-top:0px; margin-bottom:20px;">
			<div class="row">
				<div class="table-responsive">
					<table style="width:100%;">
						<tr>
							<td width="50%">
								<img src="img/logo.png" style="width:100%; max-width:200px;" />
							</td>
							<td style="text-align:right; vertical-align:middle;">
								<h4><img src="img/copyright.png" />Derechos Reservados RB Inmobiliaria 2022</h4>
							</td>
						</tr>
					</table>
				</div>
			</div>
		</div>
		<div class="alertas">
			<div class="modal fade" id="blanco" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
				<div class="modal-dialog" role="document">
					<div class="modal-content">
						<div class="modal-header">
							<button type="button" class="close" data-dismiss="modal" aria-label="Close" onclick="window.location='';"><span aria-hidden="true">&times;</span></button>
							<h4 class="modal-title" id="myModalLabel">Alerta!</h4>
						</div>
						<div class="modal-body">
							<div class="alert alert-danger" role="alert">
								<span class="glyphicon glyphicon-warning-sign" aria-hidden="true"></span>&nbsp;
								Llene todos los campos para continuar
							</div>
						</div>
						<div class="modal-footer">
							<button type="button" class="btn btn-danger" data-dismiss="modal">Aceptar</button>
						</div>
					</div>
				</div>
			</div>
			<div class="modal fade" id="error" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
				<div class="modal-dialog" role="document">
					<div class="modal-content">
						<div class="modal-header">
							<button type="button" class="close" data-dismiss="modal" aria-label="Close" onclick="window.location='';"><span aria-hidden="true">&times;</span></button>
							<h4 class="modal-title" id="myModalLabel">Alerta!</h4>
						</div>
						<div class="modal-body">
							<div class="alert alert-danger" role="alert">
								<span class="glyphicon glyphicon-warning-sign" aria-hidden="true"></span>&nbsp;
								Los datos ingresados son incorrectos.
							</div>
						</div>
						<div class="modal-footer">
							<button type="button" class="btn btn-danger" data-dismiss="modal" onclick="window.location='';">Aceptar</button>
						</div>
					</div>
				</div>
			</div>
			<div class="modal fade" id="guardado" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
				<div class="modal-dialog" role="document">
					<div class="modal-content">
						<div class="modal-header">
							<button type="button" class="close" data-dismiss="modal" aria-label="Close" onclick="window.location='';"><span aria-hidden="true">&times;</span></button>
							<h4 class="modal-title" id="myModalLabel">Alerta!</h4>
						</div>
						<div class="modal-body">
							<div class="alert alert-info" role="alert">
								<span class="glyphicon glyphicon-info-sign" aria-hidden="true"></span>&nbsp;
								Datos guardados con éxito.
							</div>
						</div>
						<div class="modal-footer">
							<button type="button" class="btn btn-primary" data-dismiss="modal" onclick="window.location='';">Aceptar</button>
						</div>
					</div>
				</div>
			</div>
			<div class="modal fade" id="eliminado" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
				<div class="modal-dialog" role="document">
					<div class="modal-content">
						<div class="modal-header">
							<button type="button" class="close" data-dismiss="modal" aria-label="Close" onclick="window.location='';"><span aria-hidden="true">&times;</span></button>
							<h4 class="modal-title" id="myModalLabel">Alerta!</h4>
						</div>
						<div class="modal-body">
							<div class="alert alert-info" role="alert">
								<span class="glyphicon glyphicon-info-sign" aria-hidden="true"></span>&nbsp;
								Registro eliminado con éxito.
							</div>
						</div>
						<div class="modal-footer">
							<button type="button" class="btn btn-primary" data-dismiss="modal" onclick="window.location='';">Aceptar</button>
						</div>
					</div>
				</div>
			</div>
			<div class="modal fade" id="errorcedula" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
				<div class="modal-dialog" role="document">
					<div class="modal-content">
						<div class="modal-header">
							<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
							<h4 class="modal-title" id="myModalLabel">Alerta!</h4>
						</div>
						<div class="modal-body">
							<div class="alert alert-danger" role="alert">
								<span class="glyphicon glyphicon-warning-sign" aria-hidden="true"></span>&nbsp;
								El número de documento de identificación es incorrecto.
							</div>
						</div>
						<div class="modal-footer">
							<button type="button" class="btn btn-danger" data-dismiss="modal">Aceptar</button>
						</div>
					</div>
				</div>
			</div>
			<div class="modal fade" id="errormail" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
				<div class="modal-dialog" role="document">
					<div class="modal-content">
						<div class="modal-header">
							<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
							<h4 class="modal-title" id="myModalLabel">Alerta!</h4>
						</div>
						<div class="modal-body">
							<div class="alert alert-danger" role="alert">
								<span class="glyphicon glyphicon-warning-sign" aria-hidden="true"></span>&nbsp;
								El email es incorrecto.
							</div>
						</div>
						<div class="modal-footer">
							<button type="button" class="btn btn-danger" data-dismiss="modal">Aceptar</button>
						</div>
					</div>
				</div>
			</div>
		</div>
	</body>
</html>
<script>
$(function(argument){
	$('.checkbox').bootstrapSwitch();
});

$('.datepicker').datepicker({
	dateFormat: 'yy-mm-dd'
});

function ValidarCedula(valor,t){
	var numero = valor;
	var suma = 0;
	var residuo = 0;
	var pri = false;
	var pub = false;
	var nat = false;
	var numeroProvincias = 24;
	var modulo = 11;

	/* Verifico que el campo no contenga letras */
	var ok=1;
	/* Aqui almacenamos los digitos de la cedula en variables. */
	d1 = numero.substr(0,1);
	d2 = numero.substr(1,1);
	d3 = numero.substr(2,1);
	d4 = numero.substr(3,1);
	d5 = numero.substr(4,1);
	d6 = numero.substr(5,1);
	d7 = numero.substr(6,1);
	d8 = numero.substr(7,1);
	d9 = numero.substr(8,1);
	d10 = numero.substr(9,1);

	if (d3==7 || d3==8){
		//console.log('El tercer dígito ingresado es inválido');
		$(t).val('');
		$('#errorcedula').modal('show');
		return false;
	}

	/* Solo para personas naturales (modulo 10) */
	if (d3 < 6){
		nat = true;
		p1 = d1 * 2; if (p1 >= 10) p1 -= 9;
		p2 = d2 * 1; if (p2 >= 10) p2 -= 9;
		p3 = d3 * 2; if (p3 >= 10) p3 -= 9;
		p4 = d4 * 1; if (p4 >= 10) p4 -= 9;
		p5 = d5 * 2; if (p5 >= 10) p5 -= 9;
		p6 = d6 * 1; if (p6 >= 10) p6 -= 9;
		p7 = d7 * 2; if (p7 >= 10) p7 -= 9;
		p8 = d8 * 1; if (p8 >= 10) p8 -= 9;
		p9 = d9 * 2; if (p9 >= 10) p9 -= 9;
		modulo = 10;
	}

	else if(d3 == 6){
		pub = true;
		p1 = d1 * 3;
		p2 = d2 * 2;
		p3 = d3 * 7;
		p4 = d4 * 6;
		p5 = d5 * 5;
		p6 = d6 * 4;
		p7 = d7 * 3;
		p8 = d8 * 2;
		p9 = 0;
	}

	/* Solo para entidades privadas (modulo 11) */
	else if(d3 == 9) {
		pri = true;
		p1 = d1 * 4;
		p2 = d2 * 3;
		p3 = d3 * 2;
		p4 = d4 * 7;
		p5 = d5 * 6;
		p6 = d6 * 5;
		p7 = d7 * 4;
		p8 = d8 * 3;
		p9 = d9 * 2;
	}

	suma = p1 + p2 + p3 + p4 + p5 + p6 + p7 + p8 + p9;
	residuo = suma % modulo;

	/* Si residuo=0, dig.ver.=0, caso contrario 10 - residuo*/
	digitoVerificador = residuo==0 ? 0: modulo - residuo;

	/* ahora comparamos el elemento de la posicion 10 con el dig. ver.*/
	if (pub==true){
		if (digitoVerificador != d9){
			//console.log('El ruc de la empresa del sector público es incorrecto.');
			$(t).val('');
			$('#errorcedula').modal('show');
			return false;
		}
		/* El ruc de las empresas del sector publico terminan con 0001*/
		if ( numero.substr(9,4) != '0001' ){
			//console.log('El ruc de la empresa del sector público debe terminar con 0001');
			$(t).val('');
			$('#errorcedula').modal('show');
			return false;
		}
	}
	else if(pri == true){
		if (digitoVerificador != d10){
			//console.log('El ruc de la empresa del sector privado es incorrecto.');
			$(t).val('');
			$('#errorcedula').modal('show');
			return false;
		}
		if ( numero.substr(10,3) != '001' ){
			//console.log('El ruc de la empresa del sector privado debe terminar con 001');
			$(t).val('');
			$('#errorcedula').modal('show');
			return false;
		}
	}

	else if(nat == true){
		if (digitoVerificador != d10){
			//console.log('El número de cédula de la persona natural es incorrecto.');
			$(t).val('');
			$('#errorcedula').modal('show');
			return false;
		}
		if (numero.length >10 && numero.substr(10,3) != '001' ){
			//console.log('El ruc de la persona natural debe terminar con 001');
			$(t).val('');
			$('#errorcedula').modal('show');
			return false;
		}
	}
	return true;
}

function justInt(e,value,t){
    if((e.keyCode >= 48 && e.keyCode <= 57) || (e.keyCode >= 96 && e.keyCode <= 105 || e.keyCode == 8 || e.keyCode == 9 || e.keyCode == 37 || e.keyCode == 39 || e.keyCode == 13)){
        return;
	}else{
		$(t).val('');
        e.preventDefault();
	}
}

function justDouble(e,value,t){
    if((e.keyCode >= 48 && e.keyCode <= 57) || (e.keyCode >= 96 && e.keyCode <= 105 || e.keyCode == 8 || e.keyCode == 9 || e.keyCode == 37 || e.keyCode == 39 || e.keyCode == 13 || e.keyCode == 44 || e.keyCode == 46)){
        return;
	}else{
		$(t).val('');
        e.preventDefault();
	}
}
	
function justText(e,value,t){
	if(e.keyCode >= 65 && e.keyCode <= 90 || e.keyCode == 37 || e.keyCode == 39 || e.keyCode == 8 || e.keyCode == 46 || e.keyCode == 9 || e.which == 0 || e.keyCode == 32){
		return;
	}else{
		e.preventDefault();
	}
}	

function validarMail(valor,t){
	var email = valor;
    expr = /^([a-zA-Z0-9_\.\-])+\@(([a-zA-Z0-9\-])+\.)+([a-zA-Z0-9]{2,4})+$/;
    if ( !expr.test(email) ){
		$(t).val('');
		$('#errormail').modal('show');
	}
}

function mayus(value,t){
	var valor = value.toUpperCase();
	$(t).val(valor);
}

$.datepicker.regional['es'] = {
	closeText: 'Cerrar',
	// prevText: '<Ant',
	// nextText: 'Sig>',
	currentText: 'Hoy',
	monthNames: ['Enero', 'Febrero', 'Marzo', 'Abril', 'Mayo', 'Junio', 'Julio', 'Agosto', 'Septiembre', 'Octubre', 'Noviembre', 'Diciembre'],
	monthNamesShort: ['Ene','Feb','Mar','Abr', 'May','Jun','Jul','Ago','Sep', 'Oct','Nov','Dic'],
	dayNames: ['Domingo', 'Lunes', 'Martes', 'Miércoles', 'Jueves', 'Viernes', 'Sábado'],
	dayNamesShort: ['Dom','Lun','Mar','Mié','Juv','Vie','Sáb'],
	dayNamesMin: ['Do','Lu','Ma','Mi','Ju','Vi','Sá'],
	weekHeader: 'Sm',
	dateFormat: 'dd/mm/yy',
	firstDay: 1,
	isRTL: false,
	showMonthAfterYear: false,
	yearSuffix: ''
};
$.datepicker.setDefaults($.datepicker.regional['es']);
$(function () {
	$(".datepicker").datepicker();
});
</script>