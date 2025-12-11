<?php
    enum EstatusReserva: string{
        case Pendiente = 'pendiente';
        case Confirmada = 'confirmada';
        case Cancelada = 'cancelada';
    }

    class Cliente{
        public function __construct(
            private int $idCliente,
            private string $nombreCliente,
            private string $emailCliente
        ){}

    }
    class Habitacion{
        public function __construct(
            private int $idHabitacion,
            private int $numeroHabitacion,
            private string $tipoHabitacion,
            private float $precioHabitacion
        ){}

        public function precioNoche(){
            return $this->precioHabitacion;
        }
    }

    class ReservaHabitacion{
        public function __construct(
            private Habitacion $habitacion,
            private int $noches,
        )
        {}
        public function getTotal(){
            return $this -> noches * $this->habitacion-> precioNoche();
        }
    }

    class Reservacion{
        private array $habitaciones = [];
        public function __construct(
            private int $idReserva,
            private Cliente $cliente,
            private DateTimeImmutable $fechaInicio,
            private DateTimeImmutable $fechaFin,
            private EstatusReserva $estatus
        )
        {}

        public function añadirHabitacion(Habitacion $habitacion, int $noches){
            $this -> habitaciones[] = new ReservaHabitacion($habitacion,$noches);
        }
        public function obtenerTotal(){
            return array_reduce(
                $this->habitaciones,fn(float $acumulador, ReservaHabitacion $rh) => $acumulador + $rh -> getTotal(),0.0
            );
        }
    }
?>
<?php
// Ejemplo de uso del ejercicio 1

    // Crear cliente
    $cliente = new Cliente(
        idCliente: 1,
        nombreCliente: "Juan Pérez",
        emailCliente: "juan@example.com"
    );

    // Crear habitaciones
    $habSimple = new Habitacion(
        idHabitacion: 101,
        numeroHabitacion: 12,
        tipoHabitacion: "Simple",
        precioHabitacion: 50.00
    );

    $habDoble = new Habitacion(
        idHabitacion: 102,
        numeroHabitacion: 20,
        tipoHabitacion: "Doble",
        precioHabitacion: 80.00
    );

    // Crear reservación
    $reserva = new Reservacion(
        idReserva: 5001,
        cliente: $cliente,
        fechaInicio: new DateTimeImmutable("2025-06-10"),
        fechaFin: new DateTimeImmutable("2025-06-15"),
        estatus: EstatusReserva::Pendiente
    );

    // Añadir habitaciones a la reserva
    $reserva->añadirHabitacion($habSimple, 3); // 3 noches * $50 = $150
    $reserva->añadirHabitacion($habDoble, 2); // 2 noches * $80 = $160

    // Obtener total
    $total = $reserva->obtenerTotal();

    echo "Total a pagar por la reservación: $$total";
?>