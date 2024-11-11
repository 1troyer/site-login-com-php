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
        $imageUrl = isset($firstNews['multimedia'][0]['url']) ? $firstNews['multimedia'][0]['url'] : "";

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

// Variável que armazena o estado pesquisado
$estadoPesquisado = isset($_POST['inputPesquisa']) ? $_POST['inputPesquisa'] : '';

$estados = [
    ["Acre", "894,470"],
    ["Alagoas", "3,351,543"],
    ["Amapá", "861,773"],
    ["Amazonas", "4,144,597"],
    ["Bahia", "14,930,634"],
    ["Ceará", "9,240,580"],
    ["Distrito Federal", "3,055,149"],
    ["Espírito Santo", "4,064,052"],
    ["Goiás", "7,113,540"],
    ["Maranhão", "7,153,262"],
    ["Mato Grosso", "3,526,220"],
    ["Mato Grosso do Sul", "2,809,394"],
    ["Minas Gerais", "21,411,923"],
    ["Pará", "8,690,745"],
    ["Paraíba", "4,059,905"],
    ["Paraná", "11,516,840"],
    ["Pernambuco", "9,616,621"],
    ["Piauí", "3,289,290"],
    ["Rio de Janeiro", "17,366,189"],
    ["Rio Grande do Norte", "3,534,165"],
    ["Rio Grande do Sul", "11,422,973"],
    ["Rondônia", "1,815,278"],
    ["Roraima", "652,713"],
    ["Santa Catarina", "7,338,473"],
    ["São Paulo", "46,289,333"],
    ["Sergipe", "2,338,474"],
    ["Tocantins", "1,590,248"]
];

?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard</title>
    <link rel="stylesheet" href="css/styleDashboard.css">
</head>
<style>
    .state-table {
    justify-content: center;
    margin-top: 20px;
}
.state-table h2{
    text-align: center;
}
table {
    border-collapse: collapse;
    width: 60%;
    margin: 0 auto;
    text-align: left;
}
th, td {
    border: 1.5px solid black;
    padding: 8px;
}
td {
    background-color: rgb(81, 47, 2);
    color: white;
}
th {
    background-color: #ffffff;
    font-weight: bold;
}

#inputPesquisa{
width: 200px;
height:30px;
border:none;
border-radius:4px;
}

.butProcurar {
    width: 150px;
    height: 30px;
    color: black;
    border:none;
    background-color: white;
    border-radius: 12px;
    cursor: pointer;
}
</style>
<body>
    <header>
        <nav>
            <a class="logo" href="">Trabalhos Web</a>
            <ul class="navlist">
                <li><a href="logout.php">Sair</a></li>
            </ul>
            <form class="pesquisa" method="POST" action="">
                <input type="search" id="inputPesquisa" name="inputPesquisa" value="<?php echo htmlspecialchars($estadoPesquisado); ?>" placeholder="Procurar Estado">
                <button class="butProcurar" type="submit">Procurar</button>
            </form>
        </nav>
    </header>

    <h1 id="bemV">Bem-vindo, <?php echo $_SESSION['username']; ?>!</h1>

    <!-- Exibindo a notícia logo abaixo do "Bem-vindo" -->
    <?php echo $newsHtml; ?>

    <!-- Tabela com os estados do Brasil e suas populações -->
    <div class="state-table">
        <h2>População dos Estados do Brasil</h2>
        <table id="estadoTabela">
            <thead>
                <tr>
                    <th>Estado</th>
                    <th>População</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($estados as $estado): ?>
                    <tr id="<?php echo strtolower($estado[0]); ?>">
                        <td><?php echo $estado[0]; ?></td>
                        <td><?php echo $estado[1]; ?></td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>

    <a href="logout.php">Sair</a>

    <script>
        document.addEventListener("DOMContentLoaded", function() {
            const estadoPesquisado = "<?php echo addslashes(strtolower($estadoPesquisado)); ?>";
            if (estadoPesquisado) {
                const row = document.getElementById(estadoPesquisado);
                if (row) {
                    row.scrollIntoView({ behavior: "smooth", block: "center" });
                    row.style.backgroundColor = "#ffff99";
                }
            }
        });
    </script>
</body>
</html>