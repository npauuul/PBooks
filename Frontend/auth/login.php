<?php
session_start();
require_once '../config/config.php';

require_once '../includes/api_client.php';
require_once '../partials/header.php';


if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $datos = [
        'username' => $_POST['username'],
        'password' => $_POST['password']
    ];
    
    $response = hacerRequestAPI('POST', 'auth/login', $datos);
    
    if ($response && !isset($response['error'])) {
        $_SESSION['token'] = $response['token'];
        $_SESSION['user'] = $response['user'];
        header('Location: ' . BASE_URL);
        exit;
    } else {
        $error = $response['error'] ?? 'Error al iniciar sesión';
    }
}
?>

<div class="row justify-content-center">
    <div class="col-md-6 col-lg-4">
        <div class="card shadow px-4 py-3">
            <div class="card-body py-4">
                <h2 class="card-title text-center mb-4 fw-bold text-uppercase py-2 text-dark">Iniciar sesion</h2>
                
                <?php if (isset($error)): ?>
                    <div class="alert alert-danger"><?php echo htmlspecialchars($error); ?></div>
                <?php endif; ?>

                <form method="POST">
                    <div class="mb-3">
                        <label for="username" class="form-label">Usuario</label>
                        <input type="text" class="form-control" id="username" name="username" required>
                    </div>
                    
                    <div class="mb-4">
                        <label for="password" class="form-label">Contraseña</label>
                        <input type="password" class="form-control" id="password" name="password">
                    </div>
                    <div class="mb-4 text-center">
                        <a href="register" class="text-muted text-decoration-none">¿No tienes cuenta? <br><span class="text-primary">Registrate Aquí</span></a>
                    </div>
                    <div class="d-grid gap-2">
                        <button type="submit" class="btn btn-primary text-uppercase py-2">
                            Ingresar
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<?php
require_once '../partials/footer.php';
?>