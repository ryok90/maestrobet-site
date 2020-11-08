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
        try {
            if ($usuario->getId()) {
                return new ApiProblem(400, 'Usuário já registrado.');
            }
            $usuario->setUsuarioCriador($this->getUsuarioAutenticado());
            $this->entityManager->persist($usuario);
            $this->entityManager->flush();

            return $usuario;
        } catch (Exception $exception) {
            throw new ApiGeneralException('Ocorreu um erro ao inserir usuário', 500, $exception);
        }
    }

    /**
     * @param Usuario $usuario
     * @return Usuario|ApiProblem
     * @throws ApiGeneralException
     */
    public function update(Usuario $usuario)
    {
        try {
            if (!$usuario->getId()) {
                return new ApiProblem(400, 'Usuário ainda não registrado');
            }

            $this->entityManager->persist($usuario);
            $this->entityManager->flush();

            return $usuario;
        } catch (Exception $exception) {
            throw new ApiGeneralException('Ocorreu um erro ao atualizar usuário', 500, $exception);
        }
    }

    /**
     * @param Usuario $usuario
     * @return bool|ApiProblem
     * @throws ApiGeneralException
     */
    public function delete(Usuario $usuario)
    {
        try {
            if (!$usuario->getId()) {
                return new ApiProblem(400, 'Usuário ainda não registrado');
            }
            $usuario->logicalDelete();
            $this->entityManager->persist($usuario);
            $this->entityManager->flush();

            return true;
        } catch (Exception $exception) {
            throw new ApiGeneralException('Ocorreu um erro ao remover usuário', 500, $exception);
        }
    }
}
