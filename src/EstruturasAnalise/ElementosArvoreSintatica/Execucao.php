<?php

namespace HenriqueBS0\Compiler\EstruturasAnalise\ElementosArvoreSintatica;

use HenriqueBS0\LexicalAnalyzer\Token;
use HenriqueBS0\SyntacticAnalyzer\SLR\Tree\Node;

class Execucao extends Node {
    private Token $execute;
    private Token $abreParenteses;
    private Token $fechaParenteses;
    private BlocoCodigo $blocoCodigo;

    

    /**
     * Get the value of execute
     */
    public function getExecute(): Token
    {
        return $this->execute;
    }

    /**
     * Set the value of execute
     */
    public function setExecute(Token $execute): self
    {
        $this->execute = $execute;

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