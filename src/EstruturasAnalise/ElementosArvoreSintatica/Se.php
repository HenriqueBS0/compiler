<?php

namespace HenriqueBS0\Compiler\EstruturasAnalise\ElementosArvoreSintatica;

use HenriqueBS0\LexicalAnalyzer\Token;
use HenriqueBS0\SyntacticAnalyzer\SLR\Tree\Node;

class Se extends Node {
    private Token $if; 
    private Token $abreParenteses; 
    private Token $identificador;
    private Token $fechaParenteses; 
    private BlocoCodigo $blocoCodigo;    

    /**
     * Get the value of if
     */
    public function getIf(): Token
    {
        return $this->if;
    }

    /**
     * Set the value of if
     */
    public function setIf(Token $if): self
    {
        $this->if = $if;

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
     * Get the value of blocoCodigo
     */
    public function getBlocoCodigo(): BlocoCodigo
    {
        return $this->blocoCodigo;
    }

    /**
     * Set the value of blocoCodigo
     */
    public function setBlocoCodigo(BlocoCodigo $blocoCodigo): self
    {
        $this->blocoCodigo = $blocoCodigo;

        return $this;
    }
}