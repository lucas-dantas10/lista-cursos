<?php

namespace Alura\Cursos\Controller;

use Alura\Cursos\Helper\RenderizadorDeHtmlTrait;
use Nyholm\Psr7\Response;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Server\RequestHandlerInterface;

class FormularioInsercao implements RequestHandlerInterface
{
    use RenderizadorDeHtmlTrait;
    
    public function handle(ServerRequestInterface $request): ResponseInterface
    {
        echo $this->renderizaHtml('formulario/formulario.php', [
            'titulo' => 'Novo Curso'
        ]);

        return new Response(200, []);
    }
}
