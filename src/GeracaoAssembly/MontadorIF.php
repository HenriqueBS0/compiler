<?php

namespace HenriqueBS0\Compiler\GeracaoAssembly;

use HenriqueBS0\Compiler\EstruturasAnalise\ElementosArvoreSintatica\Se;

class MontadorIF {
    public static function getComando(Se $se, ControladorFuncoes &$controladorFuncoes) : array
    {
        $variavel = $controladorFuncoes->getVariavel($se->getIdentificador()->getLexeme()); 

        return array_merge(
            UtilsMontador::arrayParaRegistrador($variavel->getArrayVariavel(), $variavel->getIndiceCalculado()),
            UtilsMontador::carregaValorRegistrador('1', '$t2'),
            UtilsMontador::desvioCondicional(MontadorComandos::getComandos($controladorFuncoes, $se->getBlocoCodigo()->getListaComandos()), Subrotinas::getContadorIF())
        );
    }
}