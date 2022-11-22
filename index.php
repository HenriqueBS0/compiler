<?php

ini_set("xdebug.var_display_max_children", '-1');
ini_set("xdebug.var_display_max_data", '-1');
ini_set("xdebug.var_display_max_depth", '-1');

use HenriqueBS0\Compiler\EstruturasAnalise\Parser;
use HenriqueBS0\Compiler\EstruturasAnalise\ParserException;
use HenriqueBS0\LexicalAnalyzer\LexicalAnalyzerException;
use HenriqueBS0\SyntacticAnalyzer\Parsers\SyntacticException;
use HenriqueBS0\SyntacticAnalyzer\SLR\Semantic\SemanticAnalyzerException;

require_once __DIR__ . '/vendor/autoload.php';

$parser = new Parser();

$input = "
    EXECUTE() {
        NUM TESTE;
        TESTE = 1;
    }
";


try {
    $parser->getParseTree($input);
} 
catch (ParserException $ex) {
    echo $ex->getMessage();
}

