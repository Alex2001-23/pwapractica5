<?php
session_start();
if (!isset($_SESSION['usuario_id'])) {
    header("Location: login.php");
    exit;
}

$rol    = $_SESSION['rol_id'];
$nombre = $_SESSION['usuario'];
?>
<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8" />
  <title>Dashboard - Sistema de Tareas</title>
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <!-- Bootstrap 5 -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" />
  <style>
    body {
      background: linear-gradient(135deg, #DCEEFF 0%, #5C9DBF 100%);
      min-height: 100vh;
      display: flex;
      align-items: center;
      justify-content: center;
    }
    .dashboard-card {
      background: white;
      border-radius: 1rem;
      box-shadow: 0 8px 20px rgba(0,0,0,0.15);
      padding: 2rem;
      max-width: 500px;
      width: 100%;
      position: relative;
    }
    .dashboard-card h2 {
      margin-bottom: 0.5rem;
    }
    .logout-btn {
      position: absolute;
      top: 1rem;
      right: 1rem;
    }
    .role-title {
      font-size: 1.25rem;
      margin-top: 1.5rem;
      margin-bottom: 1rem;
      color: #333;
    }
    .btn-custom {
      border-radius: 2rem;
      padding: 0.5rem 1.5rem;
      margin: 0.25rem;
    }
  </style>
</head>
<body>

  <div class="dashboard-card text-center">
    <a href="logout.php" class="btn btn-danger logout-btn">Cerrar sesión</a>
    <img src="https://cdn-icons-png.flaticon.com/512/1077/1077063.png" alt="Logo" width="50" class="mb-3">
    <h2>¡Bienvenido, <?= htmlspecialchars($nombre) ?>!</h2>

    <?php if ($rol == 1): ?>
      <div class="role-title">Administrador</div>
      <a href="usuarios.php" class="btn btn-primary btn-custom">Gestionar Usuarios</a>
      <a href="tareas.php"   class="btn btn-secondary btn-custom">Ver Todas las Tareas</a>
    <?php elseif ($rol == 2): ?>
      <div class="role-title">Gerente de Proyecto</div>
      <a href="tareas.php" class="btn btn-primary btn-custom">Gestionar Mis Tareas</a>
    <?php else: ?>
      <div class="role-title">Miembro del Equipo</div>
      <a href="tareas.php" class="btn btn-primary btn-custom">Mis Tareas Asignadas</a>
    <?php endif; ?>
  </div>

  <!-- Bootstrap JS Bundle -->
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
