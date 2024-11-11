<?php
if (isset($_POST['submit'])) {
    include_once('conexaoBD.php');

    $username = $_POST['username'];
    $senha = $_POST['senha'];

    // Insere o novo usuário no banco de dados
    $stmt = $mysqli->prepare("INSERT INTO user (username, senha) VALUES (?, ?)");
    $stmt->bind_param("ss", $username, $senha);

    if ($stmt->execute()) {
        echo "Usuário registrado com sucesso!";
    } else {
        echo "Erro ao registrar usuário: " . $mysqli->error;
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
    <title>Registro</title>
    <link rel="stylesheet" href="css/style.css">
    <style>
        #caixa_registro{
    background-color: #110909;
    color: white;
    position: absolute;
    text-align: center;
    top:30%;
    left: 36%;
    translate: (-50%, 50%);
    padding:60px 80px ;
    border-radius:10px ;
}
#caixa_registro input{
    padding: 10px 27px;
    text-align: center;
    border-radius: 5px  ;
}
#caixa_registro button{
    width: 150px;
    height: 30px;
    border-radius: 5px;background-color: ;
}
#caixa_registro button:hover{
    background-color: rgb(64, 29, 1);
    color: white;
    transition: 0.5s;
}
    </style>
</head>
<body>
    <div id="caixa_registro">
        <h3 style="font-size: 28px;">Registro</h3>
        <br><br>
        <form action="register.php" method="POST">
            <input type="text" name="username" id="username" placeholder="Username" required>
            <br><br>
            <input type="password" name="senha" id="senha" placeholder="Senha" required>
            <br><br>
            <button type="submit" name="submit" id="submit">Registrar</button>
        </form>
        <br><br>
        <a>já possui conta?</a>
        <a href="login.php">Connecte-se</a>
    </div>
</body>
</html>