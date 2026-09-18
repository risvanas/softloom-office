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
        $this->updateBookNumberCreditSequence();
        $this->updateBookNumberDebitSequence();
        $this->syncPaymentBookNumber();
    }

    public function updateBookNumberCreditSequence()
    {
        // Step 1: Fetch ordered records
        $this->db->select('TRANS_ID, BOOK_NUMBER');
        $this->db->from('tbl_transaction');
        $this->db->where('DATE_OF_TRANSACTION >=', '2026-03-01');
        $this->db->where('DATE_OF_TRANSACTION <=', '2026-03-31');
        $this->db->where('BOOK_NAME', 'PAY');
        $this->db->where('CREDIT IS NULL', null, false);
        $this->db->where('DEL_FLAG', 1);
        $this->db->where('INVOICE_TYPE', 'without_tax');
        $this->db->order_by('DATE_OF_TRANSACTION', 'ASC');
        $this->db->order_by('TRANS_ID', 'ASC');

        $query = $this->db->get();
        $results = $query->result();

        if (empty($results)) {
            echo "No records found.";
            return;
        }

        // Step 2: Get starting BOOK_NUMBER (from first row)
        $startBookNumber = (int)$results[0]->BOOK_NUMBER;

        // Step 3: Loop and update sequentially
        $currentBookNumber = $startBookNumber;

        foreach ($results as $row) {
            $this->db->where('TRANS_ID', $row->TRANS_ID);
            $this->db->update('tbl_transaction', [
                'BOOK_NUMBER' => $currentBookNumber
            ]);

            $currentBookNumber++;
        }

        echo "BOOK_NUMBER credit updated successfully./n";
    }

    public function updateBookNumberDebitSequence()
    {
        // Step 1: Fetch ordered records
        $this->db->select('TRANS_ID, BOOK_NUMBER');
        $this->db->from('tbl_transaction');
        $this->db->where('DATE_OF_TRANSACTION >=', '2026-03-01');
        $this->db->where('DATE_OF_TRANSACTION <=', '2026-03-31');
        $this->db->where('BOOK_NAME', 'PAY');
        $this->db->where('DEBIT IS NULL', null, false);
        $this->db->where('DEL_FLAG', 1);
        $this->db->order_by('DATE_OF_TRANSACTION', 'ASC');
        $this->db->order_by('TRANS_ID', 'ASC');

        $query = $this->db->get();
        $results = $query->result();

        if (empty($results)) {
            echo "No records found.";
            return;
        }

        // Step 2: Get starting BOOK_NUMBER (from first row)
        $startBookNumber = (int)$results[0]->BOOK_NUMBER;

        // Step 3: Loop and update sequentially
        $currentBookNumber = $startBookNumber;

        foreach ($results as $row) {
            $this->db->where('TRANS_ID', $row->TRANS_ID);
            $this->db->update('tbl_transaction', [
                'BOOK_NUMBER' => $currentBookNumber
            ]);

            $currentBookNumber++;
        }

        echo "BOOK_NUMBER debit updated successfully.\n";
    }

    public function syncPaymentBookNumber()
    {
        // Start transaction (safe update)
        $this->db->trans_start();

        // Step 1: Get all relevant transaction records (DEBIT only)
        $this->db->select('PAYMENT_ID, BOOK_NUMBER');
        $this->db->from('tbl_transaction');
        $this->db->where('BOOK_NAME', 'PAY');
        $this->db->where('CREDIT IS NULL', null, false); // debit entry
        $this->db->where('DEL_FLAG', 1);

        $transactions = $this->db->get()->result();

        if (empty($transactions)) {
            echo "No transaction records found.";
            return;
        }

        // Step 2: Loop and update tbl_payment
        foreach ($transactions as $row) {

            $this->db->where('PAY_ID', $row->PAYMENT_ID);
            $this->db->update('tbl_payment', [
                'BOOK_NUMBER' => $row->BOOK_NUMBER
            ]);
        }

        $this->db->trans_complete();

        if ($this->db->trans_status() === FALSE) {
            echo "Error updating payment BOOK_NUMBER.";
        } else {
            echo "Payment BOOK_NUMBER updated successfully.";
        }
    }
}
