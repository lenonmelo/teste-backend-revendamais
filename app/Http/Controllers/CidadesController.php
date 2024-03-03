<?php

namespace App\Http\Controllers;

use App\Library\RetornoMensagem;
use App\Library\ValidarId;
use App\Models\Cidade;
use App\Rules\validarDelete;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class CidadesController extends Controller
{
    /**
     * Exibe a lista de cidades.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function index()
    {
        $cidades = Cidade::all();
        return response()->json(RetornoMensagem::retorno(['cidade'], $cidades, true));
    }


    /**
     * Cria uma nova cidade.
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function create(Request $request)
    {
        try {
            $data = $request->only([
                'cidade',
            ]);

            //Realiza a validação de campos obrigatórios
            $validator = $this->validarCidade($data);

            //Caso os campos estejam em brancos, retorna as mensagens de erros
            if ($validator->fails()) {
                return response()->json(RetornoMensagem::message('error', $validator->errors()))->setStatusCode(400);
            }

            $cidade = new Cidade();

            //Seta campos para serem incluidos
            $cidade->cidade = $data['cidade'];

            $cidade->save();

            return response()->json(RetornoMensagem::message('success', 'Cidade criada com sucesso', $cidade));
        } catch (Exception $e) {
            return response()->json(RetornoMensagem::message('error', 'Ocorreu um erro ao cadastrar a cidade - ' . $e->getMessage()));
        }
    }

    /**
     * Exibe uma cidade específica.
     *
     * @param string $id ID da cidade a ser exibida.
     * @return \Illuminate\Http\JsonResponse
     */
    public function show($id)
    {
        $cidade = Cidade::find($id);
        return response()->json(RetornoMensagem::retorno(['cidade'], $cidade));
    }

    /**
     * Atualiza uma cidade existente.
     *
     * @param Request $request Objeto Request contendo os dados da cidade atualizada.
     * @param string $id ID da cidade a ser atualizada.
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(Request $request, string $id)
    {

        try {
            $existe_id_cidade = ValidarId::validar($id, new Cidade());
            if (!$existe_id_cidade) {
                return response()->json(RetornoMensagem::message('error', 'Não foi encontrada cidade com o id enviado'))->setStatusCode(400);
            }

            $cidade = Cidade::find($id);

            $data = $request->only([
                'cidade',
            ]);

            //Realiza a validação de campos obrigatórios
            $validator = $this->validarCidade($data);

            //Caso os campos estejam em brancos, retorna as mensagens de erros
            if ($validator->fails()) {
                return response()->json(RetornoMensagem::message('error', $validator->errors()))->setStatusCode(400);
            }

            //Seta campos para serem incluidos
            $cidade->cidade = $data['cidade'];

            $cidade->save();

            return response()->json(RetornoMensagem::message('success', 'Cidade atualizada com sucesso', $cidade));
        } catch (Exception $e) {
            return response()->json(RetornoMensagem::message('error', 'Ocorreu um erro ao alterar a cidade - ' . $e->getMessage()));
        }
    }

    /**
     * Remove uma cidade.
     *
     * @param string $id ID da cidade a ser removida.
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy(string $id)
    {
        $existe_id_cidade = ValidarId::validar($id, new Cidade());
        if (!$existe_id_cidade) {
            return response()->json(RetornoMensagem::message('error', 'Não foi encontrada cidade com o id enviado'))->setStatusCode(400);
        }

        $cidade = Cidade::find($id);
        //Realiza a validação para ver se o id esta relacionado a algum endereço
        //Pode ser removido se não tiver nenhuma relação
        $validator =  Validator::make($cidade->getAttributes(), [
            'id' => [ new validarDelete('cidade_id')],
        ]);
        if ($validator->fails()) {
            return response()->json(RetornoMensagem::message('error', $validator->errors()))->setStatusCode(400);
        }
        $cidade->delete();

        return response()->json(RetornoMensagem::message('success', 'Cidade removida com sucesso'));
    }

    /**
     * Valida os dados da cidade.
     *
     * @param array $data Dados da cidade a ser validada.
     * @return \Illuminate\Validation\Validator
     */
    private function validarCidade(array $data): \Illuminate\Validation\Validator
    {
        return Validator::make($data, [
            'cidade' => ['required', 'string', 'max:45', 'unique:cidades,cidade'],
        ], [
            'cidade.required' => 'Parâmetro Cidade é obrigatório',
            'cidade.unique' => 'Essa cidade já existe no sistema',
        ]);
    }
}
