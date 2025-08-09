<!-- chama os modals-->
<?php
include("includes/modals/register.php");
include("includes/modals/login.php")
?>



<!DOCTYPE html>
<html lang="pt">

<head>
  <meta charset="utf-8">
  <meta content="width=device-width, initial-scale=1.0" name="viewport">
  <title>TraceMZ- Rastreamento de Dispositivos</title>
  <meta name="description" content="Registro e consulta de IMEI para combater furtos de celulares e laptops">
  <meta name="keywords" content="IMEI, celular roubado, rastreamento, furto, dispositivo">

  <!-- Favicons -->
  <link href="assets/img/favicon.png" rel="icon">
  <link href="assets/img/apple-touch-icon.png" rel="apple-touch-icon">

  <!-- Fonts -->
  <link href="https://fonts.googleapis.com" rel="preconnect">
  <link href="https://fonts.gstatic.com" rel="preconnect" crossorigin>
  <link
    href="https://fonts.googleapis.com/css2?family=Roboto:ital,wght@0,100;0,300;0,400;0,500;0,700;0,900;1,100;1,300;1,400;1,500;1,700;1,900&family=Raleway:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap"
    rel="stylesheet">

  <!-- Vendor CSS Files -->
  <link href="assets/vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">
  <link href="assets/vendor/bootstrap-icons/bootstrap-icons.css" rel="stylesheet">
  <link href="assets/vendor/aos/aos.css" rel="stylesheet">
  <link href="assets/vendor/glightbox/css/glightbox.min.css" rel="stylesheet">
  <link href="assets/vendor/swiper/swiper-bundle.min.css" rel="stylesheet">

  <!-- Main CSS File -->
  <link href="assets/css/main.css" rel="stylesheet">
  <link rel="stylesheet" href="assets/css/home.css">

</head>

