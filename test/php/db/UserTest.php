<?php
include "src/models/db/User.php";
use PHPUnit\Framework\TestCase;
use src\models\db\User;

/**
 * Class UserTest
 * Cette classe teste la classe User.
 * @coversDefaultClass src\models\db\User
 */
final class UserTest extends TestCase
{
    private $user;

    /**
     * @before
     */
    public function setUpNeeds()
    {
        $this->user = new User('2019-01-30 10:39:42', 'toto', 'f71dbe52628a3f83a77ab494817525c6', 'Toto', 'tutu', 'tutu.toto@tutu.com');
    }

    /**
     * Test getteurs et setteurs
     * @covers \src\models\db\Entity::__call
     */
    public function testCall(){
        $this->assertSame("toto", $this->user->getLogin());
        $this->user->setLogin("titi");
        $this->assertSame("titi", $this->user->getLogin());
    }

    /**
     * @expectedException Exception
     */
    public function testFailingDate1()
    {
        $this->user = new User('2019-54-30 10:39:4232548792132', 'toto', 'f71dbe52628a3f83a77ab494817525c6', 'Toto', 'tutu', 'tutu.toto@tutu.com');
    }

    /**
     * @expectedException Exception
     */
    public function testFailingDate2()
    {
        $this->user = new User('2019-01-3021657 54:39:42', 'toto', 'f71dbe52628a3f83a77ab494817525c6', 'Toto', 'tutu', 'tutu.toto@tutu.com');
    }

    /**
     * @expectedException Exception
     */
    public function testFailingDate3()
    {
        $this->user = new User('5419278-0132549-30 10:39:42', 'toto', 'f71dbe52628a3f83a77ab494817525c6', 'Toto', 'tutu', 'tutu.toto@tutu.com');
    }

    /**
     * @expectedException Exception
     */
    public function testFailingPass()
    {
        $this->user = new User('2019-01-30 10:39:42', 'toto', 'f71db7525c6', 'Toto', 'tutu', 'tutu.toto@tutu.com');
    }

    /**
     * @expectedException Exception
     */
    public function testFailingMail()
    {
        $this->user = new User('2019-01-30 10:39:42', 'toto', 'f71dbe52628a3f83a77ab494817525c6', 'Toto', 'tutu', 'tutu.toutu.com');
    }
}