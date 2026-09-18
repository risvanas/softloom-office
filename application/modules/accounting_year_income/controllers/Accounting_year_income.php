<?php

class Accounting_year_income extends MX_Controller {

    function __construct()
    {
        parent::__construct();
        $this->load->helper(array('form', 'template', 'date'));
        $this->template->set_template('admin_template');
    }

    function index()
    {
        $menu_id = 58;
        $this->load->library('../controllers/permition_checker');
        $this->permition_checker->permition_viewprocess($menu_id);

        $sql = "SELECT tbl_accounting_year.YEAR_CODE AS code,
                       tbl_accounting_year.FROM_DATE AS st_date,
                       tbl_accounting_year.TO_DATE AS end_date,
                       (SELECT IFNULL(SUM(CREDIT), 0)
                        FROM tbl_transaction
                        JOIN tbl_account ON tbl_transaction.ACC_ID = tbl_account.ACC_ID
                        JOIN tbl_account AS income_exp ON tbl_account.PARENT_ACC_ID = income_exp.ACC_ID
                        WHERE tbl_account.PARENT_ACC_ID IN (3)
                          AND tbl_transaction.DEL_FLAG = 1
                          AND tbl_transaction.DATE_OF_TRANSACTION >= st_date
                          AND tbl_transaction.DATE_OF_TRANSACTION <= end_date) AS income
                FROM tbl_accounting_year
                WHERE tbl_accounting_year.DEL_FLAG = 1
                GROUP BY code, st_date, end_date";

        $data['year_data'] = $this->db->query($sql);
        $layout = array(
            'page'  => 'form_accountingyear_income',
            'title' => 'Accounting Year Income',
            'data'  => $data,
        );
        render_template($layout);
    }

    function year_growth()
    {
        $menu_id = 59;
        $this->load->library('../controllers/permition_checker');
        $this->permition_checker->permition_viewprocess($menu_id);

        $sql = "SELECT tbl_accounting_year.YEAR_CODE AS code,
                       tbl_accounting_year.FROM_DATE AS st_date,
                       tbl_accounting_year.TO_DATE AS end_date,
                       (SELECT IFNULL(SUM(CREDIT), 0)
                        FROM tbl_transaction
                        JOIN tbl_account ON tbl_transaction.ACC_ID = tbl_account.ACC_ID
                        JOIN tbl_account AS income_exp ON tbl_account.PARENT_ACC_ID = income_exp.ACC_ID
                        WHERE tbl_account.PARENT_ACC_ID IN (3)
                          AND tbl_transaction.DEL_FLAG = 1
                          AND tbl_transaction.DATE_OF_TRANSACTION >= st_date
                          AND tbl_transaction.DATE_OF_TRANSACTION <= end_date) AS income
                FROM tbl_accounting_year
                WHERE tbl_accounting_year.DEL_FLAG = 1
                GROUP BY code, st_date, end_date";

        $data['growth'] = $this->db->query($sql);
        $layout = array(
            'page'  => 'form_growth_graph',
            'title' => 'Business Growth',
            'data'  => $data,
        );
        render_template($layout);
    }
}
