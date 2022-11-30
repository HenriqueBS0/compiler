<?php

namespace HenriqueBS0\Compiler\GeracaoAssembly;

use HenriqueBS0\Compiler\EstruturasAnalise\ElementosArvoreSintatica\Comando;
use HenriqueBS0\Compiler\EstruturasAnalise\ElementosArvoreSintatica\ListaComandos;
use HenriqueBS0\Compiler\EstruturasAnalise\ElementosArvoreSintatica\Programa;

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
        }

        return array_merge($comandos, UtilsMontador::finaliza());
    }
}