<?php

namespace Alura\Cursos\Controller;

use Alura\Cursos\Entity\Usuario;
use Alura\Cursos\Helper\FlashMessageTrait;
use Alura\Cursos\Infra\EntityManagerCreator;

class RealizaLogin implements InterfaceControladorRequisicao
{
    use FlashMessageTrait;

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
            $this->defineMensagem('danger', 'O e-mail digitado não é um e-mail válido.');
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
            $this->defineMensagem('danger', 'E-mail ou senha inválidos');
            header('Location: /login');
            die();
        }
        
        $_SESSION['logado'] = true; 

        header('Location: /listar-cursos');
    }
}
