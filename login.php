<div class="row" style="margin-top:9%;">
	<div class="col-md-4 col-md-push-4 content-login">
		<div class="row">
			<div class="col-md-12" style="text-align:right;">
				<h3><img src="img/candado.png" style="max-width:50px;"/>Ingreso de Usuarios</h3>
			</div>
		</div>
		<div class="row" style="margin-top:15px;">
			<div class="col-md-12">
				<h4>Nombre de Usuario:</h4>
				<div class="input-group">
					<span class="input-group-addon" id="basic-addon1">
						<span class="glyphicon glyphicon-user"></span>
					</span>
					<input type="text" class="form-control" placeholder="Ingrese su nombre de usuario"  aria-describedby="basic-addon1" id="login" autocomplete="off" />
				</div>
			</div>
		</div>
		<div class="row" style="margin-top:15px;">
			<div class="col-md-12">
				<h4>Contraseña:</h4>
				<div class="input-group">
					<span class="input-group-addon" id="basic-addon1">
						<span class="glyphicon glyphicon-lock"></span>
					</span>
					<input type="password" class="form-control" placeholder="**********" aria-describedby="basic-addon1" id="pass" autocomplete="off" />
				</div>
			</div>
		</div>
		<div class="row" style="margin-top:15px;">
			<div class="col-md-12" style="text-align:right;">
				<button class="btn btn-success" type="button" onclick="guardar()" id="btnguardar">Ingresar</button>
				<img src="img/loading.gif" id="wait" style="display:none;"/>
			</div>
		</div>
	</div>
</div>
<script>
$(document).keypress(function(e){
	if(e.which == 13){
		guardar();
	}
});

function guardar(){
	var login = $('#login').val();
	var pass = $('#pass').val();
	if((login == '') || (pass == '')){
		$('#blanco').modal('show');
	}else{
		$('#btnguardar').fadeOut('slow');
		$('#wait').delay(600).fadeIn('slow');
		$.post('control/control.php',{
			login : login, pass : pass
		}).done(function(response){
			if($.trim(response) == 'ok'){
				setTimeout("window.location = '?modulo=start';",3000);
			}else if($.trim(response) == 'error'){
				setTimeout("$('#error').modal('show');",1500);
			}
		});
	}
}
</script>