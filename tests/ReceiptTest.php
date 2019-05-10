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

    public function testTotal($items, $expected) {
        $coupon = null;
        $output = $this->Receipt->total($items, $coupon);// Luuakse uus tšekk
        $this->assertEquals( // Võrdleme, kas väärtused on võrdsed
            $expected, // Tulemus, mis peaks testi läbimiseks tulema
            $output, // Kasutatakse Receipt.php funktsiooni total, mis liidab arrays olevad liikmed kokku- antud juhul peaks vastus tulema 15
            'When summing the total should equal {$expected}' // Kui vasted pole võrdsed, väljastatakse teade.
        );
    }

    public function provideTotal() {
        return [
            // Filtreerimise võti
            'ints total 16' => [[1,2,5,8], 16],
            [[-1,2,5,8], 14],
            [[1,2,8], 11],
        ];
    }

    public function testTotalAndCoupon(){
        $input = [0,2,5,8];
        $coupon = 0.20;
        $output = $this->Receipt->total($input, $coupon); // Samasugune test nagu eelmine, kuid koos kupongiga. 15 - 15*0.2 = 12
        $this->assertEquals(
            12,
            $output,
            'When summing the total should equal 12'
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

    public function testTotalException(){
        $input = [0,2,5,8];
        $coupon = 1.20;
        $this->expectException('BadMethodCallException'); // Kuna kupongi väärtus on > 1, oodatakse testi tulemuseks BadMethodCallExceptionit
        $this->Receipt->total($input, $coupon);
    }

    public function testPostTaxTotal() {
        $items = [1,2,5,8];
        $tax = 0.20;
        $coupon = null;
        $Receipt = $this->getMockBuilder('TDD\Receipt')
            ->setMethods(['tax', 'total'])
            ->getMock(); // Luuakse stub
        $Receipt->expects($this->once()) // Eeldab, et meetodit total kutsutakse välja ühe korra. Vastasel juhul test failib.
            ->method('total')
            ->with($items, $coupon)
            ->will($this->returnValue(10.00)); // Konfiguratsioon, meetod total tagastab nüüd 10. lühem variant ->willReturn(10.00);
        $Receipt->expects($this->once()) // Eeldab, et meetodit tax kutsutakse välja ühe korra. Vastasel juhul test failib.
            ->method('tax')
            ->with(10.00, $tax)
            ->will($this->returnValue(1.00)); // Konfiguratsioon, meetod total tagastab nüüd 10. lühem variant ->willReturn(1.00);
        $result = $Receipt->postTaxTotal([1,2,5,8], 0.20, null);
        $this->assertEquals(11.00, $result); // Võrdleb vasteid
    }
}
