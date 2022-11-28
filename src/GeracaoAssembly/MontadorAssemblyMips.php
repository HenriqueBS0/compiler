<?php

namespace HenriqueBS0\Compiler\GeracaoAssembly;

use HenriqueBS0\Compiler\EstruturasAnalise\ElementosArvoreSintatica\Comando;
use HenriqueBS0\Compiler\EstruturasAnalise\ElementosArvoreSintatica\DefinicaoFuncao;
use HenriqueBS0\Compiler\EstruturasAnalise\ElementosArvoreSintatica\DefinicaoParametroFuncao;
use HenriqueBS0\Compiler\EstruturasAnalise\ElementosArvoreSintatica\ListaComandos;
use HenriqueBS0\Compiler\EstruturasAnalise\ElementosArvoreSintatica\Programa;

class MontadorAssemblyMips {
    public static function getAssembly(Programa $programa) : string 
    {
        $controlador = self::getControladorFuncoes($programa);
        var_dump($controlador);
        return "";
    }

    private static function getControladorFuncoes(Programa $programa) : ControladorFuncoes 
    {
        $controlador = new ControladorFuncoes;
        $controlador = self::setFuncoesControladorFuncoes($controlador, $programa);
        $controlador = self::setFuncaoExecuteControladorFuncoes($controlador, $programa);

        return $controlador;
    }

    private static function setFuncoesControladorFuncoes(ControladorFuncoes $controlador, Programa $programa) : ControladorFuncoes
    {
        if(is_null($programa->getDefinicaoFuncoes())) {
            return $controlador;
        }

        /** @var DefinicaoFuncao */
        foreach ($programa->getDefinicaoFuncoes()->getDefinicaoFuncoes() as $definicaoFuncao) {
            
            $nomeFuncao = $definicaoFuncao->getIdentificador()->getLexeme();

            $controlador->addFuncao((new Funcao)->setNome($nomeFuncao))->setFuncao($nomeFuncao);

            if(!is_null($definicaoFuncao->getDefinicaoParametrosFuncao())) {

                /** @var DefinicaoParametroFuncao */                
                foreach ($definicaoFuncao->getDefinicaoParametrosFuncao()->getDefinicaoParametrosFuncao() as $definicaoParametro) {
                    $variavel = (new Variavel())
                        ->setNome($definicaoParametro->getIdentificador()->getLexeme())
                        ->setTipo($definicaoParametro->getTipo()->getLexeme());

                    $controlador->addVariavel($variavel);
                }
            }

            $controlador = self::setVariaveisListaComandos($controlador, $definicaoFuncao->getBlocoCodigo()->getListaComandos());
        }

        return $controlador;
    }

    private static function setFuncaoExecuteControladorFuncoes(ControladorFuncoes $controlador, Programa $programa) : ControladorFuncoes
    {
        $controlador->addFuncao((new Funcao())->setNome('EXECUTE'))->setFuncao('EXECUTE');
        return self::setVariaveisListaComandos($controlador, $programa->getExecucao()->getBlocoCodigo()->getListaComandos());
    }

    private static function setVariaveisListaComandos(ControladorFuncoes $controlador, ListaComandos $listaComandos) : ControladorFuncoes
    {
        /** @var Comando */
        foreach (array_reverse($listaComandos->getListaComandos()) as $comando) {
            
            if(!is_null($comando->getDeclaracaoVariavel())) {
                
                $declaracaoVariavel = $comando->getDeclaracaoVariavel();

                $variavel = (new Variavel)
                    ->setNome($declaracaoVariavel->getIdentificador()->getLexeme())
                    ->setTipo($declaracaoVariavel->getTipo()->getLexeme());

                $controlador->addVariavel($variavel);

                continue;
            }

            if(!is_null($comando->getAtribuicao()) && !is_null($comando->getAtribuicao()->getCadeia())) {

                $nomeVariavel  = $comando->getAtribuicao()->getIdentificador()->getLexeme();
                $valorVariavel = $comando->getAtribuicao()->getCadeia()->getLexeme(); 

                $valorVariavel = substr($valorVariavel, 1, (strlen($valorVariavel) - 2));

                $controlador->getVariavel($nomeVariavel)->setValor($valorVariavel);

                continue;
            }
        }

        return $controlador;
    }
}