<?php
  class ControllerCommonHome extends Controller {
    public function index() {
      $data = array();
      $data['rpp'] = 5;

      $this->load->model('user/auth');
      $data['isAdmin'] = $this->model_user_auth->isAdmin();
      $this->load->model('common/review');
      if (!empty($this->request->post['name']) && !empty($this->request->post['email']) && !empty($this->request->post['text'])) {
        $data['save_error'] = $this->model_common_review->save($this->request->post, $this->request->files['image'], $data['isAdmin']);
        if (empty($data['save_error'])) {
          $data['review_saved'] = true;
        }
      }

      $data['order'] = 'date';
      if (!empty($this->request->get['order'])) {
        $data['order'] = $this->request->get['order'];
      }

      $data['offs'] = 0;
      if (!empty($this->request->get['offs'])) {
        $data['offs'] = (int)$this->request->get['offs'];
      }      

      $start = !empty($this->request->get['offs']) ? (int)$this->request->get['offs'] : 0;
      $data['reviews'] = $this->model_common_review->getAll($data['offs'], $data['offs'] + $data['rpp'], $data['order'], $data['isAdmin']);

      echo $this->load->view('common/home.tpl', $data);
    }

    public function preview() {
      $data = array();

      $data['review'] = array(
        'id' => 0,
        'add_date' => time(),
        'add_name' => $this->request->post['name'],
        'add_email' => $this->request->post['email'],
        'comment' => $this->request->post['text'],
        'status' => 1,
        'is_changed' => 0,
        'image' => $this->request->post['image']
      );
      if (!empty($this->request->post['id'])) {
        $this->load->model('common/review');
        $review = $this->model_common_review->getById($this->request->post['id']);
        if ($review) {
          $data['review']['image'] = $review['image'];
        }
      }
      echo $this->load->view('common/review.tpl', $data);
    }
  }