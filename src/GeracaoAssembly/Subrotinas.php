<?php

namespace HenriqueBS0\Compiler\GeracaoAssembly;

class Subrotinas {
    private static int $contadorIF     = 0;
    private static int $contadorWhile  = 0;
    private static array $subrotinas = [];

    public static function getContadorIF() : int
    {
        $contador = self::$contadorIF;
        self::$contadorIF++;
        return $contador;
    }

    public static function getContadorWhile() : int
    {
        $contador = self::$contadorWhile;
        self::$contadorWhile++;
        return $contador;
    }

    public static function addSubrotina(array $subrotina) : void
    {
        self::$subrotinas[] = $subrotina;
    }

    public static function getSubrotinas() : array
    {
        return array_merge_recursive(self::$subrotinas);
    }
}