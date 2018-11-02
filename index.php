<?php 
include 'actions/connection.php';
session_start();
if(isset($_POST['btn-alterar']) and isset($_POST['ip']) AND isset($_GET['action']) AND isset($_GET['id'])){
	$ip = filter_var($_POST['ip'], FILTER_SANITIZE_STRING);
	echo $ip;
	if($_GET['action'] == "editado"){
		$sql = "UPDATE plugins SET serverip = '".$_POST['ip']."' WHERE id = ".$_GET[id]."";
		$execute = mysqli_query($connectar, $sql);
		header("Location: index.php");
	}
}
if(isset($_POST['btn-entrar'])){
	$user = filter_var($_POST['user'], FILTER_SANITIZE_STRING);
	$password = filter_var($_POST['pass'], FILTER_SANITIZE_STRING);
	$sql = "SELECT * FROM usuarios WHERE cliente = '".$user."' AND  senha = '".$password."';";
	$result = mysqli_query($connectar, $sql);
	$clientes = mysqli_fetch_assoc($result);
	if($clientes){
		$_SESSION['logado'] = true;
		$_SESSION['cliente'] = $clientes['cliente'];
	}else{
		header('Location: index.php?action=erro1');
		session_unset();
		session_destroy();
	}
}
if(isset($_GET['action'])){
	if($_GET['action'] == "sair"){
		header('Location: index.php');
		mysqli_close();
		session_unset();
		session_destroy();
	}

}
?>
<!DOCTYPE html>
<html>
<head>
	<title>Loading...</title>
	<meta charset="utf-8">
	<!--Import Google Icon Font-->
	<link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
    <!--Import materialize.css-->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/materialize/1.0.0/css/materialize.min.css">
    <!--Let browser know website is optimized for mobile-->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/materialize/1.0.0/js/materialize.min.js"></script>
	<script src="jquery-3.2.1.min.js"></script>
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
	<script type="text/javascript">
		$(document).ready(function(){
			$("#loadlogo").fadeIn(500);
			
			setTimeout(function(){
				$("#loadlogo").fadeOut(500);
				$("#form-login").fadeIn(2500);
				document.title = "Área do Cliente";
			}, 1*2000);
		});
	</script>
</head>

<body>
	<div class="container">
	<div class="row">
		<div class="col offset-l5">
			<img id="loadlogo" style="position:fixed;display:none;bottom:0;" width="150px" src="img/load.gif">
		</div>
	</div>
	<!-- verificar se esta logado ou não // fazer consulta na tabela iluginxd -->
	<?php 
	if(isset($_SESSION['logado']) and isset($_SESSION['cliente'])):
		$sql = "SELECT * FROM plugins WHERE usuario = '".$_SESSION['cliente']."'";
		$selectplugins = mysqli_query($connectar, $sql);
	?>
	<div class="row">
		<div class="col s12 m12 l12">
			<table class="responsive-table striped">
			<thead class="highlight black-text" style="text-align:center;">
				<th>Usuario</th>
				<th>Plugin</th>
				<th>Servidor</th>
				<th>Serial</th>
				<th></th>
			</thead>
			<tbody>
				<?php while($plugins = mysqli_fetch_assoc($selectplugins)): ?>
					<tr>
						<td><?php echo $plugins['usuario']; ?></td>
						<td><?php echo $plugins['plugin']; ?></td>
						<td><?php echo $plugins['serverip']; ?></td>
						<td><?php echo $plugins['serialkey']; ?></td>
						<td><a href="editar.php?plugin=<?php echo $plugins['plugin'];?>&id=<?php echo $plugins['id'];?>"><i class="material-icons light-green-text">edit</i></a></td>
					</tr>
				<?php endwhile;?>
			</tbody>
			</table>
			<br>
			<a href="index.php?action=sair" class="btn btn-small red">SAIR</a>
		</div>
	</div>
	<?php else: ?>
	<!-- nao logado -->
	<div class="row">
		<div style="display:none;" id="form-login" class="col s12 l6 m12 offset-l3">
			<h1 class="title">DevCast</h1>
			<form action="index.php" method="POST">
					<label for="user">Usuario</label>
					<input type="text" name="user" id="user" class="validate" title="nome de usúario" required minlength="5" maxlength="20">
					<label for="pass">Usuario</label>
					<input type="password" name="pass" id="pass" class="validate" title="senha do usúario" required minlength="5" maxlength="20">
					<!-- Erro -->
					<?php if(isset($_GET['action']) AND $_GET['action'] == "erro1"): ?>
					<p id="error" style="display:block;background:red;color:#FFF;text-align:center;width:90%;margin:0 auto;padding:10px 0;">Usúario ou senha inválido.</p>
					<script>
						setInterval(function(){
							$("#error").fadeOut(1500);
						}, 7*1000);
					</script>
					<?php endif;?>
					<!-- erro -->
					<button type="submit" name="btn-entrar" id="btn-entrar" class="btn lg">Entrar</button>
			</form>
		</div>
	</div>
	<?php endif;?>
	</div>
</body>
</html>