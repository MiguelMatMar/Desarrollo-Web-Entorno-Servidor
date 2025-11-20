<?php
    function starsHtml($stars): string {
        $s = '';
        $noEstrella = 5 - $stars;
        for($estrella = 0; $estrella < $stars; $estrella++){
            $s .= '<span class="glyphicon glyphicon-star"></span>';
        }
        for($a = 0; $a < $noEstrella; $a++){
            $s .= '<span class="glyphicon glyphicon-star-empty"></span>';
        }
        return $s;
    }
    
?>