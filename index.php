<?php
error_reporting(E_ALL);
ini_set("display_errors", 1);
  if (is_file('config.php')) {
        require_once 'config.php';
  }

  require_once __DIR__.'/system/registry.php';
  require_once __DIR__.'/system/loader.php';
  require_once __DIR__.'/system/db.php';
  require_once __DIR__.'/system/request.php';
  require_once __DIR__.'/system/action.php';
  require_once __DIR__.'/system/controller.php';
  require_once __DIR__.'/system/session.php';
  require_once __DIR__.'/system/model.php';


  $registry = new Registry();

  $loader = new Loader($registry);
  $registry->set('load', $loader);

  $db = new DB(DB_HOSTNAME, DB_USERNAME, DB_PASSWORD, DB_DATABASE, DB_PORT);
  $registry->set('db', $db);

  $request = new Request();
  $registry->set('request', $request);

  $session = new Session();
  $registry->set('session', $session);

  if (isset($request->get['route'])) {
      $action = new Action($request->get['route']);
  } else {
      $action = new Action('common/home');
  }
  $action->execute($registry);
