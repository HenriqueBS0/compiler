<?php

namespace HenriqueBS0\Compiler\GeracaoAssembly;

use HenriqueBS0\Compiler\EstruturasAnalise\ElementosArvoreSintatica\Atribuicao;

class MontadorAtribuicao {
    public static function getComandos(Atribuicao $atribuicao, ControladorFuncoes $controladorFuncoes) : array
    {
        switch (true) {
            case !is_null($atribuicao->getConstante()):
                return self::getComandosAtribuicaoConstante($atribuicao, $controladorFuncoes);
            case !is_null($atribuicao->getNot()):
                return self::getComandosAtribuicaoNot($atribuicao, $controladorFuncoes);
            case !is_null($atribuicao->getIdentificadorValor()):
                return self::getComandosAtribuicaoVariavel($atribuicao, $controladorFuncoes);
            case !is_null($atribuicao->getTrue()):
                return self::getComandosAtribuicaoTrue($atribuicao, $controladorFuncoes);
            case !is_null($atribuicao->getFalse()):
                return self::getComandosAtribuicaoFalse($atribuicao, $controladorFuncoes);
            case !is_null($atribuicao->getOperacaoAritimetica()):
                return self::getComandosAtribuicaoOperacaoAritimetica($atribuicao, $controladorFuncoes);
            case !is_null($atribuicao->getOperacaoAritimetica()):
                return self::getComandosAtribuicaoOperacaoAritimetica($atribuicao, $controladorFuncoes);
            case !is_null($atribuicao->getComparacaoQuantitativa()):
                return self::getComandosAtribuicaoComparacaoQuantitativa($atribuicao, $controladorFuncoes);
            case !is_null($atribuicao->getComparacaoIgualdade()):
                return self::getComandosAtribuicaoComparacaoIgualdade($atribuicao, $controladorFuncoes);
            case !is_null($atribuicao->getOperacaoLogicaAnd()):
                return self::getComandosAtribuicaoOperacaoLogicaAnd($atribuicao, $controladorFuncoes);
            case !is_null($atribuicao->getOperacaoLogicaOr()):
                return self::getComandosAtribuicaoOperacaoLogicaOr($atribuicao, $controladorFuncoes);   
        }
    }

    private static function getComandosAtribuicaoConstante(Atribuicao $atribuicao, ControladorFuncoes $controladorFuncoes) : array
    {

    }

    private static function getComandosAtribuicaoNot(Atribuicao $atribuicao, ControladorFuncoes $controladorFuncoes) : array
    {
        
    }

    private static function getComandosAtribuicaoVariavel(Atribuicao $atribuicao, ControladorFuncoes $controladorFuncoes) : array
    {
        
    }

    private static function getComandosAtribuicaoTrue(Atribuicao $atribuicao, ControladorFuncoes $controladorFuncoes) : array
    {
        
    }

    private static function getComandosAtribuicaoFalse(Atribuicao $atribuicao, ControladorFuncoes $controladorFuncoes) : array
    {
        
    }

    private static function getComandosAtribuicaoOperacaoAritimetica(Atribuicao $atribuicao, ControladorFuncoes $controladorFuncoes) : array
    {
        
    }

    private static function getComandosAtribuicaoComparacaoQuantitativa(Atribuicao $atribuicao, ControladorFuncoes $controladorFuncoes) : array
    {
        
    }

    private static function getComandosAtribuicaoComparacaoIgualdade(Atribuicao $atribuicao, ControladorFuncoes $controladorFuncoes) : array
    {
        
    }

    private static function getComandosAtribuicaoOperacaoLogicaAnd(Atribuicao $atribuicao, ControladorFuncoes $controladorFuncoes) : array
    {
        
    }

    private static function getComandosAtribuicaoOperacaoLogicaOr(Atribuicao $atribuicao, ControladorFuncoes $controladorFuncoes) : array
    {
        
    }

}