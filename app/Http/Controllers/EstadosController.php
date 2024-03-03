<?php

namespace App\Http\Controllers;

use App\Library\RetornoMensagem;
use App\Library\ValidarId;
use App\Models\Estado;
use App\Rules\ValidacaoDeFk;
use App\Rules\validarDelete;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class EstadosController extends Controller
{
    /**
     * Exibe a lista de estados.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function index()
    {
        $estados = Estado::all();
        return response()->json(RetornoMensagem::retorno(['estado', 'sigla'], $estados, true));
    }

    /**
     * Cria uma novo Estado.
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function create(Request $request)
    {

        try {

            $data = $request->only([
                'estado',
                'sigla'
            ]);

            //Realiza a validação de campos obrigatórios
            $validator = $this->validarEstado($data);

            //Caso os campos estejam em brancos, retorna as mensagens de erros
            if ($validator->fails()) {
                return response()->json(RetornoMensagem::message('error', $validator->errors()))->setStatusCode(400);
            }

            $estado = new Estado();

            //Seta campos para serem incluidos
            $estado->estado = $data['estado'];
            $estado->sigla = $data['sigla'];

            $estado->save();

            return response()->json(RetornoMensagem::message('success', 'Estado criada com sucesso', $estado));
        } catch (Exception $e) {
            return response()->json(RetornoMensagem::message('error', 'Ocorreu um erro ao cadastrar o estado - ' . $e->getMessage()));
        }
    }

    /**
     * Exibe umm estados específica.
     *
     * @param string $id ID do estado a ser exibida.
     * @return \Illuminate\Http\JsonResponse
     */
    public function show($id)
    {
        $estado = Estado::find($id);
        return response()->json(RetornoMensagem::retorno(['estado', 'sigla'], $estado));
    }

    /**
     * Atualiza um estado existente.
     *
     * @param Request $request Objeto Request contendo os dados do estado atualizada.
     * @param string $id ID do estado a ser atualizada.
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(Request $request, string $id)
    {
        try {
            $existe_id_estado = ValidarId::validar($id, new Estado());
            
            if (!$existe_id_estado) {
                return response()->json(RetornoMensagem::message('error', 'Não foi encontrado estado com o id enviado'))->setStatusCode(400);
            }

            $estado = Estado::find($id);

            $data = $request->only([
                'estado',
                'sigla'
            ]);

            //Realiza a validação de campos obrigatórios
            $validator = $this->validarEstado($data);

            //Caso os campos estejam em brancos, retorna as mensagens de erros
            if ($validator->fails()) {
                return response()->json(RetornoMensagem::message('error', $validator->errors()))->setStatusCode(400);
            }

            //Seta campos para serem incluidos
            $estado->estado = $data['estado'];
            $estado->sigla = $data['sigla'];

            $estado->save();

            return response()->json(RetornoMensagem::message('success', 'Estado atualizado com sucesso', $estado));
        } catch (Exception $e) {
            return response()->json(RetornoMensagem::message('error', 'Ocorreu um erro ao alterar o estado - ' . $e->getMessage()));
        }
    }

    /**
     * Remove um estado.
     *
     * @param string $id ID do estado a ser removida.
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy(string $id)
    {

        $existe_id_estado = ValidarId::validar($id, new Estado());
        if (!$existe_id_estado) {
            return response()->json(RetornoMensagem::message('error', 'Não foi encontrada estado com o id enviado'))->setStatusCode(400);
        }

        $estado = Estado::find($id);

        //Realiza a validação para ver se o id esta relacionado a algum endereço
        //Pode ser removido se não tiver nenhuma relação
        $validator =  Validator::make($estado->getAttributes(), [
            'id' => [ new validarDelete('estado_id')],
        ]);
        if ($validator->fails()) {
            return response()->json(RetornoMensagem::message('error', $validator->errors()))->setStatusCode(400);
        }

        $estado->delete();

        return response()->json(RetornoMensagem::message('success', 'Estado removida com sucesso'));
    }

    /**
     * Valida os dados do estado.
     *
     * @param array $data Dados do estado a ser validada.
     * @return \Illuminate\Validation\Validator
     */
    private function validarEstado(array $data): \Illuminate\Validation\Validator
    {
        return Validator::make($data, [
            'estado' => ['required', 'string', 'max:45', 'unique:estados,estado'],
            'sigla' => ['required', 'string', 'max:2', 'unique:estados,sigla'],
        ], [
            'estado.required' => 'Parâmetro estado é obrigatório',
            'estado.unique' => 'Esse estado já existe no sistema',
            'sigla.required' => 'Parâmetro sigla é obrigatório',
            'sigla.unique' => 'O estado com essa sigla já existe no sistema'
        ]);
    }
}
