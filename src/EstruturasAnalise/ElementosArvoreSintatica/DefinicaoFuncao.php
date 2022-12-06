<?php

namespace HenriqueBS0\Compiler\EstruturasAnalise\ElementosArvoreSintatica;

use HenriqueBS0\Compiler\EstruturasAnalise\AnaliseSemantica\AnalisadorSemantico;
use HenriqueBS0\Compiler\EstruturasAnalise\AnaliseSemantica\Funcao;
use HenriqueBS0\LexicalAnalyzer\Token;
use HenriqueBS0\SyntacticAnalyzer\SLR\Semantic\SemanticAnalyzer;
use HenriqueBS0\SyntacticAnalyzer\SLR\Tree\Node;

class DefinicaoFuncao extends Node {
    private Token $function;
    private Token $identificador;
    private Token $abreParenteses;
    private ?DefinicaoParametrosFuncao $definicaoParametrosFuncao = null;
    private Token $fechaParenteses;
    private BlocoCodigo $blocoCodigo;

    

    /**
     * Get the value of function
     */
    public function getFunction(): Token
    {
        return $this->function;
    }

    /**
     * Set the value of function
     */
    public function setFunction(Token $function): self
    {
        $this->function = $function;

        return $this;
    }

    /**
     * Get the value of identificador
     */
    public function getIdentificador(): Token
    {
        return $this->identificador;
    }

    /**
     * Set the value of identificador
     */
    public function setIdentificador(Token $identificador): self
    {
        $this->identificador = $identificador;

        return $this;
    }

    /**
     * Get the value of abreParenteses
     */
    public function getAbreParenteses(): Token
    {
        return $this->abreParenteses;
    }

    /**
     * Set the value of abreParenteses
     */
    public function setAbreParenteses(Token $abreParenteses): self
    {
        $this->abreParenteses = $abreParenteses;

        return $this;
    }

    /**
     * Get the value of definicaoParametrosFuncao
     */
    public function getDefinicaoParametrosFuncao(): ?DefinicaoParametrosFuncao
    {
        return $this->definicaoParametrosFuncao;
    }

    /**
     * Set the value of definicaoParametrosFuncao
     */
    public function setDefinicaoParametrosFuncao(DefinicaoParametrosFuncao $definicaoParametrosFuncao): self
    {
        $this->definicaoParametrosFuncao = $definicaoParametrosFuncao;

        return $this;
    }

    /**
     * Get the value of fechaParenteses
     */
    public function getFechaParenteses(): Token
    {
        return $this->fechaParenteses;
    }

    /**
     * Set the value of fechaParenteses
     */
    public function setFechaParenteses(Token $fechaParenteses): self
    {
        $this->fechaParenteses = $fechaParenteses;

        return $this;
    }

    /**
     * Get the value of blocoCodigo
     */
    public function getBlocoCodigo(): BlocoCodigo
    {
        return $this->blocoCodigo;
    }

    /**
     * Set the value of blocoCodigo
     */
    public function setBlocoCodigo(BlocoCodigo $blocoCodigo): self
    {
        $this->blocoCodigo = $blocoCodigo;

        return $this;
    }

    public function semanticValidation(SemanticAnalyzer &$semanticAnalyzer): void
    {
        $this->validacaoSemantica($semanticAnalyzer);
    }

    public function validacaoSemantica(AnalisadorSemantico &$analisadorSemantico) : void
    {
        $this->adicionarFuncao($analisadorSemantico);
        $this->removerParametrosListaVariaveis($analisadorSemantico);
    }

    public function adicionarFuncao(AnalisadorSemantico &$analisadorSemantico) : void
    {
        $funcao = new Funcao(); 
        $funcao->setNome($this->getIdentificador()->getLexeme());

        if(!is_null($this->getDefinicaoParametrosFuncao())) {
            
            /** @var DefinicaoParametroFuncao */
            foreach (array_reverse($this->getDefinicaoParametrosFuncao()->getDefinicaoParametrosFuncao()) as $definicaoParametroFuncao) {
                $funcao->addTipoParametros($definicaoParametroFuncao->getTipo()->getLexeme());
            }
        }

        $analisadorSemantico->getFuncoes()->addFuncao($funcao);
    }

    public function removerParametrosListaVariaveis(AnalisadorSemantico &$analisadorSemantico): void
    {
        if(is_null($this->getDefinicaoParametrosFuncao())) {
            return;
        }

        /** @var DefinicaoParametroFuncao */
        foreach (array_reverse($this->getDefinicaoParametrosFuncao()->getDefinicaoParametrosFuncao()) as $definicaoParametroFuncao) {
            $nomeParametro = $definicaoParametroFuncao->getIdentificador()->getLexeme();
            $analisadorSemantico->getVariaveis()->removerVariavel($nomeParametro);
        }
    }
}