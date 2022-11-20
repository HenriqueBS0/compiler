<?php

namespace HenriqueBS0\Compiler\EstruturasAnalise\ElementosArvoreSintatica;

use HenriqueBS0\SyntacticAnalyzer\SLR\Tree\Node;

class ListaComandos extends Node {
    private array $listaComandos = [];

    public function addComando(Comando $comando) : void
    {
        $this->listaComandos[] = $comando;
    }

    public function getListaComandos() : array
    {
        return $this->listaComandos;
    }

    public function setListaComandos(ListaComandos $listaComandos) : void
    {
        foreach ($listaComandos->getListaComandos() as $comando) {
            $this->addComando($comando);
        }
    } 
}