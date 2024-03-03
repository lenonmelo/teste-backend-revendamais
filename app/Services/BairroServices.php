<?php 

namespace App\Services;

use App\Library\ViaCep;
use App\Models\Bairro;
use App\Models\Cep;

/**
 * Classe para manipulação de bairros.
 *
 * @author Lenon Melo
 */
class BairroServices
{
 
    /**
     * Realiza as verificações de existencia do bairro e salva um novo caso não exista.
     *
     * @param string $bairro NOme do bairro para ser cadastrado.
     * @return Integer
     */
    public function salvarBairro($bairro)
    {
        $bairro_model = new Bairro();
        $dados_bairro = Bairro::where('bairro', $bairro)->first();
        
        if (!$dados_bairro) {
            $bairro_model->bairro = $bairro;
            $bairro_model->save();
            $dados_bairro = $bairro_model;
        }

        return $dados_bairro->id;
    }

}
