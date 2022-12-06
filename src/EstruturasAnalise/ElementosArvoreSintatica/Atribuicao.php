<?php

namespace HenriqueBS0\Compiler\EstruturasAnalise\ElementosArvoreSintatica;

use HenriqueBS0\Compiler\EstruturasAnalise\AnaliseSemantica\AnalisadorSemantico;
use HenriqueBS0\LexicalAnalyzer\Token;
use HenriqueBS0\SyntacticAnalyzer\SLR\Semantic\SemanticAnalyzer;
use HenriqueBS0\SyntacticAnalyzer\SLR\Tree\Node;

class Atribuicao extends Node
{
    private ?Token $identificador = null;
    private Token $recebe;
    private ?Token $constante = null;
    private ?Token $not = null;
    private ?Token $identificadorValor = null;
    private ?Token $cadeia = null;
    private ?Token $true = null;
    private ?Token $false = null;
    private ?OperacaoAritimetica $operacaoAritimetica = null;
    private ?Concatenacao $concatenacao = null;
    private ?ComparacaoQuantitativa $comparacaoQuantitativa = null;
    private ?ComparacaoIgualdade $comparacaoIgualdade = null;
    private ?OperacaoLogicaAnd $operacaoLogicaAnd = null;
    private ?OperacaoLogicaOr $operacaoLogicaOr = null;
    private Token $pontoVirgula;

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
        if(!is_null($this->identificador)) {
            $this->identificadorValor = $this->identificador;
        }

        $this->identificador = $identificador;

