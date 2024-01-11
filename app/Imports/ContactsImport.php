<?php

namespace App\Imports;

use App\Models\Contact;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;

class ContactsImport implements ToCollection
{
    public function collection(Collection $rows)
    {
        foreach ($rows as $row) {
            // Validar se o número de colunas está correto
            if (count($row) != 2) {
                // Pular a linha se não tiver o formato esperado
                continue;
            }

            // Validar o formato do e-mail ou número de telefone
            $name = $row[0];
            $contactValue = $row[1];

            // Adicionar validações adicionais conforme necessário para o e-mail ou número de telefone

            // Verificar se o contato já existe no banco de dados
            $existingContact = Contact::where('name', $name)
                ->where(function ($query) use ($contactValue) {
                    $query->where('email', $contactValue)
                        ->orWhere('phone', $contactValue);
                })
                ->first();

            if (!$existingContact) {
                // Salvar o contato no banco de dados se não existir
                $contact = new Contact([
                    'name' => $name,
                    // Escolha entre e-mail e número de telefone com base em alguma lógica
                    'email' => filter_var($contactValue, FILTER_VALIDATE_EMAIL) ? $contactValue : null,
                    'phone' => is_numeric($contactValue) ? $contactValue : null,
                ]);

                $contact->save();
            }
        }
    }
}