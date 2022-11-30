<?php

namespace HenriqueBS0\Compiler\GeracaoAssembly;

use HenriqueBS0\Compiler\EstruturasAnalise\ElementosArvoreSintatica\Atribuicao;
use HenriqueBS0\Compiler\EstruturasAnalise\ElementosArvoreSintatica\OperadorComparacaoQuantitativa;
use HenriqueBS0\LexicalAnalyzer\Token;

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
            default :
                return [];   
        }
    }

    private static function getComandosAtribuicaoConstante(Atribuicao $atribuicao, ControladorFuncoes $controladorFuncoes) : array
    {

        $variavel = $controladorFuncoes->getVariavel($atribuicao->getIdentificador()->getLexeme());

        return array_merge(
            UtilsMontador::carregaValorRegistrador($atribuicao->getConstante()->getLexeme()),
            UtilsMontador::registradorParaArray($variavel->getArrayVariavel(), $variavel->getIndiceCalculado())
        );
    }

    private static function getComandosAtribuicaoNot(Atribuicao $atribuicao, ControladorFuncoes $controladorFuncoes) : array
    {
        $variavel = $controladorFuncoes->getVariavel($atribuicao->getIdentificador()->getLexeme());

        return array_merge(
            UtilsMontador::arrayParaRegistrador($variavel->getArrayVariavel(), $variavel->getIndiceCalculado()),
            
            UtilsMontador::carregaValorRegistrador('1', '$t2'),

            UtilsMontador::desvioCondicional(array_merge(
                UtilsMontador::carregaValorRegistrador('0', '$t3'),
                UtilsMontador::registradorParaArray($variavel->getArrayVariavel(), $variavel->getIndice(), '$t3'),
            ), Subrotinas::getContadorIF()),

            UtilsMontador::carregaValorRegistrador('0', '$t2'),

            UtilsMontador::desvioCondicional(array_merge(
                UtilsMontador::carregaValorRegistrador('1   ', '$t3'),
                UtilsMontador::registradorParaArray($variavel->getArrayVariavel(), $variavel->getIndice(), '$t3'),
            ), Subrotinas::getContadorIF())
        );
    }

    private static function getComandosAtribuicaoVariavel(Atribuicao $atribuicao, ControladorFuncoes $controladorFuncoes) : array
    {
        $variavelAtribuida = $controladorFuncoes->getVariavel($atribuicao->getIdentificador()->getLexeme());
        $variavelAtribuir = $controladorFuncoes->getVariavel($atribuicao->getIdentificadorValor()->getLexeme());

        return array_merge(
            UtilsMontador::arrayParaRegistrador($variavelAtribuir->getArrayVariavel(), $variavelAtribuir->getIndiceCalculado()),
            UtilsMontador::registradorParaArray($variavelAtribuida->getArrayVariavel(), $variavelAtribuida->getIndiceCalculado())
        );
    }

    private static function getComandosAtribuicaoTrue(Atribuicao $atribuicao, ControladorFuncoes $controladorFuncoes) : array
    {
        $variavel = $controladorFuncoes->getVariavel($atribuicao->getIdentificador()->getLexeme());
        return array_merge(
            UtilsMontador::carregaValorRegistrador('1'),
            UtilsMontador::registradorParaArray($variavel->getArrayVariavel(), $variavel->getIndiceCalculado())
        );
    }

    private static function getComandosAtribuicaoFalse(Atribuicao $atribuicao, ControladorFuncoes $controladorFuncoes) : array
    {
        $variavel = $controladorFuncoes->getVariavel($atribuicao->getIdentificador()->getLexeme());

        return array_merge(
            UtilsMontador::carregaValorRegistrador('0'),
            UtilsMontador::registradorParaArray($variavel->getArrayVariavel(), $variavel->getIndiceCalculado())
        );
    }

    private static function getComandosAtribuicaoOperacaoAritimetica(Atribuicao $atribuicao, ControladorFuncoes $controladorFuncoes) : array
    {
        return [];
    }

    private static function getComandosAtribuicaoComparacaoQuantitativa(Atribuicao $atribuicao, ControladorFuncoes $controladorFuncoes) : array
    {
        $primeiroOperando = $atribuicao->getComparacaoQuantitativa()->getSimbolos()[2];
        $segundoOperando = $atribuicao->getComparacaoQuantitativa()->getSimbolos()[0];

        /** @var OperadorComparacaoQuantitativa */
        $operador = $atribuicao->getComparacaoQuantitativa()->getSimbolos()[1];
        
        $isMaior = $operador->getOperador()->getToken() === 'MAIOR';

        $variavel = $controladorFuncoes->getVariavel($atribuicao->getIdentificador()->getLexeme());
        
        return array_merge(
            self::carregarOperandoRegistrador($primeiroOperando, '$t1', $controladorFuncoes),
            self::carregarOperandoRegistrador($segundoOperando,  '$t2', $controladorFuncoes),

            UtilsMontador::desvioCondicional(array_merge(
                UtilsMontador::carregaValorRegistrador('1', '$t3'),
                UtilsMontador::registradorParaArray($variavel->getArrayVariavel(), $variavel->getIndice(), '$t3'),
            ), Subrotinas::getContadorIF(), '$t1', '$t2', $isMaior ? UtilsMontador::COMPARACAO_MAIOR : UtilsMontador::COMPARACAO_MENOR),


            UtilsMontador::desvioCondicional(array_merge(
                UtilsMontador::carregaValorRegistrador('0', '$t3'),
                UtilsMontador::registradorParaArray($variavel->getArrayVariavel(), $variavel->getIndice(), '$t3'),
            ), Subrotinas::getContadorIF(), '$t1', '$t2', $isMaior ? UtilsMontador::COMPARACAO_MENOR_IGUAL : UtilsMontador::COMPARACAO_MAIOR_IGUAL)
        );

    }

    private static function getComandosAtribuicaoComparacaoIgualdade(Atribuicao $atribuicao, ControladorFuncoes $controladorFuncoes) : array
    {
        return [];
    }

    private static function getComandosAtribuicaoOperacaoLogicaAnd(Atribuicao $atribuicao, ControladorFuncoes $controladorFuncoes) : array
    {
        return [];
    }

    private static function getComandosAtribuicaoOperacaoLogicaOr(Atribuicao $atribuicao, ControladorFuncoes $controladorFuncoes) : array
    {
        return [];
    }

    private static function carregarOperandoRegistrador(Token $operando, string $registrador, ControladorFuncoes $controladorFuncoes) : array
    {
        if($operando->getToken() === 'CONSTANTE') {
            return UtilsMontador::carregaValorRegistrador($operando->getLexeme(), $registrador);
        }
        
        $variavel = $controladorFuncoes->getVariavel($operando->getLexeme());

        return UtilsMontador::arrayParaRegistrador($variavel->getArrayVariavel(), $variavel->getIndiceCalculado(), $registrador);
    }
}