<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Endereco extends Model
{
    use HasFactory;

    protected $table = 'enderecos';
    public $timestamps = false;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'logradouro',
        'cep_id',
        'estado_id',
        'cidade_id',
        'bairro_id'
    ];

    //Relação com a tabela CEP
    public function cep(){
        return $this->belongsTo(Cep::class);
    }

    //Relação com a tabela estados
    public function estado(){
        return $this->belongsTo(Estado::class);
    }

    //Relação com a tabela cidades
    public function cidade(){
        return $this->belongsTo(Cidade::class);
    }

    //Relação com a tabela bairros
    public function bairro(){
        return $this->belongsTo(Bairro::class);
    }
}
