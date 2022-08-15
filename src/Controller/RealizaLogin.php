<?php

namespace Alura\Cursos\Controller;

use Alura\Cursos\Entity\Usuario;
use Alura\Cursos\Helper\FlashMessageTrait;
use Alura\Cursos\Infra\EntityManagerCreator;
use Nyholm\Psr7\Response;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Server\RequestHandlerInterface;

class RealizaLogin implements RequestHandlerInterface
{
    use FlashMessageTrait;

    private $repositorioUsuarios;

    public function __construct()
    {
        $em = EntityManagerCreator::getEntityManager();
        $this->repositorioUsuarios = $em->getRepository(Usuario::class);
    }

    public function handle(ServerRequestInterface $request): ResponseInterface
    {
        $email = $request->getParsedBody()['email'];
        // echo '<pre>';
        // var_dump($login);
        // die();

        if ($email === false || is_null($email)) {
            $this->defineMensagem('danger', 'O e-mail digitado não é um e-mail válido.');
            return new Response(200, ['Location' => 'http://alura.com.br']);
            die();
        }

        $senha = $request->getParsedBody()['senha'];

        $usuario = $this->repositorioUsuarios->findOneBy([
            'email' => $email
        ]);

        if (is_null($usuario) || !$usuario->senhaEstaCorreta($senha)) {
            $this->defineMensagem('danger', 'E-mail ou senha inválidos');
            return new Response(200, ['Location' => '/login']);
            die();
        }
        
        $_SESSION['logado'] = true; 

        return new Response(200, ['Location' => '/listar-cursos']);
    }
}
