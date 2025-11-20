<?php
    if ($path === '/donations') {
        $donModel = new Donation();
        $donations = $donModel->getAll();
        require __DIR__ . '/../app/Views/donations/index.php';
        exit;
    }

    if ($path === '/donations/create') {

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            
            // Se marcado como anônimo, não vincula user_id.
            $usuario_id = (!empty($_POST['anonimo']) || empty($_SESSION['user_id']))
                            ? null
                            : $_SESSION['user_id'];

            $donModel = new Donation();

            $donModel->create([
                'usuario_id'        => $usuario_id,
                'beneficiario_nome' => $_POST['beneficiario_nome'] ?? null,
                'beneficiario_cpf'  => $_POST['beneficiario_cpf'] ?? null,
                'titulo'            => $_POST['titulo'],
                'descricao'         => $_POST['descricao'] ?? null,
                'categoria'         => $_POST['categoria'] ?? null,
                'quantidade'        => $_POST['quantidade'] ?? null,
                'valor'             => $_POST['valor'] ?? null,
                'cidade'            => $_POST['cidade'] ?? null,
                'bairro'            => $_POST['bairro'] ?? null,
                'endereco'          => $_POST['endereco'] ?? null,
                'cep'               => $_POST['cep'] ?? null,
                'status'            => 'pendente',
                'data_doacao'       => date('Y-m-d')
            ]);

            $_SESSION['success'] = "Doação cadastrada com sucesso!";
            header("Location: /donations");
            exit;
        }

        require __DIR__ . '/../app/Views/donations/create.php';
        exit;
    }
