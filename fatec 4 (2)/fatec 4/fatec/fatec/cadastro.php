<?php
include_once("cabec.php");
include_once("config.php"); 

ini_set('display_errors', 1);
error_reporting(E_ALL);

$mensagem_sucesso = "";
$mensagem_erro = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nome        = $_POST['nome'] ?? '';
    $cpf         = $_POST['cpf'] ?? '';
    $telefone    = $_POST['telefone'] ?? '';
    $cep         = $_POST['cep'] ?? '';
    $rua         = $_POST['rua'] ?? '';
    $numero      = $_POST['numero'] ?? '';
    $complemento = $_POST['complemento'] ?? '';
    $bloco       = $_POST['bloco'] ?? '';
    $bairro      = $_POST['bairro'] ?? '';
    $cidade      = $_POST['cidade'] ?? '';
    $uf          = $_POST['uf'] ?? '';
    $senha_bruta = $_POST['senha'] ?? '';
    $confirmar   = $_POST['confirmar_senha'] ?? '';

    if (empty($nome) || empty($cpf) || empty($telefone) || empty($senha_bruta)) {
        $mensagem_erro = $lng['erroCamposObrigatorios'] ?? "Por favor, preencha todos os campos obrigatórios.";
    } elseif ($senha_bruta !== $confirmar) {
        $mensagem_erro = $lng['erroSenhasDiferentes'] ?? "As senhas não coincidem!";
    } else {
        $conexao = db_connect(); 
        if (!$conexao) {
            $mensagem_erro = $lng['erroConexao'] ?? "Erro: Falha na conexão com o banco de dados.";
        } else {
            $senha_hash = password_hash($senha_bruta, PASSWORD_DEFAULT);

            $sql = "INSERT INTO usuario 
                    (usuNome, usuCPF, usuTelefone, usuCEP, usuRua, usuNumero, usuTipoResidencia, usuBloco, usuBairro, usuCidade, usuEstado, usuSenha)
                    VALUES (:nome, :cpf, :telefone, :cep, :rua, :numero, :tipo_residencia, :bloco, :bairro, :cidade, :uf, :senha_hash)";

            $comando = $conexao->prepare($sql);

            $comando->bindParam(':nome', $nome);
            $comando->bindParam(':cpf', $cpf);
            $comando->bindParam(':telefone', $telefone);
            $comando->bindParam(':cep', $cep);
            $comando->bindParam(':rua', $rua);
            $comando->bindParam(':numero', $numero);
            $comando->bindParam(':tipo_residencia', $complemento);
            $comando->bindParam(':bloco', $bloco);
            $comando->bindParam(':bairro', $bairro);
            $comando->bindParam(':cidade', $cidade);
            $comando->bindParam(':uf', $uf);
            $comando->bindParam(':senha_hash', $senha_hash); 

            try {
                $comando->execute();
                $mensagem_sucesso = $lng['sucessoCadastro'] ?? "Usuário cadastrado com sucesso!";
                $nome = $cpf = $telefone = $cep = $rua = $numero = $complemento = $bloco = $bairro = $cidade = $uf = $senha_bruta = $confirmar = ""; 
            } catch (PDOException $e) {
                if ($e->getCode() == 23000) { 
                    $mensagem_erro = $lng['erroCPFExistente'] ?? "Erro: CPF já cadastrado.";
                } else {
                    $mensagem_erro = ($lng['erroCadastro'] ?? "Erro ao cadastrar usuário: ") . $e->getMessage();
                }
            }
        }
    }
}
?>

<style>
  body {
    background-color: #f2f2f2;
  }

  .container-form {
    max-width: 600px;
    margin: 50px auto;
    background-color: white;
    padding: 30px;
    border-radius: 12px;
    box-shadow: 0 4px 20px rgba(0,0,0,0.1);
  }

  .container-form h2 {
    color: #1986a4;
    margin-bottom: 30px;
    text-align: center;
  }

  .form-group {
    margin-bottom: 20px;
  }

  .form-group label {
    font-weight: bold;
  }

  .form-group input {
    width: 100%;
    padding: 10px;
    border-radius: 6px;
    border: 1px solid #ccc;
  }

  .btn-custom {
    width: 100%;
    padding: 10px;
    background-color: #1986a4;
    color: white;
    font-weight: bold;
    border: none;
    border-radius: 8px;
    transition: 0.3s;
  }

  .btn-custom:hover {
    background-color: #145f77;
  }

  .message-success {
    color: green;
    text-align: center;
    margin-bottom: 15px;
    font-weight: bold;
  }

  .message-error {
    color: red;
    text-align: center;
    margin-bottom: 15px;
    font-weight: bold;
  }

  .senha-container {
    position: relative;
  }

  .senha-container input {
    width: 100%;
    padding-right: 40px;
  }

  .toggle-senha {
    position: absolute;
    right: 10px;
    top: 65%;
    transform: translateY(-50%);
    width: 22px;
    height: 22px;
    cursor: pointer;
    opacity: 0.8;
  }
</style>

