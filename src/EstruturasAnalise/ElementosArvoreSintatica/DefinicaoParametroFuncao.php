<?php

namespace HenriqueBS0\Compiler\EstruturasAnalise\ElementosArvoreSintatica;

use HenriqueBS0\Compiler\EstruturasAnalise\AnaliseSemantica\AnalisadorSemantico;
use HenriqueBS0\Compiler\EstruturasAnalise\AnaliseSemantica\Variavel;
use HenriqueBS0\LexicalAnalyzer\Token;
use HenriqueBS0\SyntacticAnalyzer\SLR\Semantic\SemanticAnalyzer;
use HenriqueBS0\SyntacticAnalyzer\SLR\Tree\Node;

class DefinicaoParametroFuncao extends Node {
    private Token $tipo;
    private Token $identificador;

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

    public function semanticValidation(SemanticAnalyzer &$semanticAnalyzer): void
    {
        $this->validacaoSemantica($semanticAnalyzer);
    }

    private function validacaoSemantica(AnalisadorSemantico &$analisadorSemantico) : void
    {
        $variavel = new Variavel();
        $variavel->setNome($this->getIdentificador()->getLexeme());
        $variavel->setTipo($this->getTipo()->getLexeme());

        $analisadorSemantico->getVariaveis()->addVariavel($variavel);
    }
}