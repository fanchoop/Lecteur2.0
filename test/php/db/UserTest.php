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
    private static $user;

    public static function setUpBeforeClass()
    {
        self::$user = new User('2019-01-30 10:39:42', 'toto', 'f71dbe52628a3f83a77ab494817525c6', 'Toto', 'tutu', 'tutu.toto@tutu.com');
    }

    /**
     * Test getteurs et setteurs
     * @covers \src\models\db\Entity::__call
     */
    public function testCall(){
        $this->assertSame("toto", self::$user->getLogin());
        self::$user->setLogin("titi");
        $this->assertSame("titi", self::$user->getLogin());
    }

    /**
     * @expectedException Exception
     */
    public function testFailingDate1()
    {
        $user1 = new User('3019-01-30 10:39:61', 'toto', 'f71dbe52628a3f83a77ab494817525c6', 'Toto', 'tutu', 'tutu.toto@tutu.com');
    }

    /**
     * @expectedException Exception
     */
    public function testFailingDate2()
    {
        $user2 = new User('2019-13-32 54:39:42', 'toto', 'f71dbe52628a3f83a77ab494817525c6', 'Toto', 'tutu', 'tutu.toto@tutu.com');
    }

    /**
     * @expectedException Exception
     */
    public function testFailingDate3()
    {
        $user3 = new User('2019-12-32 10:39:42', 'toto', 'f71dbe52628a3f83a77ab494817525c6', 'Toto', 'tutu', 'tutu.toto@tutu.com');
    }

    /**
     * @expectedException Exception
     */
    public function testFailingPass()
    {
        $user4 = new User('2019-01-30 10:39:42', 'toto', 'f71db7525c6', 'Toto', 'tutu', 'tutu.toto@tutu.com');
    }

    /**
     * @expectedException Exception
     */
    public function testFailingMail()
    {
        $user5 = new User('2019-01-30 10:39:42', 'toto', 'f71dbe52628a3f83a77ab494817525c6', 'Toto', 'tutu', 'tutu.toutu.com');
    }
}
