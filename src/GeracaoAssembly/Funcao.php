<?php

namespace HenriqueBS0\Compiler\GeracaoAssembly;

class Funcao {
    private string $nome;
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

    /**
     * Get the value of nome
     */
    public function getNome(): string
    {
        return $this->nome;
    }

    /**
     * Set the value of nome
     */
    public function setNome(string $nome): self
    {
        $this->nome = $nome;

        return $this;
    }
}