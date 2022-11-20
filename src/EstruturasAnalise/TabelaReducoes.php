<?php

namespace HenriqueBS0\Compiler\EstruturasAnalise;

use HenriqueBS0\Compiler\EstruturasAnalise\ElementosArvoreSintatica\Atribuicao;
use HenriqueBS0\Compiler\EstruturasAnalise\ElementosArvoreSintatica\BlocoCodigo;
use HenriqueBS0\Compiler\EstruturasAnalise\ElementosArvoreSintatica\ChamadaFuncao;
use HenriqueBS0\Compiler\EstruturasAnalise\ElementosArvoreSintatica\Comando;
use HenriqueBS0\Compiler\EstruturasAnalise\ElementosArvoreSintatica\ComparacaoIgualdade;
use HenriqueBS0\Compiler\EstruturasAnalise\ElementosArvoreSintatica\ComparacaoQuantitativa;
use HenriqueBS0\Compiler\EstruturasAnalise\ElementosArvoreSintatica\Concatenacao;
use HenriqueBS0\Compiler\EstruturasAnalise\ElementosArvoreSintatica\DeclaracaoVariavel;
use HenriqueBS0\Compiler\EstruturasAnalise\ElementosArvoreSintatica\DefinicaoFuncao;
use HenriqueBS0\Compiler\EstruturasAnalise\ElementosArvoreSintatica\DefinicaoFuncoes;
use HenriqueBS0\Compiler\EstruturasAnalise\ElementosArvoreSintatica\DefinicaoParametroFuncao;
use HenriqueBS0\Compiler\EstruturasAnalise\ElementosArvoreSintatica\DefinicaoParametrosFuncao;
use HenriqueBS0\Compiler\EstruturasAnalise\ElementosArvoreSintatica\Enquanto;
use HenriqueBS0\Compiler\EstruturasAnalise\ElementosArvoreSintatica\Execucao;
use HenriqueBS0\Compiler\EstruturasAnalise\ElementosArvoreSintatica\ListaComandos;
use HenriqueBS0\Compiler\EstruturasAnalise\ElementosArvoreSintatica\OperacaoAritimetica;
use HenriqueBS0\Compiler\EstruturasAnalise\ElementosArvoreSintatica\OperacaoLogicaAnd;
use HenriqueBS0\Compiler\EstruturasAnalise\ElementosArvoreSintatica\OperacaoLogicaOr;
use HenriqueBS0\Compiler\EstruturasAnalise\ElementosArvoreSintatica\OperadorAritimetico;
use HenriqueBS0\Compiler\EstruturasAnalise\ElementosArvoreSintatica\OperadorComparacaoIgualdade;
use HenriqueBS0\Compiler\EstruturasAnalise\ElementosArvoreSintatica\OperadorComparacaoQuantitativa;
use HenriqueBS0\Compiler\EstruturasAnalise\ElementosArvoreSintatica\ParametrosFuncao;
use HenriqueBS0\Compiler\EstruturasAnalise\ElementosArvoreSintatica\Printa;
use HenriqueBS0\Compiler\EstruturasAnalise\ElementosArvoreSintatica\Programa;
use HenriqueBS0\Compiler\EstruturasAnalise\ElementosArvoreSintatica\Se;
use HenriqueBS0\SyntacticAnalyzer\SLR\Tree\OnReduce;
use HenriqueBS0\SyntacticAnalyzer\SLR\Tree\OnReduceTable;

