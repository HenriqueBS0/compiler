<?php

namespace HenriqueBS0\Compiler\EstruturasAnalise\ElementosArvoreSintatica;

use HenriqueBS0\SyntacticAnalyzer\SLR\Tree\Node;

class Comando extends Node {
    private ?DeclaracaoVariavel $declaracaoVariavel = null;
    private ChamadaFuncao $chamadaFuncao;
    private Atribuicao $atribuicao;
    private Printa $printa;
    private Se $se;
    private Enquanto $enquanto;

    

    /**
     * Get the value of declaracaoVariavel
     */
    public function getDeclaracaoVariavel(): ?DeclaracaoVariavel
    {
        return $this->declaracaoVariavel;
    }

    /**
     * Set the value of declaracaoVariavel
     */
    public function setDeclaracaoVariavel(DeclaracaoVariavel $declaracaoVariavel): self
    {
        $this->declaracaoVariavel = $declaracaoVariavel;

        return $this;
    }

    /**
     * Get the value of chamadaFuncao
     */
    public function getChamadaFuncao(): ChamadaFuncao
    {
        return $this->chamadaFuncao;
    }

    /**
     * Set the value of chamadaFuncao
     */
    public function setChamadaFuncao(ChamadaFuncao $chamadaFuncao): self
    {
        $this->chamadaFuncao = $chamadaFuncao;

        return $this;
    }

    /**
     * Get the value of atribuicao
     */
    public function getAtribuicao(): Atribuicao
    {
        return $this->atribuicao;
    }

    /**
     * Set the value of atribuicao
     */
    public function setAtribuicao(Atribuicao $atribuicao): self
    {
        $this->atribuicao = $atribuicao;

        return $this;
    }

    /**
     * Get the value of printa
     */
    public function getPrinta(): Printa
    {
        return $this->printa;
    }

    /**
     * Set the value of printa
     */
    public function setPrinta(Printa $printa): self
    {
        $this->printa = $printa;

        return $this;
    }

    /**
     * Get the value of se
     */
    public function getSe(): Se
    {
        return $this->se;
    }

    /**
     * Set the value of se
     */
    public function setSe(Se $se): self
    {
        $this->se = $se;

        return $this;
    }

    /**
     * Get the value of enquanto
     */
    public function getEnquanto(): Enquanto
    {
        return $this->enquanto;
    }

    /**
     * Set the value of enquanto
     */
    public function setEnquanto(Enquanto $enquanto): self
    {
        $this->enquanto = $enquanto;

        return $this;
    }
}