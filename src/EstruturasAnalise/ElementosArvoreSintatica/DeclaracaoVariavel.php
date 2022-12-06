<?php

namespace HenriqueBS0\Compiler\EstruturasAnalise\ElementosArvoreSintatica;

use HenriqueBS0\Compiler\EstruturasAnalise\AnaliseSemantica\AnalisadorSemantico;
use HenriqueBS0\Compiler\EstruturasAnalise\AnaliseSemantica\Variavel;
use HenriqueBS0\LexicalAnalyzer\Token;
use HenriqueBS0\SyntacticAnalyzer\SLR\Semantic\SemanticAnalyzer;
use HenriqueBS0\SyntacticAnalyzer\SLR\Tree\Node;

class DeclaracaoVariavel extends Node {
    private Token $tipo;
    private Token $identificador;
    private Token $pontoVirgula;

    /**
     * Get the value of tipo
     */
    public function getTipo(): Token
    {
        return $this->tipo;
    }

    /**
     * Set the value of tipo
     */
    public function setTipo(Token $tipo): self
    {
        $this->tipo = $tipo;

        return $this;
    }

    /**
     * Get the value of identificador
     */
    public function getIdentificador(): Token
    {
        return $this->identificador;
    }

    /**
     * Set the value of identificador
     */
    public function setIdentificador(Token $identificador): self
    {
        $this->identificador = $identificador;

        return $this;
    }

    /**
     * Get the value of pontoVirgula
     */
    public function getPontoVirgula(): Token
    {
        return $this->pontoVirgula;
    }

    /**
     * Set the value of pontoVirgula
     */
    public function setPontoVirgula(Token $pontoVirgula): self
    {
        $this->pontoVirgula = $pontoVirgula;

        return $this;
    }

    public function semanticValidation(SemanticAnalyzer &$semanticAnalyzer): void
    {
        $this->validacaoSemantica($semanticAnalyzer);
    }

    private function validacaoSemantica(AnalisadorSemantico &$analisadorSemantico) : void
    {
        $nomeVariavel = $this->getIdentificador()->getLexeme();

        if($analisadorSemantico->getVariaveis()->existeVariavel($nomeVariavel)) {
            $linha = $this->getIdentificador()->getPosition()->getStartLine();

            $analisadorSemantico->newSemanticException("Erro na linha {$linha}: A variável '{$nomeVariavel}' já foi declarada.");
        }

        $variavel = new Variavel();
        $variavel->setNome($nomeVariavel);
        $variavel->setTipo($this->getTipo()->getLexeme());

        $analisadorSemantico->getVariaveis()->addVariavel($variavel);
    }
}