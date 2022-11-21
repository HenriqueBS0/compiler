<?php

ini_set("xdebug.var_display_max_children", '-1');
ini_set("xdebug.var_display_max_data", '-1');
ini_set("xdebug.var_display_max_depth", '-1');

use HenriqueBS0\Compiler\EstruturasAnalise\Parser;
use HenriqueBS0\LexicalAnalyzer\LexicalAnalyzerException;
use HenriqueBS0\SyntacticAnalyzer\Parsers\SyntacticException;
use HenriqueBS0\SyntacticAnalyzer\SLR\Semantic\SemanticAnalyzerException;

require_once __DIR__ . '/vendor/autoload.php';

$parser = new Parser();

$input = "
FUNCTION teste() {
    NUM variavel;
    variavell = 1;
}

EXECUTE() {
    NUM variavel;
}";

$dump = null;

try {
    $dump = $parser->getParseTree($input);
} 
catch (LexicalAnalyzerException $ex) {
    $dump = $ex;
}
catch (SyntacticException $ex) {
    $dump = $ex;
}
catch (SemanticAnalyzerException $ex) {
    $dump = $ex;
} 
finally {
    var_dump($dump);
}

