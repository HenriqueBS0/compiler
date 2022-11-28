<?php

namespace HenriqueBS0\Compiler\GeracaoAssembly;

class ControladorFuncoes {

    private string $funcaoAtual = "";

    private int $indiceNumeros = 0;
    private int $indiceCadeias = 0;
    private int $indiceBoleanos = 0;

    private array $funcoes = [];

    public function addFuncao(Funcao $funcao) : self
    {
        $this->funcoes[$funcao->getNome()] = $funcao;

        return $this;
    }

    public function setFuncao(string $funcao) : self
    {
        $this->funcaoAtual = $funcao;
        return $this;
    }

    public function getFuncao() : Funcao
    {
        return $this->funcoes[$this->funcaoAtual];
    }

    public function addVariavel(Variavel $variavel) : self
    {
        $variavel->setIndice($this->getIndiceVariavel($variavel));
        
        $this->getFuncao()->addVariavel($variavel);

        return $this;
    } 

    public function getVariavel(string $nome) : Variavel
    {
        return $this->getFuncao()->getVariavel($nome);
    }

    private function getIndiceVariavel(Variavel $variavel) : int
    {
        $indice = 0;

        if($variavel->getTipo() === 'NUM') {
            $indice = $this->indiceNumeros;
            $this->indiceNumeros++;
        }

        if($variavel->getTipo() === 'STR') {
            $indice = $this->indiceCadeias;
            $this->indiceCadeias++;
        }

        if($variavel->getTipo() === 'BOOL') {
            $indice = $this->indiceBoleanos;
            $this->indiceBoleanos++;
        }

        return $indice;
    }
}