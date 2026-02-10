<?php

class Leave extends MX_Controller {

    function __construct() {
        parent::__construct();
        $this->load->helper(array('form', 'template'));
        $this->template->set_template('admin_template');
        $this->load->library(array('form_validation','email'));
        $this->load->model('leave_model');
    }

    function index() {
        $menu_id = 65;
        $this->load->library('../controllers/permition_checker');
        $this->permition_checker->permition_viewprocess($menu_id);
        $data['staff_list'] = $this->leave_model->selectStaff();
        $from_date = date('Y-m-d', strtotime('-1 month'));
        $to_date = date('Y-m-d');
        $data['cond'] = $this->leave_model->select_leave('', '', '', 'pending');
        $layout = array('page' => 'form_leave_list', 'title' => 'Leave application List', 'data' => $data);
        render_template($layout);
    }

    function staff_details() {
        $id = $this->input->post('staff_id');
        $data['staff_list'] = $this->leave_model->selectStaff($id);
        $this->load->view('form_staff_details', $data);
    }

    function mult_search() {
        $menu_id = 65;
        $this->load->library('../controllers/permition_checker');
        $this->permition_checker->permition_viewprocess($menu_id);
        $staff = $this->input->post('staff');
        $from_date = $this->input->post('fromdate');
        $to_date = $this->input->post('todate');
        $from_date = strtotime($from_date);
        $from = date("Y-m-d", $from_date);
        $to_date = strtotime($to_date);
        $to = date("Y-m-d", $to_date);
        $data['staff'] = $staff;
        $data['from_date'] = $this->input->post('fromdate');
        $data['to_date'] = $this->input->post('todate');
        $data['cond'] = $this->leave_model->select_leave($staff, $from, $to);
        $this->load->view('form_search_list', $data);
    }

    function leave_edit() {
        $menu_id = 65;
        $this->load->library('../controllers/permition_checker');
        $this->permition_checker->permition_editprocess($menu_id);
        $id = $this->uri->segment(3);
        $data['staff_list'] = $this->leave_model->selectStaff();
        $data['leave_edit'] = $this->leave_model->edit($id);
        $layout = array('page' => 'form_leave_edit', 'title' => 'Leave application edit', 'data' => $data);
        render_template($layout);
    }

