<?php

namespace HenriqueBS0\Compiler\GeracaoAssembly;

use HenriqueBS0\Compiler\EstruturasAnalise\ElementosArvoreSintatica\Atribuicao;
use HenriqueBS0\Compiler\EstruturasAnalise\ElementosArvoreSintatica\OperadorAritimetico;
use HenriqueBS0\Compiler\EstruturasAnalise\ElementosArvoreSintatica\OperadorComparacaoIgualdade;
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
                UtilsMontador::registradorParaArray($variavel->getArrayVariavel(), $variavel->getIndiceCalculado(), '$t3'),
            ), Subrotinas::getContadorIF()),

            UtilsMontador::carregaValorRegistrador('0', '$t2'),

            UtilsMontador::desvioCondicional(array_merge(
                UtilsMontador::carregaValorRegistrador('1   ', '$t3'),
                UtilsMontador::registradorParaArray($variavel->getArrayVariavel(), $variavel->getIndiceCalculado(), '$t3'),
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
        /** @var Token[]|OperadorAritimetico[] */
        $simbolos = array_reverse($atribuicao->getOperacaoAritimetica()->getSimbolos());

        $comandos = array_merge(
            self::carregarOperandoRegistrador($simbolos[0], '$t1', $controladorFuncoes),
            self::carregarOperandoRegistrador($simbolos[2], '$t2', $controladorFuncoes),
            self::getComandoOperacaoAritimetica($simbolos[1])
        );

        for ($indice=4; $indice < count($simbolos); $indice+=2) { 
            $comandos = array_merge(
                $comandos,
                self::carregarOperandoRegistrador($simbolos[$indice], '$t2', $controladorFuncoes),
                self::getComandoOperacaoAritimetica($simbolos[$indice-1]) 
            );
        }

        $variavelResultado = $controladorFuncoes->getVariavel($atribuicao->getIdentificador()->getLexeme());

        $comandos = array_merge($comandos, UtilsMontador::registradorParaArray($variavelResultado->getArrayVariavel(), $variavelResultado->getIndiceCalculado()));

        return $comandos;
    }

    private static function getComandoOperacaoAritimetica(OperadorAritimetico $operador) : array
    {
        if($operador->getOperador()->getToken() === 'MAIS') {
            return UtilsMontador::soma('$t1', '$t2', '$t1');
        }
        if($operador->getOperador()->getToken() === 'MENOS') {
            return UtilsMontador::subtrai('$t1', '$t2', '$t1');
        }
        if($operador->getOperador()->getToken() === 'MULTIPLICA') {
            return UtilsMontador::multiplica('$t1', '$t2', '$t1');
        }
        if($operador->getOperador()->getToken() === 'DIVIDE') {
            return UtilsMontador::divide('$t1', '$t2', '$t1');
        }
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
                UtilsMontador::registradorParaArray($variavel->getArrayVariavel(), $variavel->getIndiceCalculado(), '$t3'),
            ), Subrotinas::getContadorIF(), '$t1', '$t2', $isMaior ? UtilsMontador::COMPARACAO_MAIOR : UtilsMontador::COMPARACAO_MENOR),


            UtilsMontador::desvioCondicional(array_merge(
                UtilsMontador::carregaValorRegistrador('0', '$t3'),
                UtilsMontador::registradorParaArray($variavel->getArrayVariavel(), $variavel->getIndiceCalculado(), '$t3'),
            ), Subrotinas::getContadorIF(), '$t1', '$t2', $isMaior ? UtilsMontador::COMPARACAO_MENOR_IGUAL : UtilsMontador::COMPARACAO_MAIOR_IGUAL)
        );

    }

    private static function getComandosAtribuicaoComparacaoIgualdade(Atribuicao $atribuicao, ControladorFuncoes $controladorFuncoes) : array
    {
        $primeiroOperando = $atribuicao->getComparacaoIgualdade()->getSimbolos()[2];
        $segundoOperando = $atribuicao->getComparacaoIgualdade()->getSimbolos()[0];

        /** @var OperadorComparacaoIgualdade */
        $operador = $atribuicao->getComparacaoIgualdade()->getSimbolos()[1];
        
        $isIgualdade = $operador->getOperador()->getToken() === 'IGUALDADE';

        $variavel = $controladorFuncoes->getVariavel($atribuicao->getIdentificador()->getLexeme());
        
        return array_merge(
            self::carregarOperandoRegistrador($primeiroOperando, '$t1', $controladorFuncoes),
            self::carregarOperandoRegistrador($segundoOperando,  '$t2', $controladorFuncoes),

            UtilsMontador::desvioCondicional(array_merge(
                UtilsMontador::carregaValorRegistrador('1', '$t3'),
                UtilsMontador::registradorParaArray($variavel->getArrayVariavel(), $variavel->getIndiceCalculado(), '$t3'),
            ), Subrotinas::getContadorIF(), '$t1', '$t2', $isIgualdade ? UtilsMontador::COMPARACAO_IGUAL : UtilsMontador::COMPARACAO_DIFERENTE),


            UtilsMontador::desvioCondicional(array_merge(
                UtilsMontador::carregaValorRegistrador('0', '$t3'),
                UtilsMontador::registradorParaArray($variavel->getArrayVariavel(), $variavel->getIndiceCalculado(), '$t3'),
            ), Subrotinas::getContadorIF(), '$t1', '$t2', $isIgualdade ? UtilsMontador::COMPARACAO_DIFERENTE : UtilsMontador::COMPARACAO_IGUAL)
        );
    }

    private static function getComandosAtribuicaoOperacaoLogicaAnd(Atribuicao $atribuicao, ControladorFuncoes $controladorFuncoes) : array
    {   
        $variaveis = self::getVariaveisOperaoLogica($atribuicao);

        $comandos = [];

        $variavelAcumuladora = $controladorFuncoes->getVariavel($variaveis[0]);
        $variavelMovel       = $controladorFuncoes->getVariavel($variaveis[1]);

        $comandos = array_merge(
            UtilsMontador::arrayParaRegistrador($variavelAcumuladora->getArrayVariavel(), $variavelAcumuladora->getIndiceCalculado()),
            UtilsMontador::arrayParaRegistrador($variavelMovel->getArrayVariavel(), $variavelMovel->getIndiceCalculado(), '$t2'),
            UtilsMontador::comandoAnd('$t1', '$t2', '$t1')
        );

        for ($indice=2; $indice < count($variaveis); $indice++) { 
            $variavelMovel = $controladorFuncoes->getVariavel($variaveis[$indice]);
            $comandos = array_merge(
                $comandos,
                UtilsMontador::arrayParaRegistrador($variavelMovel->getArrayVariavel(), $variavelMovel->getIndiceCalculado(), '$t2'),
                UtilsMontador::comandoAnd('$t1', '$t2', '$t1')
            );
        }

        $variavelResultado = $controladorFuncoes->getVariavel($atribuicao->getIdentificador()->getLexeme());

        $comandos = array_merge($comandos, UtilsMontador::registradorParaArray($variavelResultado->getArrayVariavel(), $variavelResultado->getIndiceCalculado()));

        return $comandos;
    }

    private static function getComandosAtribuicaoOperacaoLogicaOr(Atribuicao $atribuicao, ControladorFuncoes $controladorFuncoes) : array
    {
        $variaveis = self::getVariaveisOperaoLogica($atribuicao);

        $comandos = [];

        $variavelAcumuladora = $controladorFuncoes->getVariavel($variaveis[0]);
        $variavelMovel       = $controladorFuncoes->getVariavel($variaveis[1]);

        $comandos = array_merge(
            UtilsMontador::arrayParaRegistrador($variavelAcumuladora->getArrayVariavel(), $variavelAcumuladora->getIndiceCalculado()),
            UtilsMontador::arrayParaRegistrador($variavelMovel->getArrayVariavel(), $variavelMovel->getIndiceCalculado(), '$t2'),
            UtilsMontador::comandoOR('$t1', '$t2', '$t1')
        );

        for ($indice=2; $indice < count($variaveis); $indice++) { 
            $variavelMovel = $controladorFuncoes->getVariavel($variaveis[$indice]);
            $comandos = array_merge(
                $comandos,
                UtilsMontador::arrayParaRegistrador($variavelMovel->getArrayVariavel(), $variavelMovel->getIndiceCalculado(), '$t2'),
                UtilsMontador::comandoOR('$t1', '$t2', '$t1')
            );
        }

        $variavelResultado = $controladorFuncoes->getVariavel($atribuicao->getIdentificador()->getLexeme());

        $comandos = array_merge($comandos, UtilsMontador::registradorParaArray($variavelResultado->getArrayVariavel(), $variavelResultado->getIndiceCalculado()));

        return $comandos;
    }

    private static function getVariaveisOperaoLogica(Atribuicao $atribuicao) {
        $variaveis = [];

        foreach (array_reverse($atribuicao->getOperacaoLogicaAnd() ? $atribuicao->getOperacaoLogicaAnd()->getSimbolos() : $atribuicao->getOperacaoLogicaOr()->getSimbolos()) as $indice => $variavel) {
            if($indice % 2 === 0) {
                $variaveis[] = $variavel->getLexeme();
            } 
        }

        return $variaveis;
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