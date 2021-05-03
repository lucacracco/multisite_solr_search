<?php

/**
 * This is project's console commands configuration for Robo task runner.
 *
 * @see http://robo.li/
 */
class RoboFile extends \Robo\Tasks {

  use \LucaCracco\RoboDrupal\Task\Drush\Tasks;

  /**
   * Run Behat test.
   *
   * @param string $config
   * @param null[] $options
   *
   * @return \Robo\Result
   */
  public function behat($config = './behat/behat.yml', $options = ['tags' => NULL]) {
    $behat_task = $this->taskExec('./vendor/bin/behat')
      ->option('config', $config);
    if ($options['tags']) {
      $behat_task->option('tags', $options['tags']);
    }
    return $behat_task->run();
  }

  /**
   * Force use account mail of test for new installation.
   *
   * @hook init install
   */
  public function initInstallCommand(\Symfony\Component\Console\Input\InputInterface $input, \Consolidation\AnnotatedCommand\AnnotationData $annotationData) {
    $input->setOption('mail', 'admin@localhost.loc');
  }

  /**
   * Insert contents.
   */
  public function testContents() {
    $task_list = [];

    foreach (['site1', 'site2'] as $site) {

      $task_list[$site . '_install_devel'] = $this->taskDrushStack($site)
        ->drush('en devel_generate');
      $task_list[$site . '_generate_content'] = $this->taskDrushStack($site)
        ->drush('genc 50 --bundles=article --add-type-label --kill --authors=1');
      $task_list[$site . '_uninstall_devel'] = $this->taskDrushStack($site)
        ->drush('pm:uninstall devel_generate');
    }

    $this->getBuilder()->addTaskList($task_list);
    return $this->getBuilder();
  }

}
