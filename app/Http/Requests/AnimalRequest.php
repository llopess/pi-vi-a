<?php

namespace App\Http\Requests;

use App\Enums\Especie;
use App\Enums\Porte;
use App\Enums\Sexo;
use App\Enums\SituacaoAnimal;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class AnimalRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    /** Checkbox desmarcado não é enviado: normaliza para true/false. */
    protected function prepareForValidation(): void
    {
        $this->merge([
            'castrado' => $this->boolean('castrado'),
            'vacinado' => $this->boolean('vacinado'),
            'vermifugado' => $this->boolean('vermifugado'),
        ]);
    }

    public function rules(): array
    {
        return [
            'nome' => ['required', 'string', 'max:80'],
            'especie' => ['required', Rule::enum(Especie::class)],
            'porte' => ['required', Rule::enum(Porte::class)],
            'sexo' => ['required', Rule::enum(Sexo::class)],
            'data_nascimento_estimada' => ['required', 'date', 'before_or_equal:today'],
            'data_recebimento' => ['required', 'date', 'before_or_equal:today'],
            'situacao' => ['sometimes', Rule::enum(SituacaoAnimal::class)],
            'castrado' => ['boolean'],
            'vacinado' => ['boolean'],
            'vermifugado' => ['boolean'],
            'descricao' => ['nullable', 'string', 'max:2000'],
            'fotos' => ['nullable', 'array', 'max:6'],
            'fotos.*' => ['image', 'max:4096'],
        ];
    }
}