<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Public_model extends CI_Model
{
  public function getAccount($username)
  {
    $account = $this->db->get_where('users', ['username' => $username])->row_array();
    $e_id = $account['intern_id'];
    $query = "SELECT  intern.id AS `id`,
                      intern.name AS `name`,
                      intern.gender AS `gender`,
                      intern.image AS `image`,
                      intern.birth_date AS `birth_date`,
                      intern.hire_date AS `hire_date`,
                      division.id AS `division_id`
                FROM  intern
          INNER JOIN  intern_division ON intern.id = intern_division.intern_id
          INNER JOIN  division ON intern_division.division_id = division.id
               WHERE `intern`.`id` = '$e_id'";
    return $this->db->query($query)->row_array();
  }

  public function get_attendance($start, $end, $dept)
  {
    $query = "SELECT  attendance.in_time AS date,
                      intern.name AS name,
                      attendance.notes AS notes,
                      attendance.image AS image,
                      attendance.lack_of AS lack_of,
                      attendance.in_status AS in_status,
                      attendance.out_time AS out_time,
                      attendance.out_status AS out_status,
                      attendance.intern_id AS e_id
                FROM  attendance
          INNER JOIN  intern_division
                  ON  attendance.intern_id = intern_division.intern_id
          INNER JOIN  intern
                  ON  attendance.intern_id = intern.id
                WHERE  intern_division.division_id = '$dept'
                  AND  (DATE(FROM_UNIXTIME(in_time)) BETWEEN '$start' AND '$end')
            ORDER BY  `date` ASC";

    return $this->db->query($query)->result_array();
  }

  public function getAllInternData($username)
  {
    // get intern id from users table
    $data = $this->db->get_where('users', ['username' => $username])->row_array();
    $e_id = $data['intern_id'];

    // Join Query
    $query = "SELECT  intern.id AS `id`,
                      intern.name AS `name`,
                      intern.gender AS `gender`,
                      intern.image AS `image`,
                      intern.birth_date AS `birth_date`,
                      intern.hire_date AS `hire_date`,
                      division.name AS `division`
                FROM  intern
          INNER JOIN  intern_division ON intern.id = intern_division.intern_id
          INNER JOIN  division ON intern_division.division_id = division.id
               WHERE `intern`.`id` = $e_id";
    // get intern data from intern table using intern id and return the row
    return $this->db->query($query)->row_array();
  }
}
