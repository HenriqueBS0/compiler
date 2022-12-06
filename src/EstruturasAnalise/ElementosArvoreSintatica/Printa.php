<?php

namespace HenriqueBS0\Compiler\EstruturasAnalise\ElementosArvoreSintatica;

use HenriqueBS0\Compiler\EstruturasAnalise\AnaliseSemantica\AnalisadorSemantico;
use HenriqueBS0\LexicalAnalyzer\Token;
use HenriqueBS0\SyntacticAnalyzer\SLR\Semantic\SemanticAnalyzer;
use HenriqueBS0\SyntacticAnalyzer\SLR\Tree\Node;

class Printa extends Node {
    private Token $print;
    private Token $abreParenteses;
    private Token $identificador;
    private Token $fechaParenteses;
    private Token $pontoVirgula;

    /**
     * Get the value of print
     */
    public function getPrint(): Token
    {
        return $this->print;
    }

    /**
     * Set the value of print
     */
    public function setPrint(Token $print): self
    {
        $this->print = $print;

        return $this;
    }

    /**
     * Get the value of abreParenteses
     */
    public function getAbreParenteses(): Token
    {
        return $this->abreParenteses;
    }

    /**
     * Set the value of abreParenteses
     */
    public function setAbreParenteses(Token $abreParenteses): self
    {
        $this->abreParenteses = $abreParenteses;

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
     * Get the value of fechaParenteses
     */
    public function getFechaParenteses(): Token
    {
        return $this->fechaParenteses;
    }

    /**
     * Set the value of fechaParenteses
     */
    public function setFechaParenteses(Token $fechaParenteses): self
    {
        $this->fechaParenteses = $fechaParenteses;

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

    public function semanticValidation(SemanticAnalyzer &$semanticAnalyzer) : void
    {
        $this->validacaoSemantica($semanticAnalyzer);
    }

    private function validacaoSemantica(AnalisadorSemantico $analisadorSemantico) : void 
    {
        $this->verificarVariavelDeclarada($analisadorSemantico);
        $this->verificarVariavelIniciada($analisadorSemantico);
    }

    private function verificarVariavelDeclarada(AnalisadorSemantico $analisadorSemantico) : void
    {
        $nomeVariavel = $this->getIdentificador()->getLexeme();
        
        if(!$analisadorSemantico->getVariaveis()->existeVariavel($nomeVariavel)) {
            $linha = $this->getIdentificador()->getPosition()->getStartLine();
            $analisadorSemantico->newSemanticException("Erro na linha {$linha}: A variável '{$nomeVariavel}' não foi declarada.");
        }
    }

    private function verificarVariavelIniciada(AnalisadorSemantico $analisadorSemantico) : void
    {
        $nomeVariavel = $this->getIdentificador()->getLexeme();
        
        if(!$analisadorSemantico->getVariaveis()->getVariavel($nomeVariavel)->iniciada()) {
            $linha = $this->getIdentificador()->getPosition()->getStartLine();
            $analisadorSemantico->newSemanticException("Erro na linha {$linha}: A variável '{$nomeVariavel}' não foi iniciada.");
        }
    }
}