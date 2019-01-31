<?php
include "src/models/User.php";
use PHPUnit\Framework\TestCase;
use src\models\User;

/**
 * Class UserTest
 * Cette classe teste la classe User.
 * @coversDefaultClass src\models\User
 */
final class UserTest extends TestCase
{
    private $User;

    /**
     * @before
     */
    public static function setUpNeeds(){

        $this->goodUser = new User('2019-01-30 10:39:42', 'toto', 'f71dbe52628a3f83a77ab494817525c6', 'Toto', 'tutu', 'tutu.toto@tutu.com');
    }

    /**
     * @expectedException Exception
     */
    public function testFailingDate1()
    {
        $this->badUserDate2 = new User('2019-54-30 10:39:42', 'toto', 'f71dbe52628a3f83a77ab494817525c6', 'Toto', 'tutu', 'tutu.toto@tutu.com');
    }

    /**
     * @expectedException Exception
     */
    public function testFailingDate2()
    {
        $this->badUserDate2 = new User('2019-01-30 54:39:42', 'toto', 'f71dbe52628a3f83a77ab494817525c6', 'Toto', 'tutu', 'tutu.toto@tutu.com');
    }

    /**
     * @expectedException Exception
     */
    public function testFailingDate3()
    {
        $this->badUserDate3 = new User('5419-01-30 10:39:42', 'toto', 'f71dbe52628a3f83a77ab494817525c6', 'Toto', 'tutu', 'tutu.toto@tutu.com');
    }
        
    /**
     * @expectedException Exception
     */
    public function testFailingPass()
    {
        $this->badUserPass = new User('2019-01-30 10:39:42', 'toto', 'f71db7525c6', 'Toto', 'tutu', 'tutu.toto@tutu.com');
    }   

    /**
     * @expectedException Exception
     */
    public function testFailingPass()
    {
        $this->badUserMail = new User('2019-01-30 10:39:42', 'toto', 'f71dbe52628a3f83a77ab494817525c6', 'Toto', 'tutu', 'tutu.toutu.com');
    }   
