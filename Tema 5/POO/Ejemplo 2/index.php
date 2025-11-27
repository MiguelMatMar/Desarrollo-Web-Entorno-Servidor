 <?php
 
    class Fruit {
        public $name;
        public $color;
        public function __construct($name, $color) {
            $this->name = $name;
            $this->color = $color;
        }
        protected function intro() {
            echo "The fruit is {$this->name} and the color is {$this->color}.";
        }
    }

    class Strawberry extends Fruit {
        public function message() {
            echo "Am I a fruit or a berry? ";
        }
    }
    class pinaColada extends Fruit{
        public function ponerAlcohol($cantidad){
            echo "<br> Tu Piña Colada tiene $cantidad% de alcohol y tiene el nombre de {$this-> name} y el color de {$this-> color} <br>";
        }
    }

    // Try to call all three methods from outside class
    $strawberry = new Strawberry("Strawberry", "red");  // OK. __construct() is public
    $strawberry->message(); // OK. message() is public


    $piñaColada = new pinaColada('Piña Colada', 'Amarillo');
    $piñaColada -> ponerAlcohol(20);

?> 