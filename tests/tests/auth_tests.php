<?php

include('../auth_functions.php');

class AuthTests extends PHPUnit_Framework_TestCase
{
    public function testAddUser()
    {
      add_user('toto','toto');
      $users=get_users();
      $this->assertArrayHasKey('toto', $users);
      $this->assertEquals($users['toto'], 'toto');
      remove_user('toto');
    }

    public function testRemoveUser()
    {
      add_user('toto','toto');
      remove_user('toto');
      $users=get_users();
      $this->assertArrayNotHasKey('toto', $users);
    }
}
?>
