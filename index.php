<?php

ini_set("xdebug.var_display_max_children", '-1');
ini_set("xdebug.var_display_max_data", '-1');
ini_set("xdebug.var_display_max_depth", '-1');

use HenriqueBS0\Compiler\EstruturasAnalise\Parser;
use HenriqueBS0\Compiler\EstruturasAnalise\ParserException;
use HenriqueBS0\Compiler\GeracaoAssembly\MontadorAssemblyMips;
use HenriqueBS0\Compiler\GeradorAssembly\Gerador;
use HenriqueBS0\LexicalAnalyzer\LexicalAnalyzerException;
use HenriqueBS0\SyntacticAnalyzer\Parsers\SyntacticException;
use HenriqueBS0\SyntacticAnalyzer\SLR\Semantic\SemanticAnalyzerException;

require_once __DIR__ . '/vendor/autoload.php';

$parser = new Parser();

$input = "
    FUNCTION teste() {
        STR TESTE;
        STR teste;

        teste = 'Ola Mundo';
    }

    EXECUTE() {
        NUM TESTE;
        BOOL teste;
        TESTE = 1;
    }
";


try {
    var_dump(MontadorAssemblyMips::getAssembly($parser->getParseTree($input)));
} 
catch (ParserException $ex) {
    echo $ex->getMessage();
}

