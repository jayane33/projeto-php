
<?php  

?>

<!DOCTYPE html>
<html lang="pt-br">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Login</title>
    <link rel="stylesheet" href="css/cadastro.css" />
  </head>
  <body>
    <img src="img/logo.png" alt="Logo" />
    <div class="caixabranca">
      <form action="php/login.php" method="POST">
        <label for="email">E-mail:</label>
        <input
          type="email"
          id="email"
          name="email"
          placeholder="Digite seu e-mail:"
          required
        />

        <label for="senha">Senha:</label>
        <input
          type="password"
          id="senha"
          name="senha"
          placeholder="Digite sua senha:"
          required
        />

        <button type="submit">Entrar</button>
      </form>
    </div>
  </body>
</html>
