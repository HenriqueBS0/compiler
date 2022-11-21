<?php

namespace HenriqueBS0\Compiler\EstruturasAnalise\AnaliseSemantica;

class Variavel {
    private string $nome;
    private string $tipo;
    private bool   $iniciada = false;

    public function getNome(): string
    {
        return $this->nome;
    }

    public function setNome(string $nome): self
    {
        $this->nome = $nome;

        return $this;
    }

    public function getTipo(): string
    {
        return $this->tipo;
    }

    public function setTipo(string $tipo) : self
    {
        $this->tipo = $tipo;

        return $this;
    }

    public function setIniciada() : self
    {
        $this->iniciada = true;
        return $this;
    }

    public function iniciada() : bool
    {
        return $this->iniciada;
    }
}