<?php

namespace HenriqueBS0\Compiler\Analisadores;

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
        return array_merge(Builder::getLetters(), Builder::getNumbers(), ['', '<', '>', '(', ')', '{', '}', '-', '+', '*', ',', ';', '/', '=', '!', ' ', PHP_EOL]);
    }

    private static function getEstados()
    {
        return [
            'INICIO', 'IDENTIFICADOR', 'IF', 'FOR', 'WHILE', 'PRINT', 'CONSTANTE', 'RECEBE', 'IGUALDADE', 'DESIGUALDADE',
            'MAIOR', 'MENOR', 'ABRE-PARENTESES', 'FECHA-PARENTESES', 'ABRE-CHAVES', 'FECHA-CHAVES', 'MENOS', 'MAIS', 'MULTIPLICA', 'DIVIDE',
            'I-IF', 'F-FOR-FUNCTION', 'O-FOR', 'P-PRINT', 'R-PRINT', 'I-PRINT', 'N-PRINT', '!-DESIGUALDADE',
            'W-WHILE', 'H-WHILE', 'I-WHILE', 'L-WHILE', 'ESPACO', 'QUEBRA-LINHA',
            'U-FUNCTION', 'N-FUNCTION', 'C-FUNCTION', 'T-FUNCTION', 'I-FUNCTION', 'O-FUNCTION', 'FUNCTION', 'VIRGULA', 'PONTO-VIRGULA', 'VAZIO',
        ];
    }

    private static function getEstadoInicial()
    {
        return 'INICIO';
    }

    private static function getEstadosFinais()
    {
        return [
            'IDENTIFICADOR',
            'IF',
            'FOR',
            'WHILE',
            'PRINT',
            'CONSTANTE',
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
            'IGUALDADE',
            'DESIGUALDADE',
            'ESPACO',
            'QUEBRA-LINHA',
            'FUNCTION',
            'VIRGULA', 
            'PONTO-VIRGULA',
            'VAZIO',
        ];
    }

    private static function getTransicoes()
    {
        $transicoes = [];

        $conjuntoTransicoes = [
            self::getTransicoesINICIO(),
            self::getTransicoesESPACO(),
            self::getTransicoesQUEBRALINHA(),
            self::getTransicoesIDENTIFICADOR(),
            self::getTransicoesCONSTANTE(),
            self::getTransicoesIDENTIFICADOR(),
            self::getTransicoesRECEBE(),
            self::getTransicoesDESIGUALDADE(),
            self::getTransicoesIF(),
            self::getTransicoesFOR(),
            self::getTransicoesWHILE(),
            self::getTransicoesPRINT(),
            self::getTransicoesFUNCTION()
        ];

        foreach($conjuntoTransicoes as $transicoesDoConjunto) {
            $transicoes = array_merge($transicoes, $transicoesDoConjunto);
        }

        return $transicoes;
    }

    private static function getTransicoesINICIO() : array
    {
        return [
            'INICIO' => Builder::getTransitions([
                'VAZIO'            => [''],
                'I-IF'             => ['I'],
                'F-FOR-FUNCTION'   => ['F'],
                'P-PRINT'          => ['P'],
                'W-WHILE'          => ['W'],
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
                '!-DESIGUALDADE'   => ['!'],
                'ESPACO'           => [' '],
                'VIRGULA'          => [','], 
                'PONTO-VIRGULA'    => [';'],
                'QUEBRA-LINHA'     => [PHP_EOL],
                'CONSTANTE'        => Builder::getNumbers(),
                'IDENTIFICADOR'    => Builder::getInputs(Builder::getLetters(), ['I', 'F', 'P', 'W']),
            ])
        ];
    }

    private static function getTransicoesIF() : array
    {
        return [
            'I-IF' => Builder::getTransitions([
                'IF'      => ['F'],
                'IDENTIFICADOR' => Builder::getInputs([Builder::getLetters(), Builder::getNumbers(), ''], ['F'])
            ]),
            'IF' => Builder::getTransitions(['IDENTIFICADOR' => Builder::getInputs([Builder::getLetters(), Builder::getNumbers()])])
        ];
    }

    private static function getTransicoesWHILE() : array
    {
        return [
            'W-WHILE' => Builder::getTransitions([
                'H-WHILE'      => ['H'],
                'IDENTIFICADOR' => Builder::getInputs([Builder::getLetters(), Builder::getNumbers(), ''], ['H'])
            ]),
            'H-WHILE' => Builder::getTransitions([
                'I-WHILE'      => ['I'],
                'IDENTIFICADOR' => Builder::getInputs([Builder::getLetters(), Builder::getNumbers(), ''], ['I'])
            ]),
            'I-WHILE' => Builder::getTransitions([
                'L-WHILE'      => ['L'],
                'IDENTIFICADOR' => Builder::getInputs([Builder::getLetters(), Builder::getNumbers(), ''], ['L'])
            ]),
            'L-WHILE' => Builder::getTransitions([
                'WHILE'      => ['E'],
                'IDENTIFICADOR' => Builder::getInputs([Builder::getLetters(), Builder::getNumbers(), ''], ['E'])
            ]),
            'WHILE' => Builder::getTransitions(['WHILE' => [''], 'IDENTIFICADOR' => Builder::getInputs([Builder::getLetters(), Builder::getNumbers()])])
        ];
    }

    private static function getTransicoesFOR() : array
    {
        return [
            'F-FOR-FUNCTION' => Builder::getTransitions([
                'O-FOR'    => ['O'],
                'IDENTIFICADOR' => Builder::getInputs([Builder::getLetters(), Builder::getNumbers(), ''], ['O'])
            ]),
            'O-FOR' => Builder::getTransitions([
                'FOR'    => ['R'],
                'IDENTIFICADOR' => Builder::getInputs([Builder::getLetters(), Builder::getNumbers(), ''], ['R'])
            ]),
            'FOR' => Builder::getTransitions(['IDENTIFICADOR' => Builder::getInputs([Builder::getLetters(), Builder::getNumbers()])])
        ];
    }

    private static function getTransicoesPRINT() : array
    {
        return [
            'P-PRINT' => Builder::getTransitions([
                'R-PRINT'    => ['R'],
                'IDENTIFICADOR' => Builder::getInputs([Builder::getLetters(), Builder::getNumbers(), ''], ['R'])
            ]),
            'R-PRINT' => Builder::getTransitions([
                'I-PRINT'    => ['I'],
                'IDENTIFICADOR' => Builder::getInputs([Builder::getLetters(), Builder::getNumbers(), ''], ['I'])
            ]),
            'I-PRINT' => Builder::getTransitions([
                'N-PRINT'    => ['N'],
                'IDENTIFICADOR' => Builder::getInputs([Builder::getLetters(), Builder::getNumbers(), ''], ['N'])
            ]),
            'N-PRINT' => Builder::getTransitions([
                'PRINT'    => ['T'],
                'IDENTIFICADOR' => Builder::getInputs([Builder::getLetters(), Builder::getNumbers(), ''], ['T'])
            ]),
            'PRINT' => Builder::getTransitions(['IDENTIFICADOR' => Builder::getInputs([Builder::getLetters(), Builder::getNumbers()])])
        ];
    }

    private static function getTransicoesFUNCTION() : array
    {
        return [
            'F-FOR-FUNCTION' => Builder::getTransitions([
                'U-FUNCTION'    => ['U'],
                'IDENTIFICADOR' => Builder::getInputs([Builder::getLetters(), Builder::getNumbers(), ''], ['U'])
            ]),
            'U-FUNCTION' => Builder::getTransitions([
                'N-FUNCTION'    => ['N'],
                'IDENTIFICADOR' => Builder::getInputs([Builder::getLetters(), Builder::getNumbers(), ''], ['N'])
            ]),
            'N-FUNCTION' => Builder::getTransitions([
                'C-FUNCTION'    => ['C'],
                'IDENTIFICADOR' => Builder::getInputs([Builder::getLetters(), Builder::getNumbers(), ''], ['C'])
            ]),
            'C-FUNCTION' => Builder::getTransitions([
                'T-FUNCTION'    => ['T'],
                'IDENTIFICADOR' => Builder::getInputs([Builder::getLetters(), Builder::getNumbers(), ''], ['T'])
            ]),
            'T-FUNCTION' => Builder::getTransitions([
                'I-FUNCTION'    => ['I'],
                'IDENTIFICADOR' => Builder::getInputs([Builder::getLetters(), Builder::getNumbers(), ''], ['I'])
            ]),
            'I-FUNCTION' => Builder::getTransitions([
                'O-FUNCTION'    => ['O'],
                'IDENTIFICADOR' => Builder::getInputs([Builder::getLetters(), Builder::getNumbers(), ''], ['O'])
            ]),
            'O-FUNCTION' => Builder::getTransitions([
                'FUNCTION'    => ['N'],
                'IDENTIFICADOR' => Builder::getInputs([Builder::getLetters(), Builder::getNumbers(), ''], ['N'])
            ]),
            'FUNCTION' => Builder::getTransitions(['IDENTIFICADOR' => Builder::getInputs([Builder::getLetters(), Builder::getNumbers()])])
        ];
    }

    private static function getTransicoesIDENTIFICADOR() : array
    {
        return ['IDENTIFICADOR' => Builder::getTransitions(['IDENTIFICADOR' => Builder::getInputs([Builder::getLetters(), Builder::getNumbers()])])];
    }

    private static function getTransicoesCONSTANTE() : array
    {
        return [
            'CONSTANTE' => Builder::getTransitions([
                'CONSTANTE' => Builder::getNumbers(),
                'IDENTIFICADOR' => Builder::getLetters()
            ])
        ];
    }

    private static function getTransicoesRECEBE() : array
    {
        return ['RECEBE' => ['=' => 'IGUALDADE']];
    }

    private static function getTransicoesDESIGUALDADE() : array
    {
        return ['!-DESIGUALDADE' => ['=' => 'DESIGUALDADE']];
    }

    private static function getTransicoesESPACO() : array
    {
        return ['ESPACO' => [' ' => 'ESPACO']];
    }

    private static function getTransicoesQUEBRALINHA() : array
    {
        return ['QUEBRA-LINHA' => [PHP_EOL => 'QUEBRA-LINHA']];
    }

    public static function get() : self
    {
        return new self();
    }
}
