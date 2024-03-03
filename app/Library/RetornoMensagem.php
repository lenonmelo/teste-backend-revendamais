<?php

namespace App\Library;

/**
 * Classe para formatar mensagens de retorno em APIs.
 *
 * @author Lenon Melo
 */
class RetornoMensagem
{

    /**
     * Cria uma mensagem de retorno.
     *
     * @param string $status Status da operação (`success` ou `error`).
     * @param string $message Mensagem da operação.
     * @param mixed $data (opcional) Dados adicionais sobre a operação.
     * @return array
     */
    static function message($status, $message, $data = false)
    {
        $resposta = [
            'status' => $status,
            'message' => $message
        ];

        if ($data) {
            $resposta['data'] = $data;
        }

        return $resposta;
    }

    static function retorno(array $array_colunas, $dados, $multi = false)
    {
        $retorno = [];
        if ($multi) {
            foreach ($dados as $indice => $dado) {
                foreach ($array_colunas as $colunas) {
                    if (isset($dado[$colunas][$colunas])) {
                        $retorno[$indice][$colunas] = $dado[$colunas][$colunas];
                    } else {
                        $retorno[$indice][$colunas] = $dado[$colunas];
                    }
                }
            }
        } else {
            foreach ($array_colunas as $colunas) {
                if (isset($dados[$colunas][$colunas])) {
                    $retorno[$colunas] = $dados[$colunas][$colunas];
                } else {
                    $retorno[$colunas] = $dados[$colunas];
                }
            }
        }



        return $retorno;
    }
}
