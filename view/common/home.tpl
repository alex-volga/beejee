<?php include 'header.tpl'; ?>
<h1>Отзывы</h1>
<?php
  if (!empty($review_saved)) {
?>
  <div class="container bg-info">Отзыв успешно добавлен/изменен.</div><br>
<?php
  }
?>
<div>
  сортировать по:
  <a role=button class="btn btn-<?php echo($order == 'name' ? 'primary' : 'default');?>" href=/?order=name<?php if (!empty($offs)) echo '&offs=',$offs;?>>имени</a>
  <a role=button class="btn btn-<?php echo($order == 'email' ? 'primary' : 'default');?>" href=/?order=email<?php if (!empty($offs)) echo '&offs=',$offs;?>>email</a>
  <a role=button class="btn btn-<?php echo($order == 'date' ? 'primary' : 'default');?>" href=/?order=date<?php if (!empty($offs)) echo '&offs=',$offs;?>>дате добавления</a>
</div>
<br>
<div id=reviews>
<?php
  if (!empty($reviews) && !empty($reviews->rows)) {
    foreach ($reviews->rows as $review) {
      include 'review.tpl';
    }
  } else {
?>
  <div class="container bg-info">Нет отзывов</div>
<?php
  }
?>
</div>
<div class=pagination>
<?php
  if ($offs > 0) {
?>
  <a href=/?order=<?php echo $order;?>&offs=<?php echo max(0, $offs - $rpp);?>>&larr; показать предыдущие <?php echo $rpp;?> записей</a>
<?php
  }
?>

<?php
  if (count($reviews->rows) >= $rpp) {
    if ($offs > 0) {
?> | <?php
    }
?>
  <a href=/?order=<?php echo $order;?>&offs=<?php echo $offs + $rpp;?>>показать следующие <?php echo $rpp;?> записей &rarr;</a>
<?php
  }
?>
</div>
<?php include 'form.tpl'; ?>
<?php include 'footer.tpl'; ?>