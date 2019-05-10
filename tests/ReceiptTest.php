<?php
namespace TDD\Test;
require dirname(dirname(__FILE__)) . DIRECTORY_SEPARATOR . 'vendor' . DIRECTORY_SEPARATOR .'autoload.php';
use PHPUnit\Framework\TestCase;
use TDD\Receipt;
class ReceiptTest extends TestCase {
    public function setUp() {
        $this->Receipt = new Receipt();
    }

    public function tearDown() {
        unset($this->Receipt);
    }

    public function testTotal() {
        $Receipt = new Receipt(); // Luuakse uus tšekk
        $this->assertEquals( // Võrdleme, kas väärtused on võrdsed
            14, // Tulemus, mis peaks järgmiselt realt tulema
            $Receipt->total([0,2,5,8]), // Kasutatakse Receipt.php funktsiooni total, mis liidab arrays olevad liikmed kokku- antud juhul peaks vastus tulema 15
            'When summing the total should equal 15' // Kui vasted pole võrdsed, väljastatakse teade.
        );
    }

    public function testTax(){
        $inputAmount = 10.00; // Luuakse testimiseks parameetrid
        $taxInput = 0.10;
        $output = $this->Receipt->tax($inputAmount, $taxInput); // Kasutatakse funktsiooni tax, mis korrutab antud juhul inputAmount ja taxInput, vastus tuleb 1.0
        $this->assertEquals( // Võrdleme, kas väärtused on võrdsed
            1.0, // Oodatud väärtus
            $output, // funktsiooni väärtus
            'The tax calculation should equal 1.00' //Veateadet hetkel ei väljastata kuna vastus on õige
        );
    }
}
