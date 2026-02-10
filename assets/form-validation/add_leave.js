var type = 'type';
var checkbox = 'checkbox';

var TABLE_NAME = 'tblstr'; // this should be named in the HTML
var ROW_BASE = 2; // first number (for display)
var hasLoaded = false;

var wind;

function fillInRows() {
    hasLoaded = true;
    for (i = 0; i < 4; i++) {
        appendRow();
    }
}

function myRowObject(zero, one, two, three, four, five, six, seven,eight) {
    this.zero = zero;
    this.one = one;
    this.two = two;
    this.three = three;
    this.four = four;
    this.five = five;
    this.six = six;
    this.seven = seven;
    this.eight = eight;
}

function appendRow() {
    hasLoaded = true;
    var tbl = document.getElementById(TABLE_NAME);
    var nextRow = tbl.rows.length;
    var iteration = nextRow + ROW_BASE;
    var row = tbl.insertRow(nextRow);

    //SL no
    var cell0 = row.insertCell(0);
    var el0 = document.createElement('input');
    el0.setAttribute('type', 'text');
    el0.setAttribute('id', 'sl' + iteration);
    el0.setAttribute('name', 'sl' + iteration);
    el0.setAttribute('size', '1');
    el0.setAttribute('value', iteration - 2);
    el0.setAttribute('readonly', 'true');
    el0.setAttribute('style', ' border: medium none; box-shadow: none; padding: 0px 0px;');
    cell0.appendChild(el0);

    //Acc Code
    var cell1 = row.insertCell(1);
    var el1 = document.createElement('input');
    el1.setAttribute('type', 'text');
    el1.setAttribute('id', 'leave_date' + iteration);
    el1.setAttribute('name', 'leave_date' + iteration);
    el1.setAttribute('value', '');
//		el1.setAttribute('size', '30');
    el1.setAttribute('style', ' border: medium none; box-shadow: none; padding: 0px 0px;');
    el1.setAttribute('readonly', 'true');
    cell1.appendChild(el1);

    //Batch Type
    var cell2 = row.insertCell(2);
    var el2 = document.createElement('select');
//    el2.setAttribute('type', 'text');
    el2.setAttribute('id', 'leave_type' + iteration);
    el2.setAttribute('name', 'leave_type' + iteration);
//    el2.setAttribute('size', '20');
//    el2.setAttribute('value', '');
    el2.setAttribute('style', ' border: medium none; box-shadow: none; padding: 0px 0px;');
//		el2	.readOnly = true;
    cell2.appendChild(el2);

    //Amount
    var cell3 = row.insertCell(3);
    var el3 = document.createElement('input');
    el3.setAttribute('type', 'text');
    el3.setAttribute('id', 'leave_reason' + iteration);
    el3.setAttribute('name', 'leave_reason' + iteration);
    el3.setAttribute('size', '15');
    el3.setAttribute('value', '');
    el3.setAttribute('class', 'form-control');
//		el3.readOnly = false;
    //el3.setAttribute('style',' border: medium none; box-shadow: none; padding: 0px 0px;');
    cell3.appendChild(el3);

    //Remarks
    var cell4 = row.insertCell(4);
    var el4 = document.createElement('select');
//    el4.setAttribute('type', 'text');
    el4.setAttribute('id', 'pm_aprov' + iteration);
    el4.setAttribute('name', 'pm_aprov' + iteration);
//    el4.setAttribute('size', '15');
//    el4.setAttribute('value', '');
    el4.setAttribute('class', 'form-control');
//		el4.readOnly = false;
    //el4.setAttribute('onkeyup', 'culRate('+iteration+');validateNumber(this)');
    //el4.setAttribute('style',' border: medium none; box-shadow: none; padding: 0px 0px;');
    cell4.appendChild(el4);

    //Remarks
    var cell5 = row.insertCell(5);
    var el5 = document.createElement('select');
//    el5.setAttribute('type', 'text');
    el5.setAttribute('id', 'hr_aprov' + iteration);
    el5.setAttribute('name', 'hr_aprov' + iteration);
//    el5.setAttribute('size', '15');
//    el5.setAttribute('value', '');
    el5.setAttribute('class', 'form-control');
//		el4.readOnly = false;
    //el4.setAttribute('onkeyup', 'culRate('+iteration+');validateNumber(this)');
    //el4.setAttribute('style',' border: medium none; box-shadow: none; padding: 0px 0px;');
    cell5.appendChild(el5);


    //Delete
    var cell6 = row.insertCell(6);
    var el6 = document.createElement('input');
    el6.setAttribute('type', 'checkbox');
    el6.id = "chkbox" + iteration;
    el6.name = "chkbox" + iteration;
    el6.align = "center";
    cell6.appendChild(el6);

    //hidden acc id
		var el7= document.createElement('input');
		el7.setAttribute('type', 'hidden');
		el7.id="leave_detail_id" + iteration;
		el7.name="leave_detail_id" + iteration;
		cell6.appendChild(el7);	


    row.myRow = new myRowObject(el0, el1, el2, el3, el4, el5, el6, el7);
}


