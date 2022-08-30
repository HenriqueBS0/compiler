<?php 

namespace HenriqueBS0\Compiler\Controllers;

use HenriqueBS0\Automaton\Automaton;
use HenriqueBS0\Automaton\Builder;
use HenriqueBS0\LexicalAnalyzer\LexicalAnalyzer;
use HenriqueBS0\LexicalAnalyzer\LexicalAnalyzerException;
use stdClass;

class AnalisadorLexicoController {
    public function interface() 
    {
        view('analisador-lexico.php');
    }

    public function getTokens() 
    {
        $input = str_replace(["\r\n", "\r"], "\n", $_REQUEST['entrada']);

        $retorno = new stdClass();
        $retorno->erro = false;

        try {
            $tokens = $this->getAnalisadorLexico()->getTokens($input);
        } catch (LexicalAnalyzerException $ex) {
            $tokens = $ex->getTokens();
            $retorno->erro = true;
            $retorno->mensagem = implode([
                "{$ex->getMessage()}<br>",
                "<ul>",
                "<li>Linha Inicial: {$ex->getPosition()->getStartLine()}</li>",
                "<li>Linha Final: {$ex->getPosition()->getEndLine()}</li>",
                "<li>Posição Inicial: {$ex->getPosition()->getLineStartPosition()}</li>",
                "<li>Posição Final: {$ex->getPosition()->getLineEndPosition()}</li>",
                "</ul>"
            ]);
        }
        finally {
            $retorno->tokens = [];
            while(!$tokens->isEmpty()) {

                $token = $tokens->pop();

                $retorno->tokens[] = (object) [
                    'token'          => $token->getToken(),
                    'lexema'         => $token->getLexeme(),
                    'linhaInicial'   => $token->getPosition()->getStartLine(), 
                    'linhaFinal'     => $token->getPosition()->getEndLine(), 
                    'posicaoInicial' => $token->getPosition()->getLineStartPosition(), 
                    'posicaoFinal'   => $token->getPosition()->getLineEndPosition()
                ];
            }
        }

        echo json_encode($retorno);
    }

