<?php
session_start();
?>
<!DOCTYPE html>
<html lang="es">
<head>
	<meta charset="UTF-8">
	<title>Inicio de sesión</title>
</head>
<body>
	<h2>Inicio de sesión</h2>
	<form method="POST" action="">
		<label>Nombre de usuario:</label>
		<input type="text" name="usuario" required>
		<br><br>
		<label>Contraseña:</label>
		<input type="password" name="password" required>
		<br><br>
		<button type="submit" name="ingresar">Iniciar sesión</button>
	</form>
	<?php
	//aquí compruebo que se haya enviado el formulario
	if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['ingresar'])) {
		$usuario = $_POST['usuario'];
		$password = $_POST['password'];

		//verifico que los campos no estén vacíos
		if ($usuario == "" || $password == "") {
			echo "Error: todos los campos son obligatorios.";
		}
		//busco si el usuario está registrado
		else if (isset($_SESSION['usuarios'][$usuario])) {
			// Aquí recupero el hash de la contraseña guardada
			$hash = $_SESSION['usuarios'][$usuario]['hash'];

			//asegurar si la contraseña es correcta
			if (password_verify($password, $hash)) {
				echo "Bienvenido al sistema, " . $_SESSION['usuarios'][$usuario]['nombre'];
			}
			else {
				echo "Contraseña incorrecta.";
			}
		}
		else {
			echo "Usuario no registrado.";
		}
	}
	?>
	<br><br>
	<a href="registro.php">Registrar un nuevo usuario</a>
</body>
</html>