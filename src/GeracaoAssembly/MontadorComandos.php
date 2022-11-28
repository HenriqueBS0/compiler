<?php

namespace HenriqueBS0\Compiler\GeracaoAssembly;

use HenriqueBS0\Compiler\EstruturasAnalise\ElementosArvoreSintatica\Comando;
use HenriqueBS0\Compiler\EstruturasAnalise\ElementosArvoreSintatica\ListaComandos;
use HenriqueBS0\Compiler\EstruturasAnalise\ElementosArvoreSintatica\Programa;

class MontadorComandos {
    public static function getComandos(Programa $programa, ControladorFuncoes $controladorFuncoes, ListaComandos $listaComandos) : array
    {
        $comandos = [];

        /** @var Comando */
        foreach (array_reverse($listaComandos->getListaComandos()) as $comando) {
            if(!is_null($comando->getAtribuicao())) {
                $comando = MontadorAtribuicao::getComandos($comando->getAtribuicao(), $controladorFuncoes);
                continue;
            }
        }

        return $comandos;
    }
}