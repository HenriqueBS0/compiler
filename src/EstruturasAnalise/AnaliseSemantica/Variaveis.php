<?php

namespace HenriqueBS0\Compiler\EstruturasAnalise\AnaliseSemantica;

class Variaveis {
    private array $variaveis = [];

    public function addVariavel(Variavel $variavel) : self
    {
        $this->variaveis[$variavel->getNome()] = $variavel;
        return $this;
    }

    public function getVariavel(string $nome) : Variavel
    {
        return $this->variaveis[$nome];
    }

    public function existeVariavel(string $nome) : bool
    {
        return isset($this->variaveis[$nome]);
    }

    public function removerVariavel(string $nome) : self 
    {
        $this->variaveis = array_filter($this->variaveis, function(Variavel $variavel) use($nome) {return $variavel->getNome() !== $nome;});
        return $this;
    }
} 