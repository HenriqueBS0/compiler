<?php

namespace HenriqueBS0\Compiler\EstruturasAnalise\AnaliseSemantica;

class Funcoes {
    /**
     * @var Funcao[]
     */
    private array $funcoes = [];

    
    public function addFuncao(Funcao $funcao) : void 
    {
        $this->funcoes[$funcao->getNome()] = $funcao;
    }

    public function funcaoExiste(string $nome) : bool 
    {
        return isset($this->funcoes[$nome]);
    }

    public function getFuncao(string $nome) :  Funcao
    {
        return $this->funcoes[$nome];
    }
}