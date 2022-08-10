<?php

namespace Alura\Cursos\Controller;

class FormularioInsercao extends ControllerComHtml implements InterfaceControladorRequisicao
{
    public function processaRequisicao(): void
    {
        echo $this->renderizaHtml('formulario/formulario.php', [
            'titulo' => 'Novo Curso'
        ]);
    }
}
