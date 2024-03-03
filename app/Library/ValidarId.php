<?php

namespace App\Library;

/**
 * Classe para formatar mensagens de retorno em APIs.
 *
 * @author Lenon Melo
 */
class ValidarId
{
 
    /**
     * Verifica se o ID do model existe.
     *
     * @param string $id ID do model a ser verificada.
     * @return boolean
     */
    static function validar($id, object $model)
    {
        $dadosModel = $model::find($id);
        if (!$dadosModel) {
            return false;
        }

        return true;
    }

}
