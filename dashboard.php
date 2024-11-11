<?php
session_start();

if (!isset($_SESSION['username'])) {
    header("Location: login.php");
    exit();
}

$apiKey = 'HEWnZ6KGy4mth6Yn92CPHNAyipAlLEuo';
$url = "https://api.nytimes.com/svc/topstories/v2/home.json?api-key=$apiKey";

// Fazendo a requisição para a API
$response = file_get_contents($url);
$newsHtml = ""; // Variável para armazenar o HTML da notícia

if ($response !== false) {
    $data = json_decode($response, true);

    if (isset($data['results']) && !empty($data['results'])) {
        $firstNews = $data['results'][0];
        $title = $firstNews['title'];
        $abstract = $firstNews['abstract'];
        $newsUrl = $firstNews['url'];

        // Verifica se há uma imagem disponível
        $imageUrl = "";
        if (isset($firstNews['multimedia']) && !empty($firstNews['multimedia'])) {
            $imageUrl = $firstNews['multimedia'][0]['url']; // Pega a primeira imagem
        }

        // HTML da notícia com a imagem
        $newsHtml = "
            <div class='nyt-news'>
                <h2>Notícia do New York Times</h2>
                <div class='news-content'>
                    <img src='$imageUrl' alt='Imagem da Notícia' class='news-image'>
                    <div class='news-text'>
                        <h3><a href='$newsUrl' target='_blank'>$title</a></h3>
                        <p>$abstract</p>
                    </div>
                </div>
            </div>
        ";
    } else {
        $newsHtml = "<p>Nenhuma notícia disponível.</p>";
    }
} else {
    $newsHtml = "<p>Erro ao obter dados da API.</p>";
}
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard</title>
    <link rel="stylesheet" href="css/styleDashboard.css">
</head>
<body>
    <header>
        <nav>
            <a class="logo" href="">Trabalhos Web</a>
            <ul class="navlist">
                <li><a href="logout.php">Sair</a></li>
            </ul>
            <form class="pesquisa">
                <button class="butDarkmode" type="submit">DARK MODE</button>
            </form>
        </nav>
    </header>

    <h1 id="bemV">Bem-vindo, <?php echo $_SESSION['username']; ?>!</h1>

    <!-- Exibindo a notícia logo abaixo do "Bem-vindo" -->
    <?php echo $newsHtml; ?>
    
    <a href="logout.php">Sair</a>
</body>
</html>
