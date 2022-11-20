<?php

namespace HenriqueBS0\Compiler\EstruturasAnalise\ElementosArvoreSintatica;

use HenriqueBS0\LexicalAnalyzer\Token;
use HenriqueBS0\SyntacticAnalyzer\SLR\Tree\Node;

class DefinicaoParametrosFuncao extends Node {
    private array $definicaoParametrosFuncao = [];
    private array $virgulas = [];


    public function addDefinicaoParametroFuncao(DefinicaoParametroFuncao $definicaoFuncao) : void
    {
        $this->definicaoParametrosFuncao[] = $definicaoFuncao;
    }

    public function getDefinicaoParametrosFuncao() : array
    {
        return $this->definicaoParametrosFuncao;
    }

    public function addVirgula(Token $virgula) : void
    {
        $this->virgulas[] = $virgula;
    }

    public function getVirgulas() : array
    {
        return $this->virgulas;
    }

    public function setDefinicaoParametrosFuncao(DefinicaoParametrosFuncao $definicaoParametrosFuncao) : void
    {
        foreach ($definicaoParametrosFuncao->getDefinicaoParametrosFuncao() as $definicaoParametroFuncao) {
            $this->addDefinicaoParametroFuncao($definicaoParametroFuncao);
        }

        foreach ($definicaoParametrosFuncao->getVirgulas() as $virgula) {
            $this->addVirgula($virgula);
        }
    }
}