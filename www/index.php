<?php
session_start();
ob_start(); // Habilita o buffer de saída

// Conexão com o banco de dados
$dsn = 'mysql:host=localhost;port=3306;dbname=servicos;charset=utf8';
$username = 'root';
$password = 'Bones27$';

try {
    $pdo = new PDO($dsn, $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die('Erro na conexão com o banco de dados: ' . $e->getMessage());
}

// Consulta para obter os serviços
$stmt = $pdo->query('SELECT * FROM servicos');
$services = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Bessa Technology</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://code.jquery.com/jquery-3.6.4.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"></script>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.21.0/font/bootstrap-icons.css">
    <link rel="stylesheet" href="style/style.css">

</head>

<body>

    <!-- Navbar -->
    <nav class="navbar navbar-expand-lg navbar-dark">
        <a class="navbar-brand" href="#">
            <img id="logo" src="img\logo.png" alt="Logo" width="50">
        </a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav"
            aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse justify-content-end" id="navbarNav">
            <ul class="navbar-nav">
                <li class="nav-item">
                    <a class="nav-link" href="#quem-somos">Quem Somos</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="#services-carousel">Serviços</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="#contato">Contatos</a>
                </li>
            </ul>
        </div>
    </nav>

    <!-- Hero Section -->
    <div id="hero-section">
        <div class="hero-content">
        </div>
    </div>

    <!-- Seção de Imagem de Fundo -->
    <div id="background-image" style="font-size: 500%;  color: #cfd1d1;">
        <b><p>Bessa Technology</p></b>
    </div>

    <!-- Quem Somos Section -->
    <div id="quem-somos" class="m-lg-5 m">
        <h2>Sobre:</h2>
        <p>Bessa Technology surge como uma inovadora e vibrante empresa dedicada a oferecer soluções digitais excepcionais no mundo em constante evolução da tecnologia. Especializados na criação de sites e na manutenção de computadores, nossa missão é impulsionar o sucesso de nossos clientes, proporcionando serviços de alta qualidade e acompanhamento personalizado.</p>
        <h2>Nossa Visão</h2>
        <p> Buscamos ser uma referência no mercado, destacando-nos pela excelência técnica, criatividade e comprometimento. Acreditamos que a tecnologia deve ser acessível a todos, e nossa visão é facilitar essa acessibilidade, contribuindo para o crescimento e prosperidade de nossos clientes.</p>
        <h2>Compromisso com a Inovação</h2>
        <p>Na Bessa Technology, abraçamos a inovação como nosso lema. Estamos constantemente atualizados com as últimas tendências e avanços tecnológicos para garantir que possamos oferecer soluções modernas e eficazes aos nossos clientes. Nosso time de profissionais altamente qualificados está pronto para transformar suas ideias em realidade digital.</p>
        <h2>Serviços Personalizados</h2>
        <p>Entendemos que cada cliente é único, e é por isso que oferecemos serviços personalizados que atendem às suas necessidades específicas. Seja na criação de um site impactante para fortalecer sua presença online ou na manutenção eficiente de seus sistemas, estamos comprometidos em fornecer soluções sob medida que impulsionarão o seu sucesso.</p>
        <h2>Ética e Transparência</h2>
        <p>Acreditamos em construir relacionamentos sólidos e duradouros com nossos clientes, baseados em ética e transparência. Cada projeto é tratado com a máxima integridade, desde a concepção até a entrega. Queremos que nossos clientes se sintam confiantes e satisfeitos em cada etapa do processo.</p>
        <h2>Parceria para o Sucesso</h2>
        <p>Na Bessa Technology, não vemos nossos clientes como meros contratantes, mas como parceiros. Estamos empenhados em caminhar lado a lado com você, entendendo suas metas e desafios para proporcionar soluções que contribuam efetivamente para o seu sucesso.</p>
        <p>Seja bem-vindo à Bessa Technology, onde a inovação encontra a excelência, e o futuro digital é moldado com dedicação e expertise. Estamos ansiosos para colaborar com você e impulsionar o seu potencial digital!</p>
    </div>

    <!-- Serviços Carousel -->
    <div id="services-carousel" class="container mt-2 bg-dark p-2  text-white">
        <div class="container">
            <h2 class="text-center">Nossos Serviços</h2>
            <div id="carouselServices" class="carousel carousel-dark slide" data-bs-ride="carousel">
                <div class="carousel-inner">

                    <?php
                    $firstItem = true;
                    foreach ($services as $index => $service) {
                        echo '<div class="carousel-item ' . ($firstItem ? ' active' : '') . '">';
                        echo '<div class="card text-center m-lg-5">';
                        echo '<div class="card-body rounded">';
                        echo '<h5 class="card-title text-dark">' . $service['nome_servico'] . '</h5>';
                        echo '<p class="card-text text-dark">' . $service['descricao'] . '</p>';
                        echo '<p class="card-text text-dark">Preço: R$ ' . number_format($service['preco'], 2, ',', '.') . '</p>';
                        echo '<a href="https://api.whatsapp.com/send?phone=5531971666141&text=Olá,%20gostaria%20de%20mais%20informações%20sobre%20o%20serviço%20' . urlencode($service['titulo']) . '" class="btn btn-success">Contate-nos no WhatsApp</a>';
                        echo '</div>';
                        echo '</div>';
                        echo '</div>';

                        $firstItem = false;
                    }
                    ?>

                </div>

                <!-- Botões de controle aqui -->
                <button class="carousel-control-prev" type="button" data-bs-target="#carouselServices" data-bs-slide="prev">
                    <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                    <span class="visually-hidden">Anterior</span>
                </button>
                <button class="carousel-control-next" type="button" data-bs-target="#carouselServices" data-bs-slide="next">
                    <span class="carousel-control-next-icon" aria-hidden="true"></span>
                    <span class="visually-hidden">Próximo</span>
                </button>
            </div>
        </div>
    </div>

        <!-- Botão para voltar ao topo -->
        <div id="btnTopoContainer" class="position-fixed bottom-0 end-0 p-3">
            <button id="btnTopo" class="btn btn-primary btn-floating btn-lg rounded-5" onclick="topFunction()" title="Voltar ao Topo">
                <i class="bi bi-arrow-up-circle">^</i>
            </button>
        </div>

    <footer id="contato" class="footer">
        <div class="container">
            <div class="row gy-4">
                <div class="col-lg-5 col-md-12 footer-info">
                    <h4>Redes Sociais</h4>
                    <ul class="list-unstyled">
                        <li>
                            <img src="img/github.png" alt="GitHub" style="width: 20px; height: 20px; margin-right: 5px;">    
                            <a href="https://github.com/josephbessa" class="text-white text-decoration-none" target="_blank">GitHub</a>
                        </li>
                        <li>
                            <img src="img/instagram.png" alt="GitHub" style="width: 20px; height: 20px; margin-right: 5px;">    
                            <a href="https://www.instagram.com/joseph_bessaa/?igshid=MzMyNGUyNmU2YQ%3D%3D&utm_source=qr" class="text-white text-decoration-none" target="_blank">Instagram</a>
                        </li>
                        <li>
                            <img src="img/linkedin.png" alt="GitHub" style="width: 20px; height: 20px; margin-right: 5px;">    
                            <a href="https://www.linkedin.com/in/joseph-bessa?utm_source=share&utm_campaign=share_via&utm_content=profile&utm_medium=ios_app" class="text-white text-decoration-none" target="_blank">LinkedIn</a>
                        </li>
                    </ul>
                </div>

                <div class="col-lg-2 col-6 footer-links">
                </div>

                <div class="col-lg-2 col-6 footer-links">
                </div>

                <div class="col-lg-3 col-md-12 footer-contact text-center text-md-start">
                    <h4>Contatos</h4>
                    <p>
                        <img src="img/localizacao.png" alt="GitHub" style="width: 20px; height: 20px; margin-right: 5px;">
                        Belo Horizonte, MG,  Brasil <br>
                        <img src="img/telefone.png" alt="GitHub" style="width: 20px; height: 20px; margin-right: 5px;">
                        <strong>Phone:</strong> (31)1234-5678<br>
                        <img src="img/gmail.png" alt="GitHub" style="width: 20px; height: 20px; margin-right: 5px;">
                        <strong>Email:</strong> joseph@teste.com<br>
                    </p>
                </div>
            </div>
        </div>
        <div> Ícones feitos por <a href="https://www.flaticon.com/br/autores/freepik" title="Freepik"> Freepik </a> from <a href="https://www.flaticon.com/br/" title="Flaticon">www.flaticon.com'</a></div>
    </footer>
     <!-- Inclusão dos scripts -->               
    <!-- <script src="https://code.jquery.com/jquery-3.6.4.slim.min.js"></script> -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"></script>

    <script src="js/script.js"></script>

</body>

</html>

