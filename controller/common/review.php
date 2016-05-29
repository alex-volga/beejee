<?php
  class ControllerCommonReview extends Controller {
    public function accept() {
      $this->load->model('user/auth');
      $isAdmin = $this->model_user_auth->isAdmin();
      if ($isAdmin && !empty($this->request->post['id'])) {
        $this->load->model('common/review');
        $this->model_common_review->accept((int)$this->request->post['id']);
      }
      echo 1;
    }

    public function decline() {
      $this->load->model('user/auth');
      $isAdmin = $this->model_user_auth->isAdmin();
      if ($isAdmin && !empty($this->request->post['id'])) {
        $this->load->model('common/review');
        $this->model_common_review->decline((int)$this->request->post['id']);
      }
      echo 1;
    }

    public function get() {
      $this->load->model('user/auth');
      $isAdmin = $this->model_user_auth->isAdmin();
      if ($isAdmin && !empty($this->request->post['id'])) {
        $this->load->model('common/review');
        header('Content-type: application/json; charset=UTF-8');
        $review = $this->model_common_review->getById((int)$this->request->post['id']);
        if (!empty($review) && !empty($review['comment'])) {
          $review['comment'] = str_replace(array('\r', '\n'), array('', "\n"), $review['comment']);
        }
        echo json_encode($review);
        return;
      }
      echo '{}';
    }
  }