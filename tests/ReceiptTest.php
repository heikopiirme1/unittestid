<?php
namespace TDD\Test;
require dirname(dirname(__FILE__)) . DIRECTORY_SEPARATOR . 'vendor' . DIRECTORY_SEPARATOR .'autoload.php';
use PHPUnit\Framework\TestCase;
use TDD\Receipt;
class ReceiptTest extends TestCase {
    public function testTotal() {
        $Receipt = new Receipt(); // Luuakse uus tšekk
        $this->assertEquals( // Võrdleme, kas väärtused on võrdsed
            14, // Tulemus, mis peaks järgmiselt realt tulema
            $Receipt->total([0,2,5,8]), // Kasutatakse Receipt.php funktsiooni total, mis liidab arrays olevad liikmed kokku- antud juhul peaks vastus tulema 15
            'When summing the total should equal 15' // Kui vasted pole võrdsed, väljastatakse teade.
        );
    }
}
