<?php
require 'infra/Database.php';

// Instância da classe Database para se conectar ao banco de dados
$db = new Database();
$conn = $db->connect();

// Inputs para a coleta de dados da ordem a ser registrada
$nomeProduto = readline("Produto a ser fabricado: ");
$quantidadeProduto = intval(readline("Quantidade a ser fabricada do produto: "));

// Solicitar a data de entrega até que uma data futura a atual seja fornecida
while (true) {
    $dataEntrega = readline("Data de entrega (AAAA-MM-DD HH:MM:SS): ");
    $dataAtual = date('Y-m-d H:i:s');
    
    if ($dataEntrega > $dataAtual) {
        break;
    } else {
        echo "A data de entrega deve ser no futuro. Tente novamente.\n";
    }
}

$materialNecessario = readline("Material necessário para fabricar: ");

// SQL para inserir uma nova ordem na tabela "ordens"
$sql = "INSERT INTO ordens (nome_produto, quantidade_produto, data_entrega, material_necessario) 
        VALUES (?, ?, ?, ?)";

// Preparar e executar a declaração SQL
$stmt = $conn->prepare($sql);
$stmt->execute([$nomeProduto, $quantidadeProduto, $dataEntrega, $materialNecessario]);

echo "Ordem registrada com sucesso!\n";

// Fechar a conexão com o banco de dados
$db->close();

