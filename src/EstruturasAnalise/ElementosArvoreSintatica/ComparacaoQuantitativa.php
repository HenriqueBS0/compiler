<?php

namespace HenriqueBS0\Compiler\EstruturasAnalise\ElementosArvoreSintatica;

use HenriqueBS0\Compiler\EstruturasAnalise\AnaliseSemantica\AnalisadorSemantico;
use HenriqueBS0\LexicalAnalyzer\Token;
use HenriqueBS0\SyntacticAnalyzer\SLR\Semantic\SemanticAnalyzer;
use HenriqueBS0\SyntacticAnalyzer\SLR\Tree\Node;

class ComparacaoQuantitativa extends Node {
    private array $simbolos = [];

    public function addSimbolo(Token|OperadorComparacaoQuantitativa $simbolo) : void
    {
        $this->simbolos[] = $simbolo;
    }

    public function getSimbolos() : array
    {
        return $this->simbolos;
    }

    public function semanticValidation(SemanticAnalyzer &$semanticAnalyzer): void
    {
        $this->validarVariaveis($semanticAnalyzer);
    }

    private function validarVariaveis(AnalisadorSemantico $analisadorSemantico) : void
    {
        foreach (array_reverse($this->getSimbolos()) as $simbolo) {
            
            if($simbolo instanceof Token && $simbolo->getToken() === 'IDENTIFICADOR') {
                $this->validarVariavel($analisadorSemantico, $simbolo);
            }

        }
    }

    private function validarVariavel(AnalisadorSemantico $analisadorSemantico, Token $variavel) : void
    {
        $this->verificarVariavelDeclarada($analisadorSemantico, $variavel);
        $this->verificarVariavelTipoNumerica($analisadorSemantico, $variavel);
        $this->verificarVariavelIniciada($analisadorSemantico, $variavel);
    }

    private function verificarVariavelDeclarada(AnalisadorSemantico $analisadorSemantico, Token $variavel) : void
    {
        $nomeVariavel = $variavel->getLexeme();

        if(!$analisadorSemantico->getVariaveis()->existeVariavel($nomeVariavel)) {
            $linha = $variavel->getPosition()->getStartLine();
            $analisadorSemantico->newSemanticException("Erro na linha {$linha}: A variável '{$nomeVariavel}' não foi declarada.");
        }
    }

    private function verificarVariavelTipoNumerica(AnalisadorSemantico $analisadorSemantico, Token $variavel) : void
    {
        $nomeVariavel = $variavel->getLexeme();

        if($analisadorSemantico->getVariaveis()->getVariavel($nomeVariavel)->getTipo() !== 'NUM') {
            $linha = $variavel->getPosition()->getStartLine();
            $analisadorSemantico->newSemanticException("Erro na linha {$linha}: A variável '{$nomeVariavel}' não é do tipo 'NUM'.");
        }
    }

    private function verificarVariavelIniciada(AnalisadorSemantico $analisadorSemantico, Token $variavel) : void
    {
        $nomeVariavel = $variavel->getLexeme();

        if(!$analisadorSemantico->getVariaveis()->getVariavel($nomeVariavel)->iniciada()) {
            $linha = $variavel->getPosition()->getStartLine();
            $analisadorSemantico->newSemanticException("Erro na linha {$linha}: A variável '{$nomeVariavel}' não foi iniciada.");
        }
    }
}