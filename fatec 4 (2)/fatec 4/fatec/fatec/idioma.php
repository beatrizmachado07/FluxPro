<?php
include_once("cabec.php");
?>

<style>
  body {
    background-color: #f0f4f8;
    font-family: Arial, sans-serif;
    text-align: center;
  }

  h2 {
    margin-top: 40px;
    color: #1986a4;
    font-size: 32px;
    font-weight: bold;
  }

  .lang-wrapper {
    display: flex;
    justify-content: center;
    gap: 40px;
    margin-top: 50px;
    flex-wrap: wrap;
  }

  .lang-card {
    background-color: #ffffff;
    border-radius: 15px;
    box-shadow: 0 6px 12px rgba(0,0,0,0.1);
    width: 220px;
    transition: transform .2s;
    padding-bottom: 15px;
    cursor: pointer;
  }

  .lang-card:hover {
    transform: scale(1.05);
  }

  .lang-header {
    border-bottom: 1px solid #ddd;
    padding: 20px 10px;
    font-size: 20px;
    font-weight: bold;
    color: #1986a4;
  }

  .lang-country {
    font-size: 16px;
    font-weight: bold;
    padding-bottom: 10px;
  }

  .lang-card img {
    width: 90px;
    margin: 10px auto;
    display: block;
  }
</style>

<h2><?= $lng['selecioneIdioma'] ?? 'Selecione o Idioma' ?></h2>

<div class="lang-wrapper">
  <div class="lang-card" onclick="window.location.href='idiomaSeleciona.php?idioma=pt'">
    <div class="lang-header"><?= $lng['portugues'] ?? 'Português' ?></div>
    <div class="lang-country">Brasil</div>
    <img src="icones/pt.png" alt="Português">
  </div>

  <div class="lang-card" onclick="window.location.href='idiomaSeleciona.php?idioma=en'">
    <div class="lang-header"><?= $lng['ingles'] ?? 'Inglês' ?></div>
    <div class="lang-country">EUA</div>
    <img src="icones/en.png" alt="Inglês">
  </div>

  <div class="lang-card" onclick="window.location.href='idiomaSeleciona.php?idioma=es'">
    <div class="lang-header"><?= $lng['espanhol'] ?? 'Espanhol' ?></div>
    <div class="lang-country">Espanha</div>
    <img src="icones/es.png" alt="Espanhol">
  </div>

  <div class="lang-card" onclick="window.location.href='idiomaSeleciona.php?idioma=it'">
    <div class="lang-header"><?= $lng['italiano'] ?? 'Italiano' ?></div>
    <div class="lang-country">Itália</div>
    <img src="icones/it_IT.png" alt="Italiano">
  </div>

  <div class="lang-card" onclick="window.location.href='idiomaSeleciona.php?idioma=fr'">
    <div class="lang-header"><?= $lng['frances'] ?? 'Francês' ?></div>
    <div class="lang-country">França</div>
    <img src="icones/fr_FR.png" alt="Francês">
  </div>
</div>

<p>&nbsp;</p>

<?php include_once("rodape.php"); ?>
