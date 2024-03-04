<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;

use App\Models\Bairro;
use App\Models\Cep;
use App\Models\Cidade;
use App\Models\Endereco;
use App\Models\Estado;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

use function Ramsey\Uuid\v1;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // \App\Models\User::factory(10)->create();

        \App\Models\User::factory()->create([
            'name' => "Usuario administrador",
            'email' => "admin@teste.com.br",
            'password' => Hash::make('admin'),
        ]);

        //Adiciona bairros
        Bairro::insert([
            ['bairro' => 'Santa Felicidade'],
            ['bairro' => 'São Geraldo'],
            ['bairro' => 'São Leopoldo da fonseca'],
            ['bairro' => 'Operária Nova'],
            ['bairro' => 'Centro'],
            ['bairro' => 'Santa Efigênia'],
            ['bairro' => 'Comércio'],
            ['bairro' => 'São José'],
            ['bairro' => 'Distrito Industrial'],
            ['bairro' => 'Universitário'],
            ['bairro' => 'São Miguel'],
            ['bairro' => 'São Braz'],
            ['bairro' => 'Batel'],
            ['bairro' => 'Mercês'],
            ['bairro' => 'Vista Alegre'],
            ['bairro' => 'Água Verde']
        ]);

        //Adiciona cidades
        Cidade::insert(
            [
                ['cidade' => 'Curitiba'],
                ['cidade' => 'Ijui'],
                ['cidade' => 'Erval Seco'],
                ['cidade' => 'Rio de Janeiro'],
                ['cidade' => 'Belo Horizonte'],
                ['cidade' => 'Salvador'],
                ['cidade' => 'Fortaleza'],
                ['cidade' => 'Recife'],
                ['cidade' => 'Santa Cruz do Sul'],
                ['cidade' => 'Rio Pardo'],
                ['cidade' => 'Bozano'],
                ['cidade' => 'Coronel Barros'],
                ['cidade' => 'Cruz Alta'],
                ['cidade' => 'Alegrete']
            ]
        );

        //Adiciona estados(UF)
        Estado::insert(
            [
                [
                    'estado' => 'Paraná',
                    'sigla' => 'PR'
                ],
                [
                    'estado' => 'Rio grande do sul',
                    'sigla' => 'RS'
                ],
                [
                    'estado' => 'São Paulo',
                    'sigla' => 'SP'
                ],
                [
                    'estado' => 'Rio de Janeiro',
                    'sigla' => 'RJ'
                ],
                [
                    'estado' => 'Minas Gerais',
                    'sigla' => 'MG'
                ],
                [
                    'estado' => 'Bahia',
                    'sigla' => 'BA'
                ],
                [
                    'estado' => 'Ceará',
                    'sigla' => 'CE'
                ],
                [
                    'estado' => 'Pernambuco',
                    'sigla' => 'PB'
                ],
                [
                    'estado' => 'Pará',
                    'sigla' => 'PA'
                ],
            ]
        );

        //Adiciona ceps
        Cep::insert(
            [
                ['cep' => '82030290'],
                ['cep' => '88250323'],
                ['cep' => '82030100'],
                ['cep' => '815656565'],
                ['cep' => '81750450'],
                ['cep' => '88809010'],
                ['cep' => '01001000'],
                ['cep' => '20040001'],
                ['cep' => '30140000'],
                ['cep' => '40010000'],
                ['cep' => '60015000'],
                ['cep' => '50020000'],
                ['cep' => '96835666'],
                ['cep' => '96815605'],
                ['cep' => '96640000'],
                ['cep' => '98733000'],
                ['cep' => '98735000'],
                ['cep' => '98005245'],
                ['cep' => '98025110'],
                ['cep' => '80420090'],
                ['cep' => '80810060'],
                ['cep' => '80420130'],
                ['cep' => '80820180'],
                ['cep' => '97542320'],
                ['cep' => '80240040'],
            ]
        );

        //Adiciona enderecos
        Endereco::insert(
            [
                [
                    'logradouro' => 'Luiz bozza',
                    'cep_id' => '1',
                    'estado_id' => '1',
                    'cidade_id' => '1',
                    'bairro_id' => '1'
                ],
                [
                    'logradouro' => 'Rua Desembargador Antônio de Paula',
                    'cep_id' => '2',
                    'estado_id' => '1',
                    'cidade_id' => '1',
                    'bairro_id' => '3'
                ],
                [
                    'logradouro' => 'Rua Santarém',
                    'cep_id' => '3',
                    'estado_id' => '3',
                    'cidade_id' => '3',
                    'bairro_id' => '4'
                ],
                [
                    'logradouro' => 'Avenida Rio Branco',
                    'cep_id' => '8',
                    'estado_id' => '4',
                    'cidade_id' => '4',
                    'bairro_id' => '5'
                ],
                [
                    'logradouro' => 'Avenida Brasil',
                    'cep_id' => '9',
                    'estado_id' => '5',
                    'cidade_id' => '5',
                    'bairro_id' => '6'
                ],
                [
                    'logradouro' => 'Avenida da França',
                    'cep_id' => '10',
                    'estado_id' => '6',
                    'cidade_id' => '6',
                    'bairro_id' => '7'
                ],
                [
                    'logradouro' => 'Avenida Tristão Gonçalves',
                    'cep_id' => '11',
                    'estado_id' => '7',
                    'cidade_id' => '7',
                    'bairro_id' => '5'
                ],
                [
                    'logradouro' => 'Avenida Dantas Barreto',
                    'cep_id' => '12',
                    'estado_id' => '8',
                    'cidade_id' => '8',
                    'bairro_id' => '8'
                ],
                [
                    'logradouro' => 'Avenida Presidente Castelo Branco',
                    'cep_id' => '13',
                    'estado_id' => '2',
                    'cidade_id' => '9',
                    'bairro_id' => '9'
                ],
                [
                    'logradouro' => 'Avenida Independência',
                    'cep_id' => '14',
                    'estado_id' => '2',
                    'cidade_id' => '9',
                    'bairro_id' => '10'
                ],
                [
                    'logradouro' => 'Avenida Presidente Vargas',
                    'cep_id' => '18',
                    'estado_id' => '2',
                    'cidade_id' => '13',
                    'bairro_id' => '5'
                ],
                [
                    'logradouro' => 'Avenida Benjamin Constant',
                    'cep_id' => '19',
                    'estado_id' => '2',
                    'cidade_id' => '13',
                    'bairro_id' => '11'
                ],
                [
                    'logradouro' => 'Rua Myltho Anselmo da Silva',
                    'cep_id' => '21',
                    'estado_id' => '1',
                    'cidade_id' => '1',
                    'bairro_id' => '14'
                ],
                [
                    'logradouro' => 'Rua Niccolo Paganini',
                    'cep_id' => '23',
                    'estado_id' => '1',
                    'cidade_id' => '1',
                    'bairro_id' => '15'
                ],
                [
                    'logradouro' => 'Praça General Osório',
                    'cep_id' => '24',
                    'estado_id' => '2',
                    'cidade_id' => '14',
                    'bairro_id' => '5'
                ],
                [
                    'logradouro' => 'Avenida Presidente Getúlio Vargas',
                    'cep_id' => '25',
                    'estado_id' => '1',
                    'cidade_id' => '1',
                    'bairro_id' => '16'
                ]
            ]
        );
    }
}
