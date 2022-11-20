<?php

namespace HenriqueBS0\Compiler\EstruturasAnalise;

use HenriqueBS0\Automaton\Automaton;
use HenriqueBS0\Automaton\Builder;

class Automato extends Automaton
{
    public function __construct()
    {
        parent::__construct(self::getAlfabeto(), self::getEstados(), self::getEstadoInicial(), self::getEstadosFinais(), self::getTransicoes());
    }

    private static function getAlfabeto()
    {
        return array_merge(Builder::getLetters(), Builder::getNumbers(), ['', '<', '>', '(', ')', '{', '}', '-', '+', '*', '\'', '.', ',', ';', '/', '=', '!', '&', '|', ' ', PHP_EOL]);
    }

    private static function getEstados()
    {
        return [
            'INICIO',
            'F-FOR-FUNCTION-FALSE',
            'IF',           'I-IF',
            'FOR',          'O-FOR',
            'WHILE',        'W-WHILE',         'H-WHILE',    'I-WHILE',    'L-WHILE', 
            'FUNCTION',     'U-FUNCTION',      'N-FUNCTION', 'C-FUNCTION', 'T-FUNCTION', 'I-FUNCTION', 'O-FUNCTION',
            'EXECUTE',      'E-EXECUTE',       'X-EXECUTE',  'EE-EXECUTE', 'C-EXECUTE',  'U-EXECUTE',  'T-EXECUTE',
            'PRINT',        'P-PRINT',         'R-PRINT',    'I-PRINT',    'N-PRINT',
            'TIPO',         'N-NUM',           'U-NUM',      'S-STR',      'T-STR',      'B-BOOL',     'O-BOOL',    'OO-BOOL',
            'TRUE',         'T-TRUE',          'R-TRUE',     'U-TRUE', 
            'FALSE',        'F-FALSE',         'A-FALSE',    'L-FALSE',    'S-FALSE',
            'ASPAS-CADEIA', 'CONTEUDO-CADEIA', 'CADEIA',
            'ESPACO',
            'QUEBRA-LINHA',
            'MAIOR',
            'MENOR',
            'ABRE-PARENTESES',
            'FECHA-PARENTESES',
            'ABRE-CHAVES',
            'FECHA-CHAVES',
            'MENOS',
            'MAIS',
            'MULTIPLICA',
            'DIVIDE',
            'RECEBE',
            'PONTO',
            'VIRGULA', 
            'PONTO-VIRGULA',
            'AND', 
            'OR', 
            'NOT',
            'IGUALDADE',
            'DESIGUALDADE',
            'CONSTANTE',
            'IDENTIFICADOR',
        ];
    }

    private static function getEstadoInicial()
    {
        return 'INICIO';
    }

    private static function getEstadosFinais()
    {
        return [
            'IF',
            'FOR',
            'WHILE',
            'FUNCTION',
            'EXECUTE',
            'PRINT',
            'TIPO',
            'TRUE', 
            'FALSE', 
            'MAIOR',
            'MENOR',
            'ABRE-PARENTESES',
            'FECHA-PARENTESES',
            'ABRE-CHAVES',
            'FECHA-CHAVES',
            'MENOS',
            'MAIS',
            'MULTIPLICA',
            'DIVIDE',
            'RECEBE',
            'CADEIA',
            'PONTO',
            'VIRGULA', 
            'PONTO-VIRGULA',
            'ESPACO',
            'QUEBRA-LINHA',
            'AND', 
            'OR', 
            'NOT',
            'IGUALDADE',
            'DESIGUALDADE',
            'CONSTANTE',
            'IDENTIFICADOR',
        ];
    }

