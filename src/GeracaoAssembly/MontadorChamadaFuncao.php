<?php

namespace HenriqueBS0\Compiler\GeracaoAssembly;

use HenriqueBS0\Compiler\EstruturasAnalise\ElementosArvoreSintatica\ChamadaFuncao;
use HenriqueBS0\LexicalAnalyzer\Token;

class MontadorChamadaFuncao {
    public static function getComando(ChamadaFuncao $chamadaFuncao, ControladorFuncoes &$controladorFuncoes) : array
    {
        $funcaoAtual = $controladorFuncoes->getFuncao()->getNome();

        
        $indicesParametros = [];
        
        if(!is_null($chamadaFuncao->getParametrosFuncao())) {
            
            /** @var Token */
            foreach (array_reverse($chamadaFuncao->getParametrosFuncao()->getIdentificadores()) as $identificador) {
                $indicesParametros[] = $controladorFuncoes->getVariavel($identificador->getLexeme())->getIndice();
            }
        }
        
        $funcaoChamada = $chamadaFuncao->getIdentificador()->getLexeme();

        $controladorFuncoes->setFuncao($funcaoChamada);

        foreach ($controladorFuncoes->getFuncao()->getParametros() as $indiceParametro => $nomeVariavel) {
            $controladorFuncoes->getVariavel($nomeVariavel)->setIndice($indicesParametros[$indiceParametro]);
        }

        $comandos = MontadorComandos::getComandos($controladorFuncoes, $controladorFuncoes->getFuncao()->listaComandos);
        
        $controladorFuncoes->setFuncao($funcaoAtual);

        return $comandos;
    }
}