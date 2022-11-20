<?php

namespace HenriqueBS0\Compiler\EstruturasAnalise\ElementosArvoreSintatica;

use HenriqueBS0\LexicalAnalyzer\Token;
use HenriqueBS0\SyntacticAnalyzer\SLR\Tree\Node;

class OperacaoAritimetica extends Node {
    private array $simbolos = [];

    public function addSimbolo(Token|OperadorAritimetico $simbolo) : void
    {
        $this->simbolos[] = $simbolo;
    }

    public function getSimbolos() : array
    {
        return $this->simbolos;
    }

    public function setOperacaoAritimetica(OperacaoAritimetica $operacaoAritimetica) : void
    {
        foreach ($operacaoAritimetica->getSimbolos() as $simbolo) {
            $this->addSimbolo($simbolo);
        }
    }
}