<div class="container-form">
  <h2><?= $lng['cadastroUsuario'] ?? 'Cadastro de Usuário' ?></h2>

  <?php if (!empty($mensagem_sucesso)): ?>
      <p class="message-success"><?= $mensagem_sucesso ?></p>
  <?php endif; ?>
  <?php if (!empty($mensagem_erro)): ?>
      <p class="message-error"><?= $mensagem_erro ?></p>
  <?php endif; ?>

  <form method="POST" action="">
    <div class="form-group">
      <label><?= $lng['nome'] ?? 'Nome' ?>:</label>
      <input type="text" name="nome" value="<?= htmlspecialchars($nome ?? '') ?>" required>
    </div>
    <div class="form-group">
      <label><?= $lng['cpf'] ?? 'CPF' ?>:</label>
      <input type="text" name="cpf" id="cpf" value="<?= htmlspecialchars($cpf ?? '') ?>" required maxlength="14">
    </div>
    <div class="form-group">
      <label><?= $lng['telefone'] ?? 'Telefone' ?>:</label>
      <input type="text" name="telefone" value="<?= htmlspecialchars($telefone ?? '') ?>" required>
    </div>

    <div class="form-group">
      <label><?= $lng['cep'] ?? 'CEP' ?>:</label>
      <input type="text" name="cep" id="cep" value="<?= htmlspecialchars($cep ?? '') ?>" required>
    </div>
    <div class="form-group">
      <label><?= $lng['rua'] ?? 'Rua' ?>:</label>
      <input type="text" name="rua" id="rua" value="<?= htmlspecialchars($rua ?? '') ?>" readonly>
    </div>
    <div class="form-group">
      <label><?= $lng['numero'] ?? 'Número' ?>:</label>
      <input type="text" name="numero" id="numero" value="<?= htmlspecialchars($numero ?? '') ?>" required>
    </div>
    <div class="form-group">
      <label><?= $lng['complemento'] ?? 'Complemento' ?>:</label>
      <input type="text" name="complemento" id="complemento" value="<?= htmlspecialchars($complemento ?? '') ?>" placeholder="<?= $lng['exComplemento'] ?? 'Casa, Apto, Condomínio...' ?>">
    </div>
    <div class="form-group">
      <label><?= $lng['bloco'] ?? 'Bloco' ?>:</label>
      <input type="text" name="bloco" id="bloco" value="<?= htmlspecialchars($bloco ?? '') ?>" placeholder="<?= $lng['opcional'] ?? 'Opcional' ?>">
    </div>
    <div class="form-group">
      <label><?= $lng['bairro'] ?? 'Bairro' ?>:</label>
      <input type="text" name="bairro" id="bairro" value="<?= htmlspecialchars($bairro ?? '') ?>" readonly>
    </div>
    <div class="form-group">
      <label><?= $lng['cidade'] ?? 'Cidade' ?>:</label>
      <input type="text" name="cidade" id="cidade" value="<?= htmlspecialchars($cidade ?? '') ?>" readonly>
    </div>
    <div class="form-group">
      <label><?= $lng['estado'] ?? 'Estado' ?>:</label>
      <input type="text" name="uf" id="uf" value="<?= htmlspecialchars($uf ?? '') ?>" readonly>
    </div>

    <div class="form-group senha-container">
      <label><?= $lng['senha'] ?? 'Senha' ?>:</label>
      <input type="password" name="senha" id="senha" required>
      <img src="icones/olho_oculto.png" class="toggle-senha" id="toggleSenha" alt="Mostrar/Ocultar">
    </div>

    <div class="form-group senha-container">
      <label><?= $lng['confirmarSenha'] ?? 'Confirmar Senha' ?>:</label>
      <input type="password" name="confirmar_senha" id="confirmar_senha" required>
      <img src="icones/olho_oculto.png" class="toggle-senha" id="toggleConfirmarSenha" alt="Mostrar/Ocultar">
    </div>

    <button type="submit" class="btn-custom"><?= $lng['cadastrar'] ?? 'Cadastrar' ?></button>
  </form>
</div>

<script>
  function togglePassword(inputId, iconId) {
    const input = document.getElementById(inputId);
    const icon = document.getElementById(iconId);
    if (input.type === "password") {
      input.type = "text";
      icon.src = "icones/olho.png";
    } else {
      input.type = "password";
      icon.src = "icones/olho_oculto.png";
    }
  }

  document.getElementById("toggleSenha").addEventListener("click", () => togglePassword("senha", "toggleSenha"));
  document.getElementById("toggleConfirmarSenha").addEventListener("click", () => togglePassword("confirmar_senha", "toggleConfirmarSenha"));

  document.getElementById('cpf').addEventListener('input', function (e) {
      let value = e.target.value.replace(/\D/g, '');
      if (value.length > 11) value = value.slice(0, 11);
      value = value.replace(/(\d{3})(\d)/, '$1.$2');
      value = value.replace(/(\d{3})(\d)/, '$1.$2');
      value = value.replace(/(\d{3})(\d{1,2})$/, '$1-$2');
      e.target.value = value;
  });

  document.getElementById("cep").addEventListener("blur", function() {
    let cep = this.value.replace(/\D/g, '');
    if (cep.length === 8) {
      fetch(`https://viacep.com.br/ws/${cep}/json/`)
        .then(response => response.json())
        .then(data => {
          if (!("erro" in data)) {
            document.getElementById("rua").value = data.logradouro;
            document.getElementById("bairro").value = data.bairro;
            document.getElementById("cidade").value = data.localidade;
            document.getElementById("uf").value = data.uf;
          } else {
            alert("CEP não encontrado.");
          }
        })
        .catch(err => console.error("Erro ao buscar CEP:", err));
    }
  });
</script>

<?php include_once("rodape.php"); ?>
