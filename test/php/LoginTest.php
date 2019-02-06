<?php
include_once "src/models/Login.php";
use PHPUnit\Framework\TestCase;
use src\models\Login;

/**
 * Class LoginTest
 * @coversDefaultClass \src\models\Login
 */
class LoginTest extends TestCase
{
    /**
     * Test de la méthode login
     * @covers ::login
     * @throws Exception
     */
    public function testLogin(){
        $this->assertTrue( Login::login("toto", "toto") );
    }

    /**
     * Test de la méthode login
     * @covers ::login
     * @expectedException Exception
     * @throws Exception
     */
    public function testLoginIdentException(){
        Login::login("efezfqzezfqez", "toto");
    }

    /**
     * Test de la méthode login
     * @covers ::login
     * @expectedException Exception
     * @throws Exception
     */
    public function testLoginMdpException(){
        Login::login("toto", "qzefqezfqezfqezf");
    }

    /**
     * Test de la méthode logout
     * @covers ::logout
     */
    public function testLogout(){
        Login::logout();
        $this->assertNull($_SESSION["id"]);
        $this->assertNull($_SESSION["login"]);
        $this->assertNull($_SESSION["email"]);
    }

    /**
     * Test de la méthode checkUser
     * @covers ::checkUser
     * @throws Exception
     */
    public function testCheckUser(){

        /* Return false */
        Login::logout();
        $this->assertFalse( Login::checkUser() );

        /* Return true */
        Login::login("toto", "toto");
        $this->assertTrue( Login::checkUser() );
    }
}