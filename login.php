<?php
session_start();
require 'db.php'; // Debe definir $conn como mysqli conectado a gestion_tareas

$error = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = $_POST['email'];
    $pass  = $_POST['password'];

    // Buscamos al usuario
    $stmt = $conn->prepare("SELECT id, nombre, contraseña, rol_id FROM usuarios WHERE email = ?");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $user = $stmt->get_result()->fetch_assoc();
    $stmt->close();

    if ($user && password_verify($pass, $user['contraseña'])) {
        // Guardar en sesión
        $_SESSION['usuario']    = $user['nombre'];
        $_SESSION['usuario_id'] = $user['id'];
        $_SESSION['rol_id']     = $user['rol_id'];

        // Redirigir según rol
        switch ($user['rol_id']) {
            case 1:
                header("Location: usuarios.php");
                break;
            case 2:
            case 3:
                header("Location: tareas.php");
                break;
            default:
                header("Location: dashboard.php");
        }
        exit;
    } else {
        $error = $user ? "Contraseña incorrecta" : "Usuario no encontrado";
    }
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <title>Login - Sistema de Tareas</title>
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <!-- Bootstrap 5 -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
  <style>
    body {
      background: linear-gradient(135deg, #5C9DBF 0%, #DCEEFF 100%);
      height: 100vh;
      display: flex;
      align-items: center;
      justify-content: center;
    }
    .card-login {
      border: none;
      border-radius: 1rem;
      box-shadow: 0 8px 20px rgba(0,0,0,0.15);
      max-width: 400px;
      width: 100%;
    }
    .card-login .card-header {
      background-color: #ffffff;
      border-bottom: none;
    }
    .card-login .card-body {
      padding: 2rem;
    }
    .btn-primary {
      border-radius: 2rem;
      padding: 0.5rem 1.5rem;
    }
    .form-control {
      border-radius: 2rem;
      padding: 0.75rem 1rem;
    }
    .logo {
      width: 60px;
      margin-bottom: 1rem;
    }
  </style>
</head>
<body>

  <div class="card card-login">
    <div class="card-header text-center">
      <img src="https://cdn-icons-png.flaticon.com/512/1077/1077063.png" alt="Logo" class="logo">
      <h3 class="mb-0">Sistema de Tareas</h3>
      <small class="text-muted">Iniciar sesión</small>
    </div>
    <div class="card-body">
      <?php if ($error): ?>
        <div class="alert alert-danger"><?= htmlspecialchars($error) ?></div>
      <?php endif; ?>
      <form method="POST" action="login.php">
        <div class="mb-3">
          <input type="email" name="email" class="form-control" placeholder="Correo electrónico" required>
        </div>
        <div class="mb-4">
          <input type="password" name="password" class="form-control" placeholder="Contraseña" required>
        </div>
        <div class="d-grid">
          <button type="submit" class="btn btn-primary">Entrar</button>
        </div>
      </form>
      <div class="text-center mt-3">
        <small>¿No tienes cuenta? <a href="register.php">Regístrate aquí</a></small>
      </div>
    </div>
  </div>

  <!-- Bootstrap JS -->
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
