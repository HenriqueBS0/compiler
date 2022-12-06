<?php

namespace HenriqueBS0\Compiler\GeracaoAssembly;

use HenriqueBS0\Compiler\EstruturasAnalise\ElementosArvoreSintatica\Comando;
use HenriqueBS0\Compiler\EstruturasAnalise\ElementosArvoreSintatica\ListaComandos;

class MontadorComandos {
    public static function getComandos(ControladorFuncoes $controladorFuncoes, ListaComandos $listaComandos) : array
    {
        $comandos = [];

        /** @var Comando */
        foreach (array_reverse($listaComandos->getListaComandos()) as $comando) {
            if(!is_null($comando->getAtribuicao())) {
                $comandos = array_merge($comandos, MontadorAtribuicao::getComandos($comando->getAtribuicao(), $controladorFuncoes));
                continue;
            }
            if(!is_null($comando->getPrinta())) {
                $comandos = array_merge($comandos, MontadorPrint::getComando($comando->getPrinta(), $controladorFuncoes));
                continue;
            }
            if(!is_null($comando->getSe())) {
                $comandos = array_merge($comandos, MontadorIF::getComando($comando->getSe(), $controladorFuncoes));
                continue;
            }
            if(!is_null($comando->getEnquanto())) {
                $comandos = array_merge($comandos, MontadorWhile::getComando($comando->getEnquanto(), $controladorFuncoes));
                continue;
            }
            if(!is_null($comando->getChamadaFuncao())) {
                $comandos = array_merge($comandos, MontadorChamadaFuncao::getComando($comando->getChamadaFuncao(), $controladorFuncoes));
                continue;
            }
        }

        return $comandos;
    }
}