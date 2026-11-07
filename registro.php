<?php
session_start();
//crear el arreglo donde voy a guardar los usuarios
if (!isset($_SESSION['usuarios'])) {
	$_SESSION['usuarios'] = array();
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<link rel="stylesheet" href="estilo.css">
	<title>Registro de usuarios</title>
</head>
<body>
	<h1>Registro de <span>usuarios</span></h1>
	<div class="contenido">
		<h2>Crear una cuenta</h2>
		<form method="POST" action="">
			<label>Nombre:</label>
			<input type="text" name="nombre" required>
			<label>Nombre de usuario:</label>
			<input type="text" name="usuario" required>
			<label>Contraseña:</label>
			<input type="password" name="password" required>
			<label>Confirmar contraseña:</label>
			<input type="password" name="confirmar" required>
			<button type="submit" name="registrar">Registrar</button>
		</form>
		<?php
		//comprobar que se haya enviado el formulario
		if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['registrar'])) {
			$nombre = $_POST['nombre'];
			$usuario = $_POST['usuario'];
			$password = $_POST['password'];
			$confirmar = $_POST['confirmar'];
			//comprobar que todos los campos tengan datos
			if ($nombre == "" || $usuario == "" || $password == "" || $confirmar == "") {
				echo "Error: todos los campos son obligatorios.";
			}
			//asegurar que la contraseña tenga minimo 6 caracteres
			else if (strlen($password) < 6) {
				echo "Error: la contraseña debe tener al menos 6 caracteres.";
			}
			//comprobar que las dos contraseñas sean iguales
			else if ($password != $confirmar) {
				echo "Error: las contraseñas no coinciden.";
			}
			//comprobar que el usuario no este registrado
			else if (isset($_SESSION['usuarios'][$usuario])) {
				echo "Error: ese usuario ya está registrado.";
			}
			else {
				//convertir la contraseña en un hash para protegerla
				$hash = password_hash($password, PASSWORD_DEFAULT);
				//guardar los datos del usuario en el arreglo
				$_SESSION['usuarios'][$usuario] = array(
					'nombre' => $nombre,
					'hash' => $hash
				);
				//mostrar el mensaje cuando el registro sea correcto
				echo "<div class='mensaje'>";
				echo "<img src='imagenes/aceptado.jpg' class='imagen-aceptado' alt='Registro correcto'>";
				echo "¡Usuario registrado correctamente!";
				echo "<br><br>";
				//mostrar la imagen para añadir otro registro
				echo "<img src='imagenes/anade.jpg' class='imagen-anade' alt='Añadir registro'>";
				echo "<a href='registro.php'>Añadir otro registro</a>";
				echo "</div>";
			}
		}
		?>
		<br>
		<a href="login.php">Ir al inicio de sesión</a>
	</div>
</body>
</html>