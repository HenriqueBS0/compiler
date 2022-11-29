<?php

namespace HenriqueBS0\Compiler\GeracaoAssembly;

class MontadorDeclaracaoVariaveis {
    public static function getComandos(ControladorFuncoes $controladorFuncoes) : array
    {
        return array_merge(
            self::getDeclaracaoNumeros($controladorFuncoes),
            self::getDeclaracaoBoleanos($controladorFuncoes),
            self::getDeclaracaoStrings($controladorFuncoes)
        );
    }

    public static function getDeclaracaoNumeros(ControladorFuncoes $controladorFuncoes) : array
    {
        $numeroVariaveis = count($controladorFuncoes->getVariaveisNumericas());

        if($numeroVariaveis === 0) {
            return [];
        }

        $space = $numeroVariaveis * 4;

        return ['inteiros:', '.align 2', ".space {$space}"];
    }

    public static function getDeclaracaoBoleanos(ControladorFuncoes $controladorFuncoes) : array
    {
        $numeroVariaveis = count($controladorFuncoes->getVariaveisBoleanas());

        if($numeroVariaveis === 0) {
            return [];
        }

        $space = $numeroVariaveis * 4;

        return ['booleanos:', '.align 2', ".space {$space}"];
    }

    public static function getDeclaracaoStrings(ControladorFuncoes $controladorFuncoes) : array
    {
        $numeroVariaveis = count($controladorFuncoes->getVariaveisCadeia());

        if($numeroVariaveis === 0) {
            return [];
        }

        $comandos = [];
        $variaveisArrayString = [];

        /** @var Variavel */
        foreach ($controladorFuncoes->getVariaveisCadeia() as $variavel) {

            $nomeVariavel =  "X{$variavel->getIndice()}"; 

            $comandos[] = "{$nomeVariavel}: .asciiz \"{$variavel->getValor()}\"";

            $variaveisArrayString[] = $nomeVariavel;
        }

        $comandos[] = "cadeias: .word " . implode(', ', $variaveisArrayString);

        return $comandos;
    }
}