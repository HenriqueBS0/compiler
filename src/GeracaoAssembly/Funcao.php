<?php

namespace HenriqueBS0\Compiler\GeracaoAssembly;

use HenriqueBS0\Compiler\EstruturasAnalise\ElementosArvoreSintatica\DefinicaoFuncao;
use HenriqueBS0\Compiler\EstruturasAnalise\ElementosArvoreSintatica\ListaComandos;

class Funcao {
    private string $nome;
    private array $variaveis = [];
    private array $parametros = [];
    public ListaComandos $listaComandos;

    public function addVariavel(Variavel $variavel, bool $parametro = false) : self
    {
        $this->variaveis[$variavel->getNome()] = $variavel;
        
        if($parametro) {
            $this->parametros[] = $variavel->getNome();
        }
        
        return $this;
    }

    public function getVariavel(string $nome) : Variavel
    {
        return $this->variaveis[$nome];
    }

    public function getVariaveis() : array
    {
        return $this->variaveis;
    }

    public function getParametros() : array
    {
        return $this->parametros;
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