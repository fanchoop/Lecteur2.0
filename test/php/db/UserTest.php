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

    public function setUpBeforeClass()
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
        private $user1;
        $this->user1 = new User('3019-01-30 10:39:61', 'toto', 'f71dbe52628a3f83a77ab494817525c6', 'Toto', 'tutu', 'tutu.toto@tutu.com');
    }

    /**
     * @expectedException Exception
     */
    public function testFailingDate2()
    {
        private $user2;
        $this->user2 = new User('2019-13-32 54:39:42', 'toto', 'f71dbe52628a3f83a77ab494817525c6', 'Toto', 'tutu', 'tutu.toto@tutu.com');
    }

    /**
     * @expectedException Exception
     */
    public function testFailingDate3()
    {
        private $user3;
        $this->user3 = new User('2019-12-32 10:39:42', 'toto', 'f71dbe52628a3f83a77ab494817525c6', 'Toto', 'tutu', 'tutu.toto@tutu.com');
    }

    /**
     * @expectedException Exception
     */
    public function testFailingPass()
    {
        private $user4;
        $this->user4 = new User('2019-01-30 10:39:42', 'toto', 'f71db7525c6', 'Toto', 'tutu', 'tutu.toto@tutu.com');
    }

    /**
     * @expectedException Exception
     */
    public function testFailingMail()
    {
        private $user5;
        $this->user5 = new User('2019-01-30 10:39:42', 'toto', 'f71dbe52628a3f83a77ab494817525c6', 'Toto', 'tutu', 'tutu.toutu.com');
    }
}
