  <div class="auth-main">
      <div class="auth-wrapper v3">
          <div class="auth-form">
              <div class="auth-header">
                  <a href="#"><img src="<?= lnk('assets/img/logoM.png') ?>" alt="img" style="width: 30px;">HGS</a>
              </div>
              <div class="card my-5">
                  <div class="card-body">
                      <!-- Form Login -->
                      <form action="<?= root() ?>login/auth" method="post">
                          <?= csrf_field() ?>
                          <!-- <form id="form-attempt"> -->

                          <div class="d-flex justify-content-between align-items-end mb-4">
                              <h3 class="mb-0"><b>Login</b></h3>
                              <!-- <a href="#" class="link-primary">Não tens uma Conta?</a> -->
                          </div>
                          <!-- Flass Mensagem -->
                          <?= flash(['success', "error"])?>

                          <div class="form-group mb-3">
                              <label class="form-label">Email</label>
                              <input type="email" name="email" class="form-control" placeholder="Endereço de Email"
                                  value="<?= old('email') ?>">
                          </div>
                          <div class="form-group mb-3">
                              <label class="form-label">Senha</label>
                              <input type="password" name="password" class="form-control" placeholder="**********">
                              <!-- <h5 class="text"></h5> -->
                          </div>
                          <div class="d-flex mt-1 justify-content-between">
                              <!-- <div class="form-check">
                                  <input class="form-check-input input-primary" type="checkbox" id="customCheckc1"
                                      checked="">
                                  <label class="form-check-label text-muted" for="customCheckc1">Clique para continuar
                                      logado</label>
                              </div> -->
                              <h5 class="text-secondary f-w-400"><a href="<?=lnk('recuperar_senha')?>">Esqueceu a
                                      senha?</a>
                              </h5>
                          </div>
                          <div class="d-grid mt-4">
                              <button type="submit" class="btn btn-primary">Login</button>
                          </div>
                      </form>
                      <!-- Form Login End-->

                      <!--  -->
                      <!--  <div class="saprator mt-3">
                          <span>Login with</span>
                      </div>
                      <div class="row">
                          <div class="col-4">
                              <div class="d-grid">
                                  <button type="button" class="btn mt-2 btn-light-primary bg-light text-muted">
                                      <img src="<?= root() ?>public\ui\assets/images/authentication/google.svg"
                                      alt="img"> <span class="d-none d-sm-inline-block"> Google</span>
                                      </button>
                          </div>
                  </div>
                  <div class="col-4">
                      <div class="d-grid">
                          <button type="button" class="btn mt-2 btn-light-primary bg-light text-muted">
                              <img src="<?= root() ?>public\ui\assets/images/authentication/twitter.svg" alt="img">
                              <span class="d-none d-sm-inline-block"> Twitter</span>
                          </button>
                      </div>
                  </div>
                  <div class="col-4">
                      <div class="d-grid">
                          <button type="button" class="btn mt-2 btn-light-primary bg-light text-muted">
                              <img src="<?= root() ?>public\ui\assets/images/authentication/facebook.svg" alt="img">
                              <span class="d-none d-sm-inline-block"> Facebook</span>
                          </button>
                      </div>
                  </div>
              </div> -->
                  </div>
              </div>
              <div class="auth-footer row">
                  <!-- <div class=""> -->
                  <div class="col my-1">
                      <p class="m-0">Copyright © <a href="#">
                              <?= $dev ?? '' ?>
                          </a></p>
                  </div>
                  <div class="col-auto my-1">
                      <ul class="list-inline footer-link mb-0">
                          <li class="list-inline-item"><a href="#">Home</a></li>
                          <li class="list-inline-item"><a href="#">Privacidade</a></li>
                          <li class="list-inline-item"><a href="#">Contactos-nos</a></li>
                      </ul>
                  </div>
                  <!-- </div> -->
              </div>
          </div>
      </div>
  </div>