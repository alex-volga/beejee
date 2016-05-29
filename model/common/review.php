<?php
  class ModelCommonReview extends Model {
    public function getById($id) {
      $result = $this->db->query('SELECT * FROM reviews WHERE id = :id', array(':id' => $id));
      if ($result) {
        return $result->row;
      }
      return array();
    }
  
    public function getAll($begin, $end, $orderBy, $isAdmin) {
      $orderList = array(
        'date' => 'add_date DESC',
        'name' => 'add_name',
        'email' => 'add_email'
      );
      if (!isset($orderList[$orderBy])) {
        $orderBy = 'date';
      }
      $query = 'SELECT * FROM reviews';
      if (!$isAdmin) {
        $query .= ' WHERE status = 1';
      }

      $query .= ' ORDER BY '.$orderList[$orderBy].' LIMIT '.(int)$begin.', '.(int)$end;
      return $this->db->query($query);
    }


    public function save($data, $image, $isAdmin) {
      $file_name = '';
      $hasImage = !empty($image) && !empty($image['name']);
      if (empty($data['remove_image']) && $hasImage && in_array($image['type'], array('image/jpeg', 'image/png', 'image/gif'))) {
          $uploadfile = basename($image['name']);
          if (file_exists(IMAGE_DIR.$uploadfile)) {
            $uploadfile = time().basename($image['name']);
          }
          if (is_uploaded_file($image['tmp_name']) && move_uploaded_file($image['tmp_name'], IMAGE_DIR.$uploadfile)) {
            $file_name = $uploadfile;
            $this->resizeImage($file_name);
          } else {
            return 'Не удалось загрузить файл.';
          }
      } else if ($hasImage) {
        return 'Не правильный тип картинки.';
      }

      $params = array(
        ':name' => $this->db->escape($data['name']),
        ':email' => $this->db->escape($data['email']),
        ':text' => $this->db->escape($data['text'])
      );
      if (!empty($data['remove_image'])) {        
        $params[':image'] = '';
      } else if ($hasImage) {
        $params[':image'] = $this->db->escape($file_name);
      }
      if ($isAdmin && !empty($data['id'])) {
        $query = 'UPDATE';
      } else {
        $query = 'INSERT INTO';
      }
      $query .=  ' reviews SET add_name = :name, add_email = :email, comment = :text';
      if ($hasImage) {
        $query .= ', image = :image';
      }
      if ($isAdmin && !empty($data['id'])) {
        $query .= ', is_changed = 1 WHERE id = :id';
        $params[':id'] = (int)$data['id'];
      }
      $this->db->query($query, $params);

      return '';
    }

    private function resizeImage($file_name) {
      $xpos = 0;
      $ypos = 0;
      $scale = 1;

      $size = getimagesize(IMAGE_DIR.$file_name);
      $mime = $size['mime'];
      $width = $size[0];
      $height = $size[1];
      if ($width > IMAGE_MAX_WIDTH || $height > IMAGE_MAX_HEIGHT) {
        $scale_w = IMAGE_MAX_WIDTH / $width;
        $scale_h = IMAGE_MAX_HEIGHT / $height;
        $scale = min($scale_w, $scale_h);

        $new_width = (int)($width * $scale);
        $new_height = (int)($height * $scale);

        if ($mime == 'image/gif') {
          $old_image = imagecreatefromgif(IMAGE_DIR.$file_name);
        } elseif ($mime == 'image/png') {
          $old_image = imagecreatefrompng(IMAGE_DIR.$file_name);
        } elseif ($mime == 'image/jpeg') {
          $old_image = imagecreatefromjpeg(IMAGE_DIR.$file_name);
        }

        $image = imagecreatetruecolor($new_width, $new_height);

        if ($mime == 'image/png') {
          imagealphablending($image, false);
          imagesavealpha($image, true);
          $background = imagecolorallocatealpha($image, 255, 255, 255, 127);
          imagecolortransparent($image, $background);
        } else {
          $background = imagecolorallocate($image, 255, 255, 255);
        }

        imagefilledrectangle($image, 0, 0, $new_width, $new_height, $background);

        imagecopyresampled($image, $old_image, $xpos, $ypos, 0, 0, $new_width, $new_height, $width, $height);
        imagedestroy($old_image);

        if ($mime == 'image/jpeg') {
          imagejpeg($image, IMAGE_DIR.$file_name, 85);
        } elseif ($mime == 'image/png') {
          imagepng($image, IMAGE_DIR.$file_name);
        } elseif ($mime == 'image/gif') {
          imagegif($image, IMAGE_DIR.$file_name);
        }
        imagedestroy($image);
      }
    }

    private function changeStatus($id, $status) {
      $query = 'UPDATE reviews SET status = '.$status.' WHERE id = '.$id;
      $this->db->query($query);
    }

    public function accept($id) {
      $this->changeStatus($id, 1);
    }

    public function decline($id) {
      $this->changeStatus($id, -1);
    }
  }