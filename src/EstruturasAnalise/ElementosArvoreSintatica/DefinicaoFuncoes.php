<?php

namespace HenriqueBS0\Compiler\EstruturasAnalise\ElementosArvoreSintatica;

use HenriqueBS0\SyntacticAnalyzer\SLR\Tree\Node;

class DefinicaoFuncoes extends Node {
    private array $definicaoFuncoes = [];

    public function addDefinicaoFuncao(DefinicaoFuncao $definicaoFuncao) : void
    {
        $this->definicaoFuncoes[] = $definicaoFuncao;
    }

    public function getDefinicaoFuncoes() : array
    {
        return $this->definicaoFuncoes;
    }

    public function setDefinicaoFuncoes(DefinicaoFuncoes $definicaoFuncoes) : void
    {
        foreach($definicaoFuncoes->getDefinicaoFuncoes() as $definicaoFuncao) {
            $this->addDefinicaoFuncao($definicaoFuncao);
        }
    }
}