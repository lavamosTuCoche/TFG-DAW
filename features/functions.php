<?php

    function separarApellidos($nombreCompleto) {
        // Lista de partículas comunes en apellidos compuestos
        $particulas = ['de', 'del', 'de la', 'de los', 'de las', 'la', 'las', 'los'];

        $nombreCompleto = trim(preg_replace('/\s+/', ' ', $nombreCompleto));
        $palabras = explode(' ', $nombreCompleto);

        $apellido1 = '';
        $apellido2 = '';
        $actual = [];

        while (count($palabras)) {
            $palabra = strtolower($palabras[0]);

            // Si la palabra es una partícula, se mantiene en el apellido actual
            if (in_array($palabra, $particulas)) {
                $actual[] = array_shift($palabras);
            } else {
                $actual[] = array_shift($palabras);
                if (!in_array(strtolower(end($actual)), $particulas)) break;
            }
        }

        $apellido1 = implode(' ', $actual);
        $apellido2 = implode(' ', $palabras);

        return [$apellido1, $apellido2];
    }


?>