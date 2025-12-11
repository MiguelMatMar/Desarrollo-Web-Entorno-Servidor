<?php

    enum EstatusPedido:string{
        case Pendiente = 'pendiente';
        case Pagado = 'pagado';
        case Enviado = 'enviado';
        case Devuelto = 'devuelto';
    }

    class Producto{
        public function __construct(
            private int $idProducto,
            private string $nombreProducto,
            private float $precioProducto
        ){}

        public function obtenerPrecio():float{
            return $this-> precioProducto;
        }
    }

    class Cliente{
        public function __construct(
            private int $idCliente,
            private string $nombreCliente,
            private string $emailCliente
        ){}
    }

    class ItemCarrito{
        public function __construct(
            private Producto $producto,
            private int $cantidad
        ){}

        public function obtenerTotal(){
            return $this->producto->getPrecio() * $this->cantidad;
        }
        
        public function obtenerProducto(){
            return $this->producto;
        }

        public function obtenerCantidad(){
            return $this->cantidad;
        }

    }

    class Carrito{
        private array $items = [];

        public function añadirProducto(Producto $producto,int $cantidad){
            $this->items[] = new ItemCarrito($producto,$cantidad);
        }

        public function obtenerTotal(){
            return array_reduce(
                $this->items,fn(float $acumulador,ItemCarrito $item) => $acumulador + $item ->obtenerTotal()
            );
        }

        public function obtenerItems(){
            return $this->items;
        }
    }

    class PedirItem{
        public function __construct(
            private Producto $producto,
            private int $cantidad,
            private float $precioUnidad
        ){}

        public function getTotal(){
            return $this-> precioUnidad* $this->cantidad;
        }
    }

    class Pedir{
        private array $items = [];

        public function __construct(
            private int $idPedido,
            private Cliente $cliente,
            private EstatusPedido $estadoPedido =  EstatusPedido::Pendiente
        ){}
        public function desdeCarrito(int $id,Cliente $cliente, Carrito $carrito){
            $pedido = new self($id,$cliente);
            foreach($carrito->obtenerItems() as $item){
                $pedido -> añadirItem(
                    $item->obtenerProducto(),
                    $item->obtenerCantidad(),
                    $item->obtenerProducto()->obtenerPrecio()
                );
            }
            return $pedido;
        }
        public function añadirItem(Producto $producto,int $cantidad,float $precioUnidad){
            $this -> items[] = new PedirItem($producto,$cantidad,$precioUnidad);
        }
        public function obtenerTotal(){
            return array_reduce(
                $this -> items,fn(float $acumulador,PedirItem $item) => $acumulador+$item->getTotal(),0.0
            );
        }
    }
?>
<?php

    
    // Ejemplo de uso
    

    // Crear productos
    $producto1 = new Producto(
        idProducto: 1,
        nombreProducto: "Teclado Mecánico",
        precioProducto: 50.00
    );

    $producto2 = new Producto(
        idProducto: 2,
        nombreProducto: "Mouse Gamer",
        precioProducto: 30.00
    );

    $producto3 = new Producto(
        idProducto: 3,
        nombreProducto: "Monitor 24 pulgadas",
        precioProducto: 120.00
    );

    // Crear cliente
    $cliente = new Cliente(
        idCliente: 100,
        nombreCliente: "Luis Ramírez",
        emailCliente: "luis.ramirez@example.com"
    );

    // Crear carrito y agregar productos
    $carrito = new Carrito();
    $carrito->añadirProducto($producto1, 2);  // 2 teclados → $100
    $carrito->añadirProducto($producto2, 1);  // 1 mouse → $30
    $carrito->añadirProducto($producto3, 1);  // 1 monitor → $120

    // Mostrar total del carrito
    echo "Total del carrito: $" . $carrito->obtenerTotal() . "<br>";

    // Crear pedido desde el carrito
    $pedido = (new Pedir(idPedido: 1, cliente: $cliente))->desdeCarrito(
        id: 1,
        cliente: $cliente,
        carrito: $carrito
    );

    // Mostrar total del pedido
    echo "Total del pedido generado: $" . $pedido->obtenerTotal() . "<br>";

?>