class TabelaReducoes {
    public static function get() : OnReduceTable
    {
        $onReduceTable = (new OnReduceTable())
            ->setCallbacksOnReduce([
            'PROGRAMA' => (new OnReduce(Programa::class))
                ->addMethod('DEFINICAO-FUNCOES', 'setDefinicaoFuncoes')
                ->addMethod('EXECUCAO',          'setExecucao'),
            'DEFINICAO-FUNCOES' => (new OnReduce(DefinicaoFuncoes::class))
                ->addMethod('DEFINICAO-FUNCAO',  'addDefinicaoFuncao')
                ->addMethod('DEFINICAO-FUNCOES', 'setDefinicaoFuncoes'),
            'DEFINICAO-FUNCAO'  => (new OnReduce(DefinicaoFuncao::class))
                ->addMethod('FUNCTION',                    'setFunction')
                ->addMethod('IDENTIFICADOR',               'setIdentificador')
                ->addMethod('ABRE-PARENTESES',             'setAbreParenteses')
                ->addMethod('DEFINICAO-PARAMETROS-FUNCAO', 'setDefinicaoParametrosFuncao')
                ->addMethod('FECHA-PARENTESES',            'setFechaParenteses')
                ->addMethod('BLOCO-CODIGO',                'setBlocoCodigo'),
            'DEFINICAO-PARAMETROS-FUNCAO' => (new OnReduce(DefinicaoParametrosFuncao::class))
                ->addMethod('DEFINICAO-PARAMETRO-FUNCAO',  'addDefinicaoParametroFuncao')
                ->addMethod('VIRGULA',                     'addVirgula')
                ->addMethod('DEFINICAO-PARAMETROS-FUNCAO', 'setDefinicaoParametrosFuncao'),
            'DEFINICAO-PARAMETRO-FUNCAO' => (new OnReduce(DefinicaoParametroFuncao::class))
                ->addMethod('TIPO',          'setTipo')
                ->addMethod('IDENTIFICADOR', 'setIdentificador'),
            'EXECUCAO' => (new OnReduce(Execucao::class))
                ->addMethod('EXECUTE',          'setExecute')
                ->addMethod('ABRE-PARENTESES',  'setAbreParenteses')
                ->addMethod('FECHA-PARENTESES', 'setFechaParenteses')
                ->addMethod('BLOCO-CODIGO',     'setBlocoCodigo'),
            'BLOCO-CODIGO' => (new OnReduce(BlocoCodigo::class))
                ->addMethod('ABRE-CHAVES',    'setAbreChaves')
                ->addMethod('LISTA-COMANDOS', 'setListaComandos')
                ->addMethod('FECHA-CHAVES',   'setFechaChaves'),
            'LISTA-COMANDOS' => (new OnReduce(ListaComandos::class))
                ->addMethod('COMANDO',        'addComando')
                ->addMethod('LISTA-COMANDOS', 'setListaComandos'),
            'COMANDO' => (new OnReduce(Comando::class))
                ->addMethod('DECLARACAO-VARIAVEL', 'setDeclaracaoVariavel')
                ->addMethod('CHAMADA-FUNCAO',      'setChamadaFuncao')
                ->addMethod('ATRIBUICAO',          'setAtribuicao')
                ->addMethod('PRINTA',              'setPrinta')
                ->addMethod('SE',                  'setSe')
                ->addMethod('ENQUANTO',            'setEnquanto'),
            'DECLARACAO-VARIAVEL' => (new OnReduce(DeclaracaoVariavel::class))
                ->addMethod('TIPO',          'setTipo')
                ->addMethod('IDENTIFICADOR', 'setIdentificador')
                ->addMethod('PONTO-VIRGULA', 'setPontoVirgula'),
            'CHAMADA-FUNCAO' => (new OnReduce(ChamadaFuncao::class))
                ->addMethod('IDENTIFICADOR',     'setIdentificador')
                ->addMethod('ABRE-PARENTESES',   'setAbreParenteses')
                ->addMethod('PARAMETROS-FUNCAO', 'setParametrosFuncao')
                ->addMethod('FECHA-PARENTESES',  'setFechaParenteses')
                ->addMethod('PONTO-VIRGULA',     'setPontoVirgula'),
            'PARAMETROS-FUNCAO' => (new OnReduce(ParametrosFuncao::class))
                ->addMethod('IDENTIFICADOR',     'addIdentificador')
                ->addMethod('VIRGULA',           'addVirgula')
                ->addMethod('PARAMETROS-FUNCAO', 'setParametrosFuncao'),
            'ATRIBUICAO' => (new OnReduce((Atribuicao::class)))
                ->addMethod('IDENTIFICADOR',           'setIdentificador')
                ->addMethod('RECEBE',                  'setRecebe')
                ->addMethod('CONSTANTE',               'setConstante')
                ->addMethod('TRUE',                    'setTrue')
                ->addMethod('FALSE',                   'setFalse')
                ->addMethod('CADEIA',                  'setCadeia')
                ->addMethod('NOT',                     'setNot')
                ->addMethod('OPERACAO-ARITIMETICA',    'setOperacaoAritimetica')
                ->addMethod('CONCATENACAO',            'setConcatenacao')
                ->addMethod('COMPARACAO-QUANTITATIVA', 'setComparacaoQuantitativa')
                ->addMethod('COMPARACAO-IGUALDADE',    'setComparacaoIgualdade')
                ->addMethod('OPERACAO-LOGICA-AND',     'setOperacaoLogicaAnd')
                ->addMethod('OPERACAO-LOGICA-OR',      'setOperacaoLogicaOr')
                ->addMethod('PONTO-VIRGULA',           'setPontoVirgula'),
            'OPERACAO-ARITIMETICA' => (new OnReduce(OperacaoAritimetica::class))
                ->addMethod('CONSTANTE',            'addSimbolo')
                ->addMethod('IDENTIFICADOR',        'addSimbolo')
                ->addMethod('OPERADOR-ARITIMETICO', 'addSimbolo')
                ->addMethod('OPERACAO-ARITIMETICA', 'setOperacaoAritimetica'),
            'OPERADOR-ARITIMETICO' => (new OnReduce(OperadorAritimetico::class))
                ->addMethod('MAIS',       'setOperador')
                ->addMethod('MENOS',      'setOperador')
                ->addMethod('MULTIPLICA', 'setOperador')
                ->addMethod('DIVIDE',     'setOperador'),
            'CONCATENACAO' => (new OnReduce(Concatenacao::class))
                ->addMethod('CADEIA',        'addSimbolo')
                ->addMethod('IDENTIFICADOR', 'addSimbolo')
                ->addMethod('PONTO',         'addSimbolo')
                ->addMethod('CONCATENACAO',  'setConcatenacao'),
            'COMPARACAO-QUANTITATIVA' => (new OnReduce(ComparacaoQuantitativa::class))
                ->addMethod('CONSTANTE',                        'addSimbolo')
                ->addMethod('IDENTIFICADOR',                    'addSimbolo')
                ->addMethod('OPERADOR-COMPARACAO-QUANTITATIVA', 'addSimbolo'),
            'OPERADOR-COMPARACAO-QUANTITATIVA' => (new OnReduce(OperadorComparacaoQuantitativa::class))
                ->addMethod('MAIOR', 'setOperador')
                ->addMethod('MENOR', 'setOperador'),
            'COMPARACAO-IGUALDADE' => (new OnReduce(ComparacaoIgualdade::class))
                ->addMethod('CONSTANTE',                     'addSimbolo')
                ->addMethod('IDENTIFICADOR',                 'addSimbolo')
                ->addMethod('CADEIA',                        'addSimbolo')
                ->addMethod('OPERADOR-COMPARACAO-IGUALDADE', 'addSimbolo'),
            'OPERADOR-COMPARACAO-IGUALDADE' => (new OnReduce(OperadorComparacaoIgualdade::class))
                ->addMethod('IGUALDADE',    'setOperador')
                ->addMethod('DESIGUALDADE', 'setOperador'),
            'OPERACAO-LOGICA-AND' => (new OnReduce(OperacaoLogicaAnd::class))
                ->addMethod('IDENTIFICADOR',       'addSimbolo')
                ->addMethod('AND',                 'addSimbolo')
                ->addMethod('OPERACAO-LOGICA-AND', 'setOperacaoLogicaAnd'),
            'OPERACAO-LOGICA-OR' => (new OnReduce(OperacaoLogicaOr::class))
                ->addMethod('IDENTIFICADOR',      'addSimbolo')
                ->addMethod('OR',                 'addSimbolo')
                ->addMethod('OPERACAO-LOGICA-OR', 'setOperacaoLogicaOr'),
            'PRINTA' => (new OnReduce(Printa::class))
                ->addMethod('PRINT',            'setPrint')
                ->addMethod('ABRE-PARENTESES',  'setAbreParenteses')
                ->addMethod('IDENTIFICADOR',    'setIdentificador')
                ->addMethod('FECHA-PARENTESES', 'setFechaParenteses')
                ->addMethod('PONTO-VIRGULA',    'setPontoVirgula'),
            'SE' => (new OnReduce(Se::class))
                ->addMethod('IF', 'setIF')
                ->addMethod('ABRE-PARENTESES',  'setAbreParenteses')
                ->addMethod('IDENTIFICADOR',    'setIdentificador')
                ->addMethod('FECHA-PARENTESES', 'setFechaParenteses')
                ->addMethod('BLOCO-CODIGO',     'setBlocoCodigo'),
            'ENQUANTO' => (new OnReduce(Enquanto::class))
                ->addMethod('WHILE',            'setWhile')
                ->addMethod('ABRE-PARENTESES',  'setAbreParenteses')
                ->addMethod('IDENTIFICADOR',    'setIdentificador')
                ->addMethod('FECHA-PARENTESES', 'setFechaParenteses')
                ->addMethod('BLOCO-CODIGO',     'setBlocoCodigo')
        ]);

        return $onReduceTable;
    }
}