<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreSolicitacaoRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    /** Validação das entradas do formulário de interesse (RF05, RNF05). */
    public function rules(): array
    {
        return [
            'nome' => ['required', 'string', 'min:3', 'max:120'],
            'email' => ['required', 'email', 'max:255'],
            'telefone' => ['required', 'string', 'min:10', 'max:20'],
            'cidade' => ['required', 'string', 'min:2', 'max:80'],
            'tipo_moradia' => ['required', 'in:casa,apartamento'],
            'possui_outros_animais' => ['nullable', 'boolean'],
            'possui_telas_protecao' => ['nullable', 'boolean'],
            'observacoes' => ['nullable', 'string', 'max:1000'],
        ];
    }

    public function attributes(): array
    {
        return [
            'nome' => 'nome',
            'email' => 'e-mail',
            'telefone' => 'telefone',
            'cidade' => 'cidade',
            'tipo_moradia' => 'tipo de moradia',
            'observacoes' => 'observações',
        ];
    }
}