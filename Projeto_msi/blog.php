<?php
session_start();
include('db.php');

// Inserir comentário e avaliação
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['comment'])) {
    $postagem_id = $_POST['postagem_id'];
    $usuario_id = $_SESSION['usuario_id']; 
    $comentario = $_POST['comentario'];
    $avaliacao = $_POST['avaliacao']; // Adicionando a avaliação de estrelas

    $stmt = $conn->prepare("INSERT INTO comentarios (postagem_id, usuario_id, comentario, avaliacao) VALUES (?, ?, ?, ?)");
    $stmt->bind_param("iisi", $postagem_id, $usuario_id, $comentario, $avaliacao);
    $stmt->execute();
    $stmt->close();
}

// Selecionar postagens
$stmt = $conn->prepare("SELECT * FROM postagens ORDER BY data DESC");
$stmt->execute();
$result = $stmt->get_result();

$postagens = [];
while ($row = $result->fetch_assoc()) {
    $postagens[] = $row;
}
$stmt->close();
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Blog</title>
    <link rel="stylesheet" href="main.css">
</head>
<body>

<div class="navbar">
    <a href="index.php">Painel Principal</a>
    <a href="quem-somos.php">Quem Somos</a>
    <a href="blog.php">Blog</a>
    <a href="logout.php">Sair</a>
</div>

<div class="content">
    <h2>Blog</h2>

    <?php foreach ($postagens as $postagem) : ?>
        <div class="postagem">
            <h3><?php echo htmlspecialchars($postagem['titulo']); ?></h3>
            <p><?php echo nl2br(htmlspecialchars($postagem['conteudo'])); ?></p>
            <p><em><?php echo htmlspecialchars($postagem['data']); ?></em></p>

            <h4>Comentários e Avaliações:</h4>
            <div class="comentarios">
                <?php
                // Selecionar comentários e avaliações
                $stmt = $conn->prepare("SELECT * FROM comentarios WHERE postagem_id = ? ORDER BY data DESC");
                $stmt->bind_param("i", $postagem['id']);
                $stmt->execute();
                $comments = $stmt->get_result();

                while ($comment = $comments->fetch_assoc()) {
                    echo "<p>" . htmlspecialchars($comment['comentario']) . " <em> - " . htmlspecialchars($comment['data']) . "</em></p>";
                    echo "<p>Avaliação: " . htmlspecialchars($comment['avaliacao']) . " estrelas</p>"; // Exibe a avaliação
                }
                $stmt->close();
                ?>
            </div>

            <?php if (isset($_SESSION['usuario'])) : ?>
                <form method="POST">
                    <input type="hidden" name="postagem_id" value="<?php echo $postagem['id']; ?>">
                    <label for="comentario">Deixe seu comentário:</label>
                    <textarea name="comentario" required></textarea>

                    <!-- Seleção de Avaliação -->
                    <label for="avaliacao">Sua Avaliação:</label>
                    <select name="avaliacao" required>
                        <option value="1">1 Estrela</option>
                        <option value="2">2 Estrelas</option>
                        <option value="3">3 Estrelas</option>
                        <option value="4">4 Estrelas</option>
                        <option value="5">5 Estrelas</option>
                    </select>

                    <input type="submit" name="comment" value="Comentar">
                </form>
            <?php else : ?>
                <p>Faça login para comentar.</p>
            <?php endif; ?>
        </div>
    <?php endforeach; ?>
</div>

</body>
</html>
