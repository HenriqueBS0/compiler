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
    EXECUTE() {
        NUM x;
        NUM y;
        NUM z;
    }
";


try {
    var_dump(MontadorAssemblyMips::getAssembly($parser->getParseTree($input)));
} 
catch (ParserException $ex) {
    echo $ex->getMessage();
}

