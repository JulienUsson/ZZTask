<?php

include(__DIR__.'/../src/classes/admin.php');

class AdminTests extends PHPUnit_Framework_TestCase
{
    public function testAddAdmin()
    {
      $admin=new Admin();
      $admin->add_admin('toto');
      $admins=$admin->get_admins();
      $this->assertContains('toto', $admins);
      $admin->remove_admin('toto');
    }

    public function testRemoveAdmin()
    {
      $admin=new Admin();
      $admin->add_admin('toto');
      $admin->remove_admin('toto');
      $admins=$admin->get_admins();
      $this->assertNotContains('toto', $admins);
    }

    public function testIsAdmin()
    {
      $admin=new Admin();
      $admin->add_admin('toto');
      $admins=$admin->get_admins();
      $this->assertTrue($admin->is_admin('toto'));
      $admin->remove_admin('toto');
    }
}
?>
