<?php
  include_once("cabec.php");
?>

<!-- CSS responsivo começa aqui -->
<style>
  :root {
    --primary: #0f8899;
  }

  #container {
    display: flex;
    justify-content: space-between;
    align-items: center;
    height: 70vh;
    padding: 0 10%;
    gap: 20px;
  }

  #container h1 {
    text-align: left;
    color: var(--primary);
    font-size: 60px;
    font-weight: bold;
  }

  #container p {
    font-size: 20px;
    color: #333;
  }

  #container img {
    width: 400px;
    border-radius: 15px;
    box-shadow: 0 4px 10px rgba(0, 0, 0, 0.2);
    transition: transform 0.3s ease;
  }

  #container img:hover {
    transform: scale(1.05);
  }

  /* Responsividade */
  @media (max-width: 992px) {
    #container {
      flex-direction: column;
      text-align: center;
      height: auto;
      padding: 40px 5%;
    }

    #container div {
      max-width: 100%;
    }

    #container h1 {
      font-size: 40px;
      text-align: center;
    }

    #container p {
      font-size: 18px;
    }

    #container img {
      width: 300px;
      margin-top: 30px;
    }
  }

  @media (max-width: 600px) {
    #container h1 {
      font-size: 32px;
    }

    #container p {
      font-size: 16px;
    }

    #container img {
      width: 250px;
    }
  }
</style>
<!-- CSS responsivo termina aqui -->

<div id="container">
  
  <!-- Texto à esquerda -->
  <div style="max-width: 50%;">
    <h1>
        <?= $lng['homeTitulo'] ?? 'Bem-Vindo ao FluxPro!' ?>
    </h1>
    
    <p>
        <?= $lng['homeTexto'] ?? 'Simplifique sua rotina. Com o FluxPro, você gerencia seus serviços, clientes e produtos em um só lugar com agilidade, clareza e eficiência.' ?>
    </p>

    <h4 style="color: #555;">
      <?php
        if (isset($_SESSION['nome'])) {
          echo "Usuário: " . $_SESSION['nome'];
        } 
      ?>
    </h4>
  </div>

  <!-- Imagem à direita -->
  <div>
    <img src="icones/imagemhome.png" alt="Imagem do FluxPro">
  </div>

</div>

<?php
  include_once("rodape.php");
?>
