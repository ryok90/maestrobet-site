<?php

namespace Usuario\Service;

use Application\Exception\ApiGeneralException;
use Application\Service\ServiceAbstract;
use Exception;
use Usuario\Entity\Usuario;
use ZF\ApiProblem\ApiProblem;


class UsuarioService extends ServiceAbstract
{
    /**
     * @param Usuario $usuario
     * @return Usuario|ApiProblem
     * @throws ApiGeneralException
     */
    public function insert(Usuario $usuario)
    {
        if ($usuario->getId()) {
            throw new ApiGeneralException(400, 'Usuário já registrado');
        }

        try {
            $usuario->setUsuarioCriador($this->getUsuarioAutenticado());
            $this->entityManager->persist($usuario);
            $this->entityManager->flush();

            return $usuario;
        } catch (Exception $exception) {
            throw new ApiGeneralException(500, 'Ocorreu um erro ao inserir usuário', $exception);
        }
    }

    /**
     * @param Usuario $usuario
     * @return Usuario|ApiProblem
     * @throws ApiGeneralException
     */
    public function update(Usuario $usuario)
    {
        if (!$usuario->getId()) {
            throw new ApiGeneralException(400, 'Usuário ainda não registrado');
        }

        try {
            $this->entityManager->persist($usuario);
            $this->entityManager->flush();

            return $usuario;
        } catch (Exception $exception) {
            throw new ApiGeneralException(500,'Ocorreu um erro ao atualizar usuário', $exception);
        }
    }

    /**
     * @param Usuario $usuario
     * @return bool|ApiProblem
     * @throws ApiGeneralException
     */
    public function delete(Usuario $usuario)
    {
        if (!$usuario->getId()) {
            throw new ApiGeneralException(400, 'Usuário ainda não registrado');
        }

        try {
            $usuario->logicalDelete();
            $this->entityManager->persist($usuario);
            $this->entityManager->flush();

            return true;
        } catch (Exception $exception) {
            throw new ApiGeneralException(500, 'Ocorreu um erro ao remover usuário', $exception);
        }
    }
}
