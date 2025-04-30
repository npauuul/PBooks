<!DOCTYPE html>
<html lang="es" class="h-100">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="Sistema de gestión de libros para librerías">
    <title><?php echo SITE_NAME . " - " . htmlspecialchars($titulo ?? 'Inicio'); ?></title>

    <link rel="preconnect" href="https://cdn.jsdelivr.net">
    <link rel="preconnect" href="https://cdnjs.cloudflare.com">

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css"/>

    <link rel="icon" href="<?php echo BASE_URL; ?>assets/img/favicon.ico" type="image/x-icon">

    <link rel="stylesheet" href="<?php echo BASE_URL; ?>assets/css/styles.css">

    <script src="<?php echo BASE_URL; ?>assets/js/theme.js" defer></script>
</head>

<body class="d-flex flex-column h-100">
    <header>
        <nav class="navbar navbar-expand-lg navbar-dark bg-primary shadow-sm">
            <div class="container">
                <a class="navbar-brand d-flex align-items-center" href="<?php echo BASE_URL; ?>">
                    <i class="fas fa-book-open me-2 fs-2"></i>
                    <span class="text-uppercase">
                        <?php if (isset($_SESSION['user'])) {
                            echo $_SESSION['user']['username'];
                        }?>
                    </span>
                </a>

                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav"
                    aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>

                <div class="collapse navbar-collapse" id="navbarNav">
                    <ul class="navbar-nav ms-auto">
                        <li class="nav-item">
                            <a class="nav-link btn btn-primary mx-1 px-3 <?php echo (basename($_SERVER['PHP_SELF']) == 'index.php') ? 'active' : ''; ?>"
                                href="<?php echo BASE_URL; ?>">
                                <i class="fas fa-home me-1"></i> INICIO
                            </a>
                        </li>

                        <!-- LOGIN / LOGOUT -->
                        <?php if (!isset($_SESSION['token'])) { ?>
                            <li class="nav-item">
                                <a class="nav-link btn btn-primary mx-1 px-3 <?php echo (basename($_SERVER['PHP_SELF'])) == 'login.php' ? 'active' : ''; ?>"
                                    href="<?php echo BASE_URL; ?>auth/login">
                                    <i class="fa-solid fa-circle-user"></i>
                                </a>
                            </li>
                        <?php } else { ?>

                            <li class="nav-item">
                                <a class="nav-link btn btn-primary mx-1 px-3 <?php echo (basename($_SERVER['PHP_SELF'])) == 'agregar.php' ? 'active' : ''; ?>"
                                    href="<?php echo BASE_URL; ?>crud/agregar">
                                    <i class="fa-solid fa-plus"></i> Añadir libro
                                </a>
                            </li>

                            <li class="nav-item">
                                <a class="nav-link btn btn-danger mx-1 px-3"
                                    href="<?php echo BASE_URL; ?>auth/logout">
                                    <i class="fa-solid fa-arrow-right-to-bracket"></i>
                                </a>
                            </li>
                        <?php }; ?>
                    </ul>
                </div>
            </div>
        </nav>
    </header>

    <main class="flex-shrink-0 my-4">
        <div class="container">