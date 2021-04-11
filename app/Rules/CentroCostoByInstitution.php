<?php

namespace App\Rules;

use App\CentroCostos;
use Illuminate\Contracts\Validation\Rule;
use App\Helpers\Helpers;

class CentroCostoByInstitution implements Rule
{
    /**
     * Create a new rule instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Determine if the validation rule passes.
     *
     * @param  string  $attribute
     * @param  mixed  $value
     * @return bool
     */
    public function passes($attribute, $value)
    {
        if (!$value) {
            return true;
        }
        return CentroCostos::where('id', $value)->where('INCodigo', Helpers::codigo_inst_seleccionada())->first();
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return 'El centro de costos no existe o no pertenece a la institucion seleccionada.';
    }
}
