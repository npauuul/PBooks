<?php
session_start();
require_once '../config/config.php';

require_once '../includes/api_client.php';
require_once '../partials/header.php';


$id = $_GET['id'];
$libro = obtenerLibro($id);
$message = null;

if (!isset($libro['title'])) {
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

    $datos = [
        'title' => $_POST['title'],
        'author' => $_POST['author'],
        'description' => $_POST['description'],
        'year' => $_POST['year'],
        'category' => $_POST['category'],
        'img_url' => $_POST['img_url'],
    ];

    $resultado = actualizarLibro($id, $datos);

    $id = $_GET['id'];
    $libro = obtenerLibro($id);

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
                <h2 class="card-title text-center mb-4 fw-bold text-uppercase py-2">Editar libro</h2>

                <form method="POST">
                    <div class="mb-3">
                        <label for="title" class="form-label">Título *</label>
                        <input type="text" class="form-control" id="title" name="title" value="<?php echo $libro['title'] ?>" required>
                    </div>

                    <div class="mb-3">
                        <label for="author" class="form-label">Autor *</label>
                        <input type="text" class="form-control" id="author" name="author" value="<?php echo $libro['author'] ?>" required>
                    </div>

                    <div class="mb-3">
                        <label for="description" class="form-label">Descripcion</label>
                        <input type="text" class="form-control" id="description" name="description" value="<?php echo $libro['description'] ?>" required>
                    </div>

                    <div class="mb-3">
                        <label for="year" class="form-label">Año de Publicación</label>
                        <input type="number" class="form-control" id="year" name="year" value="<?php echo $libro['year'] ?>">
                    </div>

                    <div class="mb-4">
                        <label for="category" class="form-label">Género</label>
                        <input type="text" class="form-control" id="category" name="category" value="<?php echo $libro['category'] ?>">
                    </div>

                    <div class="mb-4">
                        <label for="img_url" class="form-label">Imágen (URL)</label>
                        <input type="text" class="form-control" id="img_url" name="img_url" value="<?php echo $libro['img_url'] ?>">
                    </div>

                    <div class="row justify-content-between align-items-center">
                        <a href="<?php echo BASE_URL; ?>" class="btn btn-secondary fs-4 col-sm-5 mx-2"><i class="fas fa-arrow-left"></i></a>

                        <button type="submit" class="btn btn-warning fs-4 col-sm-5 mx-2">
                            <i class="fas fa-save text-white"></i>
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