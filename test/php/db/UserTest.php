<?php
include "src/models/db/User.php";
use PHPUnit\Framework\TestCase;
use src\models\db\User;
use src\models\db\DAO;

/**
 * Class UserTest
 * Cette classe teste la classe User.
 * @coversDefaultClass src\models\db\User
 */
final class UserTest extends TestCase
{
    private $user;

    /**
     * @covers ::__construct
     * @beforeClass
     */
    public function testConstruct()
    {
        $this->user = new User('2019-01-30 10:39:42', 'toto', 'f71dbe52628a3f83a77ab494817525c6', 'Toto', 'tutu', 'tutu.toto@tutu.com');
        $this->assertInstanceOf(User::class, $this->user);
//        var_dump($this->user);
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
     * @covers \src\models\db\User::__construct
     */
    public function testFailingDate1()
    {
        $user1 = new User('3019-01-30 10:39:61', 'toto', 'f71dbe52628a3f83a77ab494817525c6', 'Toto', 'tutu', 'tutu.toto@tutu.com');
    }

    /**
     * @expectedException Exception
     * @covers \src\models\db\User::__construct
     */
    public function testFailingDate2()
    {
        $user2 = new User('2019-13-32 54:39:42', 'toto', 'f71dbe52628a3f83a77ab494817525c6', 'Toto', 'tutu', 'tutu.toto@tutu.com');
    }

    /**
     * @expectedException Exception
     * @covers \src\models\db\User::__construct
     */
    public function testFailingDate3()
    {
        $user3 = new User('2019-12-32 10:39:42', 'toto', 'f71dbe52628a3f83a77ab494817525c6', 'Toto', 'tutu', 'tutu.toto@tutu.com');
    }

    /**
     * @expectedException Exception
     * @covers \src\models\db\User::__construct
     */
    public function testFailingPass()
    {
        $user4 = new User('2019-01-30 10:39:42', 'toto', 'f71db7525c6', 'Toto', 'tutu', 'tutu.toto@tutu.com');
    }

    /**
     * @expectedException Exception
     * @covers \src\models\db\User::__construct
     */
    public function testFailingMail()
    {
        $user5 = new User('2019-01-30 10:39:42', 'toto', 'f71dbe52628a3f83a77ab494817525c6', 'Toto', 'tutu', 'tutu.toutu.com');
    }
 
    /**
     * Test de la fonction findAll de la classe User
     * @covers \src\models\db\User::findAll
     */
    public function testFindAll() {
        try{
            $users = User::findAll();
        }
        catch (Exception $e){
            $e->getMessage();
            $users = null;
        }
        finally{
            DAO::close();
        }

        $my_users = ['Toto', 'Tata', 'Titi'];

        $i = 0;
        foreach ($users as $user) {
            $this->assertSame($user->getNom(), $my_users[$i]);
            $i++;
        }
    }

    /**
     * Test de la fonction find de la classe User
     * @covers \src\models\db\User::find
     */
    public function testFind() {
        $user2 = null;

        try{
            $user2 = User::find(2);
        }
        catch (Exception $e){
            $e->getMessage();
        }
        finally{
            DAO::close();
        }

        $this->assertSame($user2->getId(), 2);
        $this->assertSame($user2->getLogin(), 'tata');
    }
}
