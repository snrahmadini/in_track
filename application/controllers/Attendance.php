<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Attendance extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        is_weekends();
        is_logged_in();
        is_checked_in();
        is_checked_out();
        $this->load->library('form_validation');
        $this->load->model('Public_model');
        $this->load->model('Admin_model');
        $this->load->helper('debugger');

    }

    public function index()
    {
        // Attendance Form
        $d['title'] = 'Attendance Form';
        $d['account'] = $this->Public_model->getAccount($this->session->userdata['username']);

        console_log('Form berhasil sampai ke controller Attendance');
        if (is_writable('./images/attendance')) {
            console_log("lanjutkan bisa diupload");
        } else {
            echo "Folder TIDAK bisa ditulis! Atur chmod!";
        }

        // If Weekends
        if (is_weekends() == true) {
            $d['weekends'] = true;
            $this->load->view('templates/header', $d);
            $this->load->view('templates/sidebar');
            $this->load->view('templates/topbar');
            $this->load->view('attendance/index', $d); // Attendance Form Page
            $this->load->view('templates/footer');
        } else {
            $d['in'] = true;
            $d['weekends'] = false;
            // If haven't Check In Today
            if (is_checked_in() == false) {
                $d['in'] = false;


                $this->form_validation->set_rules('notes', 'Notes', 'required');

                console_log('Belum checkin nih bangsat');
                if ($this->form_validation->run() == false) {

                    console_log('Si Bangsat');
                    $this->load->view('templates/header', $d);
                    $this->load->view('templates/sidebar');
                    $this->load->view('templates/topbar');
                    $this->load->view('attendance/index', $d); // Attendance Form Page
                    $this->load->view('templates/footer');
                } else {
                    date_default_timezone_set('Asia/Jakarta');

                    if (!isset($_FILES['image']) || $_FILES['image']['error'] != 0) {
                        echo "<script>alert('Upload Image is Required!');</script>";
                        $this->load->view('templates/header', $d);
                        $this->load->view('templates/sidebar');
                        $this->load->view('templates/topbar');
                        $this->load->view('attendance/index', $d);
                        $this->load->view('templates/footer');
                        return;
                    }

                    $username = $this->session->userdata['username'];
                    $intern_id = $d['account']['id'];
                    $division_id = $d['account']['division_id'];
                    $iTime = time();
                    $notes = $this->input->post('notes');
                    $lack = 'None';

                    $inStatus = 'Present';

                    // Check Notes
                    if (!$notes) {
                        $lack = 'Notes';
                    }

                    // Config Upload
                    $config['upload_path'] = './images/attendance/';
                    $config['allowed_types'] = 'jpg|png|jpeg';
                    $config['max_size'] = '2048';
                    $config['file_name'] = 'item-' . date('ymd') . '-' . substr(md5(rand()), 0, 10);

                    // Load Upload Library and Pass Config
                    $this->load->library('upload', $config);
                    $image = null;
                    if ($_FILES['image']['name']) {
                        console_log("upload gambar");
                        if ($this->upload->do_upload('image')) {
                            $image = $this->upload->data('file_name');
                            console_log("sukses");

                        } else {
                            $this->upload->display_errors();
                            echo "<script>alert('Error upload image');</script>";
                            $this->load->view('templates/header', $d);
                            $this->load->view('templates/sidebar');
                            $this->load->view('templates/topbar');
                            $this->load->view('attendance/index', $d);
                            $this->load->view('templates/footer');
                            return;
                        }
                    } else {
                        if ($lack != '') {
                            $lack .= ',image';
                        } else {
                            $lack = 'image';
                        }
                    }
                    $value = [
                        'username' => $username,
                        'intern_id' => $intern_id,
                        'division_id' => $division_id,
                        'in_time' => $iTime,
                        'notes' => $notes,
                        'image' => $image,
                        'in_status' => $inStatus
                    ];
                    console_log($value);

                    $this->_checkIn($value);
                }
            }
            // End of Today Check In
            // If Checked In
            else {
                if (is_checked_out() == true) {
                    $d['disable'] = true;
                } else {
                    $d['disable'] = false;
                };
                $this->load->view('templates/header', $d);
                $this->load->view('templates/sidebar');
                $this->load->view('templates/topbar');
                $this->load->view('attendance/index', $d); // Attendance Form Page
                $this->load->view('templates/footer');
            }
        }
    }

    // Check Check IN
    private function _checkIn($value)
    {
        $this->db->insert('attendance', $value);
        $rows = $this->db->affected_rows();
        if ($rows > 0) {
            $this->session->set_flashdata('message', '<div class="alert alert-success" role="alert">
                                     Stamped attendance for today</div>');
        } else {
            $this->session->set_flashdata('message', '<div class="alert alert-danger" role="alert">
                                     Failed to stamp your attendance!</div>');
        }
        redirect('attendance');
    }

    // Check Check Out
    public function checkOut()
    {
        $username = $this->session->userdata['username'];
        $today = date('Y-m-d', time());
        $querySelect = "SELECT  attendance.username AS `username`,
                            attendance.intern_id AS `intern_id`,
                            attendance.in_time AS `in_time`
                      FROM  `attendance`
                     WHERE  `username` = '$username'
                       AND  FROM_UNIXTIME(`in_time`, '%Y-%m-%d') = '$today'";
        $checkOut = $this->db->query($querySelect)->row_array();

        $oTime = time();

        // Check Out Time
        if (date('H:i:s', $oTime) >= $checkOut['end']) {
            $outStatus = 'Over Time';
        } else {
            $outStatus = 'Early';
        };

        $value = [
            'out_time' => $oTime,
            'out_status' => $outStatus
        ];

        $queryUpdate = "UPDATE `attendance`
                       SET `out_time` ='" . $value['out_time'] . "', `out_status` ='" . $value['out_status'] . "' WHERE  `username` = '$username' AND  FROM_UNIXTIME(`in_time`, '%Y-%m-%d') = '$today'";
        $this->db->query($queryUpdate);
        redirect('attendance');
    }

    public function stats()
    {
        $d['title'] = 'Statistics';
        $d['account'] = $this->Public_model->getAccount($this->session->userdata['username']);
        $d['e_id'] = $d['account']['id'];
        $d['data'] = $this->attendance_details_data($d['e_id']);

        $this->load->view('templates/table_header', $d);
        $this->load->view('templates/sidebar');
        $this->load->view('templates/topbar');
        $this->load->view('attendance/stats', $d);
        $this->load->view('templates/table_footer');
    }

    private function attendance_details_data($e_id)
    {
        $start = $this->input->get('start');
        $end = $this->input->get('end');

        $d['attendance'] = $this->Public_model->get_attendance($e_id, $start, $end);

        $d['start'] = $start;
        $d['end'] = $end;

        return $d;
    }
}
