<?php

namespace Alura\Cursos\Controller;

class FormularioLogin extends ControllerComHtml implements InterfaceControladorRequisicao
{
    public function processaRequisicao(): void
    {
        $dados = [
            'titulo' => 'Login'
        ];
        echo $this->renderizaHtml('login/formulario.php', $dados);
    }
}
