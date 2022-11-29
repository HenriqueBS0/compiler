<?php

namespace HenriqueBS0\Compiler\GeracaoAssembly;

class UtilsMontador {

    const ARRAY_CADEIAS   = 'cadeias';
    const ARRAY_INTEIROS  = 'inteiros';
    const ARRAY_BOOLEANOS = 'booleanos';

    public static function carregaValorRegistrador(string $array, int $indice, string $registrador = '$t1') : array
    {
        return [
            "la \$t0, {$array}",
            "lw {$registrador}, {$indice}(\$t0)"
        ];
    }

    public static function salvaValorArray(string $array, int $indice, string $registrador = '$t1') : array
    {
        return [
            "la \$t0, {$array}",
            "sw {$registrador}, {$indice}(\$t0)"
        ];
    }
}