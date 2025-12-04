<?php

namespace App\Views;

/**
 * Genera una tabla HTML de 10x10.
 * La clase se renombra a TablaGenerator para seguir las convenciones de PHP 
 * (una clase por archivo con el nombre de la clase).
 */
class TablaGenerator{

    private $string;
    
    public function generateTable()
    {
        // 1. Inicializamos la cadena de texto de la tabla.
        $string = "<table border='1' style='border-collapse: collapse; width: 80%; margin: 20px auto; text-align: center;'>";

        for ($filas = 0; $filas < 10; $filas++) {
            // 2. Usamos el operador de concatenación (punto .) para unir strings
            // Abrimos la fila (<tr>) y la primera celda (<td>)
            $string .= "<tr>";
            $string .= "<td style='background-color: #ffffffff; font-weight: bold;'>Fila $filas</td>";

            for ($columnas = 0; $columnas < 10; $columnas++) {
                // 3. Añadimos las celdas de encabezado (<th>)
                $string .= "<th> Col $columnas </th>";
            }

            // 4. Cerramos la fila (</tr>), ya no hace falta el </td> extra.
            $string .= "</tr>";
        }

        // 5. Cerramos la tabla
        $string .= "</table>";
        
        return $string;
    }
}
?>