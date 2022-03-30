<?php
class news extends CI_Controller {

public function show($id) {
    $this->load->model('news_model');
    $news = $this->news_model->get_news($id);
    $data['username'] = $news['username'];
    //$data['body'] = $news['body'];
    $this->load->view('news_article', $data);
}

}

?>