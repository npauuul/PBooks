<?php
session_start();
require_once '../config/config.php';

require_once '../includes/api_client.php';
require_once '../partials/header.php';

$id = $_GET['id'];

$libro = obtenerLibro($id);

if (!$libro['title']) {
    header('Location: ' . BASE_URL . '?error=libro_no_encontrado');
    exit;
}

if ($_SESSION['user']['is_admin'] === 0) {
    // Proteger libros que no son tuyos | A menos que sea admin

    if ($libro['user_id'] != $_SESSION['user']['id']) {
        header('Location: ' . BASE_URL . '?error=libro_no_encontrado');
        exit;
    }
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $resultado = eliminarLibro($id);

    if ($resultado && !isset($resultado['error'])) {
        $_SESSION['mensaje_exito'] = "Libro eliminado correctamente";
        header('Location: ' . BASE_URL);
        exit;
    } else {
        $error = $resultado['message'] ?? "Error al eliminar el libro";
    }
}
?>

<div class="row justify-content-center">
    <div class="col-md-8 col-lg-6">
        <div class="card shadow">
            <div class="card-body p-4">
                <h2 class="card-title text-center mb-4 fw-bold text-danger text-uppercase py-2">
                    <i class="fas fa-exclamation-triangle me-2"></i>
                </h2>

                <?php if (isset($error)): ?>
                    <div class="alert alert-danger"><?php echo htmlspecialchars($error); ?></div>
                <?php endif; ?>

                <div class="alert alert-danger text-center">
                    <h5 class="fw-bold">¿Estás seguro que deseas eliminar este libro?</h5>
                    <p class="mb-0">Esta acción no se puede deshacer.</p>
                </div>

                <div class="card mb-4">
                    <div class="card-body">
                        <h5 class="card-title"><?php echo htmlspecialchars($libro['title']); ?></h5>
                        <p class="card-text text-muted"><?php echo htmlspecialchars($libro['author']); ?></p>

                        <div class="row">
                            <div class="col-md-6">
                                <p class="mb-1"><strong>Año:</strong> <?php echo $libro['year'] ?? 'N/A'; ?></p>
                            </div>
                            <div class="col-md-6">
                                <p class="mb-1"><strong>Género:</strong> <?php echo $libro['category'] ?? 'N/A'; ?></p>
                            </div>
                        </div>

                        <?php if (!empty($libro['description'])): ?>
                            <hr>
                            <p class="card-text"><?php echo htmlspecialchars($libro['description']); ?></p>
                        <?php endif; ?>
                    </div>
                </div>

                <form method="POST">
                    <div class="row g-3">
                        <div class="col-md-6">
                            <a href="<?php echo BASE_URL; ?>" class="btn btn-secondary btn-lg w-100">
                                <i class="fas fa-times me-2"></i> Cancelar
                            </a>
                        </div>
                        <div class="col-md-6">
                            <button type="submit" class="btn btn-danger btn-lg w-100">
                                <i class="fas fa-trash-alt me-2"></i> Eliminar
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<?php
require_once '../partials/footer.php';
?>