<?php

namespace Usuario\Service;

use Application\Service\ServiceAbstract;
use Usuario\Entity\Usuario;
use ZF\ApiProblem\ApiProblem;


class UsuarioService extends ServiceAbstract
{
    /**
     * @param Usuario $usuario
     * @return Usuario|ApiProblem
     */
    public function insert(Usuario $usuario)
    {
        if ($usuario->getId()) {
            return new ApiProblem(400, 'Usuário já registrado.');
        }
        $usuario->setUsuarioCriador($this->getUsuarioAutenticado());
        $this->entityManager->persist($usuario);
        $this->entityManager->flush();

        return $usuario;
    }

    /**
     * @param Usuario $usuario
     * @return Usuario|ApiProblem
     */
    public function update(Usuario $usuario)
    {
        if (!$usuario->getId()) {
            return new ApiProblem(400, 'Usuário ainda não registrado');
        }
        
        $this->entityManager->persist($usuario);
        $this->entityManager->flush();

        return $usuario;
    }

    /**
     * @param Usuario $usuario
     * @return bool|ApiProblem
     */
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
