<?php

class Enquirymodel extends CI_Model {

    function insert_data($table, $data) {
        $this->db->insert($table, $data);
    }

    function followup($table) {
        $this->db->from($table);
        $this->db->order_by("methods", " ASC");
        $res = $this->db->get();
        return $res;
    }

    function select_data($id = "", $frm="", $to="", $enq_type="", $start=0, $limit=10, $dtype='LASTFDATE') {
        $this->db->select('tbl_enquiry.*,tbl_status.status,tbl_status.style_class,tbl_account.ACC_NAME');
        $this->db->from('tbl_enquiry');
        $this->db->join('tbl_status', 'tbl_enquiry.STATUS=tbl_status.id');
        $this->db->join('tbl_account', 'tbl_enquiry.ENQTYPE=tbl_account.ACC_ID','left');
        $this->db->where('tbl_enquiry.DEL_FLAG', 1);
        if($enq_type != "")
            $this->db->where('tbl_enquiry.ENQUIRY_TYPE', $enq_type);
        if ($id != "") {
            $this->db->where('tbl_enquiry.EN_ID', $id);
        } else {
            if($frm != "" && $to != "") {
                $this->db->where("tbl_enquiry." . $dtype . " >=", $frm);
                $this->db->where("tbl_enquiry." . $dtype . " <=", $to);
            } else {
                $curnt_date = date('Y-m-d');
                if($enq_type == "0")
                    $this->db->where("(tbl_enquiry.NEXTFDATE <= '$curnt_date' OR tbl_enquiry.NEXTFDATE IS NULL)");
                else 
                    $this->db->where("tbl_enquiry.NEXTFDATE <=", $curnt_date);
                $this->db->where("(tbl_enquiry.STATUS!='3' and tbl_enquiry.STATUS!='4')");
            }
            //$this->db->where("(tbl_enquiry.STATUS!='3' and tbl_enquiry.STATUS!='1')", NULL, FALSE);
            
        }
        if($frm != "" && $to != "") {
            $this->db->order_by('tbl_enquiry.LASTFDATE desc');
        } else {
            $this->db->order_by('tbl_enquiry.NEXTFDATE desc');
        }
        $this->db->limit($limit, $start);
        $res = $this->db->get();
//        $sql = $this->db->last_query();
//        $this->db->insert('tabl_query', array('query' => $sql));
        return $res;
    }
    
    function sel_edit_id($table, $id) {
        $this->db->select('*');
        $this->db->from('tbl_enquiry');
        $this->db->where('EN_ID', $id);
        $this->db->where('DEL_FLAG', 1);
        $res = $this->db->get();
        return $res;
    }

    function sel_status($table, $id='') {
        $this->db->where('B_FLAG', 'ENQUIRY');
        if($id != '') {
            $this->db->where('id', $id);
        }
        $res = $this->db->get($table);
        return $res;
    }

    function enqtype($table, $id='') {
        $this->db->select('*');
        $this->db->from($table);
        $this->db->where('PARENT_ACC_ID', 31);
        $this->db->where('DEL_FLAG', 1);
        if($id != '') {
            $this->db->where('ACC_ID', $id);
        }
        $res = $this->db->get();
        return $res;
    }

    function selectbyid_data($id, $api='') {
        $this->db->select('tbl_followup.*,tbl_status.*,tbl_account.ACC_NAME');
        $this->db->from('tbl_followup');
        $this->db->join('tbl_status', 'tbl_followup.STATUS=tbl_status.id');
        $this->db->join('tbl_account', 'tbl_followup.FOLLOWUP_ADDED_BY=tbl_account.ACC_ID',"left");
        $this->db->where('tbl_followup.EN_ID', $id);
        $this->db->where('tbl_followup.DEL_FLAG', 1);
        $this->db->order_by('tbl_followup.FDATE', 'desc');
        $this->db->order_by('tbl_followup.FID', 'desc');
        $res = $this->db->get();
        return $res;
    }
    
