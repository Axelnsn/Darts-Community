<?php

namespace App\Http\Requests;

use App\Enums\SkillLevel;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class PlayerProfileUpdateRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'first_name' => ['nullable', 'string', 'max:255'],
            'last_name' => ['nullable', 'string', 'max:255'],
            'nickname' => ['nullable', 'string', 'max:50'],
            'date_of_birth' => ['nullable', 'date', 'before:today', 'after:' . now()->subYears(120)->format('Y-m-d')],
            'city' => ['nullable', 'string', 'max:255'],
            'skill_level' => ['nullable', Rule::enum(SkillLevel::class)],
        ];
    }

    /**
     * Get custom messages for validator errors.
     *
     * @return array<string, string>
     */
    public function messages(): array
    {
        return [
            'first_name.max' => 'Le prénom ne peut pas dépasser 255 caractères.',
            'last_name.max' => 'Le nom ne peut pas dépasser 255 caractères.',
            'nickname.max' => 'Le pseudo ne peut pas dépasser 50 caractères.',
            'date_of_birth.date' => 'La date de naissance doit être une date valide.',
            'date_of_birth.before' => 'La date de naissance doit être dans le passé.',
            'date_of_birth.after' => 'La date de naissance n\'est pas valide.',
            'city.max' => 'La ville ne peut pas dépasser 255 caractères.',
            'skill_level.enum' => 'Le niveau de jeu sélectionné n\'est pas valide.',
        ];
    }

    /**
     * Get custom attributes for validator errors.
     *
     * @return array<string, string>
     */
    public function attributes(): array
    {
        return [
            'first_name' => 'prénom',
            'last_name' => 'nom',
            'nickname' => 'pseudo',
            'date_of_birth' => 'date de naissance',
            'city' => 'ville',
            'skill_level' => 'niveau de jeu',
        ];
    }
}