function deleteChecked(tblName) {
    var checkedObjArray = new Array();
    var cCount = 0;

    if (hasLoaded) {
        var tbl = document.getElementById(tblName);
        for (var i = 0; i < tbl.rows.length; i++) {
            if (tbl.rows[i].myRow && tbl.rows[i].myRow.six.getAttribute('type') == 'checkbox' &&
                    tbl.rows[i].myRow.six.checked) {
                checkedObjArray[cCount] = tbl.rows[i];
                cCount = cCount + 1;
            }
        }
    }
    if (checkedObjArray.length > 0) {
        var rIndex = checkedObjArray[0].sectionRowIndex;
        deleteRows(checkedObjArray);
        var tbl = document.getElementById(tblName);
        reorderRows(tbl, rIndex);
    }
//	document.getElementById("idSelectAll").checked=false;

}


function deleteRows(rowObjArray) {
    if (hasLoaded) {
        for (var i = 0; i < rowObjArray.length; i++) {
            var rIndex = rowObjArray[i].sectionRowIndex;
            rowObjArray[i].parentNode.deleteRow(rIndex);
            document.getElementById("Num").value = Number(document.getElementById("Num").value) - 1;
        }
    }
}


function reorderRows(tbl, startingIndex) {
    if (hasLoaded) {
        //if (tbl.thead[0].rows[startingIndex]) {

        var count = startingIndex + ROW_BASE;

        for (var i = startingIndex; i < tbl.rows.length; i++) {

            tbl.rows[i].myRow.zero.id = 'sl' + count; // input text
            tbl.rows[i].myRow.zero.value = count - 2; // input text		

            tbl.rows[i].myRow.one.name = 'leave_date' + count; // input text
            tbl.rows[i].myRow.one.id = 'leave_date' + count; // input text

            tbl.rows[i].myRow.two.name = 'leave_type' + count; // input text
            tbl.rows[i].myRow.two.id = 'leave_type' + count; // input text

            tbl.rows[i].myRow.three.name = 'leave_reason' + count; // input text
            tbl.rows[i].myRow.three.id = 'leave_reason' + count; // input text

            tbl.rows[i].myRow.four.name = 'pm_aprov' + count; // input text
            tbl.rows[i].myRow.four.id = 'pm_aprov' + count; // input text

            tbl.rows[i].myRow.five.name = 'hr_aprov' + count; // input text
            tbl.rows[i].myRow.five.id = 'hr_aprov' + count; // input text

            tbl.rows[i].myRow.six.name = 'chkbox' + count; // input text
            tbl.rows[i].myRow.six.id = 'chkbox' + count; // input text
            
            tbl.rows[i].myRow.six.name = 'leave_detail_id' + count; // input text
            tbl.rows[i].myRow.six.id = 'leave_detail_id' + count; // input text

            count++;

        }
        //	}
    }
    hiddenFunction();
}