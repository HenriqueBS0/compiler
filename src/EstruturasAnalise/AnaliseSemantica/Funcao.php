<?php

namespace HenriqueBS0\Compiler\EstruturasAnalise\AnaliseSemantica;

class Funcao {
    private string $nome;
    private array $tiposParametros = [];

    public function getNome(): string
    {
        return $this->nome;
    }

    public function setNome(string $nome): self
    {
        $this->nome = $nome;

        return $this;
    }

    public function addTipoParametros(string $tipo) : self
    {
        $this->tiposParametros[] = $tipo;

        return $this;
    }

    public function getTiposParametros() : array
    {
        return $this->tiposParametros;
    }
}