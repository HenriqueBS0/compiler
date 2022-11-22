<?php

namespace HenriqueBS0\Compiler\EstruturasAnalise;

use Closure;
use HenriqueBS0\Compiler\EstruturasAnalise\AnaliseSemantica\AnalisadorSemantico;
use HenriqueBS0\LexicalAnalyzer\LexicalAnalyzer;
use HenriqueBS0\LexicalAnalyzer\LexicalAnalyzerException;
use HenriqueBS0\LexicalAnalyzer\TokenStack;
use HenriqueBS0\SyntacticAnalyzer\Parsers\ParserSLR;
use HenriqueBS0\SyntacticAnalyzer\Parsers\SyntacticException;
use HenriqueBS0\SyntacticAnalyzer\SLR\Semantic\SemanticAnalyzerException;

class Parser extends ParserSLR {
    public function __construct() {
        parent::__construct(new LexicalAnalyzer(Automato::get()), Gramatica::get());
        $this->setPrepareTokenStack(self::getFuncaoTratarPilhaTokens());
        $this->setOnReduceTable(TabelaReducoes::get());
        $this->setSemanticAnalyzer(new AnalisadorSemantico());
    }

    private static function getFuncaoTratarPilhaTokens() : Closure
    {
        return function(TokenStack $tokenStack) {
            $pilhaTratada = new TokenStack();
    
            while(!$tokenStack->isEmpty()) {
                $token = $tokenStack->pop();
        
                if(!in_array($token->getToken(), ['ESPACO', 'QUEBRA-LINHA'])) {
                    $pilhaTratada->push($token);
                }
            }
        
            return $pilhaTratada->reverseOrdering();
        };
    }

    /**
     * @param string $input
     * @throws ParserException
     * @return mixed
     */
    public function getParseTree(string $input): mixed
    {
        try {
            return parent::getParseTree($input);
        } 
        catch (LexicalAnalyzerException $ex) {
            throw ParserException::getExcecaoLexica($ex);
        }
        catch (SyntacticException $ex) {
            throw ParserException::getExcecaoSintatica($ex);
        }
        catch (SemanticAnalyzerException $ex) {
            throw ParserException::getExcecaoSemantica($ex);
        } 
    }
}