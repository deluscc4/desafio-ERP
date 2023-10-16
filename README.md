# Desafio ERP
Desafio Técnico - Sistema de Gerenciamento de Ordens de Produção para uma Fábrica

# Configurando o sistema
A partir do shell (linha de comando) do XAMPP, utilizando MySQL:

1. Entre no seu usuário
`mysql -u root`

3. Crie o banco de dados:
`CREATE DATABASE ordens_producao;`

4. Use o banco de dados recém-criado para criar as tabelas:
`USE ordens_producao;`

5. Cries seguinte tabela para registrar as ordens de serviço:
`CREATE TABLE ordens(
    ID INT AUTO_INCREMENT PRIMARY KEY,
    nome_produto VARCHAR(255) NOT NULL,
    quantidade_produto INT NOT NULL,
    data_entrega DATETIME NOT NULL,
    material_necessario VARCHAR(30),
    status_ordem TINYINT NOT NULL DEFAULT 1
);`

6. Crie a seguinte tabela para registrar os materiais para as ordens de serviço:
`CREATE TABLE materiais (
    ID INT AUTO_INCREMENT PRIMARY KEY,
    nome_material VARCHAR(255) NOT NULL,
    quantidade_material INT NOT NULL
);`

# Executando o sistema
O sistema conta com 6 funcionalidades, todas elas são executadas passando o seguinte comando no terminal -> `php .\main.php\[nome_arquivo_funcionalidade].php`. Exemplo: `php .\main.php\registrar_material.php`

## 1. Registrar material:
   Essa funcionalidade permite você registrar o material que será utilizado para a produção de produtos nas ordens de serviço. Será solicitado o nome e a quantidade do material que você deseja registrar no sistema. Caso o nome do material já esteja registrado, o valor colocado será incrementado no sistema.
   
   ![image](https://github.com/deluscc4/desafio-ERP/assets/122245816/6acfb99d-c978-4ec7-a842-b0d40091de1f)

## 2. Registrar ordem de serviço:
   Essa funcionalidade permite você criar uma ordem de serviço. Será solicitado o nome, quantidade, data de entrega (há validação se a data é futura) e o material necessário para a fabricação do produto.

   ![image](https://github.com/deluscc4/desafio-ERP/assets/122245816/967453d4-c77f-4c2f-89a6-51481c6f32f3)

## 3. Verificar a produção:
   Essa funcionalidade permite a verificação se a ordem de serviço poderá ser concluída dependendo da quantidade de material disponível. Será solicitado o ID da ordem de serviço a validar.

   ![image](https://github.com/deluscc4/desafio-ERP/assets/122245816/e2029281-4290-4e74-b18d-69949bc564c8)

## 4. Listar ordens de serviço:
   Essa funcionalidade traz um relatório detalhado de todas as ordens de serviço registradas no sistema.

   ![image](https://github.com/deluscc4/desafio-ERP/assets/122245816/d25415a4-b1b2-485a-b31f-728cd55417f5)

## 5. Listar odens de serviço por status:
   Essa funcionalidade traz um relatório detalhado de todas as ordens de serviço a partir do status especificado (em progresso ou concluída).

![image](https://github.com/deluscc4/desafio-ERP/assets/122245816/1c71b672-3936-4011-aac9-edd64d54eef7)

## 6. Atualizar o status das ordens de serviço:
   Essa funcionalidade atualiza o status da ordem de serviço, reduzindo do sistema a quantidade de materiais usados para concluir a ordem de serviço especificada.

   ![image](https://github.com/deluscc4/desafio-ERP/assets/122245816/1669c426-e168-4f53-b130-3042e94a6756)