    function select_enqury_count($from = "", $to = "") {
        $this->db->select("tbl_followupvia.methods, COUNT(IF(tbl_enquiry.STATUS=4, 1, NULL)) 'not_interested', COUNT(IF(tbl_enquiry.STATUS=1, 1, NULL)) 'active', COUNT(IF(tbl_enquiry.STATUS=3, 1, NULL)) 'registered', COUNT(IF(tbl_enquiry.STATUS=10, 1, NULL)) 'walkin', COUNT(tbl_enquiry.FOLLOWUPVIA) 'total_count'");
        $this->db->from('tbl_enquiry');
        $this->db->join('tbl_status', 'tbl_enquiry.STATUS = tbl_status.id');
        $this->db->join('tbl_followupvia', 'tbl_enquiry.FOLLOWUPVIA = tbl_followupvia.id');
        $this->db->where('tbl_enquiry.DEL_FLAG', 1);
        if($from != "" && $from != "1970-01-01") {
            $this->db->where('tbl_enquiry.ENTRYDATE>=', $from);
        } if($to != "" && $to != "1970-01-01") {
            $this->db->where('tbl_enquiry.ENTRYDATE<=', $to);
        }
        $this->db->group_by('tbl_enquiry.FOLLOWUPVIA');
        $res = $this->db->get();
        return $res;
    }

    function update_data($table, $data, $id) {
        $this->db->where('EN_ID', $id);
        $this->db->update($table, $data);
    }

    function update_follow($table, $data, $id) {
        $this->db->where('EN_ID', $id);
        $this->db->update($table, $data);
    }

    function multiple_select($from, $to, $dtype, $stype, $sort, $key_words, $search_type="", $college="", $course="", $sem="",$start = 0, $limit = 10) {
        $this->db->select('tbl_enquiry.*,tbl_status.status,tbl_status.style_class,tbl_account.ACC_NAME');
        $this->db->from('tbl_enquiry');
        $this->db->join('tbl_status', 'tbl_status.id=tbl_enquiry.STATUS');
        $this->db->join('tbl_account', 'tbl_account.ACC_ID=tbl_enquiry.ENQTYPE','left');
        $this->db->where('tbl_enquiry.DEL_FLAG', '1');
        $enq_type = ($search_type == 'flwup_db_histry' || $search_type == 'enqry_db_list') ? '0' : (($search_type == 'flwup_histry' || $search_type ==  'list') ? '1' : "");
        if ($enq_type != "")
            $this->db->where('tbl_enquiry.ENQUIRY_TYPE', $enq_type);
        if ($stype != "")
            $this->db->where('tbl_enquiry.STATUS', $stype);
        if ($college != "")
            $this->db->where('tbl_enquiry.COLLEGE', $college);
        if ($course != "")
            $this->db->where('tbl_enquiry.COURSE', $course);
        if ($sem != "")
            $this->db->where('tbl_enquiry.SEMESTER', $sem);
        if($search_type == 'flwup_histry' || $search_type == 'flwup_db_histry') {
            $this->db->where("(tbl_enquiry.STATUS!='3' and tbl_enquiry.STATUS!='4')");
            if($search_type == 'flwup_db_histry')
                $this->db->where("(tbl_enquiry.NEXTFDATE <= '$to' OR tbl_enquiry.NEXTFDATE IS NULL)");
            else 
                $this->db->where("tbl_enquiry.NEXTFDATE <=", $to);
        } else {
            if ($dtype != "" && $from != "1970-01-01" && $to != "1970-01-01") {
                $this->db->where('tbl_enquiry.' . $dtype . ' >=', $from);
                $this->db->where('tbl_enquiry.' . $dtype . ' <=', $to);
            }
        }
        if ($key_words != "") {
            $this->db->where("(NAME LIKE '%$key_words%' ESCAPE '!' OR PHNO LIKE '%$key_words%' ESCAPE '!')");
        }
        if ($sort != '')
            $this->db->order_by($sort, "desc");
        $this->db->limit($limit, $start);
        $res = $this->db->get();
//        $sql = $this->db->last_query();
//        $this->db->insert('tabl_query', array('query' => $sql));
        return $res;
    }
    
