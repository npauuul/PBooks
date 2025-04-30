<?php
session_start();
require_once '../config/config.php';

require_once '../includes/api_client.php';
require_once '../partials/header.php';


if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $response = [];
    
    if($_POST['verify_password'] !== $_POST['password']) {
        $error = "Las contraseñas no coinciden.";
    } else {

        $datos = [
            'username' => $_POST['username'],
            'password' => $_POST['password']
        ];
        
        $response = hacerRequestAPI('POST', 'auth/register', $datos);
        
        if ($response && !isset($response['error'])) {
            $_SESSION['mensaje_exito'] = 'Usuario registrado exitosamente. Por favor inicia sesión.';
            header('Location: ' . BASE_URL . 'auth/login');
            exit;
        }
    }
    
    $error = $error ?? ($response['error'] ?? 'Error al registrar el usuario');
}
?>

<div class="row justify-content-center">
    <div class="col-md-6 col-lg-4">
        <div class="card shadow px-4 py-3">
            <div class="card-body py-4">
                <h2 class="card-title text-center mb-4 fw-bold text-uppercase py-2 text-dark">Registro</h2>

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
                    
                    <div class="mb-4">
                        <label for="verify_password" class="form-label">Confirmar contraseña</label>
                        <input type="password" class="form-control" id="verify_password" name="verify_password">
                    </div>

                    <div class="mb-4 text-center">
                        <a href="login" class="text-muted text-decoration-none">¿Ya tienes una cuenta? <br><span class="text-primary">Inicia sesión aquí</span></a>
                    </div>
                    <div class="d-grid gap-2">
                        <button type="submit" class="btn btn-dark text-uppercase py-2">
                            Registrarme
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