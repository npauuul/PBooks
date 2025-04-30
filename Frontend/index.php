<?php
session_start();

require_once 'config/config.php';


require_once 'partials/header.php';
require_once 'includes/api_client.php';

$libros = obtenerLibros();

if (isset($_GET["error"])) {
    echo "<div class='alert alert-danger alert-dismissible fade show' role='alert'>
  ¡No se ha encontrado el libro que buscas con el ID referente!
  <button type='button' class='btn-close' data-bs-dismiss='alert' aria-label='Close'></button>
</div>";
}

?>

<?php if (!isset($_SESSION['token'])) { ?>

    <div class="row mb-4 py-5">
        <div class="col-12">
            <h1 class="display-4 text-center">Página de libros</h1>
        </div>
        <div class="container text-center mt-3 text-muted fs-5">
            <span>Inicia sesión para crear tus libros.</span>
        </div>
    </div>

<?php } else { ?>
    <div class="row mb-4">
        <div class="col-12">
            <h1 class="display-4 text-center">Catálogo de Libros</h1>
            <p class="lead text-center text-muted">Explora nuestra colección</p>
        </div>
    </div>

    <div class="row">
        <?php if (!empty($libros)): ?>
            <?php foreach ($libros as $libro): ?>
                <div class="col-md-4 mb-4">
                    <div class="card libro-card h-100">
                        <div class="card-img-top">
                            <img src="<?php echo htmlspecialchars($libro['img_url']); ?>" alt="<?php echo htmlspecialchars($libro['title']); ?>" class="img-fluid w-100">
                        </div>
                        <div class="card-body libro-body">
                            <h5 class="card-title libro-title"><?php echo htmlspecialchars($libro['title']); ?></h5>
                            <p class="card-text libro-author"><?php echo htmlspecialchars($libro['author']); ?></p>
                            <p class="card-text libro-author"><?php echo htmlspecialchars($libro['description']); ?></p>
                            <div class="libro-meta">
                                <span><?php echo $libro['year'] ?? 'Año no especificado'; ?></span>
                                <span><?php echo $libro['category'] ?? 'Sin género'; ?></span>
                            </div>
                            <div class="text-center">
                                <a href="<?php echo BASE_URL; ?>crud/ver?id=<?php echo $libro['id']; ?>"
                                    class="btn btn-xl btn-primary mt-4"><i class="fas fa-eye"></i></a>
                            </div>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        <?php else: ?>
            <div class="col-12 text-center py-5">
                <i class="fas fa-book-open fa-3x mb-3 text-muted"></i>
                <h4 class="text-muted">No se encontraron libros</h4>
            </div>
        <?php endif; ?>
    </div>

<?php }
?>

<?php
require_once 'partials/footer.php';
?>