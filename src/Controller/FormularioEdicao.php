<?php

namespace Alura\Cursos\Controller;

use Alura\Cursos\Entity\Curso;
use Alura\Cursos\Helper\RenderizadorDeHtmlTrait;
use Alura\Cursos\Infra\EntityManagerCreator;
use Nyholm\Psr7\Response;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Server\RequestHandlerInterface;

class FormularioEdicao implements RequestHandlerInterface
{
    use RenderizadorDeHtmlTrait;
    
    private $repositorio;

    public function __construct()
    {
        $em = EntityManagerCreator::getEntityManager();
        $this->repositorio = $em->getRepository(Curso::class);
    }

    public function handle(ServerRequestInterface $request): ResponseInterface
    {
        $id = $request->getQueryParams()['id'];

        if (is_null($id) || $id === false) {
            return new Response(200, ['Location' => '/listar-cursos']);
        }

        $curso = $this->repositorio->find($id);
        echo $this->renderizaHtml('formulario/formulario.php', [
            'curso' => $curso,
            'titulo' => 'Alterar Curso ' . $curso->getDescricao()
        ]);

        return new Response(200, []);
    }
}
