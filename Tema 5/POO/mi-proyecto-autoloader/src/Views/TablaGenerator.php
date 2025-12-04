<?php

namespace App\Views;

class TablaGenerator{

    private $string;
    
    public function generateTable(){
        $string = "<table border='1' style='border-collapse: collapse; width: 80%; margin: 20px auto; text-align: center;'>";

        for ($filas = 0; $filas < 10; $filas++) {
            $string .= "<tr>";

            for ($columnas = 0; $columnas < 10; $columnas++) {
                $string .= "<th> F $filas, C $columnas </th>";
            }

            $string .= "</tr>";
        }

        $string .= "</table>";
        
        return $string;
    }
}
?>