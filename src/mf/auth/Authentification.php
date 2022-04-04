<?php

namespace mf\auth;

class Authentification extends \mf\auth\AbstractAuthentification {
  public function __construct($user_login, $access_level){
    if (isset($_SESSION['user_login'])) {
      $this->user_login = $_SESSION['user_login'];
      $this->access_level = $_SESSION['access_level'];
      $this->logged_in = true;
    }

    else {
      $this->user_login = null;
      $this->access_level = self::$ACCESS_LEVEL_NONE;
      $this->logged_in = false;
    }
  }

  public function updateSession($username, $level) {
    if(login($username, $db_pass, $given_pass, $level)) {
      $this->user_login = $username;
      $this->user_access_level = $level;
  
      $_SESSION['user_login'] = $user_login;
      $_SESSION['access_level'] = $level;
  
      $this->logged_in = true;
    }
  }

  public function logout() {
    unset($_SESSION['user_login']);
    unset($_SESSION['access_right']);

    reset($this->user_login);
    reset ($this->access_level);

    $this->logged_in = false;
  } 

  public function checkAccessRight($requested) {
    if ($requested > $this->access_level) {
      $requested = false;
    }

    else {
      $requested = true;
    }
  }

  public function login($username, $db_pass, $given_pass, $level) {
    if (password_verify($pass, $db_pass)) {
      // echo 'Le mot de passe est valide !';
      updateSession($username, $level);
    } else {
      // echo 'Le mot de passe est invalide.';
      throw new \Exception('Mauvais mot de passe renseigné.');
    }
  }

  protected function hashPassword($password) {
    $hash = password_hash($password, PASSWORD_DEFAULT);

    return $hash;
  }

  protected function verifyPassword($password, $hash) {
    return password_verify($password, $hash);
  }
}