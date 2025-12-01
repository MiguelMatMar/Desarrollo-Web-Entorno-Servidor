<?php

/* ============================================================
    INTERFAZ DEL ARMA
   ============================================================ */

interface Arma {
    public function atacar($objetivo);
    public function getDamage();
}


/* ============================================================
    CLASES DE ARMAS
   ============================================================ */

class Espada implements Arma {

    private $damageBase;

    public function __construct($damageBase){
        $this->damageBase = $damageBase;
    }

    public function getDamage(){
        return $this->damageBase;
    }

    public function atacar($objetivo){}
}


class Hacha implements Arma {

    private $damageBase;

    public function __construct($damageBase){
        $this->damageBase = $damageBase;
    }

    public function getDamage(){
        return $this->damageBase * 1.4;
    }

    public function atacar($objetivo){}
}


/* ============================================================
    CLASE ABSTRACTA GUERRERO
   ============================================================ */

abstract class Guerrero {

    protected $nombre;
    protected $vida;
    protected $fuerza;
    protected $armadura;
    protected Arma $arma;

    public function __construct($nombre, $vida, $fuerza, $armadura, Arma $arma){
        $this->nombre = $nombre;
        $this->vida = $vida;
        $this->fuerza = $fuerza;
        $this->armadura = $armadura;
        $this->arma = $arma;
    }

    /* === GETTERS PARA EVITAR ERROR 500 === */

    public function getNombre(){
        return $this->nombre;
    }

    public function getVida(){
        return $this->vida;
    }

    public function getArmadura(){
        return $this->armadura;
    }


    /* ===== MÉTODOS DEL GUERRERO ===== */

    public function estaVivo(){
        return $this->vida > 0;
    }

    public function recibirDaño($dmg){
        $dmgReducido = max(0, $dmg - $this->armadura);
        $this->vida -= $dmgReducido;

        echo "{$this->getNombre()} recibe $dmgReducido de daño. Vida restante: {$this->vida}<br>";

        return $this->estaVivo();
    }

    public function atacar(Guerrero $objetivo){
        $dmg = $this->arma->getDamage() + $this->fuerza;
        echo "<strong>{$this->getNombre()}</strong> ataca a <strong>{$objetivo->getNombre()}</strong><br>";
        $objetivo->recibirDaño($dmg);
    }

    abstract public function habilidadEspecial(Guerrero $objetivo);
}


/* ============================================================
    GUERREROS CONCRETOS (POLIMORFISMO)
   ============================================================ */

class GuerreroLigero extends Guerrero {

    public function habilidadEspecial(Guerrero $objetivo){
        $extra = $this->fuerza * 1.5;
        echo "<span style='color:blue'>{$this->getNombre()} usa Golpe Rápido (+$extra daño)</span><br>";
        $objetivo->recibirDaño($this->arma->getDamage() + $extra);
    }
}


class GuerreroPesado extends Guerrero {

    public function habilidadEspecial(Guerrero $objetivo){
        $extra = $this->fuerza * 2.5;
        echo "<span style='color:red'>{$this->getNombre()} usa Ataque Brutal (+$extra daño)</span><br>";
        $objetivo->recibirDaño($this->arma->getDamage() + $extra);
    }
}


/* ============================================================
    SIMULADOR DE COMBATE
   ============================================================ */

function combate(Guerrero $g1, Guerrero $g2){

    echo "<h2>🔥 COMBATE: {$g1->getNombre()} vs {$g2->getNombre()} 🔥</h2>";

    $turno = 1;

    while($g1->estaVivo() && $g2->estaVivo()){

        echo "<h3>⚔️ Turno $turno</h3>";

        // Turno del primer guerrero
        $g1->atacar($g2);
        if(!$g2->estaVivo()){
            echo "<h1>🏆 {$g1->getNombre()} ha ganado el combate.</h1>";
            break;
        }

        // Turno del segundo guerrero
        $g2->atacar($g1);
        if(!$g1->estaVivo()){
            echo "<h1>🏆 {$g2->getNombre()} ha ganado el combate.</h1>";
            break;
        }

        // Cada 3 turnos se usan habilidades especiales
        if($turno % 3 == 0){
            echo "<h3>✨ ¡Habilidades Especiales! ✨</h3>";

            $g1->habilidadEspecial($g2);
            if(!$g2->estaVivo()){
                echo "<h1>🏆 {$g1->getNombre()} ha ganado el combate.</h1>";
                break;
            }

            $g2->habilidadEspecial($g1);
            if(!$g1->estaVivo()){
                echo "<h1>🏆 {$g2->getNombre()} ha ganado el combate.</h1>";
                break;
            }
        }

        $turno++;
        echo "<hr>";
    }
}


/* ============================================================
    EJEMPLO DE COMBATE
   ============================================================ */

$ligero = new GuerreroLigero("Auron", 120, 18, 5, new Espada(10));
$pesado = new GuerreroPesado("Thorgar", 180, 25, 10, new Hacha(12));

combate($ligero, $pesado);

?>
