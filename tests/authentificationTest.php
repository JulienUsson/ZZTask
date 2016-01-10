<?php

include(__DIR__.'/../src/classes/admin.php');
include(__DIR__.'/../src/classes/authentification.php');

class AuthentificationTests extends PHPUnit_Framework_TestCase
{
    public function testAddUser()
    {
      $auth=new Authentification();
      $auth->add_user('toto','toto');
      $users=$auth->get_users();
      $this->assertArrayHasKey('toto', $users);
      $auth->remove_user('toto');
    }

    public function testRemoveUser()
    {
      $auth=new Authentification();
      $auth->add_user('toto','toto');
      $auth->remove_user('toto');
      $users=$auth->get_users();
      $this->assertArrayNotHasKey('toto', $users);
    }

    public function testConnexion()
    {
      $auth=new Authentification();
      $auth->add_user('toto','toto');
      $auth->connect('toto', 'toto');
      $this->assertTrue($auth->is_connected()['loggedIn']);
      $auth->deconnect();
      $auth->remove_user('toto');
    }

    public function testDeconnexion()
    {
      $auth=new Authentification();
      $auth->add_user('toto','toto');
      $auth->connect('toto', 'toto');
      $auth->deconnect();
      $this->assertFalse($auth->is_connected()['loggedIn']);
      $auth->remove_user('toto');
    }

    public function testChangePassword()
    {
      $auth=new Authentification();
      $auth->add_user('toto','toto');
      $auth->change_password('toto', 'toto','titi');
      $auth->connect('toto', 'titi');
      $this->assertTrue($auth->is_connected()['loggedIn']);
      $auth->deconnect();
      $auth->change_password('toto', 'motDePassFaux','tata');
      $auth->connect('toto', 'tata');
      $this->assertFalse($auth->is_connected()['loggedIn']);
      $auth->deconnect();
      $auth->remove_user('toto');
    }
}
?>
