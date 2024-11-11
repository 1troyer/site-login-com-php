<?php
session_start();

if (isset($_POST['submit'])) {
    include_once('conexaoBD.php');

    $username = $_POST['username'];
    $senha = $_POST['senha'];

    // Consulta para verificar se o usuário e a senha estão no banco de dados
    $stmt = $mysqli->prepare("SELECT * FROM user WHERE username = ? AND senha = ?");
    $stmt->bind_param("ss", $username, $senha);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        // Login bem-sucedido
        $_SESSION['username'] = $username;
        
        // Redireciona para a página restrita (ex: dashboard.php)
        header("Location: dashboard.php");
        exit();
    } else {
        echo "Usuário ou senha incorretos!";
    }

    $stmt->close();
    $mysqli->close();
}
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <link rel="stylesheet" href="css/style.css">
</head>
<body>
    <div id="caixa_login">
        <h3 style="font-size: 28px;">Login</h3>
        <br><br>
        <form action="login.php" method="POST">
            <input type="text" name="username" id="username" placeholder="Username" required>
            <br><br>
            <input type="password" name="senha" id="senha" placeholder="Senha" required>
            <br><br>
            <button type="submit" name="submit" id="submit">Entrar</button>
        </form>
        <br><br>
        <a>Não possui conta ainda?</a>
        <a href="register.php">Registre-se</a>
    </div>
</body>
</html>