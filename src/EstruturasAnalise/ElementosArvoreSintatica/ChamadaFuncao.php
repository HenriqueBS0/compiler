<?php

namespace HenriqueBS0\Compiler\EstruturasAnalise\ElementosArvoreSintatica;

use HenriqueBS0\Compiler\EstruturasAnalise\AnaliseSemantica\AnalisadorSemantico;
use HenriqueBS0\LexicalAnalyzer\Token;
use HenriqueBS0\SyntacticAnalyzer\SLR\Semantic\SemanticAnalyzer;
use HenriqueBS0\SyntacticAnalyzer\SLR\Tree\Node;

class ChamadaFuncao extends Node {
    private Token $identificador;
    private Token $abreParenteses;
    private ?ParametrosFuncao $parametrosFuncao = null;
    private Token $fechaParenteses;
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
     * Get the value of parametrosFuncao
     */
    public function getParametrosFuncao(): ?ParametrosFuncao
    {
        return $this->parametrosFuncao;
    }

    /**
     * Set the value of parametrosFuncao
     */
    public function setParametrosFuncao(ParametrosFuncao $parametrosFuncao): self
    {
        $this->parametrosFuncao = $parametrosFuncao;

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

    private function validacaoSemantica(AnalisadorSemantico $analisadorSemantico) : void
    {
        $this->verificarFuncaoDeclarada($analisadorSemantico);
        $this->verificarParametrosFuncao($analisadorSemantico);
    }

    private function verificarFuncaoDeclarada(AnalisadorSemantico $analisadorSemantico) : void
    {
        $nomeFuncao = $this->getIdentificador()->getLexeme(); 

        if(!$analisadorSemantico->getFuncoes()->funcaoExiste($nomeFuncao)) {
            $linha = $this->getIdentificador()->getPosition()->getStartLine();
            $analisadorSemantico->newSemanticException("Erro na linha {$linha}: A função '{$nomeFuncao}' não foi declarada.");
        }
    }

    private function verificarParametrosFuncao(AnalisadorSemantico $analisadorSemantico) : void
    {
        $numeroParametrosEsperados = count($analisadorSemantico->getFuncoes()->getFuncao($this->getIdentificador()->getLexeme())->getTiposParametros());

        if($numeroParametrosEsperados === 0) {
            return;
        }

        $numeroParametrosInformados = !is_null($this->getParametrosFuncao()) ? count($this->getParametrosFuncao()->getIdentificadores()) : 0;

        if($numeroParametrosInformados < $numeroParametrosEsperados) {
            $linha = $this->getIdentificador()->getPosition()->getStartLine();
            $analisadorSemantico->newSemanticException("Erro na linha {$linha}: Parâmetros não informados na chamada da função '{$this->getIdentificador()->getLexeme()}'.");
        }
        else if($numeroParametrosInformados > $numeroParametrosEsperados) {
            $linha = $this->getIdentificador()->getPosition()->getStartLine();
            $analisadorSemantico->newSemanticException("Erro na linha {$linha}: Parâmetros adicionais foram informados na chamada da função '{$this->getIdentificador()->getLexeme()}'.");
        }

        foreach (array_reverse($this->getParametrosFuncao()->getIdentificadores()) as $indice => $parametro) {
            $this->parametroDeclarado($analisadorSemantico, $parametro);
            $this->parametroIniciado($analisadorSemantico, $parametro);
            $this->parametroTipoEsperado($analisadorSemantico, $indice, $parametro);
        }
    }

    private function parametroDeclarado(AnalisadorSemantico $analisadorSemantico, Token $parametro) : void
    {
        $nomeVariavel = $parametro->getLexeme();

        if(!$analisadorSemantico->getVariaveis()->existeVariavel($nomeVariavel)) {
            $linha = $parametro->getPosition()->getStartLine();
            $analisadorSemantico->newSemanticException("Erro na linha {$linha}: A variável '{$nomeVariavel}' não foi declarada.");
        }
    } 

    private function parametroIniciado(AnalisadorSemantico $analisadorSemantico, Token $parametro) : void
    {
        $nomeVariavel = $parametro->getLexeme();

        if(!$analisadorSemantico->getVariaveis()->getVariavel($nomeVariavel)->iniciada()) {
            $linha = $parametro->getPosition()->getStartLine();
            $analisadorSemantico->newSemanticException("Erro na linha {$linha}: A variável '{$nomeVariavel}' não foi iniciada.");
        }
    }

    private function parametroTipoEsperado(AnalisadorSemantico $analisadorSemantico, int $indice, Token $parametro) : void
    {
        $tipoInformado = $analisadorSemantico->getVariaveis()->getVariavel($parametro->getLexeme())->getTipo();
        $tipoEsperado  = $analisadorSemantico->getFuncoes()->getFuncao($this->getIdentificador()->getLexeme())->getTiposParametros()[$indice];

        if($tipoEsperado !== $tipoInformado) {
            $linha = $parametro->getPosition()->getStartLine();
            $posicaoParametro = $indice + 1;
            $analisadorSemantico->newSemanticException("Erro na linha {$linha}: A função esperava para o {$posicaoParametro}º uma variável do tipo '{$tipoEsperado}' e foi informada uma variável do tipo '{$tipoInformado}'.");
        }
    }
}