    public static function getTransicoes()
    {
        $transicoes = [];

        $conjuntosTransicoes = [
           self::getTransicoesCARACTERUNICO(),
           self::getTransicoesFdoFUNCTIONdoFORdoFUNCTION(),
           self::getTransicoesIF(),
           self::getTransicoesFOR(),
           self::getTransicoesWHILE(),
           self::getTransicoesFUNCTION(),
           self::getTransicoesEXECUTE(),
           self::getTransicoesPRINT(),
           self::getTransicoesTIPO(),
           self::getTransicoesTRUE(),
           self::getTransicoesFALSE(),
           self::getTransicoesCADEIA(),
           self::getTransicoesESPACO(),
           self::getTransicoesQUEBRALINHA(),
           self::getTransicoesIGUALDADE(),
           self::getTransicoesDESIGUALDADE(),
           self::getTransicoesCONSTANTE(),
           self::getTransicoesIDENTIFICADOR()
        ];

        foreach ($conjuntosTransicoes as $conjuntoTransicoes) {
            foreach ($conjuntoTransicoes as $estadoAtual => $conjuntoTransicoesEstado) {

                $estadoAtual = strval($estadoAtual);

                $transicoes[$estadoAtual] = isset($transicoes[$estadoAtual])
                    ? array_merge($transicoes[$estadoAtual], $conjuntoTransicoesEstado)
                    : $conjuntoTransicoesEstado;
            }
        }

        return $transicoes;
    }

    private static function getTransicoesCARACTERUNICO() 
    {
        return [
            'INICIO' => Builder::getTransitions([
                'MAIOR'            => ['>'],
                'MENOR'            => ['<'],
                'ABRE-PARENTESES'  => ['('],
                'FECHA-PARENTESES' => [')'],
                'ABRE-CHAVES'      => ['{'],
                'FECHA-CHAVES'     => ['}'],
                'MENOS'            => ['-'],
                'MAIS'             => ['+'],
                'MULTIPLICA'       => ['*'],
                'DIVIDE'           => ['/'],
                'RECEBE'           => ['='],
                'NOT'              => ['!'],
                'AND'              => ['&'],
                'OR'               => ['|'],
                'PONTO'            => ['.'],
                'VIRGULA'          => [','],
                'PONTO-VIRGULA'    => [';'],
            ])
        ];
    }

    private static function getTransicoesFdoFUNCTIONdoFORdoFUNCTION() 
    {
        return [
            'INICIO' => Builder::getTransitions(['F-FOR-FUNCTION-FALSE' => ['F']]),
        ];
    }

    private static function getTransicoesIF() 
    {
        return [
            'INICIO' => Builder::getTransitions(['I-IF' => ['I']]),
            'I-IF'   => Builder::getTransitions(['IF'   => ['F']]),
        ];
    }

    private static function getTransicoesFOR() 
    {
        return [
            'F-FOR-FUNCTION-FALSE' => Builder::getTransitions(['O-FOR' => ['O']]),
            'O-FOR'                => Builder::getTransitions(['FOR'   => ['R']]),
        ];
    }

    private static function getTransicoesWHILE() 
    {
        return [
            'INICIO'  => Builder::getTransitions(['W-WHILE' => ['W']]),
            'W-WHILE' => Builder::getTransitions(['H-WHILE' => ['H']]),
            'H-WHILE' => Builder::getTransitions(['I-WHILE' => ['I']]),
            'I-WHILE' => Builder::getTransitions(['L-WHILE' => ['L']]),
            'L-WHILE' => Builder::getTransitions(['WHILE'   => ['E']]),
        ];
    }

    private static function getTransicoesFUNCTION() 
    {
        return [
            'F-FOR-FUNCTION-FALSE' => Builder::getTransitions(['U-FUNCTION' => ['U']]),
            'U-FUNCTION'           => Builder::getTransitions(['N-FUNCTION' => ['N']]),
            'N-FUNCTION'           => Builder::getTransitions(['C-FUNCTION' => ['C']]),
            'C-FUNCTION'           => Builder::getTransitions(['T-FUNCTION' => ['T']]),
            'T-FUNCTION'           => Builder::getTransitions(['I-FUNCTION' => ['I']]),
            'I-FUNCTION'           => Builder::getTransitions(['O-FUNCTION' => ['O']]),
            'O-FUNCTION'           => Builder::getTransitions(['FUNCTION'   => ['N']]),
        ];
    }

