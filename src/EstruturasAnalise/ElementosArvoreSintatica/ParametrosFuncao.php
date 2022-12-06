<?php

namespace HenriqueBS0\Compiler\EstruturasAnalise\ElementosArvoreSintatica;

use HenriqueBS0\LexicalAnalyzer\Token;
use HenriqueBS0\SyntacticAnalyzer\SLR\Tree\Node;

class ParametrosFuncao extends Node {
    private array $identificadores = [];
    private array $virgulas = [];

    public function addIdentificador(Token $identificador) : void
    {
        $this->identificadores[] = $identificador;
    }

    public function getIdentificadores() : array
    {
        return $this->identificadores;
    }

    public function addVirgula(Token $virgula) : void
    {
        $this->virgulas[] = $virgula;
    }

    public function getVirgulas() : array
    {
        return $this->virgulas;
    }

    public function setParametrosFuncao(ParametrosFuncao $parametrosFuncao) {
        foreach ($parametrosFuncao->getIdentificadores() as $identificador) {
            $this->addIdentificador($identificador);
        }

        foreach ($parametrosFuncao->getVirgulas() as $virgula) {
            $this->addVirgula($virgula);
        }
    }
}