<?php

namespace HenriqueBS0\Compiler\EstruturasAnalise\ElementosArvoreSintatica;

use HenriqueBS0\Compiler\EstruturasAnalise\AnaliseSemantica\AnalisadorSemantico;
use HenriqueBS0\LexicalAnalyzer\Token;
use HenriqueBS0\SyntacticAnalyzer\SLR\Semantic\SemanticAnalyzer;
use HenriqueBS0\SyntacticAnalyzer\SLR\Tree\Node;

class ComparacaoIgualdade extends Node {
    private array $simbolos = [];

    public function addSimbolo(Token|OperadorComparacaoIgualdade $simbolo) : void
    {
        $this->simbolos[] = $simbolo;
    }

    public function getSimbolos() : array
    {
        return $this->simbolos;
    }

    public function semanticValidation(SemanticAnalyzer &$semanticAnalyzer): void
    {
        $this->validacaoSemantica($semanticAnalyzer);
    }

    private function validacaoSemantica(AnalisadorSemantico $analisadorSemantico) : void
    {
        $this->validarVariaveis($analisadorSemantico);
        $this->validarTiposIguais($analisadorSemantico);
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
        $this->verificaVariavelDeclarada($analisadorSemantico, $variavel);
        $this->verificaVariavelIniciada($analisadorSemantico, $variavel);
    }

    private function verificaVariavelDeclarada(AnalisadorSemantico $analisadorSemantico, Token $variavel) : void
    {
        $nomeVariavel = $variavel->getLexeme();

        if(!$analisadorSemantico->getVariaveis()->existeVariavel($nomeVariavel)) {
            $linha = $variavel->getPosition()->getStartLine();
            $analisadorSemantico->newSemanticException("Erro na linha {$linha}: A variável '{$nomeVariavel}' não foi declarada.");
        }
    }

    private function verificaVariavelIniciada(AnalisadorSemantico $analisadorSemantico, Token $variavel) : void
    {
        $nomeVariavel = $variavel->getLexeme();

        if(!$analisadorSemantico->getVariaveis()->getVariavel($nomeVariavel)->iniciada()) {
            $linha = $variavel->getPosition()->getStartLine();
            $analisadorSemantico->newSemanticException("Erro na linha {$linha}: A variável '{$nomeVariavel}' não foi iniciada.");
        }
    }

    public function validarTiposIguais(AnalisadorSemantico $analisadorSemantico) : void
    {
        $tipoPrimeiroOperando = $this->getTipoPrimeiroOperando($analisadorSemantico);
        $tipSegundoOperando = $this->getTipoSegundoOperando($analisadorSemantico);
        
        if($tipoPrimeiroOperando !== $tipSegundoOperando) {
            /** @var Token */
            $primeiroOperando = $this->getSimbolos()[0];

            $linha = $primeiroOperando->getPosition()->getStartLine();

            $analisadorSemantico->newSemanticException("Erro na linha {$linha}: Comparação de igualdade inválida, operandos de tipos diferentes, '{$tipoPrimeiroOperando}' e '{$tipSegundoOperando}'.");
        }
    }

    public function getTipoPrimeiroOperando(AnalisadorSemantico $analisadorSemantico) : string
    {
        return $this->getTipoOperando($analisadorSemantico, $this->getSimbolos()[2]);
    } 

    public function getTipoSegundoOperando(AnalisadorSemantico $analisadorSemantico) : string
    {
        return $this->getTipoOperando($analisadorSemantico, $this->getSimbolos()[0]);
    }

    public function getTipoOperando(AnalisadorSemantico $analisadorSemantico, Token $operando) : string
    {
        if($operando->getToken() === 'CADEIA') {
            return 'STR';
        }

        if($operando->getToken() === 'CONSTANTE') {
            return 'NUM';
        }

        return $analisadorSemantico->getVariaveis()->getVariavel($operando->getLexeme())->getTipo();
    }
}