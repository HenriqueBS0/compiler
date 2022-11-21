<?php

namespace HenriqueBS0\Compiler\EstruturasAnalise\AnaliseSemantica;

use HenriqueBS0\SyntacticAnalyzer\SLR\Semantic\SemanticAnalyzer;

class AnalisadorSemantico extends SemanticAnalyzer {
    private Funcoes $funcoes;
    private Variaveis $variaveis;

    public function __construct() {
        $this->funcoes = new Funcoes();
        $this->variaveis = new Variaveis();
    }

    public function getFuncoes(): Funcoes
    {
        return $this->funcoes;
    }

    public function getVariaveis(): Variaveis
    {
        return $this->variaveis;
    }
}