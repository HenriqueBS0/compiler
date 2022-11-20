<?php

namespace HenriqueBS0\Compiler\EstruturasAnalise\ElementosArvoreSintatica;

use HenriqueBS0\LexicalAnalyzer\Token;
use HenriqueBS0\SyntacticAnalyzer\SLR\Tree\Node;

class ComparacaoIgualdade extends Node {
    private array $simbolos = [];

    public function addSimbolo(Token|OperadorComparacaoIgualdade $simbolo) : void
    {
        $this->simbolos[] = $simbolo;
    }

    public function getSimbolos() : array
    {
        return $this->simbolos;
    }
}