<?php

namespace Alura\Cursos\Controller;

use Alura\Cursos\Helper\RenderizadorDeHtmlTrait;
use Nyholm\Psr7\Response;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Server\RequestHandlerInterface;

class FormularioLogin implements RequestHandlerInterface
{
    use RenderizadorDeHtmlTrait;
    
    public function handle(ServerRequestInterface $request): ResponseInterface
    {
        $dados = [
            'titulo' => 'Login'
        ];
        echo $this->renderizaHtml('login/formulario.php', $dados);

        return new Response(302, []);
    }
}
