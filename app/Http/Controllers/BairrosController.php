<?php

namespace App\Http\Controllers;

use App\Library\RetornoMensagem;
use App\Library\ValidarId;
use App\Models\Bairro;
use App\Rules\validarDelete;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class BairrosController extends Controller
{
    /**
     * Exibe a lista de bairros.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function index()
    {
        $bairros = Bairro::all();
        return response()->json(RetornoMensagem::retorno(['bairro'], $bairros, true));
    }


    /**
     * Cria uma novo bairro.
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function create(Request $request)
    {
        try {

            $data = $request->only([
                'bairro',
            ]);


            //Realiza a validação de campos obrigatórios
            $validator = $this->validarBairro($data);

            //Caso os campos estejam em brancos, retorna as mensagens de erros
            if ($validator->fails()) {
                return response()->json(RetornoMensagem::message('error', $validator->errors()))->setStatusCode(400);
            }

            $bairro = new Bairro();

            //Seta campos para serem incluidos
            $bairro->bairro = $data['bairro'];

            $bairro->save();

            return response()->json(RetornoMensagem::message('success', 'Bairro criado com sucesso', $bairro));
        } catch (Exception $e) {
            return response()->json(RetornoMensagem::message('error', 'Ocorreu um erro ao salvar o bairro - ' . $e->getMessage()));
        }
    }

    /**
     * Exibe um bairro específico.
     *
     * @param string $id ID do bairro a ser exibida.
     * @return \Illuminate\Http\JsonResponse
     */
    public function show($id)
    {
        $bairro = Bairro::find($id);
        return response()->json(RetornoMensagem::retorno(['bairro'], $bairro));
    }

    /**
     * Atualiza um bairro existente.
     *
     * @param Request $request Objeto Request contendo os dados do bairro atualizada.
     * @param string $id ID do bairro a ser atualizada.
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(Request $request, string $id)
    {
        try {
            $existe_id_bairro = ValidarId::validar($id, new Bairro());
            if (!$existe_id_bairro) {
                return response()->json(RetornoMensagem::message('error', 'Não foi encontrada um bairro com o id enviado'))->setStatusCode(400);
            }

            $bairro = Bairro::find($id);

            $data = $request->only([
                'bairro',
            ]);

            //Realiza a validação de campos obrigatórios
            $validator = $this->validarBairro($data);

            //Caso os campos estejam em brancos, retorna as mensagens de erros
            if ($validator->fails()) {
                return response()->json(RetornoMensagem::message('error', $validator->errors()))->setStatusCode(400);
            }

            //Seta campos para serem incluidos
            $bairro->bairro = $data['bairro'];

            $bairro->save();

            return response()->json(RetornoMensagem::message('success', 'Bairro atualizado com sucesso', $bairro));
        } catch (Exception $e) {
            return response()->json(RetornoMensagem::message('error', 'Ocorreu um erro ao alterar o bairro - ' . $e->getMessage()));
        }
    }

    /**
     * Remove um bairro.
     *
     * @param string $id ID do bairro a ser removida.
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy(string $id)
    {
        $existe_id_bairro = ValidarId::validar($id, new Bairro());
        if (!$existe_id_bairro) {
            return response()->json(RetornoMensagem::message('error', 'Não foi encontrado bairro com o id enviado'))->setStatusCode(400);
        }

        $bairro = Bairro::find($id);

        //Realiza a validação para ver se o id esta relacionado a algum endereço
        //Pode ser removido se não tiver nenhuma relação
        $validator =  Validator::make($bairro->getAttributes(), [
            'id' => [ new validarDelete('bairro_id')],
        ]);
        if ($validator->fails()) {
            return response()->json(RetornoMensagem::message('error', $validator->errors()))->setStatusCode(400);
        }

        $bairro->delete();

        return response()->json(RetornoMensagem::message('success', 'Bairro removido com sucesso'));
    }

    /**
     * Valida os dados do bairro.
     *
     * @param array $data Dados do bairro a ser validada.
     * @return \Illuminate\Validation\Validator
     */
    private function validarBairro(array $data): \Illuminate\Validation\Validator
    {
        return Validator::make($data, [
            'bairro' => ['required', 'string', 'max:45', 'unique:bairros,bairro'],
        ], [
            'bairro.required' => 'Parâmetro bairro é obrigatório',
            'bairro.unique' => 'Esse bairro já existe no sistema',
        ]);
    }
}