        return $this;
    }

    /**
     * Get the value of recebe
     */
    public function getRecebe(): Token
    {
        return $this->recebe;
    }

    /**
     * Set the value of recebe
     */
    public function setRecebe(Token $recebe): self
    {
        $this->recebe = $recebe;

        return $this;
    }

    /**
     * Get the value of constante
     */
    public function getConstante(): ?Token
    {
        return $this->constante;
    }

    /**
     * Set the value of constante
     */
    public function setConstante(Token $constante): self
    {
        $this->constante = $constante;

        return $this;
    }

    /**
     * Get the value of not
     */
    public function getNot(): ?Token
    {
        return $this->not;
    }

    /**
     * Set the value of not
     */
    public function setNot(Token $not): self
    {
        $this->not = $not;

        return $this;
    }

    /**
     * Get the value of identificadorValor
     */
    public function getIdentificadorValor(): ?Token
    {
        return $this->identificadorValor;
    }

    /**
     * Get the value of cadeia
     */
    public function getCadeia(): ?Token
    {
        return $this->cadeia;
    }

    /**
     * Set the value of cadeia
     */
    public function setCadeia(Token $cadeia): self
    {
        $this->cadeia = $cadeia;

        return $this;
    }

    /**
     * Get the value of true
     */
    public function getTrue(): ?Token
    {
        return $this->true;
    }

    /**
     * Set the value of true
     */
    public function setTrue(Token $true): self
    {
        $this->true = $true;

        return $this;
    }

    /**
     * Get the value of false
     */
    public function getFalse(): ?Token
    {
        return $this->false;
    }

    /**
     * Set the value of false
     */
    public function setFalse(Token $false): self
    {
        $this->false = $false;

        return $this;
    }

    /**
     * Get the value of operacaoAritimetica
     */
    public function getOperacaoAritimetica(): ?OperacaoAritimetica
    {
        return $this->operacaoAritimetica;
    }

    /**
     * Set the value of operacaoAritimetica
     */
    public function setOperacaoAritimetica(OperacaoAritimetica $operacaoAritimetica): self
    {
        $this->operacaoAritimetica = $operacaoAritimetica;

        return $this;
    }

    /**
     * Get the value of concatenacao
     */
    public function getConcatenacao(): ?Concatenacao
    {
        return $this->concatenacao;
    }

    /**
     * Set the value of concatenacao
     */
    public function setConcatenacao(Concatenacao $concatenacao): self
    {
        $this->concatenacao = $concatenacao;

        return $this;
    }

    /**
     * Get the value of comparacaoQuantitativa
     */
    public function getComparacaoQuantitativa(): ?ComparacaoQuantitativa
    {
        return $this->comparacaoQuantitativa;
    }

    /**
     * Set the value of comparacaoQuantitativa
     */
    public function setComparacaoQuantitativa(ComparacaoQuantitativa $comparacaoQuantitativa): self
    {
        $this->comparacaoQuantitativa = $comparacaoQuantitativa;

        return $this;
    }

    /**
     * Get the value of comparacaoIgualdade
     */
    public function getComparacaoIgualdade(): ?ComparacaoIgualdade
    {
        return $this->comparacaoIgualdade;
    }

    /**
     * Set the value of comparacaoIgualdade
     */
    public function setComparacaoIgualdade(ComparacaoIgualdade $comparacaoIgualdade): self
    {
        $this->comparacaoIgualdade = $comparacaoIgualdade;

        return $this;
    }

    /**
     * Get the value of operacaoLogicaAnd
     */
    public function getOperacaoLogicaAnd(): ?OperacaoLogicaAnd
    {
        return $this->operacaoLogicaAnd;
    }

    /**
     * Set the value of operacaoLogicaAnd
     */
    public function setOperacaoLogicaAnd(OperacaoLogicaAnd $operacaoLogicaAnd): self
    {
        $this->operacaoLogicaAnd = $operacaoLogicaAnd;

        return $this;
    }

    /**
     * Get the value of operacaoLogicaOr
     */
    public function getOperacaoLogicaOr(): ?OperacaoLogicaOr
    {
        return $this->operacaoLogicaOr;
    }

    /**
     * Set the value of operacaoLogicaOr
     */
    public function setOperacaoLogicaOr(OperacaoLogicaOr $operacaoLogicaOr): self
    {
        $this->operacaoLogicaOr = $operacaoLogicaOr;

        return $this;
    }

    /**
     * Get the value of pontoVirgula
     */
    public function getPontoVirgula(): Token
    {
        return $this->pontoVirgula;
    }

    /**
     * Set the value of pontoVirgula
     */
    public function setPontoVirgula(Token $pontoVirgula): self
    {
        $this->pontoVirgula = $pontoVirgula;

        return $this;
    }

    public function semanticValidation(SemanticAnalyzer &$semanticAnalyzer): void
    {
        $this->validacaoSemantica($semanticAnalyzer);
    }

    private function validacaoSemantica(AnalisadorSemantico &$analisadorSemantico) : void
    {
        $this->verificarVariavelDeclarada($analisadorSemantico);
        $this->vericarVariavelValor($analisadorSemantico);
        $this->validarOperacaoLogicaNot($analisadorSemantico);
        $this->verificacaoTipo($analisadorSemantico);

        $analisadorSemantico->getVariaveis()->getVariavel($this->getIdentificador()->getLexeme())->setIniciada();
    }

    private function verificarVariavelDeclarada(AnalisadorSemantico $analisadorSemantico) : void 
    {
        $nomeVariavel = $this->getIdentificador()->getLexeme();

        if($analisadorSemantico->getVariaveis()->existeVariavel($nomeVariavel)) {
            return;
        }

        $linha = $this->getIdentificador()->getPosition()->getStartLine();

        $analisadorSemantico->newSemanticException("Erro na linha {$linha}: A variável '{$nomeVariavel}' não foi declarada.");
    }

    private function vericarVariavelValor(AnalisadorSemantico $analisadorSemantico) : void
    {
        if(is_null($this->getIdentificadorValor())) {
            return;
        }

        $nomeVariavel = $this->getIdentificadorValor()->getLexeme();

        $declarada = $analisadorSemantico->getVariaveis()->existeVariavel($nomeVariavel);

        $linha = $this->getIdentificador()->getPosition()->getStartLine();

        if(!$declarada) {            
            $analisadorSemantico->newSemanticException("Erro na linha {$linha}: A variável '{$nomeVariavel}' não foi declarada.");
        }

        $iniciada = $analisadorSemantico->getVariaveis()->getVariavel($nomeVariavel)->iniciada();

        if(!$iniciada) {            
            $analisadorSemantico->newSemanticException("Erro na linha {$linha}: A variável '{$nomeVariavel}' não foi iniciada.");
        }
        
    }

    private function validarOperacaoLogicaNot(AnalisadorSemantico $analisadorSemantico) : void
    {
        if(is_null($this->getNot())) {
            return;
        }

        $nomeVariavel = $this->getIdentificadorValor()->getLexeme();
        $tipo = $analisadorSemantico->getVariaveis()->getVariavel($nomeVariavel)->getTipo();

        if($tipo !== 'BOOL') {
            $linha = $this->getIdentificadorValor()->getPosition()->getStartLine();
            $analisadorSemantico->newSemanticException("Erro na linha {$linha}: A variável '{$nomeVariavel}' não é do tipo 'BOOL'.");
        }
    }

    private function verificacaoTipo(AnalisadorSemantico $analisadorSemantico) : void
    {
        $nomeVariavel = $this->getIdentificador()->getLexeme();
        
        $tipoEsperado = $analisadorSemantico->getVariaveis()->getVariavel($nomeVariavel)->getTipo();

        $tipoAtribuido = $this->getTipoAtribuido($analisadorSemantico);

        if($tipoEsperado !== $tipoAtribuido) {
            $linha = $this->getIdentificador()->getPosition()->getStartLine();
            $analisadorSemantico->newSemanticException("Erro na linha {$linha}: A variável '{$nomeVariavel}' é do tipo '{$tipoEsperado}' e está recebendo um valor do tipo '{$tipoAtribuido}'.");
        }

    }

    private function getTipoAtribuido(AnalisadorSemantico $analisadorSemantico) : string
    {
        if(!is_null($this->getConstante())) {
            return 'NUM';
        }

        if(!is_null($this->getNot())) {
            return 'BOOL';
        }
    
        if(!is_null($this->getCadeia())) {
            return 'STR';
        }

        if(!is_null($this->getFalse())) {
            return 'BOOL';
        }

        if(!is_null($this->getTrue())) {
            return 'BOOL';
        }

        if(!is_null($this->getOperacaoAritimetica())) {
            return 'NUM';
        }

        if(!is_null($this->getConcatenacao())) {
            return 'STR';
        }

        if(!is_null($this->getComparacaoQuantitativa())) {
            return 'BOOL';
        }

        if(!is_null($this->getComparacaoIgualdade())) {
            return 'BOOL';
        }

        if(!is_null($this->getOperacaoLogicaAnd())) {
            return 'BOOL';
        }

        if(!is_null($this->getOperacaoLogicaOr())) {
            return 'BOOL';
        }

        if(!is_null($this->getIdentificadorValor())) {
            return $analisadorSemantico->getVariaveis()->getVariavel($this->getIdentificadorValor()->getLexeme())->getTipo();
        }
    }
}

