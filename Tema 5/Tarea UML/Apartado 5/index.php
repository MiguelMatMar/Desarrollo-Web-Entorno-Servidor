<?php

    enum EstadoCita:string{
        case Programada = "programada";
        case Cancelada = "cancelada";
        case Completada = "completada";
    }

    class Paciente{
        public function __construct(
            private int $idPaciente,
            private string $nombrePaciente
        ){}
    }
    class Especialidad{
        public function __construct(
            private int $idEspecialidad,
            private string $nombreEspecialidad
        ){}
    }

    class Medico{
        private array $especialidades = [];

        public function __construct(
            private int $idMedico,
            private string $nombreMedico
        ){}

        public function añadirEspecialidad(Especialidad $especialidad){
            $this ->especialidades[] = $especialidad;
        }
    }

    class Cita{
        public function __construct(
            private int $idCita,
            private Paciente $paciente,
            private Medico $medico,
            private DateTimeImmutable $fechaCita,
            private EstadoCita $estadoCita = EstadoCita::Programada,
            private ?string $notas = null
        ){}

        public function cancelarCita($razon){
            $this-> estadoCita = EstadoCita::Cancelada;
            $this->notas = trim($this->notas. 'Razon: '. $razon);
        }
    }
?>
<?php

    // Ejemplo de uso

    // Crear paciente
    $paciente = new Paciente(
        idPaciente: 1,
        nombrePaciente: "Laura Fernández"
    );

    // Crear médico
    $medico = new Medico(
        idMedico: 100,
        nombreMedico: "Dr. Carlos Méndez"
    );

    // Crear especialidades
    $especialidad1 = new Especialidad(
        idEspecialidad: 10,
        nombreEspecialidad: "Cardiología"
    );

    $especialidad2 = new Especialidad(
        idEspecialidad: 11,
        nombreEspecialidad: "Medicina Interna"
    );

    // Asignar especialidades al médico
    $medico->añadirEspecialidad($especialidad1);
    $medico->añadirEspecialidad($especialidad2);

    // Crear cita médica
    $cita = new Cita(
        idCita: 500,
        paciente: $paciente,
        medico: $medico,
        fechaCita: new DateTimeImmutable("2025-03-20 09:30:00")
    );

    // Cancelar la cita
    $cita->cancelarCita("El paciente no puede asistir por motivos personales.");

    echo "La cita ha sido cancelada.";

?>
