#!/bin/bash
BASE="http://softloom.test"
COOKIE="/tmp/softloom_export_cookies.txt"
rm -f "$COOKIE"
pass=0
fail=0
TODAY=$(date +%Y-%m-%d)

check_pdf() {
  local name="$1"
  local file="$2"
  if [ -f "$file" ] && head -c 4 "$file" | grep -q '%PDF'; then
    echo "[PASS] $name ($(wc -c < "$file") bytes)"
    pass=$((pass+1))
  else
    echo "[FAIL] $name"
    head -3 "$file" 2>/dev/null
    fail=$((fail+1))
  fi
}

check_html() {
  local name="$1"
  local file="$2"
  if [ -f "$file" ] && [ "$(wc -c < "$file")" -gt 50 ] && ! grep -qiE "Fatal error|Uncaught Error|Unable to load" "$file"; then
    echo "[PASS] $name ($(wc -c < "$file") bytes)"
    pass=$((pass+1))
  else
    echo "[FAIL] $name"
    head -3 "$file" 2>/dev/null
    fail=$((fail+1))
  fi
}

curl -s -c "$COOKIE" "$BASE/login" > /dev/null
curl -s -b "$COOKIE" -c "$COOKIE" -L -X POST "$BASE/login" \
  -d "username=jomin&password=*852&company_code=sis" > /dev/null

OUT="/tmp/softloom_export_out"
mkdir -p "$OUT"

curl -s -b "$COOKIE" -X POST "$BASE/trialbalance/calculation" \
  -d "generate_pdf=generate_pdf&date=$TODAY&to_date=$TODAY&comp_code=" -o "$OUT/trialbalance.pdf"
check_pdf "trialbalance_pdf" "$OUT/trialbalance.pdf"

curl -s -b "$COOKIE" -X POST "$BASE/trialbalance/calculation" \
  -d "generate_pdf=generate_excel&date=$TODAY&to_date=$TODAY&comp_code=" -o "$OUT/trialbalance.xls"
check_html "trialbalance_excel" "$OUT/trialbalance.xls"

curl -s -b "$COOKIE" --max-time 120 -X POST "$BASE/day_book/diff_date" \
  -d "generate_pdf=generate_pdf&fromdate=2025-01-01&todate=2025-01-31&comp_code=" -o "$OUT/daybook.pdf"
check_pdf "daybook_pdf" "$OUT/daybook.pdf"

curl -s -b "$COOKIE" -X POST "$BASE/day_book/diff_date" \
  -d "generate_pdf=generate_excel&fromdate=2024-01-01&todate=$TODAY&comp_code=" -o "$OUT/daybook.xls"
check_html "daybook_excel" "$OUT/daybook.xls"

curl -s -b "$COOKIE" -X POST "$BASE/income_and_expenditure/calculation" \
  -d "generate_pdf=generate_pdf&from_date=2024-01-01&to_date=$TODAY&comp_code=" -o "$OUT/income.pdf"
check_pdf "income_pdf" "$OUT/income.pdf"

curl -s -b "$COOKIE" -X POST "$BASE/income_and_expenditure/calculation" \
  -d "generate_pdf=generate_excel&from_date=2024-01-01&to_date=$TODAY&comp_code=" -o "$OUT/income.xls"
check_html "income_excel" "$OUT/income.xls"

curl -s -b "$COOKIE" --max-time 120 -X POST "$BASE/student/mult_search" \
  -d "generate_pdf=generate_pdf&fromdate=2025-01-01&todate=$TODAY&dat=REG_DATE&course=&stat=&key_words=&sort_by=NAME&type=list&company=sis" -o "$OUT/student.pdf"
check_pdf "student_pdf" "$OUT/student.pdf"

curl -s -b "$COOKIE" -X POST "$BASE/student/mult_search" \
  -d "generate_pdf=generate_excel&fromdate=2020-01-01&todate=$TODAY&dat=REG_DATE&course=&stat=&key_words=&sort_by=NAME&type=list&company=sis" -o "$OUT/student.xls"
check_html "student_excel" "$OUT/student.xls"

curl -s -b "$COOKIE" -X POST "$BASE/invoice/get_gst_invoice_list" \
  -d "generate_pdf=generate_pdf&frm=2024-01-01&to=$TODAY&company_code=sis&key_words=" -o "$OUT/gst_invoice.pdf"
check_pdf "gst_invoice_pdf" "$OUT/gst_invoice.pdf"

curl -s -b "$COOKIE" -X POST "$BASE/invoice/get_gst_invoice_list" \
  -d "generate_pdf=generate_excel&frm=2024-01-01&to=$TODAY&company_code=sis&key_words=" -o "$OUT/gst_invoice.xls"
check_html "gst_invoice_excel" "$OUT/gst_invoice.xls"

echo "---"
echo "Passed: $pass  Failed: $fail"
exit $([ "$fail" -eq 0 ] && echo 0 || echo 1)
