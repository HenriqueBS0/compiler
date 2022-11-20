<?php

namespace HenriqueBS0\Compiler\EstruturasAnalise;

use HenriqueBS0\SyntacticAnalyzer\Grammar\Grammar;
use HenriqueBS0\SyntacticAnalyzer\Grammar\GrammarBuilder;

class Gramatica {
    static function get() : Grammar
    {
        return GrammarBuilder::getGrammar([
            'PROGRAMA                         ::= <DEFINICAO-FUNCOES> <EXECUCAO> | <EXECUCAO>',
            'DEFINICAO-FUNCOES                ::= <DEFINICAO-FUNCAO> <DEFINICAO-FUNCOES> | <DEFINICAO-FUNCAO>', 
            'DEFINICAO-FUNCAO                 ::= FUNCTION IDENTIFICADOR ABRE-PARENTESES FECHA-PARENTESES <BLOCO-CODIGO>',
            'DEFINICAO-FUNCAO                 ::= FUNCTION IDENTIFICADOR ABRE-PARENTESES <DEFINICAO-PARAMETROS-FUNCAO> FECHA-PARENTESES <BLOCO-CODIGO>',
            'DEFINICAO-PARAMETROS-FUNCAO      ::= <DEFINICAO-PARAMETRO-FUNCAO> VIRGULA <DEFINICAO-PARAMETROS-FUNCAO> | <DEFINICAO-PARAMETRO-FUNCAO>',
            'DEFINICAO-PARAMETRO-FUNCAO       ::= TIPO IDENTIFICADOR',
            'EXECUCAO                         ::= EXECUTE ABRE-PARENTESES FECHA-PARENTESES <BLOCO-CODIGO>',
            'BLOCO-CODIGO                     ::= ABRE-CHAVES <LISTA-COMANDOS> FECHA-CHAVES', 
            'LISTA-COMANDOS                   ::= <COMANDO> <LISTA-COMANDOS> | <COMANDO>',                               
            'COMANDO                          ::= <DECLARACAO-VARIAVEL> | <CHAMADA-FUNCAO> | <ATRIBUICAO> | <PRINTA> | <SE> | <ENQUANTO>',
            'DECLARACAO-VARIAVEL              ::= TIPO IDENTIFICADOR PONTO-VIRGULA',
            'CHAMADA-FUNCAO                   ::= IDENTIFICADOR ABRE-PARENTESES <PARAMETROS-FUNCAO> FECHA-PARENTESES PONTO-VIRGULA',
            'CHAMADA-FUNCAO                   ::= IDENTIFICADOR ABRE-PARENTESES FECHA-PARENTESES PONTO-VIRGULA',
            'PARAMETROS-FUNCAO                ::= IDENTIFICADOR VIRGULA <PARAMETROS-FUNCAO> | IDENTIFICADOR',
            'ATRIBUICAO                       ::= IDENTIFICADOR RECEBE CONSTANTE PONTO-VIRGULA',
            'ATRIBUICAO                       ::= IDENTIFICADOR RECEBE IDENTIFICADOR PONTO-VIRGULA',
            'ATRIBUICAO                       ::= IDENTIFICADOR RECEBE CADEIA PONTO-VIRGULA',
            'ATRIBUICAO                       ::= IDENTIFICADOR RECEBE TRUE PONTO-VIRGULA',
            'ATRIBUICAO                       ::= IDENTIFICADOR RECEBE FALSE PONTO-VIRGULA',
            'ATRIBUICAO                       ::= IDENTIFICADOR RECEBE NOT IDENTIFICADOR PONTO-VIRGULA',
            'ATRIBUICAO                       ::= IDENTIFICADOR RECEBE <OPERACAO-ARITIMETICA> PONTO-VIRGULA',
            'ATRIBUICAO                       ::= IDENTIFICADOR RECEBE <CONCATENACAO> PONTO-VIRGULA',
            'ATRIBUICAO                       ::= IDENTIFICADOR RECEBE <COMPARACAO-QUANTITATIVA> PONTO-VIRGULA',
            'ATRIBUICAO                       ::= IDENTIFICADOR RECEBE <COMPARACAO-IGUALDADE> PONTO-VIRGULA',
            'ATRIBUICAO                       ::= IDENTIFICADOR RECEBE <OPERACAO-LOGICA-AND> PONTO-VIRGULA',
            'ATRIBUICAO                       ::= IDENTIFICADOR RECEBE <OPERACAO-LOGICA-OR> PONTO-VIRGULA',
            'OPERACAO-ARITIMETICA             ::= CONSTANTE <OPERADOR-ARITIMETICO> CONSTANTE',
            'OPERACAO-ARITIMETICA             ::= IDENTIFICADOR <OPERADOR-ARITIMETICO> IDENTIFICADOR',
            'OPERACAO-ARITIMETICA             ::= IDENTIFICADOR <OPERADOR-ARITIMETICO> CONSTANTE',
            'OPERACAO-ARITIMETICA             ::= CONSTANTE <OPERADOR-ARITIMETICO> IDENTIFICADOR',
            'OPERACAO-ARITIMETICA             ::= CONSTANTE <OPERADOR-ARITIMETICO> <OPERACAO-ARITIMETICA>',
            'OPERACAO-ARITIMETICA             ::= IDENTIFICADOR <OPERADOR-ARITIMETICO> <OPERACAO-ARITIMETICA>',
            'OPERADOR-ARITIMETICO             ::= MAIS | MENOS | MULTIPLICA | DIVIDE',
            'CONCATENACAO                     ::= CADEIA PONTO CADEIA',
            'CONCATENACAO                     ::= IDENTIFICADOR PONTO IDENTIFICADOR',
            'CONCATENACAO                     ::= CADEIA PONTO IDENTIFICADOR',
            'CONCATENACAO                     ::= IDENTIFICADOR PONTO CADEIA',
            'CONCATENACAO                     ::= CADEIA PONTO <CONCATENACAO>',
            'CONCATENACAO                     ::= IDENTIFICADOR PONTO <CONCATENACAO>',
            'COMPARACAO-QUANTITATIVA          ::= CONSTANTE <OPERADOR-COMPARACAO-QUANTITATIVA> CONSTANTE',
            'COMPARACAO-QUANTITATIVA          ::= IDENTIFICADOR <OPERADOR-COMPARACAO-QUANTITATIVA> IDENTIFICADOR',
            'COMPARACAO-QUANTITATIVA          ::= CONSTANTE <OPERADOR-COMPARACAO-QUANTITATIVA> IDENTIFICADOR',
            'COMPARACAO-QUANTITATIVA          ::= IDENTIFICADOR <OPERADOR-COMPARACAO-QUANTITATIVA> CONSTANTE', 
            'OPERADOR-COMPARACAO-QUANTITATIVA ::= MAIOR | MENOR',
            'COMPARACAO-IGUALDADE             ::= CONSTANTE <OPERADOR-COMPARACAO-IGUALDADE> CONSTANTE',
            'COMPARACAO-IGUALDADE             ::= IDENTIFICADOR <OPERADOR-COMPARACAO-IGUALDADE> IDENTIFICADOR',
            'COMPARACAO-IGUALDADE             ::= CADEIA <OPERADOR-COMPARACAO-IGUALDADE> CADEIA',
            'COMPARACAO-IGUALDADE             ::= CONSTANTE <OPERADOR-COMPARACAO-IGUALDADE> IDENTIFICADOR',
            'COMPARACAO-IGUALDADE             ::= IDENTIFICADOR <OPERADOR-COMPARACAO-IGUALDADE> CONSTANTE',
            'COMPARACAO-IGUALDADE             ::= CADEIA <OPERADOR-COMPARACAO-IGUALDADE> IDENTIFICADOR',
            'COMPARACAO-IGUALDADE             ::= IDENTIFICADOR <OPERADOR-COMPARACAO-IGUALDADE> CADEIA',
            'OPERADOR-COMPARACAO-IGUALDADE    ::= IGUALDADE | DESIGUALDADE',
            'OPERACAO-LOGICA-AND              ::= IDENTIFICADOR AND <OPERACAO-LOGICA-AND> |IDENTIFICADOR AND IDENTIFICADOR',
            'OPERACAO-LOGICA-OR               ::= IDENTIFICADOR OR <OPERACAO-LOGICA-OR> |IDENTIFICADOR OR IDENTIFICADOR',      
            'PRINTA                           ::= PRINT ABRE-PARENTESES IDENTIFICADOR FECHA-PARENTESES PONTO-VIRGULA',
            'SE                               ::= IF ABRE-PARENTESES IDENTIFICADOR FECHA-PARENTESES <BLOCO-CODIGO>',
            'ENQUANTO                         ::= WHILE ABRE-PARENTESES IDENTIFICADOR FECHA-PARENTESES <BLOCO-CODIGO>',
        ]);
    }
}