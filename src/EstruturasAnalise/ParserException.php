<?php

namespace HenriqueBS0\Compiler\EstruturasAnalise;

use Exception;
use HenriqueBS0\LexicalAnalyzer\LexicalAnalyzerException;
use HenriqueBS0\SyntacticAnalyzer\Parsers\SyntacticException;
use HenriqueBS0\SyntacticAnalyzer\SLR\Semantic\SemanticAnalyzer;
use HenriqueBS0\SyntacticAnalyzer\SLR\Semantic\SemanticAnalyzerException;

class ParserException extends Exception {
    
    const TIPO_LEXICO = 1;
    const TIPO_SINTATICO = 2;
    const TIPO_SEMANTICO = 3;

    private $tipo;

    public function getTipo() : int
    {
        return $this->tipo;
    }

    public function __construct(int $tipo, string $mensagem = "", int $codigo = 0) {
        parent::__construct($mensagem, $codigo);
        $this->tipo = $tipo;
    }

    public static function getExcecaoLexica(LexicalAnalyzerException $ex) : self
    {
        $caracter = explode("'", $ex->getMessage())[1];
        return new ParserException(self::TIPO_LEXICO, "Erro na linha {$ex->getPosition()->getStartLine()}: Caracter '{$caracter}' não pertence ao alfabeto da linguagem.");
    }

    public static function getExcecaoSintatica(SyntacticException $ex) : self
    {
        return new ParserException(self::TIPO_SEMANTICO, "Erro na linha {$ex->getToken()->getPosition()->getStartLine()}: Token '{$ex->getToken()->getLexeme()}' inesperado.");
    }

    public static function getExcecaoSemantica(SemanticAnalyzerException $ex) : self
    {
        return new ParserException(self::TIPO_SEMANTICO, $ex->getMessage());
    }
}