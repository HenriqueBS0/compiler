<?php

namespace HenriqueBS0\Compiler\EstruturasAnalise\ElementosArvoreSintatica;

use HenriqueBS0\Compiler\EstruturasAnalise\AnaliseSemantica\AnalisadorSemantico;
use HenriqueBS0\LexicalAnalyzer\Token;
use HenriqueBS0\SyntacticAnalyzer\SLR\Semantic\SemanticAnalyzer;
use HenriqueBS0\SyntacticAnalyzer\SLR\Tree\Node;

class BlocoCodigo extends Node {
    private Token $abreChaves;
    private ListaComandos $listaComandos;
    private Token $fechaChaves;

    /**
     * Get the value of abreChaves
     */
    public function getAbreChaves(): Token
    {
        return $this->abreChaves;
    }

    /**
     * Set the value of abreChaves
     */
    public function setAbreChaves(Token $abreChaves): self
    {
        $this->abreChaves = $abreChaves;

        return $this;
    }

    /**
     * Get the value of listaComandos
     */
    public function getListaComandos(): ListaComandos
    {
        return $this->listaComandos;
    }

    /**
     * Set the value of listaComandos
     */
    public function setListaComandos(ListaComandos $listaComandos): self
    {
        $this->listaComandos = $listaComandos;

        return $this;
    }

    /**
     * Get the value of fechaChaves
     */
    public function getFechaChaves(): Token
    {
        return $this->fechaChaves;
    }

    /**
     * Set the value of fechaChaves
     */
    public function setFechaChaves(Token $fechaChaves): self
    {
        $this->fechaChaves = $fechaChaves;

        return $this;
    }

    public function semanticValidation(SemanticAnalyzer &$semanticAnalyzer): void
    {
        $this->validacaoSemantica($semanticAnalyzer);
    }

    public function validacaoSemantica(AnalisadorSemantico &$analisadorSemantico): void
    {
        /** @var Comando */
        foreach ($this->getListaComandos()->getListaComandos() as $comando) {
            if(!is_null($comando->getDeclaracaoVariavel())) {
                $nomeVariavelDeclarada = $comando->getDeclaracaoVariavel()->getIdentificador()->getLexeme();

                if(!$analisadorSemantico->getVariaveis()->getVariavel($nomeVariavelDeclarada)->iniciada()) {
                    $linha =  $comando->getDeclaracaoVariavel()->getIdentificador()->getPosition()->getStartLine();
                    $analisadorSemantico->newSemanticException("Erro na linha {$linha}: Variável '{$nomeVariavelDeclarada}' não utilizada.");
                }

                $analisadorSemantico->getVariaveis()->removerVariavel($nomeVariavelDeclarada);
            }
        }
    }
}