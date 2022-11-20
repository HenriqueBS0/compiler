<?php

namespace HenriqueBS0\Compiler\EstruturasAnalise\ElementosArvoreSintatica;

use HenriqueBS0\LexicalAnalyzer\Token;
use HenriqueBS0\SyntacticAnalyzer\SLR\Tree\Node;

class Concatenacao extends Node {
    private array $simbolos = [];

    public function addSimbolo(Token $simbolo) : void
    {
        $this->simbolos[] = $simbolo;
    }

    public function getSimbolos() : array
    {
        return $this->simbolos;
    }

    public function setConcatenacao(Concatenacao $concatenacao) : void
    {
        foreach ($concatenacao->getSimbolos() as $simbolo) {
            $this->addSimbolo($simbolo);
        }
    }
}