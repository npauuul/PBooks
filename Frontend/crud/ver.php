<?php
session_start();
require_once '../config/config.php';

require_once '../partials/header.php';
require_once '../includes/api_client.php';

if (!isset($_GET['id'])) {
    header('Location: ' . BASE_URL);
    exit;
}

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

$titulo = $libro['title'];
?>

<div class="row justify-content-center">
    <div class="col-md-8">
        <div class="card shadow">
            <div class="row g-0">
                <div class="col-md-4 d-flex align-items-center justify-content-center bg-light">
                    <img src="<?php echo $libro['img_url']?>" alt="<?php echo $libro['title']?>" class="w-100" style="height: 100%;">
                </div>
                <div class="col-md-8 py-5">
                    <div class="card-body">
                        <h2 class="card-title"><?php echo htmlspecialchars($libro['title']); ?></h2>
                        <p class="card-text"><?php echo htmlspecialchars($libro['description']); ?></p>
                        <p class="text-muted"><?php echo htmlspecialchars($libro['author']); ?></p>
                        
                        <hr>
                        
                        <div class="mb-3">
                            <h5>Detalles</h5>
                            <ul class="list-unstyled">
                                <li><strong>Año de publicación:</strong> <?php echo $libro['year'] ?? 'No especificado'; ?></li>
                                <li><strong>Género:</strong> <?php echo $libro['category'] ?? 'No especificado'; ?></li>
                            </ul>
                        </div>
                        
                        <div class="d-flex gap-2">
                            <a href="<?php echo BASE_URL; ?>" class="btn btn-xl btn-secondary mt-4">
                                <i class="fas fa-arrow-left"></i>
                            </a>
                            <a href="<?php echo BASE_URL; ?>crud/editar?id=<?php echo $libro['id']; ?>"
                                class="btn btn-xl btn-warning mt-4"><i class="fas fa-pencil text-white"></i></a>
                            <a href="<?php echo BASE_URL; ?>crud/eliminar?id=<?php echo $libro['id']; ?>"
                                class="btn btn-xl btn-danger mt-4"><i class="fas fa-x"></i></a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<?php
require_once '../partials/footer.php';
?>