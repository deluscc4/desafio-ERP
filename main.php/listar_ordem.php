<?php
require 'infra/Database.php';

// Instancia a classe Database para se conectar ao banco de dados
$db = new Database();
$conn = $db->connect();

// SQL para listar todas as ordens da tabela "ordens"
$sql = "SELECT * FROM ordens";

// Preparar e executar a consulta SQL
$stmt = $conn->query($sql);
$ordens = $stmt->fetchAll(PDO::FETCH_ASSOC);

// Exibir as ordens percorrendo um array de ordens e mostrando uma a uma
if (count($ordens) > 0) {
    echo "Lista de Ordens:\n--------------------------------------\n";
    foreach ($ordens as $ordem) {
        echo "ID: " . $ordem['id'] . "\n";
        echo "Nome do produto a ser fabricado: " . $ordem['nome_produto'] . "\n";
        echo "Quantidade do produto a ser fabricado: " . $ordem['quantidade_produto'] . "\n";
        echo "Data de entrega: " . $ordem['data_entrega'] . "\n";
        echo "Status da ordem (1 = em progesso, 0 = concluído): " . $ordem['status_ordem'] . "\n";
        echo "\n";
    }
} else {
    echo "Nenhuma ordem encontrada.\n";
}

// Fechar a conexão com o banco de dados
$db->close();