<body class="index-page">

  <header id="header" class="header d-flex align-items-center fixed-top">
    <div class="container-fluid container-xl position-relative d-flex align-items-center">

      <a href="/home" class="logo d-flex align-items-center me-auto">
        <img src="assets/img/logo_trace.png" alt="TraceMz" style="height: 50px;">
      </a>

      <nav id="navmenu" class="navmenu">
        <ul>
          <li><a href="#hero" class="active">Início</a></li>
          <li><a href="#como-funciona">Como Funciona</a></li>
          <li><a href="#beneficios">Benefícios</a></li>
          <li><a href="#faq">FAQ</a></li>
          <li><a href="#contato">Contato</a></li>
          <li class="d-xl-none"><a href="#login" class="cta-btn" data-bs-toggle="modal"
              data-bs-target="#loginModal">Iniciar Sessão</a></li>
        </ul>
        <i class="mobile-nav-toggle d-xl-none bi bi-list"></i>
      </nav>

      <div class="d-flex gap-3">
        <a href="#login" class="cta-btn d-none d-xl-block" data-bs-toggle="modal" data-bs-target="#loginModal">Iniciar
          Sessão</a>
      </div>

    </div>
  </header>

  <main class="main">

    <!-- Hero Section -->
    <section id="hero" class="hero section dark-background">
      <img src="assets/img/hero-bg.jpg" alt="Celular com cadeado de segurança" data-aos="fade-in">

      <div class="container d-flex flex-column align-items-center text-center mt-auto">
        <h2 data-aos="fade-up" data-aos-delay="100">PROTEJA SEU DISPOSITIVO<br><span>CONTRA FURTOS</span></h2>
        <p data-aos="fade-up" data-aos-delay="200">Registre seu celular ou laptop e ajude a combater o comércio ilegal
        </p>
        <div data-aos="fade-up" data-aos-delay="300" class="d-flex gap-3 my-4">
          <a href="#consultar-imei" class="btn btn-danger w-180 h-50">Consultar IMEI</a>
          <a href="#cadastro" class="btn btn-outline-light w-180 h-50" data-bs-toggle="modal"
            data-bs-target="#registerModal">Criar Conta</a>
        </div>
      </div>

      <div class="about-info mt-auto position-relative">
        <div class="container position-relative" data-aos="fade-up">
          <div class="row justify-content-center align-items-center text-center text-lg-start"> 
            <div class="col-lg-6 mb-4 mb-lg-0">
              <h2 class="text-center text-lg-start">Sobre o TraceMz</h2>
              <p class="text-center text-lg-start">Uma plataforma inovadora para registro e consulta de dispositivos móveis, ajudando vítimas de furto e inibindo o comércio ilegal.</p>
            </div>
            <div class="col-lg-3 mb-4 mb-lg-0">
              <h3 class="text-center">Cobertura</h3>
              <p class="text-center">Smartphones, notebooks, tablets e wearables de todas as marcas</p>
            </div>
            <div class="col-lg-3">
              <h3 class="text-center">Segurança</h3>
              <p class="text-center">Criptografia militar, cloud protegida e verificação em tempo real</p>
            </div>
          </div>
        </div>
      </div>

    </section><!-- /Hero Section -->

    <!-- Consulta IMEI Section -->
    <section id="consultar-imei" class="section bg-light">
      <div class="container" data-aos="fade-up">
        <div class="row justify-content-center">
          <div class="col-lg-8 text-center">
            <h2 class="mb-4">Verifique se um dispositivo foi roubado</h2>
            <div class="imei-check-form">
              <form>
                <div class="input-group mb-3">
                  <input type="text" class="form-control form-control-sm" placeholder="Digite o IMEI (15 dígitos)"
                    pattern="[0-9]{15}" required>
                  <button class="btn btn-danger" type="submit">Consultar</button>
                </div>
                <small class="text-muted">Não sabe onde encontrar o IMEI? <a href="#faq">Clique aqui</a></small>
              </form>
            </div>
          </div>
        </div>
      </div>
    </section><!-- /Consulta IMEI Section -->

    <!-- Como Funciona Section -->
    <section id="como-funciona" class="section">
      <div class="container py-5">
        <div class="text-center mb-5" data-aos="fade-up">
          <h2 class="mb-3">Proteja seu dispositivo em 3 passos</h2>
          <p class="lead text-muted">Sistema simples e eficaz para segurança de seus equipamentos</p>
        </div>

        <div class="row g-4">
          <div class="col-lg-4" data-aos="fade-up" data-aos-delay="100">
            <div class="feature-card card border-0 shadow-sm">
              <div class="card-body p-4 text-center">
                <div class="feature-icon">
                  <i class="bi bi-phone"></i>
                </div>
                <h3 class="h4">Registre Seu Dispositivo</h3>
                <p>Cadastre o IMEI e número de série do seu celular ou laptop em nossa plataforma segura.</p>
                <div class="step-badge">1</div>
              </div>
            </div>
          </div>

          <div class="col-lg-4" data-aos="fade-up" data-aos-delay="200">
            <div class="feature-card card border-0 shadow-sm">
              <div class="card-body p-4 text-center">
                <div class="feature-icon text-danger">
                  <i class="bi bi-shield-lock"></i>
                </div>
                <h3 class="h4">Reporte Furto/Perda</h3>
                <p>Em caso de roubo, atualize o status do dispositivo em sua conta para alertar o sistema.</p>
                <div class="step-badge">2</div>
              </div>
            </div>
          </div>

          <div class="col-lg-4" data-aos="fade-up" data-aos-delay="300">
            <div class="feature-card card border-0 shadow-sm">
              <div class="card-body p-4 text-center">
                <div class="feature-icon text-success">
                  <i class="bi bi-search"></i>
                </div>
                <h3 class="h4">Consulte Antes de Comprar</h3>
                <p>Verifique se um dispositivo usado foi reportado como roubado antes de adquirir.</p>
                <div class="step-badge">3</div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </section><!-- /Como Funciona Section -->

    <!-- Beneficcios Section -->
    <section id="beneficios" class="section bg-light">
      <div class="container py-5">
        <div class="row align-items-center">
          <div class="col-lg-6 mb-5 mb-lg-0" data-aos="fade-right">
            <img src="assets/img/hero-bg.jpg" class="img-fluid rounded-3 shadow" alt="Benefícios do TraceMz">
          </div>
          <div class="col-lg-6" data-aos="fade-left">
            <h2 class="mb-4">Por que usar o TraceMz?</h2>

            <div class="d-flex mb-4">
              <div class="benefit-icon text-primary">
                <i class="bi bi-shield-check"></i>
              </div>
              <div>
                <h3 class="h5">Proteção Ativa</h3>
                <p class="mb-0">Aumente significativamente as chances de recuperar seu dispositivo em caso de furto.</p>
              </div>
            </div>

            <div class="d-flex mb-4">
              <div class="benefit-icon text-success">
                <i class="bi bi-search"></i>
              </div>
              <div>
                <h3 class="h5">Consulta Pública</h3>
                <p class="mb-0">Verifique gratuitamente se um dispositivo foi reportado como roubado antes de comprar.
                </p>
              </div>
            </div>

            <div class="d-flex mb-4">
              <div class="benefit-icon text-danger">
                <i class="bi bi-graph-up"></i>
              </div>
              <div>
                <h3 class="h5">Dados Estatísticos</h3>
                <p class="mb-0">Contribua para mapear zonas de risco e padrões de furto em Moçambique.</p>
              </div>
            </div>
          </div>
        </div>
      </div>
    </section><!-- /Beneficios Section -->

    <!-- FAQ Section -->
    <section id="faq" class="section">
      <div class="container py-5">
        <div class="text-center mb-5" data-aos="fade-up">
          <h2 class="mb-3">Perguntas Frequentes</h2>
          <p class="text-muted">Tire suas dúvidas sobre o TraceMz</p>
        </div>

        <div class="row justify-content-center">
          <div class="col-lg-10">
            <div class="accordion" id="faqAccordion">

              <div class="accordion-item border-0 shadow-sm mb-3" data-aos="fade-up">
                <h3 class="accordion-header" id="headingOne">
                  <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
                    data-bs-target="#collapseOne" aria-expanded="false">
                    <i class="bi bi-question-circle me-2 " style="color: var(--accent);"></i> O que é IMEI e onde
                    encontro no meu celular?
                  </button>
                </h3>
                <div id="collapseOne" class="accordion-collapse collapse" aria-labelledby="headingOne"
                  data-bs-parent="#faqAccordion">
                  <div class="accordion-body">
                    <div class="d-flex">
                      <div class="flex-shrink-0">
                        <i class="bi bi-info-circle text-primary me-3"></i>
                      </div>
                      <div>
                        O IMEI (International Mobile Equipment Identity) é um número único de identificação do seu
                        dispositivo. Para encontrá-lo:
                        <ul class="mt-2">
                          <li>Digite <code>*#06#</code> no teclado de chamada</li>
                          <li>Verifique nas configurações do aparelho (Geral > Sobre)</li>
                          <li>Olhe na caixa original ou na nota fiscal</li>
                          <li>Para iPhones: Ajustes > Geral > Sobre</li>
                        </ul>
                      </div>
                    </div>
                  </div>
                </div>
              </div>

              <div class="accordion-item border-0 shadow-sm mb-3" data-aos="fade-up" data-aos-delay="100">
                <h3 class="accordion-header" id="headingTwo">
                  <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
                    data-bs-target="#collapseTwo">
                    <i class="bi bi-question-circle me-2 " style="color: var(--accent);"></i> Posso consultar um IMEI
                    sem ter conta no sistema?
                  </button>
                </h3>
                <div id="collapseTwo" class="accordion-collapse collapse" aria-labelledby="headingTwo"
                  data-bs-parent="#faqAccordion">
                  <div class="accordion-body">
                    <div class="d-flex">
                      <div class="flex-shrink-0">
                        <i class="bi bi-info-circle text-primary me-3"></i>
                      </div>
                      <div>
                        Sim! A consulta de IMEI é aberta ao público. Qualquer pessoa pode verificar se um dispositivo
                        foi reportado como roubado. Você só precisa criar uma conta para registrar seus próprios
                        dispositivos ou reportar furtos.
                      </div>
                    </div>
                  </div>
                </div>
              </div>

              <div class="accordion-item border-0 shadow-sm mb-3" data-aos="fade-up" data-aos-delay="200">
                <h3 class="accordion-header" id="headingThree">
                  <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
                    data-bs-target="#collapseThree">
                    <i class="bi bi-question-circle me-2 " style="color: var(--accent);"></i> Meu dispositivo foi
                    roubado. O que fazer?
                  </button>
                </h3>
                <div id="collapseThree" class="accordion-collapse collapse" aria-labelledby="headingThree"
                  data-bs-parent="#faqAccordion">
                  <div class="accordion-body">
                    <div class="d-flex">
                      <div class="flex-shrink-0">
                        <i class="bi bi-info-circle text-primary me-3"></i>
                      </div>
                      <div>
                        <ol>
                          <li>Acesse sua conta TraceMz e atualize o status do dispositivo para "Roubado/Furtado"</li>
                          <li>Registre imediatamente um boletim de ocorrência na polícia</li>
                          <li>Utilize os links de rastreio disponíveis em nosso sistema (Find My iPhone, Find My Device)
                          </li>
                          <li>Informe sua operadora para bloquear o IMEI</li>
                          <li>Mantenha seu cadastro atualizado com quaisquer informações relevantes</li>
                        </ol>
                      </div>
                    </div>
                  </div>
                </div>
              </div>

              <div class="accordion-item border-0 shadow-sm mb-3" data-aos="fade-up" data-aos-delay="300">
                <h3 class="accordion-header" id="headingFour">
                  <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
                    data-bs-target="#collapseFour">
                    <i class="bi bi-question-circle me-2 " style="color: var(--accent);"></i> Como posso ter certeza que
                    meus dados estão seguros?
                  </button>
                </h3>
                <div id="collapseFour" class="accordion-collapse collapse" aria-labelledby="headingFour"
                  data-bs-parent="#faqAccordion">
                  <div class="accordion-body">
                    <div class="d-flex">
                      <div class="flex-shrink-0">
                        <i class="bi bi-info-circle text-primary me-3"></i>
                      </div>
                      <div>
                        O TraceMz utiliza várias camadas de segurança:
                        <ul class="mt-2">
                          <li>Criptografia avançada de todos os dados sensíveis</li>
                          <li>Autenticação segura com verificação em duas etapas</li>
                          <li>Servidores protegidos com firewall e monitoramento 24/7</li>
                          <li>Política rigorosa de não compartilhamento de dados pessoais</li>
                          <li>Conformidade com as leis de proteção de dados de Moçambique</li>
                        </ul>
                        Seus dados estão muito mais seguros conosco do que em um cadastro físico de lojas ou serviços
                        informais.
                      </div>
                    </div>
                  </div>
                </div>
              </div>

            </div>
          </div>
        </div>
      </div>
    </section><!-- /FAQ Section -->

    <!-- Contato Section -->
    <section id="contato" class="section">
      <div class="container section-title" data-aos="fade-up">
        <h2>Contato</h2>
        <p>Entre em contato conosco para dúvidas ou parcerias</p>
      </div>
      <div class="container">
        <div class="row gy-4 mt-1">
          <div class="col-lg-6" data-aos="fade-up" data-aos-delay="300">
            <iframe
              src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d14390.09939853462!2d32.5728471!3d-25.9665303!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x1ee69b3aae665555%3A0x315d5d5d1b1e1b1e!2sMaputo!5e0!3m2!1sen!2smz!4v1620000000000!5m2!1sen!2smz"
              frameborder="0" style="border:0; width: 100%; height: 400px;" allowfullscreen="" loading="lazy"></iframe>
          </div>

          <div class="col-lg-6">
            <form class="php-email-form" data-aos="fade-up" data-aos-delay="400">
              <div class="row gy-4">

                <div class="col-md-6">
                  <input type="text" name="name" class="form-control" placeholder="Seu Nome" required>
                </div>

                <div class="col-md-6">
                  <input type="email" class="form-control" name="email" placeholder="Seu Email" required>
                </div>

                <div class="col-md-12">
                  <input type="text" class="form-control" name="subject" placeholder="Assunto" required>
                </div>

                <div class="col-md-12">
                  <textarea class="form-control" name="message" rows="6" placeholder="Mensagem" required></textarea>
                </div>

                <div class="col-md-12 text-center">
                  <button class="btn btn-danger w-100 btn-lg" type="submit">Enviar Mensagem</button>
                </div>
              </div>
            </form>
          </div>
        </div>
      </div>
    </section><!-- /Contato Section -->

  </main>

  <footer id="footer" class="footer dark-background">

    <div class="footer-top">
      <div class="container">
        <div class="row gy-4">
          <div class="col-lg-4 col-md-6 footer-about">
            <a href="home.html" class="logo d-flex align-items-center">
              <span class="sitename">TraceMz</span>
            </a>
            <div class="footer-contact pt-3">
              <p>Maputo, Moçambique</p>
              <p class="mt-3"><strong>Telefone:</strong> <span>+258 84 9000 531</span></p>
              <p><strong>Email:</strong> <span>microtechcorporation@gmail.com</span></p>
            </div>
          </div>

          <div class="col-lg-2 col-md-3 footer-links">
            <h4>Links Úteis</h4>
            <ul>
              <li><a href="#hero">Início</a></li>
              <li><a href="#como-funciona">Como Funciona</a></li>
              <li><a href="#beneficios">Benefícios</a></li>
              <li><a href="#faq">FAQ</a></li>
              <li><a href="#contato">Contato</a></li>
            </ul>
          </div>

          <div class="col-lg-2 col-md-3 footer-links">
            <h4>Termos</h4>
            <ul>
              <li><a href="#">Política de Privacidade</a></li>
              <li><a href="#">Termos de Serviço</a></li>
              <li><a href="#">Perguntas Frequentes</a></li>
            </ul>
          </div>

          <div class="col-lg-4 col-md-6 footer-newsletter">
            <h4>Receba Atualizações</h4>
            <p>Assine nossa newsletter para novidades e dicas de segurança</p>
            <form>
              <div class="input-group mb-3">
                <input type="text" class="form-control form-control-sm" placeholder="seu email" required>
                <button class="btn btn-danger" type="submit">Assinar</button>
              </div>
            </form>
          </div>

        </div>
      </div>
    </div>

    <div class="copyright text-center">
      <div
        class="container d-flex flex-column flex-lg-row justify-content-center justify-content-lg-between align-items-center">
        <div class="d-flex flex-column align-items-center align-items-lg-start">
          <div>
            © Copyright <strong><span>TraceMz</span></strong>. Todos os direitos reservados
          </div>
        </div>
        <div class="social-links order-first order-lg-last mb-3 mb-lg-0">
          <a href="#"><i class="bi bi-facebook"></i></a>
          <a href="#"><i class="bi bi-instagram"></i></a>
          <a href="#"><i class="bi bi-linkedin"></i></a>
          <a href="#"><i class="bi bi-twitter-x"></i></a>
        </div>
      </div>
    </div>

  </footer>

  <!-- Scroll Top -->
  <a href="#" id="scroll-top" class="scroll-top d-flex align-items-center justify-content-center"><i
      class="bi bi-arrow-up-short"></i></a>

  <!-- Preloader -->
  <div id="preloader"></div>

  <!-- Vendor JS Files -->
  <script src="assets/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
  <script src="assets/vendor/aos/aos.js"></script>
  <script src="assets/vendor/glightbox/js/glightbox.min.js"></script>
  <script src="assets/vendor/swiper/swiper-bundle.min.js"></script>

  <!-- Main JS File -->
  <script src="assets/js/main.js"></script>
  <script src="assets/js/modals.js"></script>


</body>

</html>