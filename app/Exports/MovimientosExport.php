<?php

namespace App\Exports;

use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;

class MovimientosExport implements FromView
{
    public function __construct($data, $filtros)
    {
        $this->data = $data;
        $this->filtros = $filtros;
    }

    public function view(): View
    {
        return view('modulos.contaparroquial.libroMayor.export', [
            'data' => $this->data,
            'filtros' => $this->filtros,
        ]);
    }
}
