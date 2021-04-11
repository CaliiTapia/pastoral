<?php

namespace App\Exports;

use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;


class PlanDeCuentasExport implements FromView{

    public function __construct($data)
    {
        $this->data = $data;
    }

    public function view(): View
    {
        return view('modulos.contaparroquial.mantenedores.reportes.planDeCuentas', [
            'data' => $this->data,
        ]);
    }

}