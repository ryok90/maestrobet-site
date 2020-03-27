<?php

namespace Usuario\Service;

use Application\Service\ServiceAbstract;
use DateTime;
use Doctrine\ORM\EntityManagerInterface;
use Exception;
use RuntimeException;
use Usuario\Entity\Usuario;
use ZF\ApiProblem\ApiProblem;
use Zend\Mvc\Controller\AbstractActionController;

class UsuarioService extends ServiceAbstract
{
    public function insert(Usuario $usuario)
    {
        if ($usuario->getId()) {
            return new ApiProblem(400, 'Usuário já registrado.');
        }

        $this->entityManager->persist($usuario);
        $this->entityManager->flush();

        return $usuario;
    }

    public function update(Usuario $usuario)
    {
        if (!$usuario->getId()) {
            return new ApiProblem(400, 'Usuário ainda não registrado');
        }
        
        $this->entityManager->persist($usuario);
        $this->entityManager->flush();

        return $usuario;
    }

    public function delete(Usuario $usuario)
    {
        if (!$usuario->getId()) {
            return new ApiProblem(400, 'Usuário ainda não registrado');
        }
        $usuario->logicalDelete();

        $this->entityManager->persist($usuario);
        $this->entityManager->flush();

        return true;
    }
}
