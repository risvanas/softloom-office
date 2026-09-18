-- Align tbl_transaction with legacy inserts that omit these columns (PHP app sends no defaults).
-- Run once against your Softloom database, e.g.:
--   mysql -u USER -p DATABASE < database/tbl_transaction_allow_null.sql

ALTER TABLE `tbl_transaction`
  MODIFY `PAYMENT_ID` int DEFAULT NULL,
  MODIFY `TRANSACTION_DATE` date DEFAULT NULL,
  MODIFY `CASH_TO` varchar(100) DEFAULT NULL,
  MODIFY `CASH_RECEIVED_BY` varchar(100) DEFAULT NULL;
