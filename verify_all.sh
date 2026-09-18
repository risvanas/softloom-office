#!/bin/bash
set -e
ROOT="$(cd "$(dirname "$0")" && pwd)"
cd "$ROOT"

echo "=== PHP 8.4 Softloom Verification ==="
php test_php84_bootstrap.php
php test_crud_db.php
./test_routes.sh
./test_exports_http.sh

echo ""
echo "=== Additional page checks ==="
COOKIE="/tmp/softloom_verify_cookies.txt"
rm -f "$COOKIE"
curl -s -c "$COOKIE" "http://softloom.test/login" > /dev/null
curl -s -b "$COOKIE" -c "$COOKIE" -L -X POST "http://softloom.test/login" \
  -d "username=jomin&password=*852&company_code=sis" > /dev/null

pages=(
  dashboard
  accounting_year_income
  graph/income_expenditure_graph
  student_payment/payment
  invoice
)

for page in "${pages[@]}"; do
  body=$(curl -s -b "$COOKIE" -L "http://softloom.test/$page")
  if echo "$body" | grep -qiE "Database Error|Fatal error|Uncaught Error|Parse error"; then
    echo "[FAIL] $page"
    echo "$body" | rg -i "Database Error|Fatal error|Error Number" | head -3
    exit 1
  fi
  echo "[PASS] $page"
done

echo ""
echo "All verification checks passed."
