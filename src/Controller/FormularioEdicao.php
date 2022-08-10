<?php

namespace Alura\Cursos\Controller;

use Alura\Cursos\Entity\Curso;
use Alura\Cursos\Infra\EntityManagerCreator;

class FormularioEdicao extends ControllerComHtml implements InterfaceControladorRequisicao
{
    private $repositorio;

    public function __construct()
    {
        $em = EntityManagerCreator::getEntityManager();
        $this->repositorio = $em->getRepository(Curso::class);
    }

    public function processaRequisicao(): void
    {
        $id = filter_input(
            INPUT_GET,
            'id',
            FILTER_VALIDATE_INT
        );

        if (is_null($id) || $id === false) {
            header("Location: /listar-cursos");
            return;
        }

        $curso = $this->repositorio->find($id);
        echo $this->renderizaHtml('formulario/formulario.php', [
            'curso' => $curso,
            'titulo' => 'Alterar Curso ' . $curso->getDescricao()
        ]);
        
    }
}
