<?php
require 'infra/Database.php';

// Instância da classe Database para se conectar ao banco de dados
$db = new Database();
$conn = $db->connect();

// Inputs para a coleta de dados do material a ser registrado
$nomeMaterial = readline("Nome do material: ");
$quantidadeMaterial = intval(readline("Quantidade do material: "));

// Verificando se o material já existe no banco de dados
$sql = "SELECT id FROM materiais WHERE nome_material = ?";
$stmt = $conn->prepare($sql);
$stmt->execute([$nomeMaterial]);
$materialExistente = $stmt->fetch(PDO::FETCH_ASSOC);

if ($materialExistente) {
    // Se o material já existe (nome_material for igual a algum existente no banco de dados), o valor colocado será incrementado na quantidade atual
    $idMaterial = $materialExistente['id'];
    $sql = "UPDATE materiais SET quantidade_material = quantidade_material + ? WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->execute([$quantidadeMaterial, $idMaterial]);
    echo "Material registrado e quantidade atualizada com sucesso!\n";
} else {
    // Caso contrário, será registrado
    $sql = "INSERT INTO materiais (nome_material, quantidade_material) VALUES (?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->execute([$nomeMaterial, $quantidadeMaterial]);
    echo "Material registrado com sucesso!\n";
}

// Fechar a conexão com o banco de dados
$db->close();
?>
