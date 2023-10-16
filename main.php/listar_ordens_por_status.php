<?php
require 'infra/Database.php';

// Instancie a classe Database para se conectar ao banco de dados
$db = new Database();
$conn = $db->connect();

// Solicitar a escolha do usuário
echo "Escolha o status das ordens a serem listadas:\n";
echo "1 - Em progresso\n";
echo "0 - Concluídas\n";
$statusEscolhido = readline("Informe o status desejado (1 ou 0): ");

// Validar a escolha do usuário se colocar algum numero que não seja nenhum dos status disponíveis
if ($statusEscolhido !== '1' && $statusEscolhido !== '0') {
    echo "Escolha inválida. Por favor, escolha 1 para em progresso ou 0 para concluídas.\n";
    exit;
}

// SQL para listar as ordens com base no status escolhido
$sql = "SELECT * FROM ordens WHERE status_ordem = ?";

// Preparar e executar a consulta SQL
$stmt = $conn->prepare($sql);
$stmt->execute([$statusEscolhido]);
$ordens = $stmt->fetchAll(PDO::FETCH_ASSOC);

// Exibir as ordens se tiver alguma registrada, percorrendo um array
if (count($ordens) > 0) {
    $statusLabel = ($statusEscolhido === '1') ? 'em progresso' : 'concluídas';
    echo "\n\nLista das ordens $statusLabel:\n--------------------------------------\n";
    foreach ($ordens as $ordem) {
        echo "ID: " . $ordem['id'] . "\n";
        echo "Nome do produto a ser fabricado: " . $ordem['nome_produto'] . "\n";
        echo "Quantidade do produto a ser fabricado: " . $ordem['quantidade_produto'] . "\n";
        echo "Data de entrega: " . $ordem['data_entrega'] . "\n";
        echo "Status da ordem (1 = em progresso, 0 = concluído): " . $ordem['status_ordem'] . "\n";
        echo "\n";
    }
} else {
    echo "Nenhuma ordem encontrada com o status escolhido.\n";
}

// Fechar a conexão com o banco de dados
$db->close();
