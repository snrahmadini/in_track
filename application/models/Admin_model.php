<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Admin_model extends CI_Model
{
  public function getAdmin($username)
  {
    $account = $this->db->get_where('users', ['username' => $username])->row_array();
    $e_id = $account['intern_id'];
    $query = "SELECT  intern.id AS `id`,
                      intern.name AS `name`,
                      intern.gender AS `gender`,
                      intern.image AS `image`,
                      intern.birth_date AS `birth_date`,
                      intern.hire_date AS `hire_date`
                FROM  intern
               WHERE `intern`.`id` = '$e_id'";
    return $this->db->query($query)->row_array();
  }
  public function getDataForDashboard()
  {
    $d['intern'] = $this->db->get('intern')->result_array();
    $d['c_intern'] = $this->db->get('intern')->num_rows();
    $d['division'] = $this->db->get('division')->result_array();
    $d['c_division'] = $this->db->get('division')->num_rows();
    $d['users'] = $this->db->get('users')->result_array();

    $query_users  = "SELECT * FROM intern_division
           LEFT JOIN users
                  ON intern_division.intern_id = users.intern_id
          INNER JOIN intern
                  ON intern_division.intern_id = intern.id";
    $d['c_users'] = $this->db->query($query_users)->num_rows();

    return $d;
  }

  public function getDepartment()
  {
    $query = "SELECT  division.name AS d_name,
                      division.id AS d_id,
                      COUNT(intern_division.intern_id) AS d_quantity
                FROM  division
                JOIN  intern_division
                  ON  division.id = intern_division.division_id
            GROUP BY  d_name
    ";
    return $this->db->query($query)->result_array();
  }

  public function getDepartmentInterns($d_id)
  {
    $query = "SELECT  intern_division.intern_id AS e_id,
                      intern.name AS e_name,
                      intern.image AS e_image,
                      intern.hire_date AS e_hdate
                FROM  intern_division
          INNER JOIN  intern
                  ON  intern_division.intern_id = intern.id
               WHERE  intern_division.division_id = '$d_id'
    ";
    return $this->db->query($query)->result_array();
  }

  public function getInternStatsbyCurrent($e_id)
  {
    $year = date('Y', time());
    $month = date('m', time());
    $query = "SELECT  in_time AS `date`,
                      out_time AS `out_time`,
                      in_status AS `status`
                FROM  attendance
                WHERE  intern_id = $e_id
                  AND  YEAR(FROM_UNIXTIME(in_time)) = $year
                  AND  MONTH(FROM_UNIXTIME(in_time)) = $month
            ORDER BY  `date` ASC";

    return $this->db->query($query)->result_array();
  }
}
