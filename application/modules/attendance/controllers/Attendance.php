<?php

class Attendance extends MX_Controller {

    function __construct() {
        parent::__construct();
        $this->load->helper(array('form', 'template'));
        $this->template->set_template('admin_template');
        $this->load->library('form_validation');
        $this->load->model('attendance_model');
    }

    function index() {
        $menu_id = 66;
        $this->load->library('../controllers/permition_checker');
        $this->permition_checker->permition_viewprocess($menu_id);
        $data['staff_list'] = $this->attendance_model->selectStaff();
        $data['year_list'] = $this->attendance_model->selectYear();
        $layout = array('page' => 'form_attendance_list', 'title' => 'Attendance report', 'data' => $data);
        render_template($layout);
    }

    function mult_search() {
        $menu_id = 66;
        $this->load->library('../controllers/permition_checker');
        $this->permition_checker->permition_viewprocess($menu_id);
        $staff = $this->input->post('staff');
        $rep_type = $this->input->post('rep_type');
        $year = $this->input->post('year');
        $month = $this->input->post('month');
        $type = $this->input->post('type');
        $date = $this->input->post('date');
        $date = strtotime($date);
        $date = date("Y-m-d", $date);
        $data['staff'] = $staff;
        $data['rep_type'] = $this->input->post('rep_type');
        $data['year'] = $this->input->post('year');
        $data['month'] = $this->input->post('month');
        $data['date'] = $this->input->post('date');
        $data['type'] = $type;
        if ($type == 'hme') {
            $data['cond'] = $this->attendance_model->select_hme_attendance($year, $month);
        } else {
            if ($rep_type == 'individual') {
                $data['cond'] = $this->attendance_model->select_individual_attendance($staff, $year, $month);
                $data['calendar'] = $this->attendance_model->selectCalendar($year, $month);
            } else {
                $data['cond'] = $this->attendance_model->select_daywise_attendance($date);
                $data['calendar'] = $this->attendance_model->selectCalendar('', '', $date);
            }
        }
        $this->load->view('form_search_list', $data);
    }

    function get_month() {
        $year = $this->input->post('year');
        $month = $this->attendance_model->selectMonth($year)->result();
        echo json_encode($month);
        exit();
    }

    function add_work_from_home() {
        $menu_id = 71;
        $this->load->library('../controllers/permition_checker');
        $data['staff_list'] = $this->attendance_model->selectStaff();
        $data['msg'] = "";
        $this->form_validation->set_rules('txt_staff', 'Staff', 'required');
        if ($this->form_validation->run() == FALSE) {
            $this->permition_checker->permition_viewprocess($menu_id);
            $layout = array('page' => 'form_work_frm_hme', 'title' => 'Work From Home', 'data' => $data);
            render_template($layout);
        } else {
            $this->permition_checker->permition_addprocess($menu_id);
            $staff = $this->input->post('txt_staff');
            $date = $this->input->post('txt_date');
            $date = strtotime($date);
            $date = date("Y-m-d", $date);
            $from = $this->input->post('txt_from_time');
            $to = $this->input->post('txt_to_time');
            $from = strtotime($from);
            $from = date("H:i:s", $from);
            $to = strtotime($to);
            $to = date("H:i:s", $to);
            $this->attendance_model->add_wrk_frm_hme($staff, $date, $from, $to);
            $data['msg'] = 'New Attendance added successfully';
            $layout = array('page' => 'form_work_frm_hme', 'title' => 'Work From Home', 'data' => $data);
            render_template($layout);
        }
    }

    function work_frm_hme_list() {
        $menu_id = 71;
        $this->load->library('../controllers/permition_checker');
        $this->permition_checker->permition_viewprocess($menu_id);
//        $data['staff_list'] = $this->attendance_model->selectStaff();
        $data['year_list'] = $this->attendance_model->selectYear();
        $layout = array('page' => 'form_wrk_hme_list', 'title' => 'Work From Home List', 'data' => $data);
        render_template($layout);
    }

    function wrk_at_hme_delete() {
        $menu_id = 71;
        $this->load->library('../controllers/permition_checker');
        $id = $this->uri->segment(3);
        $this->permition_checker->permition_deleteprocess($menu_id);
        $this->attendance_model->delete_wrk_frm_hme($id);
        redirect('attendance/work_frm_hme_list');
    }

}

?>