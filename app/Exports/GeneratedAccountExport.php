<?php

namespace App\Exports;

use App\Models\GeneratedAccount;
use Maatwebsite\Excel\Concerns\FromCollection;

class GeneratedAccountExport implements FromCollection
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        return GeneratedAccount::select("username", "password")->get();
    }
    /**
     * Write code on Method
     *
     * @return response()
     */
    public function headings(): array
    {
        return ["Username", "Password"];
    }
}
