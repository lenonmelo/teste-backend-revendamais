<?php

namespace App\Services;

use App\Models\Cep;

/**
 * Classe para manipulação de CEPs.
 *
 * @author Lenon Melo
 */
class CepServices
{

    /**
     * Realiza as verificações de existencia do CEP e salva um novo caso não exista.
     *
     * @param string $cep Cep para ser cadastrado.
     * @return boolean
     */
    public function salvarCep($cep)
    {
        $cepModel = new Cep();
        $dadosCep = Cep::where('cep', $cep)->first();

        if (!$dadosCep) {
            $cepModel->cep = $cep;
            $cepModel->save();
            $dadosCep = $cepModel;
        }

        return $dadosCep->id;
    }

    /**
     * Busca o ID do endereço na base de dados a partir do CEP.
     *
     * @param string $cep O CEP a ser buscado.
     *
     * @return int|bool O ID do endereço na base de dados ou `false` se o CEP não for encontrado.
     */
    public function buscaEnderecoPeloCep($cep)
    {

        $dados_cep = Cep::where('cep', $cep)->first();
        if (!$dados_cep) {
            return false;
        }
        return $dados_cep->id;
    }
}
