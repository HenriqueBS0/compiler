<?php

namespace HenriqueBS0\Compiler\GeracaoAssembly;

use HenriqueBS0\Compiler\EstruturasAnalise\ElementosArvoreSintatica\Printa;

class MontadorPrint {
    public static function getComando(Printa $printa, ControladorFuncoes $controladorFuncoes) : array
    {
        $variavelPrint = $controladorFuncoes->getVariavel($printa->getIdentificador()->getLexeme());

        return $variavelPrint->getTipo() === 'NUM' ? self::printaInteiro($variavelPrint) : self::printaString($variavelPrint);
    }

    private static function printaInteiro(Variavel $variavel) : array 
    {
        return array_merge(
            UtilsMontador::arrayParaRegistrador($variavel->getArrayVariavel(), $variavel->getIndiceCalculado()),
            ['li $v0, 1', 'move $a0, $t1', 'syscall']
        );
    }

    private static function printaString(Variavel $variavel) : array 
    {
        return array_merge(
            UtilsMontador::arrayParaRegistrador($variavel->getArrayVariavel(), $variavel->getIndiceCalculado()),
            ['li $v0, 4', 'move $a0, $t1', 'syscall']
        );
    }
}