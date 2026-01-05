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
            <a href="index.html" class="logo d-flex align-items-center me-auto">
                <img src="<?= root() ?>public/assets/img/logo.png" alt="">
                <!-- Uncomment the line below if you also wish to use a text logo -->
                <!-- <h1 class="sitename">Medicio</h1>  -->
            </a>
            <!-- ========== Start nav ========== -->

            <!-- ========== End nav ========== -->

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

                    <!-- <li><a href="/logout">Logout</a></li> -->

                    <form action="<?php echo root(); ?>logout" method="post">
                        <button type="submit" class="btn">
                            Sair
                    </form>

                <?php endif ?>
                <!--    <ul class="dropdown-list">
                            <?php if (logged()) : ?>
                                <li><a href="/profile">Profile</a></li>
                                <li><a href="/logout">Logout</a></li>
                            <?php else: ?>
                                <li><a href="/login">Login</a></li>
                                <li><a href="/register">Register</a></li>
                            <?php endif ?>


                        </ul> -->
                </li>
                </ul>
                <i class="mobile-nav-toggle d-xl-none bi bi-list"></i>
            </nav>

            <!-- <a class="cta-btn" href="index.html#appointment">Make an Appointment</a> -->


        </div>

    </div>

</header>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const links = document.querySelectorAll('#navmenu a[href]');
        const currentPath = window.location.pathname.replace(/\/$/, '');

        links.forEach(link => {
            const linkPath = link.getAttribute('href').replace(/\/$/, '');
            if (
                linkPath &&
                linkPath !== '#' &&
                (linkPath === currentPath || (linkPath === '' && currentPath === ''))
            ) {
                links.forEach(l => l.classList.remove('active'));
                link.classList.add('active');
            }
        });
    });
</script>