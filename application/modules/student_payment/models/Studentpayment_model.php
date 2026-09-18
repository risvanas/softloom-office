<?php

class Studentpayment_model extends CI_Model {

    function stud_insert($tab, $dat)
    {
        $this->db->insert($tab, $dat);
    }

    function payment_details()
    {
        $this->db->distinct('*');
        $this->db->select('tbl_student.STUDENT_ID, tbl_student.NAME, tbl_student.CONTACT_NO, tbl_student.FEE_AMOUNT');
        $this->db->from('tbl_payment');
        $this->db->join('tbl_student', 'tbl_student.STUDENT_ID = tbl_payment.STUDENT_ID');
        $this->db->where('tbl_student.DEL_FLAG', '1');
        $this->db->group_by('NAME');

        return $this->db->get();
    }

    function get_paid_amount($student_id)
    {
        $this->db->select_sum('AMOUNT', 'amt');
        $this->db->from('tbl_payment');
        $this->db->where('STUDENT_ID', $student_id);
        $query = $this->db->get();
        $row   = $query->row();

        return $row ? (float) $row->amt : 0;
    }
}
