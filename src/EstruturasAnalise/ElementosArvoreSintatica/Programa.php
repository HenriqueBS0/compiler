<?php

namespace HenriqueBS0\Compiler\EstruturasAnalise\ElementosArvoreSintatica;

use HenriqueBS0\SyntacticAnalyzer\SLR\Semantic\SemanticAnalyzer;
use HenriqueBS0\SyntacticAnalyzer\SLR\Tree\Node;

class Programa extends Node {
    private DefinicaoFuncoes $definicaoFuncoes;
    private Execucao $execucao;

    /**
     * Get the value of definicaoFuncoes
     */
    public function getDefinicaoFuncoes(): DefinicaoFuncoes
    {
        return $this->definicaoFuncoes;
    }

    /**
     * Set the value of definicaoFuncoes
     */
    public function setDefinicaoFuncoes(DefinicaoFuncoes $definicaoFuncoes): self
    {
        $this->definicaoFuncoes = $definicaoFuncoes;

        return $this;
    }

    /**
     * Get the value of execucao
     */
    public function getExecucao(): Execucao
    {
        return $this->execucao;
    }

    /**
     * Set the value of execucao
     */
    public function setExecucao(Execucao $execucao): self
    {
        $this->execucao = $execucao;

        return $this;
    }

    public function semanticValidation(SemanticAnalyzer &$semanticAnalyzer): void
    {
        var_dump($semanticAnalyzer);
    }
}