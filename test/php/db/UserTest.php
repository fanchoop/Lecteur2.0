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
     * @beforeAll
     */
    public static function setUpNeeds(){

        $this->goodUser = new User('2019-01-30 10:39:42', 'toto', 'f71dbe52628a3f83a77ab494817525c6', 'Toto', 'tutu', 'tutu.toto@tutu.com');
        $this->badUserDate1 = new User('1023-01-30 10:39:42', 'toto', 'f71dbe52628a3f83a77ab494817525c6', 'Toto', 'tutu', 'tutu.toto@tutu.com');
        $this->badUserDate2 = new User('');
        $this->badUserDate3 = new User('');
        $this->badUserPass = new User();
        $this->badUserMail = new User();

    }