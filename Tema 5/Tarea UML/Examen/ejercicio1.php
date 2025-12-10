<?php

    // Apartado 2.1
        abstract class PersonajeBase {

            public function __construct(
                protected string $nombre,
                protected int $puntosVida,
                protected int $nivel
            ) {}

            abstract public function calcularPoderAtaque(): int;

            public function recibirDaño($cantidad): void {
                $this->puntosVida -= $cantidad;
                echo "{$this->nombre} recibe $cantidad de daño. Vida restante: {$this->puntosVida}<br>";
            }
        }

    // Apartado 3
        interface Combatiente {
            public function atacar($objetivo): void;
        }

    // Apartado 2.2
        class Guerrero extends PersonajeBase implements Combatiente {
            
            public function __construct(
                string $nombre,
                int $puntosVida,
                int $nivel,
                private int $fuerza
            ) {
                parent::__construct($nombre, $puntosVida, $nivel);
            }

            public function calcularPoderAtaque(): int {
                return (int) ($this->fuerza * 1.5);
            }

            public function atacar($objetivo): void {
                $poder = $this->calcularPoderAtaque();
                echo "{$this->nombre} ataca con $poder puntos de daño.<br>";
                $objetivo->recibirDaño($poder);
            }
        }

        class Mago extends PersonajeBase implements Combatiente {

            private int $mana = 200;

            public function __construct(
                string $nombre,
                int $puntosVida,
                int $nivel,
                private int $inteligencia
            ) {
                parent::__construct($nombre, $puntosVida, $nivel);
            }

            public function calcularPoderAtaque(): int {
                if ($this->mana >= 50) {
                    $this->mana -= 50;
                }
                return $this->inteligencia * 2;
            }

            public function rellenarMana($cantidad) {
                $this->mana += $cantidad;
            }

            public function atacar($objetivo): void {
                $poder = $this->calcularPoderAtaque();
                echo "{$this->nombre} lanza un hechizo con $poder puntos de daño. Mana restante: {$this->mana}<br>";
                $objetivo->recibirDaño($poder);
            }
        }

    // Apartado 3
        class Arena {
            public function iniciarDuelo($combatiente1, $combatiente2) {
                echo "<strong>¡Comienza el duelo!</strong><br>";
                $combatiente1->atacar($combatiente2);
                $combatiente2->atacar($combatiente1);
            }
        }

    // Apartado 4
        trait inventario {
            public function usarPocion() {
                $this->puntosVida += 20;
                echo "{$this->nombre} usa una poción y recupera 20 puntos de vida. Total: {$this->puntosVida}<br>";
            }
        }

?>
<?php

    // Ahora jugar

    $jugador1 = new Mago("Paco",300,20,50);
    $jugador2 = new Guerrero("Jose",300,10,150);
    
    $arena1 = new Arena();
    $arena1->iniciarDuelo($jugador1,$jugador2);
?>