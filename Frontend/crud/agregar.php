<?php
session_start();
require_once '../config/config.php';

require_once '../includes/api_client.php';
require_once '../partials/header.php';


if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $datos = [
        'title' => $_POST['title'],
        'author' => $_POST['author'],
        'description' => $_POST['description'] ?? null,
        'year' => $_POST['year'] ?? null,
        'category' => $_POST['category'] ?? null,
        'img_url' => $_POST['img_url'] ?? null,
    ];

    $resultado = agregarLibro($datos);

    if (isset($resultado['error'])) {
        echo "<div class='alert alert-danger alert-dismissible fade show' role='alert'>
   " . $resultado['message'] . "
  <button type='button' class='btn-close' data-bs-dismiss='alert' aria-label='Close'></button>
</div>";
    } else {
        echo "<div class='alert alert-success alert-dismissible fade show' role='alert'>
   " . $resultado['message'] . "
  <button type='button' class='btn-close' data-bs-dismiss='alert' aria-label='Close'></button>
</div>";
    }
}
?>

<div class="row justify-content-center">
    <div class="col-md-8 col-lg-6">
        <div class="card shadow">
            <div class="card-body p-4">
                <h2 class="card-title text-center mb-4 fw-bold text-uppercase py-2">Nuevo libro</h2>

                <form method="POST">
                    <div class="mb-3">
                        <label for="title" class="form-label">Título *</label>
                        <input type="text" class="form-control" id="title" name="title" required>
                    </div>

                    <div class="mb-3">
                        <label for="author" class="form-label">Autor *</label>
                        <input type="text" class="form-control" id="author" name="author" required>
                    </div>

                    <div class="mb-3">
                        <label for="description" class="form-label">Descripcion</label>
                        <input type="text" class="form-control" id="description" name="description" required>
                    </div>

                    <div class="mb-3">
                        <label for="year" class="form-label">Año de Publicación</label>
                        <input type="number" class="form-control" id="year" name="year">
                    </div>

                    <div class="mb-4">
                        <label for="category" class="form-label">Género</label>
                        <input type="text" class="form-control" id="category" name="category">
                    </div>

                    <div class="mb-4">
                        <label for="img_url" class="form-label">Imágen (URL)</label>
                        <input type="text" class="form-control" id="img_url" name="img_url">
                    </div>

                    <div class="d-grid gap-2">
                        <button type="submit" class="btn btn-primary btn-lg fs-4">
                            <i class="fas fa-plus me-2"></i>
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