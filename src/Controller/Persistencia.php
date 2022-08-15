<?php

namespace Alura\Cursos\Controller;

use Alura\Cursos\Entity\Curso;
use Alura\Cursos\Helper\FlashMessageTrait;
use Alura\Cursos\Infra\EntityManagerCreator;
use Nyholm\Psr7\Response;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Server\RequestHandlerInterface;

class Persistencia implements RequestHandlerInterface
{
    use FlashMessageTrait;

    private $entityManager;

    public function __construct()
    {
        $this->entityManager = EntityManagerCreator::getEntityManager();
    }

    public function handle(ServerRequestInterface $request): ResponseInterface
    {       
        $curso = new Curso();
        $curso->setDescricao($_POST['descricao']);
        $id = $request->getQueryParams()['id'];

        $tipo = 'success';
        if (!is_null($id) && $id !== false) {
            $curso->setId($id);
            $this->entityManager->merge($curso);
            $this->defineMensagem($tipo, 'Curso atualizado com sucesso.');
        } else {
            $this->entityManager->persist($curso);
            $this->defineMensagem($tipo, 'Curso adicionado com sucesso.');
        }
        
        $this->entityManager->flush();
        
        return new Response(200, ['Location' => '/listar-cursos']);
    }
}
