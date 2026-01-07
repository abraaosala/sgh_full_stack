<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta content="width=device-width, initial-scale=1.0" name="viewport">
    <title>
        {{$title??'SGH'}}
    </title>
    <meta name="description" content="{{ $description ?? '' }}">
    <meta name="keywords" content="{{ $keywords ?? '' }}">

    <!-- Favicons -->
    <link rel="icon" href="<?= asset('img/logoM.png') ?>" type="image/x-icon">
    <link href="<?= asset('img/apple-touch-icon.png') ?>" rel="apple-touch-icon">

    <!-- Fonts -->
    <link href="https://fonts.googleapis.com" rel="preconnect">
    <link href="https://fonts.gstatic.com" rel="preconnect" crossorigin>
    <link
        href="https://fonts.googleapis.com/css2?family=Roboto:ital,wght@0,100;0,300;0,400;0,500;0,700;0,900;1,100;1,300;1,400;1,500;1,700;1,900&family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&family=Raleway:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap"
        rel="stylesheet">

    <!-- Vendor CSS Files -->
    <link href="<?= asset('vendor/bootstrap/css/bootstrap.min.css') ?>" rel="stylesheet" />
    <link href="<?= asset('vendor/bootstrap-icons/bootstrap-icons.css') ?>" rel="stylesheet" />
    <link href="<?= asset('vendor/aos/aos.css" rel="stylesheet') ?>">
    <link href="<?= asset('vendor/fontawesome-free/css/all.min.css') ?>" rel="stylesheet" />
    <link href="<?= asset('vendor/glightbox/css/glightbox.min.css') ?>" rel="stylesheet" />
    <link href="<?= asset('vendor/swiper/swiper-bundle.min.css') ?>" rel="stylesheet" />

    <!-- Main CSS File -->
    <link href="<?= asset('css/main.css') ?>" rel="stylesheet" />
</head>

<body class="index-page">

    <header id="header" class="header sticky-top">

        <div class="topbar d-flex align-items-center">
            <div class="container d-flex justify-content-center justify-content-md-between">
                <div class="d-none d-md-flex align-items-center">
                    <i class="bi bi-clock me-1"></i>
                    Segunda-Sabado -
                </div>
                <div class="d-flex align-items-center">
                    <i class="bi bi-phone me-1"></i> Liga para nós agora <?= env('APP_FONE') ?? '' ?>
                </div>
            </div>
        </div><!-- End Top Bar -->

        <div class="branding d-flex align-items-center">

            <div class="container position-relative d-flex align-items-center justify-content-end">
                <a href="/" class="logo d-flex align-items-center me-auto">
                    <img src="<?= root() ?>public/assets/img/logo.png" alt="">
                    <!-- <h1 class="sitename">Medicio</h1>  -->
                </a>

                <nav id="navmenu" class="navmenu">
                    <ul>
                        <li><a href="/">Home</a></li>
                        <li><a href="/about">About</a></li>
                        <li><a href="/services">Services</a></li>
                        <li><a href="/departments">Departments</a></li>
                        <li><a href="/doctors">Doctors</a></li>

                        <li><a href="#contact">Contact</a></li>

                        <li class="dropdown"><a href="#"><span>Menu</span> <i class="bi bi-chevron-down toggle-dropdown"></i></a>
                            <?php if (!logged()) : ?>
                        <li><a href="<?= root() ?>login" target="_blank">Login</a></li>
                    <?php else: ?>
                        <li><a href="<?= root() ?>meu-perfil">meu Perfil</a></li>

                        <form action="<?php echo root(); ?>logout" method="post">
                            <button type="submit" class="btn">
                                Sair
                        </form>

                    <?php endif ?>
                    </li>
                    </ul>
                    <i class="mobile-nav-toggle d-xl-none bi bi-list"></i>
                </nav>

            </div>

        </div>

    </header>

    @yield('content')

    <footer class="pc-footer">
        <div class="footer-wrapper container-fluid">
            <div class="row">
                <div class="col-sm my-1">
                    <p class="m-0">
                        <?= $sistem ?? 'SGH' ?> Desenvolvido por <a href="" target="_blank">Salab</a> .</p>
                </div>
                <div class="col-auto my-1">
                    <ul class="list-inline footer-link mb-0">
                        <li class="list-inline-item"><a href="/">Home</a></li>
                    </ul>
                </div>
            </div>
        </div>
    </footer>

    <!-- Scroll Top -->
    <a href="#" id="scroll-top" class="scroll-top d-flex align-items-center justify-content-center"><i
            class="bi bi-arrow-up-short"></i></a>

    <!-- Vendor JS Files -->
    <script src="{{ asset('vendor/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
    <script src="{{ asset('vendor/php-email-form/validate.js') }}"></script>
    <script src="{{ asset('vendor/aos/aos.js') }}"></script>
    <script src="{{ asset('vendor/glightbox/js/glightbox.min.js') }}"></script>
    <script src="{{ asset('vendor/purecounter/purecounter_vanilla.js') }}"></script>
    <script src="{{ asset('vendor/swiper/swiper-bundle.min.js') }}"></script>

    <!-- Main JS File -->
    <script src="{{ asset('js/custom.js') }}"></script>
    <script src="{{ asset('js/main.js') }}"></script>

</body>

</html>