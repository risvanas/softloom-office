<?php

class Calendar extends MX_Controller {

    function __construct() {
        parent::__construct();
        $this->load->helper(array('form', 'template'));
        $this->template->set_template('admin_template');
        $this->load->library('form_validation');
        $this->load->model('calendar_model');
    }

    function index() {
        $menu_id = 67;
        $this->load->library('../controllers/permition_checker');
        $data['msg'] = "";
        $data['errmsg'] = "";
        $this->form_validation->set_rules('txt_cal_year', 'Year', 'required');
        $this->form_validation->set_rules('txt_cal_month', 'Month', 'required');
        if ($this->form_validation->run() == FALSE) {
            $this->permition_checker->permition_viewprocess($menu_id);
            $layout = array('page' => 'form_calendar_entry', 'title' => 'Calendar', 'data' => $data);
            render_template($layout);
        } else {
            $this->permition_checker->permition_addprocess($menu_id);
            $year = $this->input->post('txt_cal_year');
            $month = $this->input->post('txt_cal_month');
            $n = $this->input->post('Num');
            if ($n == '2') {
                $data['msg'] = "";
                $data['errmsg'] = "You have some form errors. Please check below.";
                $layout = array('page' => 'form_calendar_entry', 'title' => 'Calendar', 'data' => $data);
                render_template($layout);
                return FALSE;
            }
            $sess_array = $this->session->userdata('logged_in');
            $create_by = $sess_array['user_id'];
            $this->load->library('../controllers/lockdate');
            $location_details = $this->lockdate->location_details();
            $create_on = gmdate("Y-m-d H:i:s");
            $this->db->query("DELETE FROM tbl_calendar WHERE YEAR(CAL_DATE)= $year AND MONTH(CAL_DATE)=" . ($month + 1));
            for ($i = 3; $i <= $n; $i++) {
                $date = $this->input->post('calendar_date' . $i);
                $date = strtotime($date);
                $date = date("Y-m-d", $date);
                $calendar_day = $this->input->post('calendar_day' . $i);
                $calendar_off = ($this->input->post('calendar_off' . $i)) ? 1 : 0;
                $working_hrs = $this->input->post('working_hrs' . $i);
                $working_hrs = ($working_hrs == '') ? 0 : $working_hrs;
                $description = $this->input->post('description' . $i);
                $ins_data = array(
                    'CAL_DATE' => $date,
                    'CAL_DAY' => $calendar_day,
                    'CAL_OFF' => $calendar_off,
                    'WORKING_HOURS' => $working_hrs,
                    'CAL_DESCRIPTION' => $description,
                    'CREATED_BY' => $create_by,
                    'CREATED_ON' => $create_on,
                    'LOCATION_DETAILS' => $location_details
                );
                $this->calendar_model->acc_insert('tbl_calendar', $ins_data);
            }
            $data['msg'] = 'Calendar addedd successfully';
            $layout = array('page' => 'form_calendar_entry', 'title' => 'Calendar', 'data' => $data);
            render_template($layout);
        }
    }

    function get_calendar() {
        $year = $this->input->post('year');
        $month = $this->input->post('month');
        $calndr = $this->calendar_model->selectCalendar($year, $month)->result();
        echo json_encode($calndr);
        exit();
    }

    function attendance_list() {
        $menu_id = 68;
        $this->load->library('../controllers/permition_checker');
        $this->permition_checker->permition_viewprocess($menu_id);
        $data['year_list'] = $this->calendar_model->selectYear();
        $data['mnth_list'] = $this->calendar_model->selectMonth(date('Y'));
        $layout = array('page' => 'form_attendance_list', 'title' => 'Attendance List', 'data' => $data);
        render_template($layout);
    }

    function mult_search() {
        $menu_id = 68;
        $this->load->library('../controllers/permition_checker');
        $this->permition_checker->permition_viewprocess($menu_id);
//        $staff = $this->input->post('staff');
//        $rep_type = $this->input->post('rep_type');
        $year = $this->input->post('year');
        $month = $this->input->post('month');
        $staff_status = $this->input->post('staff_status');
//        $date = $this->input->post('date');
//        $date = strtotime($date);
//        $date = date("Y-m-d", $date);
//        $data['staff'] = $staff;
//        $data['rep_type'] = $this->input->post('rep_type');
        $data['year'] = $this->input->post('year');
        $data['month'] = $this->input->post('month');
//        $data['date'] = $this->input->post('date');
//        if ($rep_type == 'individual') {
            $data['cond'] = $this->calendar_model->select_attendance($year, $month, $staff_status);
//        } else {
//            $data['cond'] = $this->calendar_model->select_daywise_attendance($date);
//        }
//            echo "<pre>";
//            print_r($data['cond']->result());
//            echo "</pre>";
        $this->load->view('form_search_list', $data);
    }

}

?>