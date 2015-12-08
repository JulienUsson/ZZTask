<?php

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

    public function testConnection()
    {
      $auth=new Authentification();
      $auth->add_user('toto','toto');
      $auth->connect('toto', 'toto');
      $this->assertTrue($auth->is_connected());
      $auth->remove_user('toto');
    }
}
?>
