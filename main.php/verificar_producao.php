<?php
require 'infra/Database.php';

// Instância da classe Database para se conectar ao banco de dados
$db = new Database();
$conn = $db->connect();

// Inputs para a coleta de dados da ordem
$ordemID = intval(readline("Informe o ID da ordem que deseja verificar: "));

// SQL para obter os detalhes da ordem e dos materiais necessários
$sql = "SELECT o.id, o.nome_produto, o.quantidade_produto, o.material_necessario, m.quantidade_material
        FROM ordens o
        INNER JOIN materiais m ON o.material_necessario = m.nome_material
        WHERE o.id = ?";


// Preparar e executar a consulta SQL
$stmt = $conn->prepare($sql);
$stmt->execute([$ordemID]);
$ordemDetalhes = $stmt->fetch(PDO::FETCH_ASSOC);

if ($ordemDetalhes) {
    $nomeProduto = $ordemDetalhes['nome_produto'];
    $nomeMaterial = $ordemDetalhes['material_necessario'];
    $quantidadeProduto = $ordemDetalhes['quantidade_produto'];
    $quantidadeMaterial = $ordemDetalhes['quantidade_material'];

    if ($quantidadeMaterial >= $quantidadeProduto) {
        echo "A produção de $nomeProduto é possível com base nos materiais disponíveis.\n";
    } else {
        echo "A produção de $nomeProduto não é possível devido à falta de materiais ($nomeMaterial: " . ($quantidadeProduto - $quantidadeMaterial) . " unidades faltando).\n";
    }
} else {
    echo "Se a ordem com o ID especificado existe, o material necessário para esse serviço ainda não está cadastrado no sistema.\n";
}

// Fechar a conexão com o banco de dados
$db->close();
?>
