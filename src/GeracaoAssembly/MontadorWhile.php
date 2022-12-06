<?php

namespace HenriqueBS0\Compiler\GeracaoAssembly;

use HenriqueBS0\Compiler\EstruturasAnalise\ElementosArvoreSintatica\Enquanto;

class MontadorWhile {
    public static function getComando(Enquanto $enquanto, ControladorFuncoes &$controladorFuncoes) : array
    {
        $indiceWhile = Subrotinas::getContadorWhile();

        $labelWhile      = "WHILE{$indiceWhile}";
        $labelSaidaWhile = "SAIDAWHILE{$indiceWhile}";

        $variavel = $controladorFuncoes->getVariavel($enquanto->getIdentificador()->getLexeme());

        return [
            "$labelWhile:",
            UtilsMontador::arrayParaRegistrador($variavel->getArrayVariavel(), $variavel->getIndiceCalculado()),
            ["bne \$t1, 1, {$labelSaidaWhile}"],
            MontadorComandos::getComandos($controladorFuncoes, $enquanto->getBlocoCodigo()->getListaComandos()),
            ["j {$labelWhile}"],
            "$labelSaidaWhile:"
        ];
    }
}