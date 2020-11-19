<?php

namespace Importacao\V1\Rpc\Usuario;

use Application\Controller\ImportacaoUsuarioAbstractController;
use Usuario\Entity\Agente;
use Usuario\Entity\Banca;
use Usuario\Entity\Usuario;
use Zend\Http\Response;
use Zend\Http\Request;
use Zend\Json\Json;

class UsuarioController extends ImportacaoUsuarioAbstractController
{
    public function usuarioAction()
    {
        /** @var Response $response */
        $response = $this->getResponse();

        /** @var Request $request */
        $request = $this->getRequest();
        $upload = $request->getFiles()->toArray()['usuarios'];

        $json = file_get_contents($upload['tmp_name']);
        $decoded = Json::decode($json, Json::TYPE_ARRAY);

        $bancas = $this->getMappedEntities(Banca::class);
        $agentes = $this->getMappedEntities(Agente::class);
        $usuarios = $this->getMappedUsuarios();

        $adjusted = $this->adjustUsuarios($decoded, $usuarios, $agentes, $bancas);

        $this->getService()->insertBatch($adjusted);

        /** @var Response $response */
        $response = $this->getResponse();
        $response->setStatusCode(204);

        return;
    }

    protected function getMappedEntities($entity)
    {
        $entityRepo = $this->getRepository($entity);
        $entityRepo->setMaxResults(null);
        $objects = $entityRepo->getActiveResults();
        $array = [];

        /** @var Agente|Banca $object */
        foreach ($objects as $object) {
            $array[$object->getUsuario()->getNome()] = $object;
        }

        return $array;
    }

    protected function getMappedUsuarios()
    {
        $usuarioRepo = $this->getRepository();
        $usuarioRepo->setMaxResults(null);
        $usuarios = $usuarioRepo->getActiveResults();
        $array = [];

        /** @var Usuario $usuario */
        foreach ($usuarios as $usuario) {
            $array[$usuario->getNome()] = $usuario;
        }

        return $array;
    }

    protected function adjustUsuarios($subjects, $usuarios, $agentes, $bancas)
    {
        $errors = [];
        $array = [];
        foreach ($subjects as $subject) {
            /** @var Usuario $usuario */
            $usuario = $usuarios[$subject['nome']] ?? null;
            
            if (!$usuario instanceof Usuario) {
                $errors[] = $subject['nome'];

            } else {
                $desconto = !empty($subject['desconto']) ? $subject['desconto'] : 0;

                $agente = $agentes[$subject['agente']] ?? null;
                $comissaoPerca = !empty($subject['perca']) ? $subject['perca'] : null;
                $comissaoGanho = !empty($subject['ganho']) ? $subject['ganho'] : null;

                $banca1 = $bancas[$subject['banca1']] ?? null;
                $partBanca1 = !empty($subject['participacaoBanca1']) ? $subject['participacaoBanca1'] : null;

                $banca2 = $bancas[$subject['banca2']] ?? null;
                $partBanca2 = !empty($subject['participacaoBanca2']) ? $subject['participacaoBanca2'] : null;

                $responsavel = $usuarios[$subject['responsavel']] ?? null;

                $usuario->setDesconto($desconto);
                $usuario->setAgente($agente);
                $usuario->setCommissaoAgentePerca($comissaoPerca);
                $usuario->setCommissaoAgenteGanho($comissaoGanho);
                $usuario->setBanca1($banca1);
                $usuario->setParticipacaoBanca1($partBanca1);
                $usuario->setBanca2($banca2);
                $usuario->setParticipacaoBanca2($partBanca2);
                $usuario->setResponsavel($responsavel);

                $array[] = $usuario;
            }
        }
        return $array;
    }
}
