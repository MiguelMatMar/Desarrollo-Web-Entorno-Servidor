# Clases Abstractas

Una clase abstracta es como un molde incompleto:
- Puede tener métodos ya programados
- Puede tener métodos abstractos (obligan a las subclases a implementarlos)
- Puede tener atributos
- No se puede instanciar

### Cuándo usarla
Cuando varias clases comparten lógica común, pero cada una debe implementar su propia versión de algunos métodos.

```php
abstract class Persona {
    // Propiedades (estado) con visibilidad
    protected string $nombre;
    private int $edad;
    public static int $contador = 0; // propiedad estática

    // Constante de clase
    public const TIPO = 'Humano';

    // Constructor concreto
    public function __construct(string $nombre, int $edad) {
        $this->nombre = $nombre;
        $this->edad = $edad;
        self::$contador++;
    }

    // Método concreto (puede usarse tal cual en subclases)
    public function saludar(): string {
        return "Hola, soy {$this->nombre}.";
    }

    // Método static concreto
    public static function obtenerContador(): int {
        return self::$contador;
    }

    // Método final (no puede sobreescribirse en subclases)
    final public function infoTipo(): string {
        return "Tipo: " . self::TIPO;
    }

    // Método abstracto — obliga a la subclase a implementarlo
    abstract public function obtenerRol(): string;

    // Método abstracto protegido (la subclase debe implementarlo)
    abstract protected function calcularCategoriaEdad(): string;
}

// Subclase que implementa los métodos abstractos
class Empleado extends Persona {
    private string $puesto;

    public function __construct(string $nombre, int $edad, string $puesto) {
        parent::__construct($nombre, $edad);
        $this->puesto = $puesto;
    }

    // Implementación obligatoria del método abstracto público
    public function obtenerRol(): string {
        return "Empleado - {$this->puesto}";
    }

    // Implementación del método abstracto protegido
    protected function calcularCategoriaEdad(): string {
        return ($this->edad >= 65) ? 'Jubilado' : 'Activo';
    }

    // Podemos usar y ampliar métodos concretos heredados
    public function saludar(): string {
        return parent::saludar() . " Trabajo como {$this->puesto}.";
    }
}

// Uso
$e = new Empleado("María", 30, "Desarrolladora");
echo $e->saludar() . PHP_EOL;           // Hola, soy María. Trabajo como Desarrolladora.
echo $e->obtenerRol() . PHP_EOL;       // Empleado - Desarrolladora
echo Persona::obtenerContador() . PHP_EOL; // 1


-- Interface -- 
Una interface es solo una lista de métodos que una clase debe implementar.
– No tiene código, solo la declaración de métodos
– No puede tener propiedades (solo constantes)
– Una clase puede implementar muchas interfaces

Cuándo usarla

Cuando quieres definir qué debe hacer una clase, sin decir cómo lo hace.

```php
<?php
// archivo: interface_example.php

interface Autenticable {
    // Constante en interfaz
    public const TOKEN_LIFETIME = 3600; // segundos

    // Firma de métodos que la clase debe implementar
    public function login(string $usuario, string $password): bool;
    public function logout(): void;
    public function getToken(): ?string;
}

interface Auditable {
    public function registrarAccion(string $accion): void;
}

// Clase que implementa dos interfaces
class SistemaAuth implements Autenticable, Auditable {
    private ?string $token = null;

    public function login(string $usuario, string $password): bool {
        // lógica de ejemplo (no real)
        if ($usuario === 'admin' && $password === '1234') {
            $this->token = bin2hex(random_bytes(16));
            $this->registrarAccion("Login correcto: $usuario");
            return true;
        }
        $this->registrarAccion("Login fallido: $usuario");
        return false;
    }

    public function logout(): void {
        $this->token = null;
        $this->registrarAccion("Logout");
    }

    public function getToken(): ?string {
        return $this->token;
    }

    public function registrarAccion(string $accion): void {
        // implementación de Auditable
        echo "[AUDIT] $accion\n";
    }
}

// Uso
$s = new SistemaAuth();
$s->login('admin', '1234');  // muestra audit
echo $s->getToken() ? "Token OK\n" : "Sin token\n";


-- Traits -- 

Un trait es un paquete de métodos reutilizables que puedes “pegar” dentro de una clase.
– Sí puede tener código
– Sirve para reutilizar funciones
– Una clase puede usar muchos traits
– No crea relación de herencia

Cuándo usarlo

Cuando diferentes clases necesitan el mismo comportamiento, pero no tienen relación entre ellas.

3.1 Trait simple con propiedad y método
```php
<?php
// archivo: trait_simple.php

trait Loggable {
    // Propiedad dentro del trait
    protected ?string $ultimoLog = null;

    public function log(string $mensaje): void {
        $this->ultimoLog = $mensaje;
        echo "[LOG] " . $mensaje . PHP_EOL;
    }

    public function obtenerUltimoLog(): ?string {
        return $this->ultimoLog;
    }

    // Trait puede declarar métodos abstractos — obliga a la clase a implementarlos
    abstract public function getIdentificador(): string;
}
### 3.2 Uso del trait en clases

```php
<?php
// archivo: trait_use.php
require_once 'trait_simple.php';

class Servicio {
    use Loggable;

    public function getIdentificador(): string {
        return 'Servicio#1';
    }

    public function ejecutar(): void {
        $this->log("Ejecutando servicio {$this->getIdentificador()}");
    }
}

$s = new Servicio();
$s->ejecutar(); // [LOG] Ejecutando servicio Servicio#1

### 3.3 Conflictos entre traits y resolución (insteadof, as)

```php
<?php
// archivo: trait_conflict.php

trait A {
    public function saludo() {
        echo "Hola desde A\n";
    }
}

trait B {
    public function saludo() {
        echo "Hola desde B\n";
    }

    public function despedida() {
        echo "Adiós desde B\n";
    }
}

class MiClase {
    use A, B {
        // Elegimos saludo() de A en lugar de B
        A::saludo insteadof B;

        // Creamos un alias para la versión de B
        B::saludo as saludoDesdeB;
    }
}

$obj = new MiClase();
$obj->saludo();          // Hola desde A
$obj->saludoDesdeB();    // Hola desde B
$obj->despedida();       // Adiós desde B
