<?php

namespace HenriqueBS0\Compiler\EstruturasAnalise;

use Closure;
use HenriqueBS0\LexicalAnalyzer\LexicalAnalyzer;
use HenriqueBS0\LexicalAnalyzer\TokenStack;
use HenriqueBS0\SyntacticAnalyzer\Parsers\ParserSLR;

class Parser extends ParserSLR {
    public function __construct() {
        parent::__construct(new LexicalAnalyzer(Automato::get()), Gramatica::get());
        $this->setPrepareTokenStack(self::getFuncaoTratarPilhaTokens());
        $this->setOnReduceTable(TabelaReducoes::get());
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
}