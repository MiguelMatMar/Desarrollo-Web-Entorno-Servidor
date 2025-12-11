<?php

abstract class Vehiculoo{
    public function __construct(
        protected $idVehiculo,
        protected string $marcaVehiculo,
        protected string $modeloVehiculo,
        protected float $precioVehiculo,
        protected ?string $matricula = null
    ){}

    public function getPrecio(): float {
        return $this->precioVehiculo;
    }
}

class Coche extends Vehiculoo{
    public function __construct(
        int $idVehiculo,
        string $marcaVehiculo,
        string $modeloVehiculo,
        float $precioVehiculo,
        private int $puertas,
        ?string $matricula = null
    ){
        parent::__construct($idVehiculo,$marcaVehiculo,$modeloVehiculo,$precioVehiculo,$matricula);
    }
}

class Moto extends Vehiculoo{
    public function __construct(
        int $idVehiculo,
        string $marcaVehiculo,
        string $modeloVehiculo,
        float $precioVehiculo,
        private int $cilindrosMotor,
        ?string $matricula = null
    ){
        parent::__construct($idVehiculo,$marcaVehiculo,$modeloVehiculo,$precioVehiculo,$matricula);
    }
}

class Van extends Vehiculoo{
    public function __construct(
        int $idVehiculo,
        string $marcaVehiculo,
        string $modeloVehiculo,
        float $precioVehiculo,
        private float $capacidadKg,
        ?string $matricula = null
    ){
        parent::__construct($idVehiculo,$marcaVehiculo,$modeloVehiculo,$precioVehiculo,$matricula);
    }
}

class Cliente{
    public function __construct(
        private int $idCliente,
        private string $nombreCliente
    ){}
}

class VentaPersona{
    public function __construct(
        private int $idVentaPersona,
        private string $nombrVentaPersona
    ){}
}

class Venta{
    public function __construct(
        private int $idVenta,
        private Vehiculoo $vehiculo,
        private Cliente $cliente,
        private VentaPersona $ventaPersona,
        private DateTimeImmutable $fechaVenta,
        private float $venta
    ){}
}

?>
<?php

// Ejemplo de uso

$coche = new Coche(
    idVehiculo: 1,
    marcaVehiculo: "Toyota",
    modeloVehiculo: "Corolla",
    precioVehiculo: 15000,
    puertas: 4,
    matricula: "ABC-123"
);

$cliente = new Cliente(
    idCliente: 100,
    nombreCliente: "Roberto Martínez"
);

$vendedor = new VentaPersona(
    idVentaPersona: 10,
    nombrVentaPersona: "Lucía Fernández"
);

$venta1 = new Venta(
    idVenta: 5000,
    vehiculo: $coche,
    cliente: $cliente,
    ventaPersona: $vendedor,
    fechaVenta: new DateTimeImmutable("2025-06-12 14:30:00"),
    venta: $coche->getPrecio()
);

echo "Venta registrada correctamente.";

?>
