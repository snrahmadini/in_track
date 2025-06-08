<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Admin_model extends CI_Model
{
  public function getAdmin($username)
  {
    $account = $this->db->get_where('users', ['username' => $username])->row_array();
    $e_id = $account['employee_id'];
    $query = "SELECT  employee.id AS `id`,
                      employee.name AS `name`,
                      employee.gender AS `gender`,
                      employee.image AS `image`,
                      employee.birth_date AS `birth_date`,
                      employee.hire_date AS `hire_date`
                FROM  employee
               WHERE `employee`.`id` = '$e_id'";
    return $this->db->query($query)->row_array();
  }
  public function getDataForDashboard()
  {
    $d['employee'] = $this->db->get('employee')->result_array();
    $d['c_employee'] = $this->db->get('employee')->num_rows();
    $d['division'] = $this->db->get('division')->result_array();
    $d['c_division'] = $this->db->get('division')->num_rows();
    $d['users'] = $this->db->get('users')->result_array();
    $d['c_users'] = $this->db->get('users')->num_rows();

    return $d;
  }

  public function getDepartment()
  {
    $query = "SELECT  division.name AS d_name,
                      division.id AS d_id,
                      COUNT(employee_division.employee_id) AS d_quantity
                FROM  division
                JOIN  employee_division
                  ON  division.id = employee_division.division_id
            GROUP BY  d_name
    ";
    return $this->db->query($query)->result_array();
  }

  public function getDepartmentEmployees($d_id)
  {
    $query = "SELECT  employee_division.employee_id AS e_id,
                      employee.name AS e_name,
                      employee.image AS e_image,
                      employee.hire_date AS e_hdate
                FROM  employee_division
          INNER JOIN  employee
                  ON  employee_division.employee_id = employee.id
               WHERE  employee_division.division_id = '$d_id'
    ";
    return $this->db->query($query)->result_array();
  }

  public function getEmployeeStatsbyCurrent($e_id)
  {
    $year = date('Y', time());
    $month = date('m', time());
    $query = "SELECT  in_time AS `date`,
                      out_time AS `out_time`,
                      in_status AS `status`,
                      lack_of AS `lack_of`
                FROM  attendance
                WHERE  employee_id = $e_id
                  AND  YEAR(FROM_UNIXTIME(in_time)) = $year
                  AND  MONTH(FROM_UNIXTIME(in_time)) = $month
            ORDER BY  `date` ASC";

    return $this->db->query($query)->result_array();
  }
}
