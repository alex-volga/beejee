<div class=container id=auth-container>
<?php if (!empty($isAdmin)) { ?>
    Вы залогинены как администратор 
    <button class="btn btn-primary" id=admin-logout>Выйти
</button>
<?php } else { ?>

    <form class="form-inline" id=login-form>
      <div class="form-group">
        <label for=login>Логин</label>
        <input type=text class="form-control" id=login name=login>
      </div>
      <div class="form-group">
        <label for=pass>Пароль</label>
        <input type=password class="form-control" id=pass name=pass>
      </div>
      <button type=submit class="btn btn-primary" id=admin-login>Войти</button>
      <div id=login-error class=bg-danger></div>
    </form>
<?php } ?>
  </div>
</div>
<br>
  <script src=js/jquery.min.js></script>
  <script src=js/script.js></script>
</body>
</html>