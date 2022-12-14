<?php

namespace Alura\Cursos\Controller;

use Alura\Cursos\Entity\Curso;
use Alura\Cursos\Helper\RenderizadorDeHtmlTrait;
use Alura\Cursos\Infra\EntityManagerCreator;
use Nyholm\Psr7\Response;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Server\RequestHandlerInterface;

class ListarCursos implements RequestHandlerInterface
{
    use RenderizadorDeHtmlTrait;

    private $repositorioDeCursos;

    public function __construct()
    {
        $entityManagerCreate = new EntityManagerCreator();
        $entityManager = $entityManagerCreate->getEntityManager();
        $this->repositorioDeCursos = $entityManager->getRepository(Curso::class);
    }

    public function handle(ServerRequestInterface $request): ResponseInterface
    {
        echo $this->renderizaHtml('cursos/listar-cursos.php', [
            'cursos' => $this->repositorioDeCursos->findAll(),
            'titulo' => 'Lista De Curso'
        ]);

        return new Response(302, []);
    }
}
