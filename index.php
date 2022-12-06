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
    FUNCTION maiorIdade(NUM idade) {
        STR MSG1;
        MSG1 = 'MAIOR DE IDADE.\\n';

        BOOL isMaior;
        isMaior = idade > 17;

        IF(isMaior) {
            PRINT(MSG1);
        }
    }

    EXECUTE() {        
        NUM idade;
        idade = 18;
        maiorIdade(idade);
    }
";


try {
    var_dump(MontadorAssemblyMips::getAssembly($parser->getParseTree($input)));
} 
catch (ParserException $ex) {
    echo $ex->getMessage();
}

