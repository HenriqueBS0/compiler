<?php

namespace HenriqueBS0\Compiler\GeracaoAssembly;

class Variavel {
    private string $nome;
    private string $tipo;
    private ?string $valor = null;
    private int $indice;

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

    /**
     * Get the value of tipo
     */
    public function getTipo(): string
    {
        return $this->tipo;
    }

    /**
     * Set the value of tipo
     */
    public function setTipo(string $tipo): self
    {
        $this->tipo = $tipo;

        return $this;
    }

    /**
     * Get the value of valor
     */
    public function getValor(): ?string
    {
        return $this->valor;
    }

    /**
     * Set the value of valor
     */
    public function setValor(string $valor): self
    {
        if(is_null($this->getValor())) {
            $this->valor = $valor;
        }

        return $this;
    }

    /**
     * Get the value of indice
     */
    public function getIndice(): int
    {
        return $this->indice;
    }

    /**
     * Set the value of indice
     */
    public function setIndice(int $indice): self
    {
        $this->indice = $indice;

        return $this;
    }
}