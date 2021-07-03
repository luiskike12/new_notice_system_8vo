<?php

namespace App\Http\Middleware;

use Illuminate\Foundation\Http\Middleware\VerifyCsrfToken as Middleware;

class VerifyCsrfToken extends Middleware
{
    /**
     * The URIs that should be excluded from CSRF verification.
     *
     * @var array
     */
    protected $except = [
        '/alumno/registrar',
        '/alumno/loginApp',
        '/alumno/actualizar',
        '/aviso/TraerAvisosAlumnos',
        '/aviso/TraerAvisosAlumnosFiltros',
        '/aviso/verificarAviso',
    ];
}
