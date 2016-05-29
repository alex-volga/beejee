<?php
  class ControllerUserUser extends Controller {
    public function login() {
      $this->load->model('user/auth');
      $this->model_user_auth->auth($this->request->post['login'], $this->request->post['pass']);
      echo $this->model_user_auth->isAdmin() ? 1 : 0;
    }

    public function logout() {
      $this->load->model('user/auth');
      $this->model_user_auth->logout();
    }
  }