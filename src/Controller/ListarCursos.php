<?php

namespace Alura\Cursos\Controller;

use Alura\Cursos\Entity\Curso;
use Alura\Cursos\Helper\RenderizadorDeHtmlTrait;
use Alura\Cursos\Infra\EntityManagerCreator;

class ListarCursos implements InterfaceControladorRequisicao
{
    use RenderizadorDeHtmlTrait;

    private $repositorioDeCursos;

    public function __construct()
    {
        $entityManagerCreate = new EntityManagerCreator();
        $entityManager = $entityManagerCreate->getEntityManager();
        $this->repositorioDeCursos = $entityManager->getRepository(Curso::class);
    }

    public function processaRequisicao(): void
    {    
        echo $this->renderizaHtml('cursos/listar-cursos.php', [
            'cursos' => $this->repositorioDeCursos->findAll(),
            'titulo' => 'Lista De Curso'
        ]);
    }
}
