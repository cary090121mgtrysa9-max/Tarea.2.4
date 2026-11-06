<?php
session_start();
//aqui cree el arreglo donde voy a guardar los usuarios
if (!isset($_SESSION['usuarios'])) {
	$_SESSION['usuarios'] = array();
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
	<meta charset="UTF-8">
	<title>Registro de usuarios</title>
</head>
<body>
	<h2>Registro de usuarios</h2>
	<form method="POST" action="">
		<label>Nombre:</label>
		<input type="text" name="nombre" required>
		<br><br>
		<label>Nombre de usuario:</label>
		<input type="text" name="usuario" required>
		<br><br>
		<label>Contraseña:</label>
		<input type="password" name="password" required>
		<br><br>
		<label>Confirmar contraseña:</label>
		<input type="password" name="confirmar" required>
		<br><br>
		<button type="submit" name="registrar">Registrar</button>
	</form>
	<?php
	//aqui se ve que se ha enviado el formulario
	if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['registrar'])) {
		$nombre = $_POST['nombre'];
		$usuario = $_POST['usuario'];
		$password = $_POST['password'];
		$confirmar = $_POST['confirmar'];
		//esto es para verificar que ningún campo esté vacío
		if ($nombre == "" || $usuario == "" || $password == "" || $confirmar == "") {
			echo "Error: todos los campos son obligatorios.";
		}
		//compruebo que la contraseña tenga mínimo 6 caracteres
		else if (strlen($password) < 6) {
			echo "Error: la contraseña debe tener al menos 6 caracteres.";
		}
		//aqui verifico que las contraseñas coincidan
		else if ($password != $confirmar) {
			echo "Error: las contraseñas no coinciden.";
		}
		//aquí compruebo que el usuario no haya estado registrado
		else if (isset($_SESSION['usuarios'][$usuario])) {
			echo "Error: ese usuario ya está registrado.";
		}
		else {
		//se convierte la contraseña en un hash
			$hash = password_hash($password, PASSWORD_DEFAULT);

			//guardo los datos del usuario en el arreglo
			$_SESSION['usuarios'][$usuario] = array(
				'nombre' => $nombre,
				'hash' => $hash
			);
			echo "Usuario registrado correctamente.";
		}
	}
	?>
	<br><br>
	<a href="login.php">Ir al inicio de sesión</a>
</body>
</html>
