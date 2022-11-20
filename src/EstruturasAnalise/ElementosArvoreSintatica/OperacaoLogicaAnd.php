<?php

namespace HenriqueBS0\Compiler\EstruturasAnalise\ElementosArvoreSintatica;

use HenriqueBS0\LexicalAnalyzer\Token;
use HenriqueBS0\SyntacticAnalyzer\SLR\Tree\Node;

class OperacaoLogicaAnd extends Node {
    private array $simbolos = [];

    public function addSimbolo(Token $simbolo) : void
    {
        $this->simbolos[] = $simbolo;
    }

    public function getSimbolos() : array
    {
        return $this->simbolos;
    }

    public function setOperacaoLogicaAnd(OperacaoLogicaAnd $operacaoLogicaAnd) : void
    {
        foreach ($operacaoLogicaAnd->getSimbolos() as $simbolo) {
            $this->addSimbolo($simbolo);
        }
    }
}