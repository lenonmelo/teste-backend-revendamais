<?php

namespace App\Http\Controllers;

use App\Library\RetornoMensagem;
use App\Library\ValidarId;
use App\Library\ViaCep;

use App\Models\Endereco;
use App\Rules\Cep;
use App\Rules\ValidacaoDeFk;
use App\Services\BairroServices;
use App\Services\CepServices;
use App\Services\CidadeServices;
use App\Services\EnderecoServices;
use App\Services\EstadoServices;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class EnderecosController extends Controller
{
    /**
     * Exibe a lista de endereços com seus respectivos CEPS.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function index()
    {
        $endereco = Endereco::all();
        $endereco->load('cep', 'bairro', 'cidade', 'estado');

        return response()->json(RetornoMensagem::retorno(['cep', 'logradouro', 'bairro', 'cidade', 'estado'], $endereco, true));
    }

    /**
     * Exibe umm endereços com seus respectivos CEP.
     *
     * @param string $id ID do endereço a ser exibida.
     * @return \Illuminate\Http\JsonResponse
     */
    public function show($id)
    {
        $endereco = Endereco::find($id);
        $endereco->load('cep', 'bairro', 'cidade', 'estado');

        return response()->json(RetornoMensagem::retorno(['cep', 'logradouro', 'bairro', 'cidade', 'estado'], $endereco));
    }

    /**
     * Cria uma novo Endereço e CEP.
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function create(Request $request)
    {
        try {
            $data = $request->only([
                'cep',
                'logradouro',
                'estado_id',
                'cidade_id',
                'bairro_id',
            ]);

            //Realiza a validação de campos obrigatórios
            $validator = $this->validarEndereço($data);

            //Caso os campos estejam em brancos, retorna as mensagens de erros
            if ($validator->fails()) {
                return response()->json(RetornoMensagem::message('error', $validator->errors()))->setStatusCode(400);
            }

            $cepServices = new CepServices();
            $cep_id = $cepServices->salvarCep($data['cep']);

            $endereco = new Endereco();

            //Seta campos para serem incluidos
            $data['cep_id'] = $cep_id;

            $endereco = $this->preencheEndereco($endereco, $data);

            $endereco->save();

            $endereco->load('cep', 'bairro', 'cidade', 'estado');

            return response()->json(RetornoMensagem::message('success', 'Endereço criada com sucesso', $endereco));
        } catch (Exception $e) {
            return response()->json(RetornoMensagem::message('error', 'Ocorreu um erro ao cadastrar o endereço - ' . $e->getMessage()));
        }
    }

    /**
     * Atualiza um endereco existente.
     *
     * @param Request $request Objeto Request contendo os dados do endereço atualizada.
     * @param string $id ID do endereço a ser atualizada.
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(Request $request, string $id)
    {

        try {
            $existe_id_endereco = ValidarId::validar($id, new Endereco());
            if (!$existe_id_endereco) {
                return response()->json(RetornoMensagem::message('error', 'Não foi encontrado endereco com o id enviado'))->setStatusCode(400);
            }

            $data = $request->only([
                'cep',
                'logradouro',
                'estado_id',
                'cidade_id',
                'bairro_id',
            ]);

            //Realiza a validação de campos obrigatórios
            $validator = $this->validarEndereço($data);

            //Caso os campos estejam em brancos, retorna as mensagens de erros
            if ($validator->fails()) {
                return response()->json(RetornoMensagem::message('error', $validator->errors()))->setStatusCode(400);
            }

            $cepServices = new CepServices();
            $cep_id = $cepServices->salvarCep($data['cep']);

            $endereco = Endereco::find($id);

            //Seta campos para serem incluidos
            $data['cep_id'] = $cep_id;
            $endereco = $this->preencheEndereco($endereco, $data);

            $endereco->save();

            $endereco->load('cep', 'bairro', 'cidade', 'estado');

            return response()->json(RetornoMensagem::message('success', 'Endereço alterado com sucesso', $endereco));
        } catch (Exception $e) {
            return response()->json(RetornoMensagem::message('error', 'Ocorreu um erro ao cadastrar o endereço - ' . $e->getMessage()));
        }
    }

    /**
     * Remove um endereço.
     *
     * @param string $id ID do endereço a ser removida.
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy(string $id)
    {
        $existe_id_endereco = ValidarId::validar($id, new Endereco());
        if (!$existe_id_endereco) {
            return response()->json(RetornoMensagem::message('error', 'Não foi encontrado endereco com o id enviado'))->setStatusCode(400);
        }

        $endreco = Endereco::find($id);
        $endreco->delete();

        return response()->json(RetornoMensagem::message('success', 'Endereço removido com sucesso'));
    }

    /**
     * Valida os dados do endereços e CEPs.
     *
     * @param array $data Dados do endereço a ser validada.
     * @return \Illuminate\Validation\Validator
     */
    private function validarEndereço(array $data): \Illuminate\Validation\Validator
    {
        return Validator::make($data, [
            'cep' => ['required', new Cep],
            'logradouro' => ['required', 'string', 'max:45'],
            'estado_id' => ['required', new ValidacaoDeFk('estado', 'id')],
            'cidade_id' => ['required', new ValidacaoDeFk('cidade', 'id')],
            'bairro_id' => ['required', new ValidacaoDeFk('bairro', 'id')]
        ], [
            'cep.required' => 'Parâmetro cep é obrigatório',
            'logradouro.required' => 'Parâmetro logradouro é obrigatório',
            'estado_id.required' => 'Parâmetro estado_id é obrigatório',
            'cidade_id.required' => 'Parâmetro cidade_id é obrigatório',
            'bairro_id.required' => 'Parâmetro bairro_id é obrigatório',
        ]);
    }

    /**
     * Preenche os campos de um objeto Endereço com os dados informados.
     *
     * @param Endereço $endereco Objeto da classe Endereço a ser preenchido.
     * @param array $data Array com os dados do endereço.
     *
     * @return Endereço O objeto Endereço preenchido com os dados informados.
     *
     * @throws Exception Se o array `$data` não contiver todos os campos necessários.
     */
    public function preencheEndereco(Endereco $endereco, $data)
    {
        $endereco->logradouro = $data['logradouro'];
        $endereco->cep_id = $data['cep_id'];
        $endereco->bairro_id = $data['bairro_id'];
        $endereco->cidade_id = $data['cidade_id'];
        $endereco->estado_id = $data['estado_id'];


        return $endereco;
    }

    /**
     * Busca um Endereço pelo CEP informado. Se o CEP não for encontrado na base de dados local, o método buscará o endereço no ViaCEP e o salvará na base de dados local.
     *
     * @param string $cep O CEP a ser buscado.
     *
     * @return Endereço|null Um objeto Endereço com os dados do CEP ou `null` se o CEP não for encontrado.
     *
     * @throws Exception Se o serviço ViaCEP estiver indisponível.
     */
    public function buscaPorCep($cep)
    {
        try {
            //Realizar a validação do CEP
            $validacao =  Validator::make(['cep' => $cep], [
                'cep' => ['required', new Cep],
            ]);
            if ($validacao->fails()) {
                return response()->json(RetornoMensagem::message('error', $validacao->errors()))->setStatusCode(400);
            }

            $cepServices = new CepServices();

            $cep_id_local = $cepServices->buscaEnderecoPeloCep($cep);
            if (!$cep_id_local) {

                $viacep = new ViaCep();
                $endereco_externo = $viacep->buscaCep($cep);

                //Caso não existir o CEP na base de dados do viacep, é retornado a mensagem abaixo
                if (!$endereco_externo) {
                    return response()->json(RetornoMensagem::message('error', 'Esse cep não existe'))->setStatusCode(400);
                }

                $bairro_service = new BairroServices();
                $bairro_id = $bairro_service->salvarBairro($endereco_externo['bairro']);

                $cidade_service = new CidadeServices();
                $cidade_id = $cidade_service->salvarCidade($endereco_externo['cidade']);

                $estado_service = new EstadoServices();
                $estado_id = $estado_service->salvarEstado($endereco_externo['uf']);

                $cepServices = new CepServices();
                $cep_id = $cepServices->salvarCep($endereco_externo['cep']);

                $endereco_service = new EnderecoServices();
                $id_endereco = $endereco_service->salvarEndereco($endereco_externo['logradouro'], $cep_id, $bairro_id, $cidade_id, $estado_id);

                $enderecos_cep = Endereco::find($id_endereco);
                $enderecos_cep->load('cep', 'bairro', 'cidade', 'estado');

                return response()->json([RetornoMensagem::retorno(['cep', 'logradouro', 'bairro', 'cidade', 'estado'], $enderecos_cep)]);
            }
            $enderecos_cep = Endereco::where("cep_id", $cep_id_local)->get();
            $enderecos_cep->load('cep', 'bairro', 'cidade', 'estado');
            return response()->json(RetornoMensagem::retorno(['cep', 'logradouro', 'bairro', 'cidade', 'estado'], $enderecos_cep, true));
        } catch (Exception $e) {
            return response()->json(RetornoMensagem::message('error', 'Ocorreu um erro buscar o endereço pelo CEP - ' . $e->getMessage()));
        }
    }

    /**
     * Busca Endereços por um termo de pesquisa. O termo de pesquisa pode ser o logradouro, bairro, cidade, estado ou sigla do estado.
     *
     * @param Request $request Objeto Request com os dados da requisição.
     *
     * @return array Um array com os objetos Endereço encontrados.
     *
     * @throws Exception Se a validação do Request falhar.
     */
    public function buscaPorEndereco(Request $request)
    {

        try {
            $data = $request->only([
                'endereco',
            ]);

            //Realiza a validação de campos obrigatórios
            $validator = Validator::make($data, [
                'endereco' => ['required', 'string', 'max:45'],
            ], [
                'endereco.required' => 'Campo endereco é obrigatório'
            ]);

            if ($validator->fails()) {
                return response()->json(RetornoMensagem::message('error', $validator->errors()))->setStatusCode(400);
            }

            $endereco = $data['endereco'];
            $enderecos = Endereco::query()
                ->select(['c.cep', 'enderecos.logradouro', 'b.bairro', 'cid.cidade', 'est.estado', 'est.sigla'])
                ->join('ceps AS c', 'c.id', '=', 'enderecos.cep_id')
                ->join('bairros AS b', 'b.id', '=', 'enderecos.bairro_id')
                ->join('cidades AS cid', 'cid.id', '=', 'enderecos.cidade_id')
                ->join('estados AS est', 'est.id', '=', 'enderecos.estado_id')
                ->where(function ($query) use ($endereco) {
                    $query->where('enderecos.logradouro', 'like', "%$endereco%")
                        ->orWhere('b.bairro', 'like', "%$endereco%")
                        ->orWhere('cid.cidade', 'like', "%$endereco%")
                        ->orWhere('est.estado', 'like', "%$endereco%")
                        ->orWhere('est.sigla', 'like', "%$endereco%");
                })->get();

            return response()->json(RetornoMensagem::retorno(['cep', 'logradouro', 'bairro', 'cidade', 'estado'], $enderecos->toArray(), true));
        } catch (Exception $e) {
            return response()->json(RetornoMensagem::message('error', 'Ocorreu um erro ao cadastrar o endereço - ' . $e->getMessage()));
        }
    }
}
