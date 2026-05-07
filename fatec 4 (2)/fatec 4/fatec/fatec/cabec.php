<!doctype html>
<?php
  if (session_status() === PHP_SESSION_NONE) {
      session_start();
  }

  if (!isset($_COOKIE['idioma'])) {
    $_COOKIE['idioma'] = 'pt';
  }

  // Traduções
  if (file_exists(strtolower('./idioma/' . $_COOKIE['idioma']) . '.lang')) {
    $lng = parse_ini_file('./idioma/' . strtolower($_COOKIE['idioma']) . '.lang');
  } else {
    $lng = parse_ini_file('./idioma/pt.lang');
  }

  // Ajuste de imagens de bandeiras
  $bandeira = [
      'pt' => 'pt.png',
      'en' => 'en.png',
      'es' => 'es.png',
      'it' => 'it_IT.png',
      'fr' => 'fr_FR.png'
  ];

  // Caso falte usa o padrão
  $imgBandeira = isset($bandeira[$_COOKIE['idioma']]) ? $bandeira[$_COOKIE['idioma']] : 'pt.png';
?>
<html lang="pt-BR">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">

  <link rel="icon" type="image/png" href="icones/iconedeaba.png">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet">
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"></script>

  <title>FluxPro</title>
</head>
<body>
<nav class="navbar navbar-expand-lg navbar-dark" style="background-color: #1986a4;">
  <div class="container-fluid">
    <a class="navbar-brand" href="index.php">FluxPro</a>

    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent">
      <span class="navbar-toggler-icon"></span>
    </button>

    <div class="collapse navbar-collapse" id="navbarSupportedContent">
      <ul class="navbar-nav me-auto mb-2 mb-lg-0">

        <li class="nav-item">
          <a class="nav-link active" href="index.php"><?= $lng['home'] ?></a>
        </li>

        <li class="nav-item dropdown">
          <a class="nav-link dropdown-toggle active" href="#" id="navbarDropdown" data-bs-toggle="dropdown">
            <?= $lng['cadastro'] ?>
          </a>
          <ul class="dropdown-menu" aria-labelledby="navbarDropdown">
            <li><a class="dropdown-item" href="pessoa.php"><?= $lng['pessoa'] ?></a></li>
            <li><a class="dropdown-item" href="produto.php"><?= $lng['produto'] ?></a></li>
            <li><a class="dropdown-item" href="servicos.php"><?= $lng['servico'] ?></a></li>
          </ul>
        </li>

        <?php if (isset($_SESSION['usuNome'])): ?>
          <li class="nav-item">
            <span class="nav-link active"><?= htmlspecialchars($_SESSION['usuNome']) ?></span>
          </li>
        <?php else: ?>
          <li class="nav-item">
            <a class="nav-link active" href="login.php"><?= $lng['login'] ?></a>
          </li>
        <?php endif; ?>
      </ul>

      <!-- Bandeira -->
      <div class="me-3">
        <a href="idioma.php">
          <img src="./icones/<?= $imgBandeira ?>" width="40px" alt="Idioma">
        </a>
      </div>

      <!-- Clima estilizado igual ao menu -->
      <div class="nav-link text-white me-4"
           id="clima-menu"
           style="font-weight: normal; font-size: 1rem; padding-left: 0;">
        Carregando clima...
      </div>

      <?php if (isset($_SESSION['usuNome'])): ?>
        <ul class="navbar-nav">
          <li class="nav-item">
            <a class="nav-link text-white" href="logout.php"><?= $lng['sair'] ?></a>
          </li>
        </ul>
      <?php endif; ?>
    </div>
  </div>
</nav>

<script>
async function carregarClima() {
    const apiKey = "5fd8b43c3872a9ee64fdcd64284f45e4";
    const cidade = "Sao Paulo";

    try {
        const url = `https://api.openweathermap.org/data/2.5/weather?q=${cidade}&appid=${apiKey}&units=metric&lang=pt_br`;
        const resposta = await fetch(url);
        const dados = await resposta.json();

        if (dados.main) {
            const temp = Math.round(dados.main.temp);
            const clima = dados.weather[0].description;
            document.getElementById("clima-menu").textContent = `${temp}°C - ${clima}`;
        } else {
            document.getElementById("clima-menu").textContent = "Clima indisponível";
        }
    } catch (e) {
        document.getElementById("clima-menu").textContent = "Erro ao carregar";
    }
}

carregarClima();
</script>

</body>
</html>
