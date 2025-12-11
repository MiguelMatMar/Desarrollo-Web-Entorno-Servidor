<?php

    abstract class Usuario{
        public function __construct(
            protected int $id,
            protected string $nombreUsuario
        ){}
    }

    class Lector extends Usuario{}
    class Bibliotecario extends Usuario{}

    class Libro{
        public function __construct(
            private int $idLibro,
            private string $tituloLibro,
            private string $autorLibro,
            private string $isbn,
            private int $añoLibro
        )
        {}
    }

    class Copia{
        public function __construct(
            private int $idCopia,
            private Libro $libro,
            private string $codigoBarras
        ){}
    }

    class Prestamo{
        public function __construct(
            private int $idPrestamo,
            private Copia $copia,
            private Lector $lector,
            private DateTimeImmutable $tiempoComienzo,
            private ?DateTimeImmutable $tiempoFin = null
        ){}

        public function isActive(){
            return $this-> tiempoFin === null;
        }

    }
?>
<?php

    // Ejemplo de uso

    // Crear usuarios
    $lector = new Lector(
        id: 1,
        nombreUsuario: "María González"
    );

    $bibliotecario = new Bibliotecario(
        id: 2,
        nombreUsuario: "Jorge Ramírez"
    );

    // Crear libro
    $libro = new Libro(
        idLibro: 101,
        tituloLibro: "Cien Años de Soledad",
        autorLibro: "Gabriel García Márquez",
        isbn: "978-0-06-088328-7",
        añoLibro: 1967
    );

    // Crear una copia del libro
    $copia1 = new Copia(
        idCopia: 5001,
        libro: $libro,
        codigoBarras: "CB-001-A"
    );

    // Registrar un préstamo
    $prestamo = new Prestamo(
        idPrestamo: 9001,
        copia: $copia1,
        lector: $lector,
        tiempoComienzo: new DateTimeImmutable("2025-01-15 10:00:00")
    );

    // Verificar si el préstamo está activo
    if ($prestamo->isActive()) {
        echo "El préstamo está activo.<br>";
    } else {
        echo "El préstamo ya fue devuelto.<br>";
    }

?>