    function leave_update() {
        $id = $this->input->post('txt_id');
        $staff_id = $this->input->post('txt_staff');
        $n = $this->input->post('Num');

        $sess_array = $this->session->userdata('logged_in');
        $modified_by = $sess_array['user_id'];
        $this->load->library('../controllers/lockdate');
        $location_details = $this->lockdate->location_details();
        $modified_on = gmdate("Y-m-d H:i:s");
        $main_ins_data = array(
            'STAFF_ID' => $staff_id,
            'LOCATION_DETAILS' => $location_details
        );
        
        $staff = $this->leave_model->selectStaff($staff_id)->row();
        $html = "<html><body><p>Hi,<br><br></p>
                    <table style='border-collapse: collapse'>
                        <tr>
                            <th style='border: 1px solid;padding: 10px;text-align: center'>Date</th>
                            <th style='border: 1px solid;padding: 10px;text-align: center'>Leave Type</th>
                            <th style='border: 1px solid;padding: 10px;text-align: center'>Reason</th>
                            <th style='border: 1px solid;padding: 10px;text-align: center'>Project manager</th>" .
                            "<th style='border: 1px solid;padding: 10px;text-align: center'>HR manager</th>
                        </tr>
                    ";
        
        $pm = $hr = "";
        for ($i = 3; $i <= $n; $i++) {
            $detail_id = $this->input->post('leave_detail_id' . $i);
            $date = $this->input->post('leave_date' . $i);
            $date = strtotime($date);
            $date = date("Y-m-d", $date);
            $leave_type = $this->input->post('leave_type' . $i);
            $reason = $this->input->post('leave_reason' . $i);
            $reason = str_replace("'", "&#39;", $reason);
            $pm_status = $this->input->post('pm_aprov' . $i);
            $hr_status = $this->input->post('hr_aprov' . $i);
            $pm_comment = $this->input->post('pm_comment' . $i);
            $hr_comment = $this->input->post('hr_comment' . $i);
//            $details = $this->leave_model->sel_data('tbl_leave_details', array('ID'=>$id))->row();
            $ins_data = array(
                'STAFF_ID' => $staff_id,
//                'LEAVE_ID' => $leave_id,
                'LEAVE_DATE' => $date,
                'LEAVE_TYPE' => $leave_type,
                'REASON' => $reason,
                'LOCATION_DETAILS' => $location_details
            );
            
            if ($pm_status != NULL) {
                $pm = $pm_status;
                $ins_data['APPROVED_PM'] = "IF(PM_STATUS IS NULL OR PM_STATUS='','" . $modified_by . "', APPROVED_PM)";
                $ins_data['PM_APPROVED_ON'] = "IF(PM_STATUS IS NULL OR PM_STATUS='','" . $modified_on . "', PM_APPROVED_ON)";
                $ins_data['PM_COMMENT'] = "IF(PM_STATUS IS NULL OR PM_STATUS='','" . $pm_comment . "', PM_COMMENT)";
                $ins_data['PM_STATUS'] = "IF(PM_STATUS IS NULL OR PM_STATUS='','" . $pm_status . "', PM_STATUS)";
//                $condition = 'PM_STATUS';
            }
            if ($hr_status != NULL) {
                $hr = $hr_status;
                $ins_data['APPROVED_HR'] = "IF(HR_STATUS IS NULL OR HR_STATUS='','" . $modified_by . "', APPROVED_HR)";
                $ins_data['HR_APPROVED_ON'] = "IF(HR_STATUS IS NULL OR HR_STATUS='','" . $modified_on . "', HR_APPROVED_ON)";
                $ins_data['HR_COMMENT'] = "IF(HR_STATUS IS NULL OR HR_STATUS='','" . $hr_comment . "', HR_COMMENT)";
                $ins_data['HR_STATUS'] = "IF(HR_STATUS IS NULL OR HR_STATUS='','" . $hr_status . "', HR_STATUS)";
//                $condition = 'HR_STATUS';
            }

            $this->leave_model->acc_update('tbl_leave_details', $ins_data, $detail_id);
            
            $details = $this->leave_model->sel_data('tbl_leave_details', array('ID'=>$detail_id))->row();
            $aprvd_pm = $this->leave_model->sel_data('tbl_account', array('ACC_ID'=>$details->APPROVED_PM))->row();
            $aprvd_hr = $this->leave_model->sel_data('tbl_account', array('ACC_ID'=>$details->APPROVED_HR))->row();
            $leave = (($leave_type == '0.5') ? 'Half' : 'Full' ) . ' Day';
            $pm_stts = ($details->PM_STATUS != "") ? ucfirst(str_replace("_", " ", $details->PM_STATUS)) . ' (' . $aprvd_pm->ACC_NAME . ')' : "";
            $hr_stts = ($details->HR_STATUS != "") ? ucfirst(str_replace("_", " ", $details->HR_STATUS)) . ' (' . $aprvd_hr->ACC_NAME . ')' : "";
            $html .= "<tr>
                        <td style='border: 1px solid;padding: 10px'>$date</td>
                        <td style='border: 1px solid;padding: 10px'>$leave</td>
                        <td style='border: 1px solid;padding: 10px'>$reason</td>
                        <td style='border: 1px solid;padding: 10px'>$pm_stts</td>
                        <td style='border: 1px solid;padding: 10px'>$hr_stts</td>
                    </tr>";
        }
        if ($pm != "") {
            $main_ins_data['PM_STATUS'] = $pm;
            $main_ins_data['PM_APPROVED_BY'] = $modified_by;
            $main_ins_data['PM_APPROVED_ON'] = $modified_on;
//            $condition = 'PM_STATUS';
        }
        if ($hr != "") {
            $main_ins_data['HR_STATUS'] = $hr;
            $main_ins_data['HR_APPROVED_BY'] = $modified_by;
            $main_ins_data['HR_APPROVED_ON'] = $modified_on;
//            $condition = 'HR_STATUS';
        }
        $this->leave_model->acc_update('tbl_leave', $main_ins_data, $id);
        
        $staff = $this->leave_model->sel_data('tbl_account', array('ACC_ID'=>$staff_id))->row();
        $html .= "</table></body></html>";
        $config = array();
//            $config['protocol'] = 'smtp';
//            $config['smtp_host'] = 'softloom.com';
//            $config['smtp_user'] = 'noreply@softloom.com';
//            $config['smtp_pass'] = 'J+ni2:1?V475121566';
//            $config['smtp_port'] = 465;
            $config['mailtype'] = 'html';
            $this->email->initialize($config);
            $this->email->from('noreply@softloom.com', 'Softloom It solutions');
            $to = array($staff->ACC_EMAIL);
            $this->email->to($to);
            $this->email->subject('Status change on Leave Request');
            $this->email->message($html);
            $this->email->send();
        
        redirect("leave");
    }

    function leave_delete() {
        $menu_id = 65;
        $this->load->library('../controllers/permition_checker');
        $this->permition_checker->permition_deleteprocess($menu_id);
        $id = $this->uri->segment(3);
        $sess_array = $this->session->userdata('logged_in');
        $deleted_by = $sess_array['user_id'];
        $this->load->library('../controllers/lockdate');
        $location_details = $this->lockdate->location_details();
        $deleted_on = gmdate("Y-m-d H:i:s");
        $dat = array('DEL_FLAG' => '0',
            'DELETED_BY' => $deleted_by,
            'DELETED_ON' => $deleted_on,
            'LOCATION_DETAILS' => $location_details);
        $this->leave_model->delete('tbl_leave_details', $id, $dat);
        redirect("leave/leave_list");
    }

}

?>