<?php

ini_set("xdebug.var_display_max_children", '-1');
ini_set("xdebug.var_display_max_data", '-1');
ini_set("xdebug.var_display_max_depth", '-1');

use HenriqueBS0\Compiler\EstruturasAnalise\Parser;
use HenriqueBS0\Compiler\EstruturasAnalise\ParserException;
use HenriqueBS0\Compiler\GeracaoAssembly\MontadorAssemblyMips;

require_once __DIR__ . '/vendor/autoload.php';

$parser = new Parser();

$input = "

    FUNCTION soma(NUM X, NUM Y, NUM R) {
        R = X + Y;
    }

    EXECUTE() {        
        NUM n1;
        NUM n2;
        NUM resultado;

        n1 = 1;
        n2 = 2;
        resultado = 0;

        soma(n1, n2, resultado);
        
        soma(resultado, resultado, resultado);

        PRINT(resultado);
    }
";


try {
    var_dump(MontadorAssemblyMips::getAssembly($parser->getParseTree($input)));
} 
catch (ParserException $ex) {
    echo $ex->getMessage();
}

