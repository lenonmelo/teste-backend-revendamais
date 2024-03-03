<?php 

namespace App\Services;

use App\Models\Bairro;
use App\Models\Cidade;

/**
 * Classe para manipulação de cidades.
 *
 * @author Lenon Melo
 */
class CidadeServices
{
 
    /**
     * Realiza as verificações de existencia da cidade e salva um novo caso não exista.
     *
     * @param string $cidade Nome da cidade para ser cadastrado.
     * @return Integer
     */
    public function salvarCidade($cidade)
    {
        $cidade_model = new Cidade();
        $dados_cidade = Cidade::where('cidade', $cidade)->first();
        
        if (!$dados_cidade) {
            $cidade_model->cidade = $cidade;
            $cidade_model->save();
            $dados_cidade = $cidade_model;
        }

        return $dados_cidade->id;
    }

}
