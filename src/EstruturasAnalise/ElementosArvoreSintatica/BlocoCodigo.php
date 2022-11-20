<?php

namespace HenriqueBS0\Compiler\EstruturasAnalise\ElementosArvoreSintatica;

use HenriqueBS0\LexicalAnalyzer\Token;
use HenriqueBS0\SyntacticAnalyzer\SLR\Tree\Node;

class BlocoCodigo extends Node {
    private Token $abreChaves;
    private ListaComandos $listaComandos;
    private Token $fechaChaves;

    

    /**
     * Get the value of abreChaves
     */
    public function getAbreChaves(): Token
    {
        return $this->abreChaves;
    }

    /**
     * Set the value of abreChaves
     */
    public function setAbreChaves(Token $abreChaves): self
    {
        $this->abreChaves = $abreChaves;

        return $this;
    }

    /**
     * Get the value of listaComandos
     */
    public function getListaComandos(): ListaComandos
    {
        return $this->listaComandos;
    }

    /**
     * Set the value of listaComandos
     */
    public function setListaComandos(ListaComandos $listaComandos): self
    {
        $this->listaComandos = $listaComandos;

        return $this;
    }

    /**
     * Get the value of fechaChaves
     */
    public function getFechaChaves(): Token
    {
        return $this->fechaChaves;
    }

    /**
     * Set the value of fechaChaves
     */
    public function setFechaChaves(Token $fechaChaves): self
    {
        $this->fechaChaves = $fechaChaves;

        return $this;
    }
}