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
     
            if (count($row) != 2) {
       
                continue;
            }

            $name = $row[0];
            $contactValue = $row[1];
          
            $existingContact = Contact::where('name', $name)
                ->where(function ($query) use ($contactValue) {
                    $query->where('email', $contactValue)
                        ->orWhere('phone', $contactValue);
                })
                ->first();

            if (!$existingContact) {
               
                $contact = new Contact([
                    'name' => $name,
                    'email' => filter_var($contactValue, FILTER_VALIDATE_EMAIL) ? $contactValue : null,
                    'phone' => is_numeric($contactValue) ? $contactValue : null,
                ]);

                $contact->save();
            }
        }
    }
}