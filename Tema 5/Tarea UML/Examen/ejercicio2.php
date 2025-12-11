<?php

    // Apartado 1
    // Apartado 3
        interface Procesable{
            public function depositar($monto):void;
            public function retirar($monto):void;
        }
    // Apartado 2
        // 2.1 
            abstract class CuentaBase implements Procesable{
                public function __construct(
                    private string $iban,
                    private string $titular,
                    private float $saldo

                ){}

                abstract protected function aplicarMantenimiento():void;

                public function retirar($monto):void{
                    if($this -> saldo < $monto ){

                        throw new Exception("No puedes retirar tanta cantidad, saldo minimo <br>");
                    }
                    $this -> saldo -= $monto;
                }
                public function depositar($monto):void{
                    $this -> saldo += $monto;
                }
                public function getSaldo(){
                    return $this -> saldo;
                }
            }
        // 2.2
            class CuentaAhorro extends CuentaBase{
                public function __construct(
                    private string $iban,
                    private string $titular,
                    private float $saldo,
                    
                ) {
                    parent::__construct($iban, $titular, $saldo);
                }
                protected function aplicarMantenimiento():void{
                    $this -> saldo *= 1.02;
                }
            }
            class CuentaCorriente extends CuentaBase{
                public function __construct(
                    private string $iban,
                    private string $titular,
                    private float $saldo,
                    
                ) {
                    parent::__construct($iban, $titular, $saldo);
                }
                protected function aplicarMantenimiento():void{
                    $this -> saldo -= 10;
                }
            }
    
    // Apartado 4
    

    function realizarTransferencia($origen,$destino,$monto) {
        try{
            $origen -> retirar($monto);
            $destino -> depositar($monto);
            echo "<br> Transferencia realizada con exito <br>";
        }catch(Exception $e){
            echo "Problema: ".$e -> getMessage();
        }
    }

?>
<?php

    $cuenta1 = new cuentaCorriente('iban1','Jose',5000);
    $cuenta2 = new cuentaAhorro('iban2','Jose',3000);
    $retirar = 73.53;

    echo "Cuenta 1 ". $cuenta1 -> getSaldo() . "<br>";
    echo "Cuenta 2 ". $cuenta2 -> getSaldo() . "<br>";
    
    echo "Se esta intentando realizar una transferencia de $retirar<br> ";
    echo  realizarTransferencia($cuenta1,$cuenta2,$retirar);
   
    echo "<br>Cuenta 1 ". $cuenta1 -> getSaldo() . "<br>";
    echo "Cuenta 2 ". $cuenta2 -> getSaldo() . "<br>";
    
    
?>