    function followup_count($search_type="",$from="", $to="", $dtype="", $stype="", $sort="", $key_words="", $college="", $course="", $sem="") {
        $this->db->select('count(*) as cnt');
        $this->db->from('tbl_enquiry');
        $this->db->join('tbl_status', 'tbl_enquiry.STATUS=tbl_status.id');
        $this->db->join('tbl_account', 'tbl_enquiry.ENQTYPE=tbl_account.ACC_ID','left');
        $this->db->where('tbl_enquiry.DEL_FLAG', 1);
        $enq_type = ($search_type == 'flwup_db_histry' || $search_type == 'enqry_db_list') ? '0' : (($search_type == 'flwup_histry' || $search_type == 'list') ? '1' : "");
        if ($enq_type != "")
            $this->db->where('tbl_enquiry.ENQUIRY_TYPE', $enq_type);
        if ($stype != "")
            $this->db->where('tbl_enquiry.STATUS', $stype);
        if ($college != "")
            $this->db->where('tbl_enquiry.COLLEGE', $college);
        if ($course != "")
            $this->db->where('tbl_enquiry.COURSE', $course);
        if ($sem != "")
            $this->db->where('tbl_enquiry.SEMESTER', $sem);
        if($search_type == 'flwup_histry' || $search_type == 'flwup_db_histry') {
            $to = ($to != "1970-01-01" && $to != "") ? $to : date('Y-m-d');
            $this->db->where("(tbl_enquiry.STATUS!='3' and tbl_enquiry.STATUS!='4')");
            if($search_type == 'flwup_db_histry')
                $this->db->where("(tbl_enquiry.NEXTFDATE <= '$to' OR tbl_enquiry.NEXTFDATE IS NULL)");
            else 
                $this->db->where("tbl_enquiry.NEXTFDATE <=", $to);
        } else {
            if ($dtype != "" && $from != "1970-01-01" && $to != "1970-01-01") {
                $this->db->where('tbl_enquiry.' . $dtype . ' >=', $from);
                $this->db->where('tbl_enquiry.' . $dtype . ' <=', $to);
            }
        }
        if ($key_words != "") {
//            $this->db->like('NAME', $key_words);
//            $this->db->or_like('PHNO', $key_words);
            $this->db->where("(NAME LIKE '%$key_words%' ESCAPE '!' OR PHNO LIKE '%$key_words%' ESCAPE '!')");
        }
        if ($sort != '')
            $this->db->order_by($sort, "desc");
        $res = $this->db->get()->row();
//        $sql = $this->db->last_query();
//        $this->db->insert('tabl_query', array('query' => $sql));
        return $res->cnt;
    }

    
    function select_college() {
        $this->db->distinct();
        $this->db->select('COLLEGE');
        $this->db->from('tbl_enquiry');
        $this->db->where('COLLEGE IS NOT NULL');
        $this->db->where("COLLEGE !=''");
        $this->db->where('DEL_FLAG', 1);
        $this->db->where('ENQUIRY_TYPE', 0);
        $res = $this->db->get();
        return $res;
    }
    
    function select_course() {
        $this->db->distinct();
        $this->db->select('COURSE');
        $this->db->from('tbl_enquiry');
        $this->db->where('COURSE IS NOT NULL');
        $this->db->where("COURSE !=''");
        $this->db->where('DEL_FLAG', 1);
        $this->db->where('ENQUIRY_TYPE', 0);
        $res = $this->db->get();
        return $res;
    }
    
    function select_sem() {
        $this->db->distinct();
        $this->db->select('SEMESTER');
        $this->db->from('tbl_enquiry');
        $this->db->where('SEMESTER IS NOT NULL');
        $this->db->where("SEMESTER !=''");
        $this->db->where('DEL_FLAG', 1);
        $this->db->where('ENQUIRY_TYPE', 0);
        $res = $this->db->get();
        return $res;
    }
    function delete_spam_messages($table, $key) {
        $this->db->like('description','porn');
        $this->db->or_like('description','???');
        $this->db->or_like('description','fuck');
        $this->db->or_like('description','sex');
        $this->db->or_like('description','zithromax');
        $this->db->or_like('description','https://google.com');
        $this->db->or_like('description','züchter');
        $this->db->or_like('description','I would like to buy ad space');
        $this->db->or_like('description','Bitcoin');
        $this->db->or_like('description','Irina');
        $this->db->or_like('description','Eric');
        $this->db->or_like('description','sending you my intimate photos');
        $this->db->where($key, 199);
        $this->db->delete($table);
    }

}

?>