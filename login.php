<?php
session_start();
?>
<!DOCTYPE html>
<html lang="es">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<link rel="stylesheet" href="estilo.css">
	<title>Inicio de sesión</title>
</head>
<body>
	<h1>Inicio de <span>sesión</span></h1>
	<div class="contenido">
		<h2>Bienvenido</h2>
		<form method="POST" action="">
			<label>Nombre de usuario:</label>
			<input type="text" name="usuario" required>
			<label>Contraseña:</label>
			<input type="password" name="password" required>
			<button type="submit" name="ingresar">Iniciar sesión</button>
		</form>
		<?php
		//comprobar que se haya enviado el formulario
		if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['ingresar'])) {
			$usuario = $_POST['usuario'];
			$password = $_POST['password'];
			//comprobar que los campos no esten vacios
			if ($usuario == "" || $password == "") {
				echo "Error: todos los campos son obligatorios.";
			}
			//buscar si el usuario esta registrado
			else if (isset($_SESSION['usuarios'][$usuario])) {
				//recuperar el hash de la contraseña guardada
				$hash = $_SESSION['usuarios'][$usuario]['hash'];
				//asegurar que la contraseña sea correcta
				if (password_verify($password, $hash)) {
					//mostrar el mensaje cuando el acceso sea autorizado
					echo "<div class='mensaje'>";
					echo "<img src='imagenes/pasa.jpg' class='imagen-pasa' alt='Acceso autorizado'>";
					echo "¡Bienvenido al sistema, " . $_SESSION['usuarios'][$usuario]['nombre'] . "!";
					echo "</div>";
				}
				else {
					//mostrar el mensaje cuando la contraseña sea incorrecta
					echo "<div class='mensaje'>";
					echo "<img src='imagenes/dudo.jpg' class='imagen-dudo' alt='Contraseña incorrecta'>";
					echo "Contraseña incorrecta.";
					echo "</div>";
				}
			}
			else {
				//mostrar el mensaje cuando el usuario no este registrado
				echo "<div class='mensaje'>";
				echo "<img src='imagenes/no.jpg' class='imagen-no' alt='Acceso rechazado'>";
				echo "Usuario no registrado. Acceso rechazado.";
				echo "</div>";
			}
		}
		?>
		<br>
		<a href="registro.php">Registrar un nuevo usuario</a>
	</div>
</body>
</html