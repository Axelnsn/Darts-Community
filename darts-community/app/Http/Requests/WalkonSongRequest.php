<?php

namespace App\Http\Requests;

use App\Enums\WalkonSongType;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rules\Enum;

class WalkonSongRequest extends FormRequest
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
        $rules = [
            'walkon_song_type' => ['required', new Enum(WalkonSongType::class)],
        ];

        $type = $this->input('walkon_song_type');

        if ($type === 'youtube') {
            $rules['walkon_song_url'] = [
                'required',
                'url',
                'regex:/^(https?:\/\/)?(www\.)?(youtube\.com\/watch\?v=|youtu\.be\/|youtube\.com\/embed\/)[\w-]+/',
            ];
        } elseif ($type === 'spotify') {
            $rules['walkon_song_url'] = [
                'required',
                'url',
                'regex:/^https?:\/\/open\.spotify\.com\/track\/[\w]+/',
            ];
        } elseif ($type === 'mp3') {
            $rules['walkon_song_file'] = [
                'required',
                'file',
                'mimes:mp3,mpeg,audio/mpeg',
                'max:10240', // 10MB in KB
            ];
        }

        return $rules;
    }

    /**
     * Get custom messages for validator errors.
     *
     * @return array<string, string>
     */
    public function messages(): array
    {
        return [
            'walkon_song_type.required' => 'Veuillez sélectionner un type de musique.',
            'walkon_song_url.required' => 'Veuillez entrer une URL.',
            'walkon_song_url.url' => 'L\'URL doit être valide.',
            'walkon_song_url.regex' => 'L\'URL doit être une URL YouTube ou Spotify valide.',
            'walkon_song_file.required' => 'Veuillez sélectionner un fichier MP3.',
            'walkon_song_file.mimes' => 'Le fichier doit être au format MP3.',
            'walkon_song_file.max' => 'Le fichier ne doit pas dépasser 10 Mo.',
        ];
    }
}
