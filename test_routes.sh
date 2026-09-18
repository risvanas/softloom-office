#!/bin/bash
# HTTP smoke tests for all Softloom modules on PHP 8.4
BASE="http://softloom.test"
COOKIE="/tmp/softloom_test_cookies.txt"
rm -f "$COOKIE"
pass=0
fail=0

check() {
  local name="$1"
  local code="$2"
  local body="$3"
  if [ "$code" = "200" ] && ! echo "$body" | grep -qiE "Fatal error|Uncaught Error|Parse error|Call to undefined"; then
    echo "[PASS] $name (HTTP $code)"
    pass=$((pass+1))
  else
    echo "[FAIL] $name (HTTP $code)"
    echo "$body" | head -2
    fail=$((fail+1))
  fi
}

curl -s -c "$COOKIE" "$BASE/login" > /dev/null
curl -s -b "$COOKIE" -c "$COOKIE" -L -X POST "$BASE/login" \
  -d "username=jomin&password=*852&company_code=sis" > /dev/null

modules=(
  login dashboard student invoice feecollection ledger receipt voucher account
  enquiry followup trialbalance day_book income_and_expenditure bank_voucher
  customer_payment user_managing menu_management balance_sheet profit_and_loss
  accounting_year/new_accounting_year accounting_year_income temp_invoice invoice_cancelation
  training_refund training_return staff_ledger salary_posting leave calendar
  backup graph service student_payment menu_permition income_expenditure
)

for mod in "${modules[@]}"; do
  resp=$(curl -s -w "\n%{http_code}" -b "$COOKIE" -L "$BASE/$mod")
  code=$(echo "$resp" | tail -1)
  body=$(echo "$resp" | sed '$d')
  check "module_$mod" "$code" "$body"
done

echo "---"
echo "Passed: $pass  Failed: $fail"
exit $([ "$fail" -eq 0 ] && echo 0 || echo 1)
