<?php 

namespace App\Library;

use GuzzleHttp\Client;

/**
 * Classe executar e retornar dados de endereço através do serviço externo viacep.com.br
 *
 * @author Lenon Melo
 */
class ViaCep
{

     /**
     * Busca dados de endereço pelo cep.
     *
     * @param string $cep cep para ser filtrado.
     * @return array
     */
    static function buscaCep($cep)
    {
        $client = new Client();
        
        $busca_dados_externos = $client->request('GET', "https://viacep.com.br/ws/{$cep}/json/");
        $dados_externos = json_decode($busca_dados_externos->getBody(), true);

        //Caso retornar o parâmetro erro, é por que o CEP não existe na base de CEP nacional
        if(isset($dados_externos['erro']) && $dados_externos['erro']){
            return false;
        }
        
        return [
            'cep' => str_replace("-", "", $dados_externos['cep']),
            'logradouro' => $dados_externos['logradouro'],
            'bairro' => $dados_externos['bairro'],
            'cidade' => $dados_externos['localidade'],
            'uf' => $dados_externos['uf']
        ];

    }

}