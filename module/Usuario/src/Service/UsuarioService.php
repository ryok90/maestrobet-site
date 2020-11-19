<?php

namespace Usuario\Service;

use Application\Exception\ApiGeneralException;
use Application\Service\ServiceAbstract;
use Exception;
use Usuario\Entity\Agente;
use Usuario\Entity\Banca;
use Usuario\Entity\Cliente;
use Usuario\Entity\Repasse;
use Usuario\Entity\Usuario;
use Usuario\Rbac\RoleProvider;
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

    /**
     * @param array $usuarios
     * @return void
     */
    public function insertBatch($usuarios)
    {
        try {
            /** @var Usuario $usuario */
            foreach ($usuarios as $usuario) {
                $this->entityManager->persist($usuario);
            }
            $this->entityManager->flush();
        } catch (Exception $exception) {
            throw new ApiGeneralException(500, 'Ocorreu um erro ao inserir usuários de importação', $exception);
        }
    }

    /**
     * Cria e persiste os objetos do usuario
     * @param Usuario $usuario
     * @return void
     */
    protected function createRoles($usuario)
    {
        $roles = $usuario->getRoles();

        foreach ($roles as $role) {
            switch ($role) {
                case RoleProvider::ROLE_AGENTE:
                    $agente = new Agente();
                    $agente->setUsuario($usuario);
                    $this->entityManager->persist($agente);
                    break;

                case RoleProvider::ROLE_BANCA:
                    $banca = new Banca();
                    $banca->setUsuario($usuario);
                    $this->entityManager->persist($banca);
                    break;

                case RoleProvider::ROLE_CLIENTE:
                    $cliente = new Cliente();
                    $cliente->setUsuario($usuario);
                    $this->entityManager->persist($cliente);
                    break;
                
                case RoleProvider::ROLE_REPASSE:
                    $repasse = new Repasse();
                    $repasse->setUsuario($usuario);
                    $this->entityManager->persist($repasse);
                    break;
            }
        }
    }
}
