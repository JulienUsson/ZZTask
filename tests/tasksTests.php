<?php

include(__DIR__.'/../src/classes/authentification.php');
include(__DIR__.'/../src/classes/tasks.php');

class tasksTests extends PHPUnit_Framework_TestCase {
	public function testAddTask()
    {
		$auth=new Authentification();
		$tasks=new Tasks();
		$auth->add_user('test_user','test_password');
		$this->assertEquals(count($tasks_t[0]), 0);
		$tasks->add_task('test_user', 'test_title', 'test_task');
		$tasks_t=$tasks->get_tasks('test_user');
		$this->assertEquals(count($tasks_t[0]), 1);
		$this->assertEquals($tasks_t[0][0]['title'], 'test_title');
		$this->assertEquals($tasks_t[0][0]['description'], 'test_task');
		$this->assertEquals($tasks_t[0][0]['user'], 'test_user');
		$tasks->remove_task('test_user', 0, 0);
		$auth->remove_user('test_user');
    }


    public function testRemoveTask()
    {
		$auth=new Authentification();
		$tasks=new Tasks();
		$auth->add_user('test_user','test_password');
		$tasks->add_task('test_user', 'test_title', 'test_task');
		$tasks->remove_task('test_user', 0, 0);
		$tasks_t=$tasks->get_tasks('test_user');
		$this->assertArrayNotHasKey(0,$tasks_t[0]);
		$auth->remove_user('test_user');
    }

	public function testMoveTask()
	{
		$auth=new Authentification();
		$tasks=new Tasks();
		$auth->add_user('test_user','test_password');
		$tasks->add_task('test_user', 'test_title', 'test_task');
		$tasks->move_task('test_user',0,0);
		$tasks_t=$tasks->get_tasks('test_user');
		$this->assertArrayNotHasKey(0,$tasks_t[0]);
		$this->assertEquals('title', $tasks_t[1][0]['title']);
		$tasks->move_task('test_user',1,0);
		$tasks_t=$tasks->get_tasks('test_user');
		$this->assertArrayNotHasKey(0,$tasks_t[0]);
		$this->assertEquals('test_title', $tasks_t[2][0]['title']);
		$auth->remove_user('test_user');
	}
}
?>
