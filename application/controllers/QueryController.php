<?php

class QueryController extends MX_Controller
{

    function __construct()
    {
        parent::__construct();
        $this->load->helper(array('form', 'template'));
        $this->template->set_template('admin_template');
        $this->load->database();
    }

    function index()
    {
        $this->updateBookNumber();
    }

    public function updateBookNumber()
    {
        $acc_year_code = 19;

        // with_tax starts at 101 (start_number 100 + 1), without_tax starts at 1 (start_number 0 + 1)
        $with_tax_start = 100;
        $without_tax_start = 0;

        $this->db->trans_start();

        // Step 1: Create backup columns (safe to run more than once)
        if (!in_array('BOOK_NUMBER_OLD', $this->db->list_fields('tbl_payment'))) {
            $this->db->query(
                'ALTER TABLE tbl_payment ADD COLUMN BOOK_NUMBER_OLD INT(11) DEFAULT NULL AFTER BOOK_NUMBER'
            );
        }

        if (!in_array('BOOK_NUMBER_OLD', $this->db->list_fields('tbl_transaction'))) {
            $this->db->query(
                'ALTER TABLE tbl_transaction ADD COLUMN BOOK_NUMBER_OLD INT(11) DEFAULT NULL AFTER BOOK_NUMBER'
            );
        }

        // Step 2: Copy current values into backup columns (only rows not backed up yet)
        $this->db->query(
            'UPDATE tbl_payment SET BOOK_NUMBER_OLD = BOOK_NUMBER WHERE BOOK_NUMBER_OLD IS NULL'
        );
        $this->db->query(
            'UPDATE tbl_transaction SET BOOK_NUMBER_OLD = BOOK_NUMBER WHERE BOOK_NUMBER_OLD IS NULL'
        );

        // Step 3: Re-order tbl_payment.BOOK_NUMBER for ACC_YEAR_CODE = 19
        // Same scope as payment report + Feecollection: TYPE = 'STD' only
        // Grouping: ACC_YEAR_CODE + DEL_FLAG + INVOICE_TYPE + COMPANY (Feecollection MAX query)
        // with_tax  -> 101, 102, 103 ... per company
        // without_tax -> 1, 2, 3 ... per company
        $this->db->query("
            UPDATE tbl_payment p
            JOIN (
                SELECT
                    PAY_ID,
                    ROW_NUMBER() OVER (
                        PARTITION BY COMPANY, INVOICE_TYPE
                        ORDER BY PAYMENT_DATE ASC, PAY_ID ASC
                    ) + CASE INVOICE_TYPE
                        WHEN 'with_tax' THEN {$with_tax_start}
                        ELSE {$without_tax_start}
                      END AS new_book_number
                FROM tbl_payment
                WHERE ACC_YEAR_CODE = {$acc_year_code}
                  AND DEL_FLAG = 1
                  AND TYPE = 'STD'
                  AND INVOICE_TYPE IN ('with_tax', 'without_tax')
            ) ranked ON p.PAY_ID = ranked.PAY_ID
            SET p.BOOK_NUMBER = ranked.new_book_number
        ");

        // Step 3b: Restore non-STD rows (e.g. CUSTOMER) — not shown on payment report
        $this->db->query("
            UPDATE tbl_payment
            SET BOOK_NUMBER = BOOK_NUMBER_OLD
            WHERE ACC_YEAR_CODE = {$acc_year_code}
              AND TYPE != 'STD'
        ");

        // Step 4: Sync tbl_transaction from tbl_payment (Feecollection PAY book conditions)
        $this->db->query("
            UPDATE tbl_transaction t
            JOIN tbl_payment p ON t.PAYMENT_ID = p.PAY_ID
            SET t.BOOK_NUMBER = p.BOOK_NUMBER
            WHERE t.BOOK_NAME = 'PAY'
              AND t.ACC_YEAR_CODE = {$acc_year_code}
              AND t.DEL_FLAG = 1
              AND t.INVOICE_TYPE = p.INVOICE_TYPE
              AND t.COMPANY = p.COMPANY
              AND p.ACC_YEAR_CODE = {$acc_year_code}
              AND p.DEL_FLAG = 1
              AND p.TYPE = 'STD'
        ");

        $this->db->trans_complete();

        if ($this->db->trans_status() === FALSE) {
            echo 'Error updating BOOK_NUMBER. All changes were rolled back.';
        } else {
            echo 'Done. Original values saved in BOOK_NUMBER_OLD. '
                . "ACC_YEAR_CODE {$acc_year_code} STD payments re-numbered per COMPANY + INVOICE_TYPE: with_tax from "
                . ($with_tax_start + 1) . ', without_tax from ' . ($without_tax_start + 1)
                . '. tbl_transaction (BOOK_NAME=PAY) synced. Non-STD rows restored from backup.';
        }
    }

    public function updateBookNumberRevert()
    {
        $this->db->trans_start();

        $payment_fields = $this->db->list_fields('tbl_payment');
        $transaction_fields = $this->db->list_fields('tbl_transaction');

        $has_payment_backup = in_array('BOOK_NUMBER_OLD', $payment_fields);
        $has_transaction_backup = in_array('BOOK_NUMBER_OLD', $transaction_fields);

        if (!$has_payment_backup && !$has_transaction_backup) {
            echo 'Nothing to revert. BOOK_NUMBER_OLD columns do not exist.';
            return;
        }

        // Step 1: Restore original BOOK_NUMBER from backup columns
        if ($has_payment_backup) {
            $this->db->query(
                'UPDATE tbl_payment SET BOOK_NUMBER = BOOK_NUMBER_OLD WHERE BOOK_NUMBER_OLD IS NOT NULL'
            );
        }

        if ($has_transaction_backup) {
            $this->db->query(
                'UPDATE tbl_transaction SET BOOK_NUMBER = BOOK_NUMBER_OLD WHERE BOOK_NUMBER_OLD IS NOT NULL'
            );
        }

        // Step 2: Remove backup columns
        if ($has_payment_backup) {
            $this->db->query('ALTER TABLE tbl_payment DROP COLUMN BOOK_NUMBER_OLD');
        }

        if ($has_transaction_backup) {
            $this->db->query('ALTER TABLE tbl_transaction DROP COLUMN BOOK_NUMBER_OLD');
        }

        $this->db->trans_complete();

        if ($this->db->trans_status() === FALSE) {
            echo 'Error reverting BOOK_NUMBER. All changes were rolled back.';
        } else {
            echo 'Done. BOOK_NUMBER restored from BOOK_NUMBER_OLD and backup columns removed.';
        }
    }
}
