<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class StoreGuestBookRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        // return false;
        return true; // ubah ke true agar request diizinkan
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            //
            'tanggal'   => 'required|date',
            'nama'      => 'required|string|max:255',
            'nik_nip'   => 'nullable|string|max:50',
            'alamat'    => 'required|string',
            'jabatan'   => 'nullable|string|max:100',
            'maksud_tujuan' => 'required|string',
            'keterangan'    => 'nullable|string',
            'foto'          => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
            'foto_webcam'   =>  'nullable|string', // bisa berupa file upload atau data Base64 dari WebCam
        ];
    }
}
