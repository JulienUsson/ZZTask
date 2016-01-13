<?php

include(__DIR__.'/../src/classes/authentification.php');
include(__DIR__.'/../src/classes/tasks.php');

class tasksTests extends PHPUnit_Framework_TestCase {
	public function testAddTask() {
		$t=new Tasks();
		$tasks=$t->get_tasks();
		$nb_tasks=count($tasks);
		$t->add_task('titre', 'description', 'toto');
		$tasks=$t->get_tasks();
		$this->assertEquals(count($tasks), $nb_tasks+1);
		$this->assertEquals($tasks[count($tasks)-1]['title'], 'titre');
		$this->assertEquals($tasks[count($tasks)-1]['description'], 'description');
		$this->assertEquals($tasks[count($tasks)-1]['user'], 'toto');
		$t->remove_task(count($tasks)-1);
  }

  public function testRemoveTask() {
		$t=new Tasks();
		$t->add_task('titre', 'description', 'toto');
		$tasks=$t->get_tasks();
		$nb_tasks=count($tasks);
		$t->remove_task(count($tasks)-1);
		$tasks=$t->get_tasks();
		$this->assertEquals(count($tasks), $nb_tasks-1);
  }
}
?>
