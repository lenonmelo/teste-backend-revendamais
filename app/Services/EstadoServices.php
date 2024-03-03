<?php 

namespace App\Services;

use App\Models\Bairro;
use App\Models\Estado;

/**
 * Classe para manipulação de bairros.
 *
 * @author Lenon Melo
 */
class EstadoServices
{
 
    /**
     * Realiza as verificações de existencia do estado e salva um novo caso não exista.
     *
     * @param string $uf Sigla do estado para ser cadastrado.
     * @return Integer
     */
    public function salvarEstado($uf)
    {
        $estado_model = new Estado();
        $dados_estado = Estado::where('sigla', $uf)->first();
        
        if (!$dados_estado) {
            $estado_model->estado = $this->encontraEstadoPorUf($uf);
            $estado_model->sigla = $uf;
            $estado_model->save();
            $dados_estado = $estado_model;
        }

        return $dados_estado->id;
    }

    
    /**
     * Retorna o nome por extenço do estado conforme a sigla UF enviada
     *
     * @param string $uf Sigla do estado para ser encontrada
     * @return string
     */
    public function encontraEstadoPorUf($uf)
    {
        $estados = [
            'AC' => 'Acre',
            'AL' => 'Alagoas',
            'AP' => 'Amapá',
            'AM' => 'Amazonas',
            'BA' => 'Bahia',
            'CE' => 'Ceará',
            'DF' => 'Distrito Federal',
            'ES' => 'Espírito Santo',
            'GO' => 'Goiás',
            'MA' => 'Maranhão',
            'MT' => 'Mato Grosso',
            'MS' => 'Mato Grosso do Sul',
            'MG' => 'Minas Gerais',
            'PA' => 'Pará',
            'PB' => 'Paraíba',
            'PR' => 'Paraná',
            'PE' => 'Pernambuco',
            'PI' => 'Piauí',
            'RJ' => 'Rio de Janeiro',
            'RN' => 'Rio Grande do Norte',
            'RS' => 'Rio Grande do Sul',
            'RO' => 'Rondônia',
            'RR' => 'Roraima',
            'SC' => 'Santa Catarina',
            'SP' => 'São Paulo',
            'SE' => 'Sergipe',
            'TO' => 'Tocantins',
        ];

        return $estados[$uf];
    }

}
