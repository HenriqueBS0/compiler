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
    NUM  testeNUM;
    BOOL testeBOOL;
    STR  testeSTR;
}

FUNCTION teste(NUM X) {
    NUM  testeNUM;
    BOOL testeBOOL;
    STR  testeSTR;
}

FUNCTION teste(NUM X, BOOL Y, STR Z) {
    NUM  testeNUM;
    BOOL testeBOOL;
    STR  testeSTR;
}

EXECUTE() {
    NUM  testeNUM;
    BOOL testeBOOL;
    STR  testeSTR;
    
    testeFuncaoSemParametros();
    testeFuncaoComUmParametros(x);
    testeFuncaoComtTresParametros(x, y, f);

    var = 1;
    var = TRUE;
    var = FALSE;
    var = X;
    var = 'teste';
    var = !X;
    var = 12 + 12;
    var = 12 - 12;
    var = 12 * 12;
    var = 12 / 12;
    var = X + Y;
    var = X - Y;
    var = X * Y;
    var = X / Y;
    var = 1 + 12 - 23 * 46 / 34;
    var = X + Y - V * G / T;
    var = 1 + Y - 54 * G / 34;
    var = 'STR' . 'STR';
    var = VAR . 'STR';
    var = VAR . VAR;
    var = 'STR' . X . 'STR' . Y;
    var = 1 > 2;
    var = X > Y;
    var = X > 2;
    var = 1 < 2;
    var = X < Y;
    var = X < 2;
    var = 1 == 2;
    var = X == Y;
    var = X == 2;
    var = 'STR' == 'STR';
    var = 'STR' == Y;
    var = 1 != 2;
    var = X != Y;
    var = X != 2;
    var = 'STR' != 'STR';
    var = 'STR' != Y;
    var = X & Y;
    var = X & Y & Z;
    var = X | Y;
    var = X | Y | Z;
    PRINT(X);
    
    IF(X) {
        FUNCAO(X);
    }

    WHILE(X) {
        FUNCAO(X);
    }
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

