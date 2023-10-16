<?php
require 'infra/Database.php';

// Instância da classe Database para se conectar ao banco de dados
$db = new Database();
$conn = $db->connect();

// Inputs para a coleta de dados da atualização de status
$ordemID = intval(readline("ID da ordem a ser atualizada: "));
$novoStatus = intval(readline("Novo status (1 para 'em progresso', 0 para 'concluída'): "));

if ($novoStatus === 0) {
    // Verificar o status atual da ordem
    $sqlVerificarStatus = "SELECT status_ordem, material_necessario, quantidade_produto FROM ordens WHERE id = ?";
    $stmtVerificarStatus = $conn->prepare($sqlVerificarStatus);
    $stmtVerificarStatus->execute([$ordemID]);
    $ordemStatusDetalhes = $stmtVerificarStatus->fetch(PDO::FETCH_ASSOC);

    if (!$ordemStatusDetalhes) {
        echo "Nenhuma ordem encontrada com o ID especificado.\n";
    } elseif ($ordemStatusDetalhes['status_ordem'] === 0) {
        echo "Esta ordem já está concluída e não pode ser atualizada.\n";
    } else {
        // Verificar se há material suficiente
        $materialNecessario = $ordemStatusDetalhes['material_necessario'];
        $quantidadeProduto = $ordemStatusDetalhes['quantidade_produto'];

        // Verificar a quantidade de material disponível
        $sqlVerificarMaterial = "SELECT quantidade_material FROM materiais WHERE nome_material = ?";
        $stmtVerificarMaterial = $conn->prepare($sqlVerificarMaterial);
        $stmtVerificarMaterial->execute([$materialNecessario]);
        $quantidadeMaterialDisponivel = $stmtVerificarMaterial->fetchColumn();

        if ($quantidadeMaterialDisponivel >= $quantidadeProduto) {
            // Reduzir a quantidade de material na tabela materiais
            $sqlAtualizarMateriais = "UPDATE materiais SET quantidade_material = quantidade_material - ? WHERE nome_material = ?";
            $stmtAtualizarMateriais = $conn->prepare($sqlAtualizarMateriais);
            $stmtAtualizarMateriais->execute([$quantidadeProduto, $materialNecessario]);

            // Atualizar o status da ordem
            $sqlAtualizarStatus = "UPDATE ordens SET status_ordem = ? WHERE id = ?";
            $stmtAtualizarStatus = $conn->prepare($sqlAtualizarStatus);
            $stmtAtualizarStatus->execute([$novoStatus, $ordemID]);

            echo "Status da ordem atualizado com sucesso e a quantidade de materiais foi atualizada no sistema.\n";
        } else {
            echo "A produção da ordem não é possível devido à falta de materiais ($materialNecessario: " . ($quantidadeProduto - $quantidadeMaterialDisponivel) . " unidades faltando).\n";
        }
    }
} else {
    echo "O status da ordem não foi atualizado, pois ainda não há materiais disponíveis.\n";
}

// Fechar a conexão com o banco de dados
$db->close();
?>
