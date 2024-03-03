<?php

namespace App\Rules;

use Closure;
use Illuminate\Contracts\Validation\ValidationRule;

class validarDelete implements ValidationRule
{
    private $coluna;

    public function __construct($coluna)
    {
        $this->coluna = $coluna;
    }

    /**
     * Run the validation rule.
     *
     * @param  \Closure(string): \Illuminate\Translation\PotentiallyTranslatedString  $fail
     */
    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        $modelClass = $this->getModelClass("endereco");

        $existe_id = $modelClass::query()
            ->where($this->coluna, $value)
            ->exists();

        if ($existe_id) {
            $fail("O id $value npode ser excluido, pois ele tem esta relacionado a um endereço.");
        }
    }

    
    private function getModelClass($tabela)
    {
        // Utilize a lógica para determinar a classe do modelo com base na tabela
        // (Exemplo: substitua App\Models\User pelo modelo correto)
        return 'App\\Models\\' . $tabela;
    }
}
