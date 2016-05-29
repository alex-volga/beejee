<a name=edit-form></a>
<h3>Добавить/изменить отзыв</h3>
<div id=review-error class=bg-danger><?php if (!empty($save_error)) echo $save_error;?></div>
<form id=send-review enctype="multipart/form-data" method=post action=/>
  <div class=form-group>
    <label for=username>Имя</label>
    <input type=text class=form-control name=name id=username required>
  </div>
 <div class=form-group>
    <label for=email>Email</label>
    <input type=email class=form-control id=email name=email required>
  </div>
 <div class=form-group>
    <label for=text>Текст сообщения</label>
    <textarea name=text id=text class=form-control rows=4 required></textarea>
  </div>
 <div class=form-group id=image-row>
    <label for=image>Картинка</label>
    <input type=file name=image id=image accept=image/*>
  </div>
 <div class="form-group clearfix">
    <div class="col-sm-offset-2 col-sm-10">
      <button class="btn btn-default" id=preview-button>Предварительный просмотр</button>
      <button class="btn btn-success" type=submit>Отправить</button>
    </div>
  </div>
</form>
<div id=preview-container></div>