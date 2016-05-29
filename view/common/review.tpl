<blockquote<?php if ($review['status'] == -1) echo ' class=bg-danger'?>>
  <p>
<?php
  if (!empty($review['image']) || empty($review['id'])) {
?>
  <img src=/images/<?php echo $review['image'];?> width=<?php echo IMAGE_MAX_WIDTH;?>px align=left class=img-rounded style="margin-right:10px">
<?php
  }
?>
    <p class=clearfix><?php echo str_replace(array('\r','\n', "\n"), array('', '<br>', '<br>'), $review['comment']); ?></p>
  </p>
  <footer>
    <a href="mailto:<?php echo $review['add_email']; ?>"><?php echo $review['add_name']; ?></a>
    <?php echo date('d.m.Y H:i:s', strtotime($review['add_date'])); ?>
    <?php if (!empty($review['is_changed'])) { ?>
      изменен администратором
    <?php } ?>
    <?php
      if ($review['status'] == 0) {
    ?>
        <button review-id=<?php echo $review['id'];?> class="btn btn-default admin-review-edit">изменить</button>
        <button review-id=<?php echo $review['id'];?> class="btn btn-success admin-review-accept">принять</button>
        <button review-id=<?php echo $review['id'];?> class="btn btn-danger admin-review-decline">отклонить</button>
    <?php
      }
    ?>
  </footer>
</blockquote>