    private static function getTransicoesEXECUTE() 
    {
        return [
            'INICIO'     => Builder::getTransitions(['E-EXECUTE'  => ['E']]),
            'E-EXECUTE'  => Builder::getTransitions(['X-EXECUTE'  => ['X']]),
            'X-EXECUTE'  => Builder::getTransitions(['EE-EXECUTE' => ['E']]),
            'EE-EXECUTE' => Builder::getTransitions(['C-EXECUTE'  => ['C']]),
            'C-EXECUTE'  => Builder::getTransitions(['U-EXECUTE'  => ['U']]),
            'U-EXECUTE'  => Builder::getTransitions(['T-EXECUTE'  => ['T']]),
            'T-EXECUTE'  => Builder::getTransitions(['EXECUTE'    => ['E']]),
        ];
    }

    private static function getTransicoesPRINT() 
    {
        return [
            'INICIO'  => Builder::getTransitions(['P-PRINT' => ['P']]),
            'P-PRINT' => Builder::getTransitions(['R-PRINT' => ['R']]),
            'R-PRINT' => Builder::getTransitions(['I-PRINT' => ['I']]),
            'I-PRINT' => Builder::getTransitions(['N-PRINT' => ['N']]),
            'N-PRINT' => Builder::getTransitions(['PRINT'   => ['T']]),
        ];
    }

    private static function getTransicoesTIPO() 
    {
        return [
            'INICIO'  => Builder::getTransitions([
                'N-NUM'  => ['N'],
                'S-STR'  => ['S'],
                'B-BOOL' => ['B']
            ]),
            'N-NUM'   => Builder::getTransitions(['U-NUM'   => ['U']]),
            'U-NUM'   => Builder::getTransitions(['TIPO'    => ['M']]),
            'S-STR'   => Builder::getTransitions(['T-STR'   => ['T']]),
            'T-STR'   => Builder::getTransitions(['TIPO'    => ['R']]),
            'B-BOOL'  => Builder::getTransitions(['O-BOOL'  => ['O']]),
            'O-BOOL'  => Builder::getTransitions(['OO-BOOL' => ['O']]),
            'OO-BOOL' => Builder::getTransitions(['TIPO'    => ['L']]),
        ];
    }

    private static function getTransicoesTRUE() 
    {
        return [
            'INICIO'  => Builder::getTransitions(['T-TRUE' => ['T']]),
            'T-TRUE'  => Builder::getTransitions(['R-TRUE' => ['R']]),
            'R-TRUE'  => Builder::getTransitions(['U-TRUE' => ['U']]),
            'U-TRUE'  => Builder::getTransitions(['TRUE'   => ['E']]),
        ];
    }

    private static function getTransicoesFALSE() 
    {
        return [
            'F-FOR-FUNCTION-FALSE' => Builder::getTransitions(['A-FALSE' => ['A']]),
            'A-FALSE' => Builder::getTransitions(['L-FALSE'              => ['L']]),
            'L-FALSE' => Builder::getTransitions(['S-FALSE'              => ['S']]),
            'S-FALSE' => Builder::getTransitions(['FALSE'                => ['E']]),
        ];
    }

    private static function getTransicoesCADEIA()
    {
        return [
            'INICIO'          => Builder::getTransitions(['ASPAS-CADEIA' => ["'"]]),
            'ASPAS-CADEIA'    => Builder::getTransitions(['CONTEUDO-CADEIA' => Builder::getInputs(self::getAlfabeto(), ["'"])]),
            'CONTEUDO-CADEIA' => Builder::getTransitions([
                'CONTEUDO-CADEIA' => Builder::getInputs(self::getAlfabeto(), ["'"]),
                'CADEIA'          => ["'"]
            ]),
        ];
    }

    private static function getTransicoesESPACO()
    {
        return [
            'INICIO' => Builder::getTransitions(['ESPACO' => [' ']]),
            'ESPACO' => Builder::getTransitions(['ESPACO' => [' ']]),
        ];
    }

    private static function getTransicoesQUEBRALINHA()
    {
        return [
            'INICIO'       => Builder::getTransitions(['QUEBRA-LINHA' => [PHP_EOL]]),
            'QUEBRA-LINHA' => Builder::getTransitions(['QUEBRA-LINHA' => [PHP_EOL]]),
        ];
    }

