<section class="section" style="background: linear-gradient(135deg, #f8fafc 0%, #e0e7ff 100%); min-height: 100vh;">
    <div class="container py-3"><!-- Alterado de py-5 para py-3 -->
        <div class="row justify-content-center">
            <div class="col-lg-5 col-md-7">
                <div class="card p-4 shadow-lg border-0 rounded-4" style="background: #fff;">
                    <div class="section-title text-center mb-1"><!-- Moveu para dentro do card -->
                        <h2 class="fw-bold text-primary"><i class="bi bi-person-circle me-2"></i>
                            <br>
                            Entrar no SGH
                        </h2>
                        <p class="text-secondary">Por favor, insira suas credenciais para acessar o sistema.</p>
                    </div>

                    <form id="login" class="needs-validation" novalidate>
                        <!-- Formulário de login -->
                        <?= flash(['error', 'success', 'info']) ?>

                        <div class="form-group mb-3">
                            <label for="username" class="form-label fw-semibold">Usuário</label>
                            <div class="input-group">
                                <span class="input-group-text bg-light"><i class="bi bi-person"></i></span>
                                <input type="text" id="username" name="username" class="form-control" required autofocus autocomplete="username" aria-label="Usuário">
                            </div>
                        </div>
                        <div class="form-group mb-4 position-relative">
                            <label for="password" class="form-label fw-semibold">Senha</label>
                            <div class="input-group">
                                <span class="input-group-text bg-light"><i class="bi bi-lock"></i></span>
                                <input type="password" id="password" name="password" class="form-control" required autocomplete="current-password" aria-label="Senha">
                                <button type="button" class="btn btn-outline-secondary border-0" tabindex="-1" onclick="togglePassword()" aria-label="Mostrar ou ocultar senha">
                                    <span id="toggleIcon" class="bi bi-eye"></span>
                                </button>
                            </div>
                        </div>

                        <div class="text-center mb-2">
                            <button class="btn btn-primary w-100 fw-bold" type="submit">
                                <i class="bi bi-box-arrow-in-right me-1"></i>Entrar
                            </button>
                        </div>
                        <div class="text-center">
                            <a href="/auth/forgot" class="small text-decoration-none text-primary">Esqueceu a senha?</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
</section>
<script>
    function togglePassword() {
        const pwd = document.getElementById('password');
        const icon = document.getElementById('toggleIcon');
        if (pwd.type === 'password') {
            pwd.type = 'text';
            icon.className = 'bi bi-eye-slash';
        } else {
            pwd.type = 'password';
            icon.className = 'bi bi-eye';
        }
    }
</script>