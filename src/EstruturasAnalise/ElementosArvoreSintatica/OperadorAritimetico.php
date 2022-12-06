<?php

namespace HenriqueBS0\Compiler\EstruturasAnalise\ElementosArvoreSintatica;

use HenriqueBS0\LexicalAnalyzer\Token;
use HenriqueBS0\SyntacticAnalyzer\SLR\Tree\Node;

class OperadorAritimetico extends Node {
    private Token $operador;

    /**
     * Get the value of operador
     */
    public function getOperador(): Token
    {
        return $this->operador;
    }

    /**
     * Set the value of operador
     */
    public function setOperador(Token $operador): self
    {
        $this->operador = $operador;

        return $this;
    }
}