    private static function getTransicoesIGUALDADE() 
    {
        return ['RECEBE' => Builder::getTransitions(['IGUALDADE' => ['=']])];
    }

    private static function getTransicoesDESIGUALDADE() 
    {
        return ['NOT' => Builder::getTransitions(['DESIGUALDADE' => ['=']])];
    }

    private static function getTransicoesCONSTANTE() 
    {
        return [
            'INICIO'    => Builder::getTransitions(['CONSTANTE' => Builder::getNumbers()]),
            'CONSTANTE' => Builder::getTransitions(['CONSTANTE' => Builder::getNumbers()]),
        ];
    }

    private static function getTransicoesIDENTIFICADOR() 
    {
        $todosCaracteres = [Builder::getLetters(), Builder::getNumbers(), '']; 

        return [
            'INICIO'               => Builder::getTransitions(['IDENTIFICADOR' => Builder::getInputs([Builder::getLetters(), ''], ['F', 'I', 'W', 'E', 'P', 'N', 'S', 'B', 'T'])]),
            'F-FOR-FUNCTION-FALSE' => Builder::getTransitions(['IDENTIFICADOR' => Builder::getInputs($todosCaracteres, ['O', 'U', 'A'])]),
            'IF'                   => Builder::getTransitions(['IDENTIFICADOR' => Builder::getInputs($todosCaracteres)]),
            'I-IF'                 => Builder::getTransitions(['IDENTIFICADOR' => Builder::getInputs($todosCaracteres, ['F'])]),
            'FOR'                  => Builder::getTransitions(['IDENTIFICADOR' => Builder::getInputs($todosCaracteres)]),
            'O-FOR'                => Builder::getTransitions(['IDENTIFICADOR' => Builder::getInputs($todosCaracteres, ['R'])]),
            'WHILE'                => Builder::getTransitions(['IDENTIFICADOR' => Builder::getInputs($todosCaracteres)]),
            'W-WHILE'              => Builder::getTransitions(['IDENTIFICADOR' => Builder::getInputs($todosCaracteres, ['H'])]),
            'H-WHILE'              => Builder::getTransitions(['IDENTIFICADOR' => Builder::getInputs($todosCaracteres, ['I'])]),
            'I-WHILE'              => Builder::getTransitions(['IDENTIFICADOR' => Builder::getInputs($todosCaracteres, ['L'])]),
            'L-WHILE'              => Builder::getTransitions(['IDENTIFICADOR' => Builder::getInputs($todosCaracteres, ['E'])]), 
            'FUNCTION'             => Builder::getTransitions(['IDENTIFICADOR' => Builder::getInputs($todosCaracteres)]), 
            'U-FUNCTION'           => Builder::getTransitions(['IDENTIFICADOR' => Builder::getInputs($todosCaracteres, ['N'])]),
            'N-FUNCTION'           => Builder::getTransitions(['IDENTIFICADOR' => Builder::getInputs($todosCaracteres, ['C'])]),
            'C-FUNCTION'           => Builder::getTransitions(['IDENTIFICADOR' => Builder::getInputs($todosCaracteres, ['T'])]),
            'T-FUNCTION'           => Builder::getTransitions(['IDENTIFICADOR' => Builder::getInputs($todosCaracteres, ['I'])]),
            'I-FUNCTION'           => Builder::getTransitions(['IDENTIFICADOR' => Builder::getInputs($todosCaracteres, ['O'])]),
            'O-FUNCTION'           => Builder::getTransitions(['IDENTIFICADOR' => Builder::getInputs($todosCaracteres, ['N'])]),
            'EXECUTE'              => Builder::getTransitions(['IDENTIFICADOR' => Builder::getInputs($todosCaracteres)]),  
            'E-EXECUTE'            => Builder::getTransitions(['IDENTIFICADOR' => Builder::getInputs($todosCaracteres, ['X'])]),
            'X-EXECUTE'            => Builder::getTransitions(['IDENTIFICADOR' => Builder::getInputs($todosCaracteres, ['E'])]),
            'EE-EXECUTE'           => Builder::getTransitions(['IDENTIFICADOR' => Builder::getInputs($todosCaracteres, ['C'])]), 
            'C-EXECUTE'            => Builder::getTransitions(['IDENTIFICADOR' => Builder::getInputs($todosCaracteres, ['U'])]),
            'U-EXECUTE'            => Builder::getTransitions(['IDENTIFICADOR' => Builder::getInputs($todosCaracteres, ['T'])]),
            'T-EXECUTE'            => Builder::getTransitions(['IDENTIFICADOR' => Builder::getInputs($todosCaracteres, ['E'])]),
            'PRINT'                => Builder::getTransitions(['IDENTIFICADOR' => Builder::getInputs($todosCaracteres)]),
            'P-PRINT'              => Builder::getTransitions(['IDENTIFICADOR' => Builder::getInputs($todosCaracteres, ['R'])]),    
            'R-PRINT'              => Builder::getTransitions(['IDENTIFICADOR' => Builder::getInputs($todosCaracteres, ['I'])]),    
            'I-PRINT'              => Builder::getTransitions(['IDENTIFICADOR' => Builder::getInputs($todosCaracteres, ['N'])]),    
            'N-PRINT'              => Builder::getTransitions(['IDENTIFICADOR' => Builder::getInputs($todosCaracteres, ['T'])]),
            'TIPO'                 => Builder::getTransitions(['IDENTIFICADOR' => Builder::getInputs($todosCaracteres)]),
            'N-NUM'                => Builder::getTransitions(['IDENTIFICADOR' => Builder::getInputs($todosCaracteres, ['U'])]),
            'U-NUM'                => Builder::getTransitions(['IDENTIFICADOR' => Builder::getInputs($todosCaracteres, ['M'])]),
            'S-STR'                => Builder::getTransitions(['IDENTIFICADOR' => Builder::getInputs($todosCaracteres, ['T'])]),
            'T-STR'                => Builder::getTransitions(['IDENTIFICADOR' => Builder::getInputs($todosCaracteres, ['R'])]),
            'B-BOOL'               => Builder::getTransitions(['IDENTIFICADOR' => Builder::getInputs($todosCaracteres, ['O'])]),
            'O-BOOL'               => Builder::getTransitions(['IDENTIFICADOR' => Builder::getInputs($todosCaracteres, ['O'])]),
            'OO-BOOL'              => Builder::getTransitions(['IDENTIFICADOR' => Builder::getInputs($todosCaracteres, ['L'])]),
            'TRUE'                 => Builder::getTransitions(['IDENTIFICADOR' => Builder::getInputs($todosCaracteres)]),
            'T-TRUE'               => Builder::getTransitions(['IDENTIFICADOR' => Builder::getInputs($todosCaracteres, ['R'])]), 
            'R-TRUE'               => Builder::getTransitions(['IDENTIFICADOR' => Builder::getInputs($todosCaracteres, ['U'])]), 
            'U-TRUE'               => Builder::getTransitions(['IDENTIFICADOR' => Builder::getInputs($todosCaracteres, ['E'])]), 
            'FALSE'                => Builder::getTransitions(['IDENTIFICADOR' => Builder::getInputs($todosCaracteres)]),
            'F-FALSE'              => Builder::getTransitions(['IDENTIFICADOR' => Builder::getInputs($todosCaracteres, ['A'])]),
            'A-FALSE'              => Builder::getTransitions(['IDENTIFICADOR' => Builder::getInputs($todosCaracteres, ['L'])]),
            'L-FALSE'              => Builder::getTransitions(['IDENTIFICADOR' => Builder::getInputs($todosCaracteres, ['S'])]),
            'S-FALSE'              => Builder::getTransitions(['IDENTIFICADOR' => Builder::getInputs($todosCaracteres, ['E'])]),
            'CONSTANTE'            => Builder::getTransitions(['IDENTIFICADOR' => Builder::getInputs($todosCaracteres, Builder::getNumbers())]),
            'IDENTIFICADOR'        => Builder::getTransitions(['IDENTIFICADOR' => Builder::getInputs($todosCaracteres)]),
        ];
    }

    public static function get() : self
    {
        return new self();
    }
}
