<?php

namespace HenriqueBS0\Compiler\EstruturasAnalise\ElementosArvoreSintatica;

use HenriqueBS0\LexicalAnalyzer\Token;
use HenriqueBS0\SyntacticAnalyzer\SLR\Tree\Node;

class ChamadaFuncao extends Node {
    private Token $identificador;
    private Token $abreParenteses;
    private ParametrosFuncao $parametrosFuncao;
    private Token $fechaParenteses;
    private Token $pontoVirgula;

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
     * Get the value of parametrosFuncao
     */
    public function getParametrosFuncao(): ParametrosFuncao
    {
        return $this->parametrosFuncao;
    }

    /**
     * Set the value of parametrosFuncao
     */
    public function setParametrosFuncao(ParametrosFuncao $parametrosFuncao): self
    {
        $this->parametrosFuncao = $parametrosFuncao;

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
}