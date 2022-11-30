<?php

namespace HenriqueBS0\Compiler\GeracaoAssembly;

class UtilsMontador {

    const ARRAY_CADEIAS   = 'cadeias';
    const ARRAY_INTEIROS  = 'inteiros';
    const ARRAY_BOOLEANOS = 'booleanos';

    const COMPARACAO_IGUAL       = 'beq';
    const COMPARACAO_DIFERENTE   = 'bne';
    const COMPARACAO_MENOR       = 'blt';
    const COMPARACAO_MAIOR       = 'bgt';
    const COMPARACAO_MENOR_IGUAL = 'ble';
    const COMPARACAO_MAIOR_IGUAL = 'bge';

    public static function arrayParaRegistrador(string $array, int $indice, string $registrador = '$t1') : array
    {
        return [
            "la \$t0, {$array}",
            "lw {$registrador}, {$indice}(\$t0)"
        ];
    }

    public static function registradorParaArray(string $array, int $indice, string $registrador = '$t1') : array
    {
        return [
            "la \$t0, {$array}",
            "sw {$registrador}, {$indice}(\$t0)"
        ];
    }

    public static function carregaValorRegistrador(string $valor, string $registrador = '$t1') : array
    {
        return ["li {$registrador}, {$valor}"];
    }

    public static function copiarValorRegistrador(string $registradorOrigem, string $registradorDestino) : array
    {
        return ["move {$registradorDestino}, {$registradorOrigem}"]; 
    }

    public static function desvioCondicional(array $comandos, int $contadorIF, string $resgistradorA = '$t1', string $resgistradorB = '$t2', string $comparacao = self::COMPARACAO_IGUAL) : array
    {
        $label = "IF{$contadorIF}";

        Subrotinas::addSubrotina(["{$label}:", array_merge($comandos, self::finaliza())]);
        return ["{$comparacao} {$resgistradorA}, $resgistradorB, {$label}"];
    }

    public static function finaliza() : array 
    {
        return ['li $v0, 10', 'syscall'];
    }
}