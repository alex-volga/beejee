<?php
  class ModelUserAuth extends Model {
    public function isAdmin() {
      return !empty($this->session->data['admin']);
    }

    public function auth($login, $pass)
    {
      if (ADMIN_LOGIN == $login && ADMIN_PASS_HASH == md5($pass))
      {
        $this->session->data['admin'] = 1;
      }
      return false;
    }

    public function logout()
    {
      unset($this->session->data['admin']);
    }
  }