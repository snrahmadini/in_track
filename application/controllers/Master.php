<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Master extends CI_Controller
{
  public function __construct()
  {
    parent::__construct();
    is_logged_in();
    $this->load->library('form_validation');
    $this->load->model('Public_model');
    $this->load->model('Admin_model');
  }
  public function index()
  {
    // Department Data
    $d['title'] = 'Division';
    $d['division'] = $this->db->get('division')->result_array();
    $d['account'] = $this->Admin_model->getAdmin($this->session->userdata['username']);

    $this->load->view('templates/table_header', $d);
    $this->load->view('templates/sidebar');
    $this->load->view('templates/topbar');
    $this->load->view('master/division/index', $d); // Department Page
    $this->load->view('templates/table_footer');
  }
  public function a_dept()
  {
    // Add Division
    $d['title'] = 'Division';
    $d['account'] = $this->Admin_model->getAdmin($this->session->userdata['username']);
    // Form Validation
    $this->form_validation->set_rules('d_id', 'Division ID', 'required|trim|exact_length[3]|alpha');
    $this->form_validation->set_rules('d_name', 'Division Name', 'required|trim');

    if ($this->form_validation->run() == false) {
      $this->load->view('templates/header', $d);
      $this->load->view('templates/sidebar');
      $this->load->view('templates/topbar');
      $this->load->view('master/division/a_dept', $d); // Add Department Page
      $this->load->view('templates/footer');
    } else {
      $this->_addDept();
    }
  }

  private function _addDept()
  {
    $data = [
      'id' => $this->input->post('d_id'),
      'name' => $this->input->post('d_name')
    ];

    $checkId = $this->db->get_where('division', ['id' => $data['id']])->num_rows();
    if ($checkId > 0) {
      $this->session->set_flashdata('message', '<div class="alert alert-danger" role="alert">
      Failed to add, ID used!</div>');
    } else {
      $this->db->insert('division', $data);
      $this->session->set_flashdata('message', '<div class="alert alert-success" role="alert">
        Successfully added a new division!</div>');
    }
    redirect('master');
  }

  public function e_dept($d_id)
  {
    // Edit Division
    $d['title'] = 'Division';
    $d['d_old'] = $this->db->get_where('division', ['id' => $d_id])->row_array();
    $d['account'] = $this->Admin_model->getAdmin($this->session->userdata['username']);
    // Form Validation
    $this->form_validation->set_rules('d_name', 'Division Name', 'required|trim');

    if ($this->form_validation->run() == false) {
      $this->load->view('templates/header', $d);
      $this->load->view('templates/sidebar');
      $this->load->view('templates/topbar');
      $this->load->view('master/division/e_dept', $d); // Edit Division Page
      $this->load->view('templates/footer');
    } else {
      $name = $this->input->post('d_name');
      $this->_editDept($d_id, $name);
    }
  }
  private function _editDept($d_id, $name)
  {
    $data = ['name' => $name];
    $this->db->update('division', $data, ['id' => $d_id]);
    $this->session->set_flashdata('message', '<div class="alert alert-success" role="alert">
        Successfully edited a division!</div>');
    redirect('master');
  }
  public function d_dept($d_id)
  {
    $this->db->delete('division', ['id' => $d_id]);
    $this->session->set_flashdata('message', '<div class="alert alert-success" role="alert">
        Successfully deleted a division!</div>');
    redirect('master');
  }
  // End of division

  public function intern()
  {
    // Intern Data
    $d['title'] = 'Intern';
    $d['intern'] = $this->db->get('intern')->result_array();
    $d['account'] = $this->Admin_model->getAdmin($this->session->userdata['username']);

    $this->load->view('templates/table_header', $d);
    $this->load->view('templates/sidebar');
    $this->load->view('templates/topbar');
    $this->load->view('master/intern/index', $d); // Intern Page
    $this->load->view('templates/table_footer');
  }

  public function a_intern()
  {
    // Add Intern
    $d['title'] = 'Intern';
    $d['division'] = $this->db->get('division')->result_array();
    $d['account'] = $this->Admin_model->getAdmin($this->session->userdata['username']);

    // Form Validation
    $this->form_validation->set_rules('e_name', 'Intern Name', 'required|trim');
    $this->form_validation->set_rules('email', 'Email', 'required|trim|valid_email');
    $this->form_validation->set_rules('e_gender', 'Gender', 'required');
    $this->form_validation->set_rules('e_birth_date', 'Birth Date', 'required|trim');
    $this->form_validation->set_rules('e_hire_date', 'Hire Date', 'required|trim');

    if ($this->form_validation->run() == false) {
      $this->load->view('templates/header', $d);
      $this->load->view('templates/sidebar');
      $this->load->view('templates/topbar');
      $this->load->view('master/intern/a_intern', $d); // Add Intern Page
      $this->load->view('templates/footer');
    } else {
      $this->_addIntern();
    }
  }

  private function _addIntern()
  {
    $name = $this->input->post('e_name');
    $division = $this->input->post('d_id');
    $email = $this->input->post('email');
    $gender = $this->input->post('e_gender');
    $birth_date = $this->input->post('e_birth_date');
    $hire_date = $this->input->post('e_hire_date');

    // Check Email
    $query = "SELECT * FROM intern WHERE email = '$email'";
    $checkEmail = $this->db->query($query)->num_rows();

    if ($checkEmail > 0) {
      $this->session->set_flashdata('message', '<div class="alert alert-danger" role="alert">
      Email already used!</div>');
      redirect('master/a_intern');
    }

    // Config Upload Image
    $config['upload_path'] = './images/pp/';
    $config['allowed_types'] = 'jpg|png|jpeg';
    $config['max_size'] = '2048';
    $config['file_name'] = 'item-' . date('ymd') . '-' . substr(md5(rand()), 0, 10);

    // load library upload and pass config
    $this->load->library('upload', $config);

    if ($_FILES['image']['name']) {
      if ($this->upload->do_upload('image')) {
        $image = $this->upload->data('file_name');
      }
    } else {
      $image = 'default.png';
    }

    $data = [
      'name' => $name,
      'email' => $email,
      'gender' => $gender,
      'image' => $image,
      'birth_date' => $birth_date,
      'hire_date' => $hire_date
    ];

    $this->db->insert('intern', $data);
    $getEmp = $this->db->get_where('intern', ['email' => $data['email']])->row_array();
    // var_dump($getEmp);
    // die;
    $e_id = $getEmp['id'];
    $d = [
      'division_id' => $division,
      'intern_id' => $e_id
    ];

    $this->db->insert('intern_division', $d);
    $rows = $this->db->affected_rows();
    if ($rows > 0) {
      $this->session->set_flashdata('message', '<div class="alert alert-success" role="alert">
        Successfully added a new intern!</div>');
    } else {
      $this->session->set_flashdata('message', '<div class="alert alert-danger" role="alert">
        Failed to add data!</div>');
    }
    redirect('master/intern');
  }

  public function e_intern($e_id)
  {
    $d['title'] = 'Intern';
    $d['intern'] = $this->db->get_where('intern', ['id' => $e_id])->row_array();
    $d['division_current'] = $this->db->get_where('intern_division', ['intern_id' => $e_id])->row_array();
    $d['division'] = $this->db->get('division')->result_array();
    $d['account'] = $this->Admin_model->getAdmin($this->session->userdata['username']);

    $this->form_validation->set_rules('e_name', 'Name', 'required|trim');
    $this->form_validation->set_rules('e_gender', 'Gender', 'required');
    $this->form_validation->set_rules('e_birth_date', 'Birth Date', 'required|trim');
    $this->form_validation->set_rules('e_hire_date', 'Hire Date', 'required|trim');
    $this->form_validation->set_rules('d_id', 'Division', 'required|trim');

    if ($this->form_validation->run() == false) {
      $this->load->view('templates/header', $d);
      $this->load->view('templates/sidebar');
      $this->load->view('templates/topbar');
      $this->load->view('master/intern/e_intern', $d); // Edit Intern Page
      $this->load->view('templates/footer');
    } else {
      $name = $this->input->post('e_name');
      $gender = $this->input->post('e_gender');
      $birth_date = $this->input->post('e_birth_date');
      $hire_date = $this->input->post('e_hire_date');
      $d_id = $this->input->post('d_id');
      $s_id = $this->input->post('s_id');

      // Config Upload Image
      $config['upload_path'] = './images/pp/';
      $config['allowed_types'] = 'jpg|png|jpeg';
      $config['max_size'] = '2048';
      $config['file_name'] = 'item-' . date('ymd') . '-' . substr(md5(rand()), 0, 10);

      // load library upload and pass config
      $this->load->library('upload', $config);

      if ($_FILES['image']['name']) {
        if ($this->upload->do_upload('image')) {
          $image = $this->upload->data('file_name');
          $old_image = $d['intern']['image'];
          if ($old_image != 'default.png') {
            unlink('./images/pp/' . $old_image);
          }
        }
      } else {
        $image = 'default.png';
      }

      $data = [
        'name' => $name,
        'gender' => $gender,
        'image' => $image,
        'birth_date' => $birth_date,
        'hire_date' => $hire_date
      ];
      $division = [
        'division_id' => $d_id
      ];
      $this->_editIntern($e_id, $data, $division);
    }
  }
  private function _editIntern($e_id, $data, $division)
  {
    $this->db->update('intern', $data, ['id' => $e_id]);
    $upd1 = $this->db->affected_rows();
    $this->db->update('intern_division', $division, ['intern_id' => $e_id]);
    $upd2 = $this->db->affected_rows();
    if ($upd1 > 0 && $upd2 > 0) {
      $this->session->set_flashdata('message', '<div class="alert alert-success" role="alert">
      Successfully updated an intern!</div>');
      redirect('master/intern');
    } else if ($upd1 > 0 && $upd2 <= 0) {
      $this->session->set_flashdata('message', '<div class="alert alert-success" role="alert">
      Successfully updated an intern!</div>');
      redirect('master/intern');
    } else if ($upd1  <= 0 && $upd2 > 0) {
      $this->session->set_flashdata('message', '<div class="alert alert-success" role="alert">
      Successfully updated an intern!</div>');
      redirect('master/intern');
    } else {
      $this->session->set_flashdata('message', '<div class="alert alert-danger" role="alert">
      Failed to update intern\'s data!</div>');
      redirect('master/intern');
    }
  }
  public function d_intern($e_id)
  {
    $this->db->delete('intern', ['id' => $e_id]);
    $this->session->set_flashdata('message', '<div class="alert alert-success" role="alert">
        Successfully deleted an intern!</div>');
    redirect('master/intern');
  }

  public function users()
  {
    $query = "SELECT intern_division.intern_id AS e_id,
                     intern_division.division_id AS d_id,
                     users.username AS u_username,
                     intern.name AS e_name
                FROM intern_division
           LEFT JOIN users
                  ON intern_division.intern_id = users.intern_id
          INNER JOIN intern
                  ON intern_division.intern_id = intern.id
          ";
    $d['title'] = 'Users';
    $d['data'] = $this->db->query($query)->result_array();
    $d['account'] = $this->Admin_model->getAdmin($this->session->userdata['username']);

    $this->load->view('templates/table_header', $d);
    $this->load->view('templates/sidebar');
    $this->load->view('templates/topbar');
    $this->load->view('master/users/index', $d);
    $this->load->view('templates/table_footer');
  }

  public function a_users($e_id)
  {
    $empDep = $this->db->get_where('intern_division', ['intern_id' => $e_id])->row_array();
    $d['title'] = 'Users';
    $d['username'] = $empDep['division_id'] . $empDep['intern_id'];
    $d['e_id'] = $empDep['intern_id'];
    $d['account'] = $this->Admin_model->getAdmin($this->session->userdata['username']);

    $this->form_validation->set_rules('u_username', 'Username', 'required|trim|min_length[6]');
    $this->form_validation->set_rules('u_password', 'Password', 'required|trim|min_length[6]');

    if ($this->form_validation->run() == false) {
      $this->load->view('templates/header', $d);
      $this->load->view('templates/sidebar');
      $this->load->view('templates/topbar');
      $this->load->view('master/users/a_users', $d);
      $this->load->view('templates/footer');
    } else {
      $username = $this->input->post('u_username');
      if ($empDep['division_id'] != 'ADM') {
        $role_id = 2;
      } else {
        $role_id = 1;
      }
      $data = [
        'username' => $username,
        'password' => password_hash($this->input->post('u_password'), PASSWORD_DEFAULT),
        'intern_id' => $this->input->post('e_id'),
        'role_id' => $role_id
      ];
      $this->_addUsers($data);
    }
  }
  private function _addUsers($data)
  {
    $this->db->insert('users', $data);
    $rows = $this->db->affected_rows();
    if ($rows > 0) {
      $this->session->set_flashdata('message', '<div class="alert alert-success" role="alert">
          Successfully created an account!</div>');
    } else {
      $this->session->set_flashdata('message', '<div class="alert alert-danger" role="alert">
        Failed to create account!</div>');
    }
    redirect('master/users');
  }

  public function e_users($username)
  {
    $d['title'] = 'Users';
    $d['users'] = $this->db->get_where('users', ['username' => $username])->row_array();
    $d['account'] = $this->Admin_model->getAdmin($this->session->userdata['username']);

    $this->form_validation->set_rules('password', 'Password', 'required|trim|min_length[6]');

    if ($this->form_validation->run() == false) {
      $this->load->view('templates/header', $d);
      $this->load->view('templates/sidebar');
      $this->load->view('templates/topbar');
      $this->load->view('master/users/e_users', $d);
      $this->load->view('templates/footer');
    } else {
      $data = ['password' => password_hash($this->input->post('password'), PASSWORD_DEFAULT)];
      $this->_editUsers($data, $username);
    }
  }
  private function _editUsers($data, $username)
  {
    $this->db->update('users', $data, ['username' => $username]);
    $rows = $this->db->affected_rows();
    if ($rows > 0) {
      $this->session->set_flashdata('message', '<div class="alert alert-success" role="alert">
          Successfully edited an account!</div>');
    } else {
      $this->session->set_flashdata('message', '<div class="alert alert-danger" role="alert">
        Failed to edit account!</div>');
    }
    redirect('master/users');
  }

  public function d_users($username)
  {
    $this->db->delete('users', ['username' => $username]);
    $rows = $this->db->affected_rows();
    if ($rows > 0) {
      $this->session->set_flashdata('message', '<div class="alert alert-success" role="alert">
          Successfully deleted an account!</div>');
    } else {
      $this->session->set_flashdata('message', '<div class="alert alert-danger" role="alert">
        Failed to delete account!</div>');
    }
    redirect('master/users');
  }
}
