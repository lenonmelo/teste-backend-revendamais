<?php 

namespace App\Services;


use App\Models\Endereco;

/**
 * Classe para manipulação de enderecos.
 *
 * @author Lenon Melo
 */
class EnderecoServices
{
 
    /**
     * Salva um novo Endereço na base de dados.
     *
     * @param string $logradouro O logradouro do endereço.
     * @param int $cep_id O ID do CEP do endereço.
     * @param int $bairro_id O ID do bairro do endereço.
     * @param int $cidade_id O ID da cidade do endereço.
     * @param int $estado_id O ID do estado do endereço.
     *
     * @return int O ID do Endereço salvo na base de dados.
     *
     */
    public function salvarEndereco($logradouro, $cep_id, $bairro_id, $cidade_id, $estado_id)
    {
        $endereco_model = new Endereco();
        
        $endereco_model->logradouro = $logradouro;
        $endereco_model->cep_id = $cep_id;
        $endereco_model->bairro_id = $bairro_id;
        $endereco_model->cidade_id = $cidade_id;
        $endereco_model->estado_id = $estado_id;
        $endereco_model->save();
        
        return $endereco_model->id;
    }

}
