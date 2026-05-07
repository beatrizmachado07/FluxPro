<?php
    include_once("cabec.php");
?>

<div id="container" class="row justify-content-center">
    <h2>Dados da Pessoa</h2>
    <form action="pessoaGrava.php">
        <div class="form-group">
            <label for="nome">Nome: </label>
            <input type="text" name="nome">

            <label for="tipo">Tipo:</label>
            <input type="text" id="tipo" name="tipo" list="optipo">
            <datalist id="optipo">
                <option value="F">Física</option>
                <option value="J">Jurídica</option>
            </datalist>
        </div>

        <div class="form-group">
            <input type="submit" class="btn btn-dark" value="Gravar">
        </div>
    </form>
</div>

<?php
    include_once("rodape.php");
?>