<?php

namespace Alura\Cursos\Controller;

use Alura\Cursos\Entity\Usuario;
use Alura\Cursos\Infra\EntityManagerCreator;

class RealizaLogin extends ControllerComHtml implements InterfaceControladorRequisicao
{
    private $repositorioUsuarios;

    public function __construct()
    {
        $em = EntityManagerCreator::getEntityManager();
        $this->repositorioUsuarios = $em->getRepository(Usuario::class);
    }

    public function processaRequisicao(): void
    {
        $email = filter_input(
            INPUT_POST,
            'email',
            FILTER_VALIDATE_EMAIL
        );

        if ($email === false || is_null($email)) {
            $_SESSION['tipo_mensagem'] = 'danger';
            $_SESSION['mensagem'] = 'O e-mail digitado não é um e-mail válido.';
            header('Location: /login');
            return;
        }

        $senha = filter_input(INPUT_POST,
                'senha',
                FILTER_SANITIZE_STRING
        );

        $usuario = $this->repositorioUsuarios->findOneBy([
            'email' => $email
        ]);

        if (is_null($usuario) || !$usuario->senhaEstaCorreta($senha)) {
            $_SESSION['tipo_mensagem'] = 'danger';
            $_SESSION['mensagem'] = 'E-mail ou senha inválidos';
            header('Location: /login');
            die();
        }
        
        $_SESSION['logado'] = true; 

        header('Location: /listar-cursos');
    }
}