    private function getAnalisadorLexico() : LexicalAnalyzer 
    {
        $alfabeto = array_merge(Builder::getLetters(), Builder::getNumbers(), ['', '<', '>', '(', ')', '{', '}', '-', '+', '*', '/', '=', '!', ' ', PHP_EOL]);

        $estados = [
            'INICIO', 'VARIAVEL', 'IF', 'FOR', 'WHILE', 'PRINT', 'CONSTANTE', 'RECEBE', 'IGUALDADE', 'DESIGUALDADE',
            'MAIOR', 'MENOR', 'ABRE-PARENTESES', 'FECHA-PARENTESES', 'ABRE-CHAVES', 'FECHA-CHAVES', 'MENOS', 'MAIS', 'MULTIPLICA', 'DIVIDE',
            'I-IF', 'F-FOR', 'O-FOR', 'P-PRINT', 'R-PRINT', 'I-PRINT', 'N-PRINT', '!-DESIGUALDADE',
            'W-WHILE', 'H-WHILE', 'I-WHILE', 'L-WHILE', 'ESPACO', 'QUEBRA-LINHA'
        ];

        $estadoInicial = 'INICIO';
    
        $trasicoes = [
            'INICIO' => Builder::getTransitions([
                'I-IF'             => ['I'],
                'F-FOR'            => ['F'],
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
                'QUEBRA-LINHA'     => [PHP_EOL],
                'CONSTANTE'        => Builder::getNumbers(),
                'VARIAVEL'         => Builder::getInputs(Builder::getLetters(), ['I', 'F', 'P', 'W']),
            ]),
            'I-IF' => Builder::getTransitions([
                'IF'      => ['F'],
                'VARIAVEL' => Builder::getInputs([Builder::getLetters(), Builder::getNumbers(), ''], ['F'])
            ]),
            'IF' => Builder::getTransitions(['VARIAVEL' => Builder::getInputs([Builder::getLetters(), Builder::getNumbers()])]),
            'W-WHILE' => Builder::getTransitions([
                'H-WHILE'      => ['H'],
                'VARIAVEL' => Builder::getInputs([Builder::getLetters(), Builder::getNumbers(), ''], ['H'])
            ]),
            'H-WHILE' => Builder::getTransitions([
                'I-WHILE'      => ['I'],
                'VARIAVEL' => Builder::getInputs([Builder::getLetters(), Builder::getNumbers(), ''], ['I'])
            ]),
            'I-WHILE' => Builder::getTransitions([
                'L-WHILE'      => ['L'],
                'VARIAVEL' => Builder::getInputs([Builder::getLetters(), Builder::getNumbers(), ''], ['L'])
            ]),
            'L-WHILE' => Builder::getTransitions([
                'WHILE'      => ['E'],
                'VARIAVEL' => Builder::getInputs([Builder::getLetters(), Builder::getNumbers(), ''], ['E'])
            ]),
            'WHILE' => Builder::getTransitions(['WHILE' => [''], 'VARIAVEL' => Builder::getInputs([Builder::getLetters(), Builder::getNumbers()])]),
            'F-FOR' => Builder::getTransitions([
                'O-FOR'    => ['O'],
                'VARIAVEL' => Builder::getInputs([Builder::getLetters(), Builder::getNumbers(), ''], ['O'])
            ]),
            'O-FOR' => Builder::getTransitions([
                'FOR'    => ['R'],
                'VARIAVEL' => Builder::getInputs([Builder::getLetters(), Builder::getNumbers(), ''], ['R'])
            ]),
            'FOR' => Builder::getTransitions(['VARIAVEL' => Builder::getInputs([Builder::getLetters(), Builder::getNumbers()])]),
            'P-PRINT' => Builder::getTransitions([
                'R-PRINT'    => ['R'],
                'VARIAVEL' => Builder::getInputs([Builder::getLetters(), Builder::getNumbers(), ''], ['R'])
            ]),
            'R-PRINT' => Builder::getTransitions([
                'I-PRINT'    => ['I'],
                'VARIAVEL' => Builder::getInputs([Builder::getLetters(), Builder::getNumbers(), ''], ['I'])
            ]),
            'I-PRINT' => Builder::getTransitions([
                'N-PRINT'    => ['N'],
                'VARIAVEL' => Builder::getInputs([Builder::getLetters(), Builder::getNumbers(), ''], ['N'])
            ]),
            'N-PRINT' => Builder::getTransitions([
                'PRINT'    => ['T'],
                'VARIAVEL' => Builder::getInputs([Builder::getLetters(), Builder::getNumbers(), ''], ['T'])
            ]),
            'PRINT' => Builder::getTransitions(['VARIAVEL' => Builder::getInputs([Builder::getLetters(), Builder::getNumbers()])]),
            'VARIAVEL' => Builder::getTransitions(['VARIAVEL' => Builder::getInputs([Builder::getLetters(), Builder::getNumbers()])]),
            'CONSTANTE' => Builder::getTransitions([
                'CONSTANTE' => Builder::getNumbers(),
                'VARIAVEL' => Builder::getLetters()
            ]),
            'RECEBE' => [
                '=' => 'IGUALDADE'
            ],
            '!-DESIGUALDADE' => [
                '=' => 'DESIGUALDADE'
            ],
            'ESPACO' => [
                ' ' => 'ESPACO'
            ],
            'QUEBRA-LINHA' => [
                PHP_EOL => 'QUEBRA-LINHA'
            ],
        ];
    
        $estadosFinais = [
            'VARIAVEL',
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
            'QUEBRA-LINHA'
        ];
    
        $automato = new Automaton($alfabeto, $estados, $estadoInicial, $estadosFinais,$trasicoes);

        return new LexicalAnalyzer($automato);
    }
}