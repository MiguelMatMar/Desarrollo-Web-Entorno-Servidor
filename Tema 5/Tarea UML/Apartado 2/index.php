<?php

    abstract class Usuario{
        public function __construct(
            protected int $idUsuario,
            protected string $nombreUsuario,
            protected string $emailUsuario
        )
        {}
    }

    class Estudiante extends Usuario{
        private array $asignaturasEstudiante = [];

        public function ponerAsignatura($curso):void{
            $this -> asignaturasEstudiante[] = new Inscripcion($this,$curso);
        }
    }

    class Profesor extends Usuario{
        private array $cursos = [];

        public function añadirCurso($curso):void{
            $this-> cursos[] = $curso;
        }

    }

    class Curso{
        private array $modulos = [];

        public function __construct(
            private int $idCurso,
            private string $nombreCurso,
            private string $descripcionCurso,
            private string $dificultadCurso,
            private Profesor $profesor
        ){}

        public function añadirModulo(Modulo $modulo){
            $this -> modulos[] = $modulo;
        }

    }

    class Modulo {
        private array $lecciones = [];

        public function __construct(
            private int $idModulo,
            private string $nombrModulo
        ){}

        public function añadirLecciones(Leccion $leccion){
            $this -> lecciones[] = $leccion;
        }

    }
    class Leccion{
        private array $tareas = [];

        public function __construct(
            private int $idLeccion,
            private string $tituloLeccion,
            private string $contenidoLeccion
        ){}

        public function añadirTarea(Tarea $tarea){
            $this -> tareas[] = $tarea;
        }
    }

    class Tarea {
        public function __construct(
            private int $idTarea,
            private string $descripcionTarea,
            private bool $obligatira = false
        ){}
    }

    class Inscripcion{
        public function __construct(
            private Estudiante $estudiante,
            private Curso $curso,
            private DateTimeImmutable $fechaInscripccion = new DateTimeImmutable()
        ){}
    }

?>
<?php

    
    // Ejemplo de uso   

    // Crear profesor
    $profesor = new Profesor(
        idUsuario: 1,
        nombreUsuario: "Carlos López",
        emailUsuario: "carlos.lopez@example.com"
    );

    // Crear curso
    $cursoPHP = new Curso(
        idCurso: 101,
        nombreCurso: "Programación en PHP",
        descripcionCurso: "Curso completo desde cero.",
        dificultadCurso: "Intermedio",
        profesor: $profesor
    );

    // Asociar curso a profesor
    $profesor->añadirCurso($cursoPHP);

    // Crear módulos
    $modulo1 = new Modulo(
        idModulo: 1,
        nombrModulo: "Introducción a PHP"
    );

    $modulo2 = new Modulo(
        idModulo: 2,
        nombrModulo: "Programación Orientada a Objetos"
    );

    // Agregar módulos al curso
    $cursoPHP->añadirModulo($modulo1);
    $cursoPHP->añadirModulo($modulo2);

    // Crear lecciones
    $leccion1 = new Leccion(
        idLeccion: 1,
        tituloLeccion: "¿Qué es PHP?",
        contenidoLeccion: "Historia, características y primeros pasos."
    );

    $leccion2 = new Leccion(
        idLeccion: 2,
        tituloLeccion: "Clases y Objetos",
        contenidoLeccion: "Conceptos fundamentales de POO en PHP."
    );

    // Añadir lecciones a módulos
    $modulo1->añadirLecciones($leccion1);
    $modulo2->añadirLecciones($leccion2);

    // Crear tareas
    $tarea1 = new Tarea(
        idTarea: 1,
        descripcionTarea: "Instalar PHP en tu computadora.",
        obligatira: true
    );

    $tarea2 = new Tarea(
        idTarea: 2,
        descripcionTarea: "Crear tu primera clase PHP.",
        obligatira: false
    );

    // Agregar tareas a lecciones
    $leccion1->añadirTarea($tarea1);
    $leccion2->añadirTarea($tarea2);

    // Crear estudiante
    $estudiante = new Estudiante(
        idUsuario: 10,
        nombreUsuario: "Ana Martínez",
        emailUsuario: "ana.martinez@example.com"
    );

    // Inscribir estudiante al curso
    $estudiante->ponerAsignatura($cursoPHP);

    echo "Ejemplo completado: estudiante inscrito y contenido del curso creado correctamente.";

?>