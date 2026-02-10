<?php

class Followupmodel extends CI_Model {

    function insert_data($table, $data) {
        $this->db->insert($table, $data);
    }

    function select_data($start=0, $limit=10) {
        $this->db->select('tbl_followup.FID,tbl_followup.EN_ID,tbl_enquiry.NAME,tbl_status.status,tbl_followup.ENTRY_DATE,tbl_followup.NEXTFDATE,tbl_followup.description');
        $this->db->from('tbl_followup');
        $this->db->join('tbl_enquiry', 'tbl_enquiry.EN_ID=tbl_followup.EN_ID');
        $this->db->join('tbl_status', 'tbl_status.id=tbl_followup.STATUS');
        $this->db->where('tbl_followup.DEL_FLAG', 1);
        $currnt_date = date('Y-m-d');
        $this->db->where('tbl_followup.ENTRY_DATE >=', $currnt_date);
        $this->db->where('tbl_followup.ENTRY_DATE <=', $currnt_date);
        $this->db->limit($limit, $start);
        $res = $this->db->get();
//        $sql = $this->db->last_query();
//        $this->db->insert('tabl_query', array('query' => $sql));
        return $res;
    }

    function enquiry_data($table, $id) {
        $this->db->select('*');
        $this->db->from('tbl_followup');
        $this->db->where('FID', $id);
        $res = $this->db->get();
        return $res;
    }

    function select_en_id($table) {
        $this->db->select('EN_ID');
        $this->db->group_by('EN_ID');
        $this->db->where('DEL_FLAG', '1');
        $res = $this->db->get($table);
        return $res;
    }

    function update_data($table, $data, $id) {
        $this->db->where('FID', $id);
        $this->db->update($table, $data);
    }

    function update_enquiry_data($table, $data, $id) {
        $this->db->where('EN_ID', $id);
        $this->db->update($table, $data);
    }

    function enquiry_update($table, $data, $id) {
        $this->db->where('EN_ID', $id);
        $this->db->update($table, $data);
    }

    function fselectbyid_data($table, $id, $from_api='') {
        // $this->db->where('FID', $id);
        // $res = $this->db->get($table);
        // return $res;
        if($from_api != "") {
            $this->db->select('tbl_followup.*,tbl_enquiry.NAME,tbl_enquiry.ENTRYDATE as enq_entry_date,tbl_enquiry.LASTFDATE,tbl_enquiry.NEXTFDATE as enquiry_next_fdate');
        } else {
            $this->db->select('tbl_followup.*');
        }
        $this->db->from($table);
        if($from_api != "") {
            $this->db->join('tbl_enquiry', 'tbl_enquiry.EN_ID=tbl_followup.EN_ID');
        } 
        $this->db->where('FID', $id);
         $res = $this->db->get();
        return $res;
    }

    function fupdate_data($table, $data, $id) {
        $this->db->where('FID', $id);
        $this->db->update($table, $data);
    }

    function statustype($table, $id = '') {
        $this->db->select('*');
        $this->db->from($table);
        $this->db->where('B_FLAG', 'ENQUIRY');
        if($id != '') {
            $this->db->where('id', $id);
        }
        $res = $this->db->get();
        return $res;
    }

    function multiple_select($dtype, $stype, $sort, $from, $to, $sr, $dat, $start=0, $limit=10) {
        $this->db->select('*');
        $this->db->from('tbl_followup');
        $this->db->join('tbl_enquiry', 'tbl_enquiry.EN_ID=tbl_followup.EN_ID');
        $this->db->join('tbl_status', 'tbl_followup.STATUS=tbl_status.id');
        $this->db->where('tbl_followup.DEL_FLAG', 1);
        if ($dat != "" && $dtype != "" && $stype == "" && $sort == "" && $sr == "") {
            if ($dat != "" && $dtype != "") {
                if ($dtype == 'Nfdate') {
                    if($from != "" && $from != "1970-01-01") 
                        $this->db->where('tbl_followup.NEXTFDATE >=', $from);
                    if($to != "" && $to != "1970-01-01")
                        $this->db->where('tbl_followup.NEXTFDATE <=', $to);
                } elseif ($dtype == 'Entrydate') {
                    if($from != "" && $from != "1970-01-01")
                        $this->db->where('tbl_followup.ENTRY_DATE >=', $from);
                    if($to != "" && $to != "1970-01-01")
                        $this->db->where('tbl_followup.ENTRY_DATE <=', $to);
                }
            }
        }
        if ($dat != "" && $dtype != "" && $stype != "" && $sort == "" && $sr == "") {
            if ($dat != "" && $dtype != "" && $stype != "") {
                if ($dtype == 'Nfdate') {
                    $this->db->where('tbl_followup.NEXTFDATE >=', $from);
                    $this->db->where('tbl_followup.NEXTFDATE <=', $to);
                    $this->db->where('tbl_status.id', $stype);
                } else if ($dtype == 'Entrydate') {
                    $this->db->where('tbl_followup.ENTRY_DATE >=', $from);
                    $this->db->where('tbl_followup.ENTRY_DATE <=', $to);
                    $this->db->where('tbl_status.id', $stype);
                }
            }
        }
        if ($dat == "" && $dtype == "" && $stype != "" && $sort == "" && $sr == "") {
            $this->db->where('tbl_status.id', $stype);
        }
        if ($dat == "" && $dtype != "" && $stype != "" && $sort == "" && $sr == "") {
            $this->db->where('tbl_status.id', $stype);
        }
        if ($dat == "" && $dtype == "" && $stype == "" && $sort != "" && $sr == "") {
            if ($sort == 'Name') {
                $this->db->order_by('tbl_followup.NAME');
            }
        }
        if ($dat == "" && $dtype != "" && $stype == "" && $sort != "" && $sr == "") {
            if ($sort == 'Date' && $dtype == 'Nfdate') {
                $this->db->order_by('tbl_followup.NEXTFDATE');
            }
            if ($sort == 'Date' && $dtype == 'Entrydate') {
                $this->db->order_by('tbl_followup.ENTRY_DATE');
            }
        }
        if ($dat == "" && $dtype != "" && $stype != "" && $sort != "" && $sr == "") {
            if ($sort == 'Date' && $dtype == 'Nfdate' && $stype != "") {
                $this->db->order_by('tbl_followup.NEXTFDATE');
                $this->db->where('tbl_status.id', $stype);
            }
            if ($sort == 'Date' && $dtype == 'Entrydate' && $stype != "") {
                $this->db->order_by('tbl_followup.ENTRY_DATE');
                $this->db->where('tbl_status.id', $stype);
            }
            if ($sort == 'Name' && $stype != "") {
                $this->db->order_by('tbl_enquiry.NAME');
                $this->db->where('tbl_status.id', $stype);
            }
        }
        if ($dat != "" && $dtype != "" && $stype == "" && $sort != "" && $sr != "") {

            if ($sort == 'Date' && $dtype == 'Nfdate') {
                $this->db->order_by('tbl_followup.NEXTFDATE');
            }
            if ($sort == 'Date' && $dtype == 'Entrydate' && $stype != "") {
                $this->db->order_by('tbl_followup.ENTRY_DATE');
            }
            if ($sort == 'Name' && $stype != "") {
                $this->db->order_by('tbl_enquiry.NAME');
            }
        }
        if ($dat != "" && $dtype != "" && $stype != "" && $sort != "" && $sr == "") {
            $this->db->where('tbl_status.id', $stype);
        }
        if ($dat != "" && $dtype != "" && $stype == "" && $sort != "" && $sr == "") {
            if ($dtype == 'Nfdate' && $sort == 'Date') {
                $this->db->where('tbl_followup.NEXTFDATE >=', $from);
                $this->db->where('tbl_followup.NEXTFDATE <=', $to);
                $this->db->order_by('tbl_followup.NEXTFDATE');
            } elseif ($dtype == 'Entrydate' && $sort == 'Date') {
                $this->db->where('tbl_followup.ENTRY_DATE >=', $from);
                $this->db->where('tbl_followup.ENTRY_DATE <=', $to);
                $this->db->order_by('tbl_followup.ENTRY_DATE');
            } elseif ($dtype == 'Nfdate' && $sort == 'Name') {
                $this->db->where('tbl_followup.NEXTFDATE >=', $from);
                $this->db->where('tbl_followup.NEXTFDATE <=', $to);
                $this->db->order_by('tbl_enquiry.NAME');
            } elseif ($dtype == 'Entrydate' && $sort == 'Name') {
                $this->db->where('tbl_followup.ENTRY_DATE >=', $from);
                $this->db->where('tbl_followup.ENTRY_DATE <=', $to);
                $this->db->order_by('tbl_enquiry.NAME');
            }
        }
        if ($dat != "" && $dtype != "" && $stype != "" && $sort != "" && $sr == "") {
            if ($dtype == 'Nfdate' && $sort == 'Date' && $stype != "") {
                $this->db->where('tbl_followup.NEXTFDATE >=', $from);
                $this->db->where('tbl_followup.NEXTFDATE <=', $to);
                $this->db->order_by('tbl_followup.NEXTFDATE');
                $this->db->where('tbl_status.id', $stype);
            } elseif ($dtype == 'Entrydate' && $sort == 'Date') {
                $this->db->where('tbl_followup.ENTRY_DATE >=', $from);
                $this->db->where('tbl_followup.ENTRY_DATE <=', $to);
                $this->db->order_by('tbl_followup.ENTRY_DATE');
                $this->db->where('tbl_status.id', $stype);
            } elseif ($dtype == 'Nfdate' && $sort == 'Name') {
                $this->db->where('tbl_followup.NEXTFDATE >=', $from);
                $this->db->where('tbl_followup.NEXTFDATE <=', $to);
                $this->db->order_by('tbl_enquiry.NAME');
                $this->db->where('tbl_status.id', $stype);
            } elseif ($dtype == 'Entrydate' && $sort == 'Name') {
                $this->db->where('tbl_followup.ENTRY_DATE >=', $from);
                $this->db->where('tbl_followup.ENTRY_DATE <=', $to);
                $this->db->order_by('tbl_enquiry.NAME');
                $this->db->where('tbl_status.id', $stype);
            }
        }
        if ($dat == "" && $dtype == "" && $stype == "" && $sort == "" && $sr != "") {
            $this->db->like('tbl_enquiry.NAME', $sr);
        }
        if ($dat != "" && $dtype != "" && $stype == "" && $sort == "" && $sr != "") {
            if ($dat != "" && $dtype != "" && $sr != "") {
                if ($dtype == 'Nfdate') {
                    $this->db->where('tbl_followup.NEXTFDATE >=', $from);
                    $this->db->where('tbl_followup.NEXTFDATE <=', $to);
                    $this->db->order_by('tbl_followup.NEXTFDATE');
                    $this->db->like('tbl_enquiry.NAME', $sr);
                } elseif ($dtype == 'Entrydate') {
                    $this->db->where('tbl_followup.ENTRY_DATE >=', $from);
                    $this->db->where('tbl_followup.ENTRY_DATE <=', $to);
                    $this->db->order_by('tbl_followup.ENTRY_DATE');
                    $this->db->like('tbl_enquiry.NAME', $sr);
                }
            }
        }

        if ($dat == "" && $dtype == "" && $stype != "" && $sort == "" && $sr != "") {
            if ($stype != "" && $sr != "") {
                $this->db->like('tbl_enquiry.NAME', $sr);
                $this->db->where('tbl_status.id', $stype);
            }
        }

        if ($dat != "" && $dtype != "" && $stype != "" && $sort == "" && $sr != "") {
            if ($dat != "" && $dtype != "" && $stype != "" && $sr != "") {

                if ($dtype == 'Nfdate') {
                    $this->db->where('tbl_followup.NEXTFDATE >=', $from);
                    $this->db->where('tbl_followup.NEXTFDATE <=', $to);
                    $this->db->order_by('tbl_followup.NEXTFDATE');
                    $this->db->like('tbl_enquiry.NAME', $sr);
                    $this->db->where('tbl_status.id', $stype);
                } elseif ($dtype == 'Entrydate') {
                    $this->db->where('tbl_followup.ENTRY_DATE >=', $from);
                    $this->db->where('tbl_followup.ENTRY_DATE <=', $to);
                    $this->db->order_by('tbl_followup.ENTRY_DATE');
                    $this->db->like('tbl_enquiry.NAME', $sr);
                    $this->db->where('tbl_status.id', $stype);
                }
            }
        }
        if ($dat == "" && $dtype == "" && $stype == "" && $sort != "" && $sr != "") {
            if ($sort == 'Name') {
                $this->db->order_by('tbl_enquiry.NAME');
                $this->db->like('tbl_enquiry.NAME', $sr);
            }
        }
        if ($dat == "" && $dtype == "" && $stype != "" && $sort != "" && $sr != "") {
            if ($stype != "" && $sort != "" && $sr != "") {
                if ($sort == 'Name') {
                    $this->db->order_by('tbl_enquiry.NAME');
                    $this->db->like('tbl_enquiry.NAME', $sr);
                    $this->db->where('tbl_status.id', $stype);
                }
            }
        }
        if ($dat != "" && $dtype != "" && $stype == "" && $sort == "" && $sr != "") {
            if ($dat != "" && $dtype != "" && $sr != "") {
                if ($dtype == 'Nfdate') {
                    $this->db->where('tbl_followup.NEXTFDATE >=', $from);
                    $this->db->where('tbl_followup.NEXTFDATE <=', $to);
                    $this->db->like('tbl_enquiry.NAME', $sr);
                } elseif ($dtype == 'Entrydate') {
                    $this->db->where('tbl_followup.ENTRY_DATE >=', $from);
                    $this->db->where('tbl_followup.ENTRY_DATE <=', $to);
                    $this->db->like('tbl_enquiry.NAME', $sr);
                }
            }
        }

        if ($dat != "" && $dtype != "" && $stype == "" && $sort != "" && $sr != "") {
            if ($dat != "" && $dtype != "" && $sort != "" && $sr != "") {
                if ($dtype == 'Nfdate' && $sort == 'Name') {
                    $this->db->where('tbl_followup.NEXTFDATE >=', $from);
                    $this->db->where('tbl_followup.NEXTFDATE <=', $to);
                    $this->db->like('tbl_enquiry.NAME', $sr);
                    $this->db->order_by('tbl_enquiry.NAME');
                } elseif ($dtype == 'Entrydate' && $sort == 'Name') {
                    $this->db->where('tbl_followup.ENTRY_DATE >=', $from);
                    $this->db->where('tbl_followup.ENTRY_DATE <=', $to);
                    $this->db->like('tbl_enquiry.NAME', $sr);
                    $this->db->order_by('tbl_enquiry.NAME');
                } else if ($dtype == 'Nfdate' && $sort == 'Date') {
                    $this->db->where('tbl_followup.NEXTFDATE >=', $from);
                    $this->db->where('tbl_followup.NEXTFDATE <=', $to);
                    $this->db->like('tbl_enquiry.NAME', $sr);
                    $this->db->order_by('tbl_followup.NEXTFDATE');
                } elseif ($dtype == 'Entrydate' && $sort == 'Name') {
                    $this->db->where('tbl_followup.ENTRY_DATE >=', $from);
                    $this->db->where('tbl_followup.ENTRY_DATE <=', $to);
                    $this->db->like('tbl_enquiry.NAME', $sr);
                    $this->db->order_by('tbl_followup.ENTRY_DATE');
                }
            }
        }
        if ($dat != "" && $dtype != "" && $stype != "" && $sort != "" && $sr != "") {
            if ($dtype == 'Nfdate' && $sort == 'Name') {
                $this->db->where('tbl_followup.NEXTFDATE >=', $from);
                $this->db->where('tbl_followup.NEXTFDATE <=', $to);
                $this->db->like('tbl_enquiry.NAME', $sr);
                $this->db->where('tbl_status.id', $stype);
                $this->db->order_by('tbl_enquiry.NAME');
            } else if ($dtype == 'Entrydate' && $sort == 'Name') {
                $this->db->where('tbl_followup.ENTRY_DATE >=', $from);
                $this->db->where('tbl_followup.ENTRY_DATE <=', $to);
                $this->db->like('tbl_enquiry.NAME', $sr);
                $this->db->where('tbl_status.id', $stype);
                $this->db->order_by('tbl_enquiry.NAME');
            } else if ($dtype == 'Nfdate' && $sort == 'Date') {
                $this->db->where('tbl_followup.NEXTFDATE >=', $from);
                $this->db->where('tbl_followup.NEXTFDATE <=', $to);
                $this->db->like('tbl_enquiry.NAME', $sr);
                $this->db->where('tbl_status.id', $stype);
                $this->db->order_by('tbl_followup.NEXTFDATE');
            } else if ($dtype == 'Entrydate' && $sort == 'Date') {
                $this->db->where('tbl_followup.ENTRY_DATE >=', $from);
                $this->db->where('tbl_followup.ENTRY_DATE <=', $to);
                $this->db->like('tbl_enquiry.NAME', $sr);
                $this->db->where('tbl_status.id', $stype);
                $this->db->order_by('tbl_followup.ENTRY_DATE');
            }
        }
        $this->db->limit($limit, $start);
        $res = $this->db->get();
//        $sql = $this->db->last_query();
//        $this->db->insert('tabl_query', array('query' => $sql));
        return $res;
    }
    
    function followup_count($from="", $to="", $dtype="", $stype="", $sort="", $sr="", $dat="") {
        $this->db->select('count(*) as cnt');
        $this->db->from('tbl_followup');
        $this->db->join('tbl_enquiry', 'tbl_enquiry.EN_ID=tbl_followup.EN_ID');
        $this->db->join('tbl_status', 'tbl_followup.STATUS=tbl_status.id');
        $this->db->where('tbl_followup.DEL_FLAG', 1);
        if ($dat == "" && $dtype != "" && $stype == "" && $sort == "" && $sr == "") {
            if ($dtype == 'Nfdate') {
                if($from != "" && $from != "1970-01-01") 
                    $this->db->where('tbl_followup.NEXTFDATE >=', $from);
                if($to != "" && $to != "1970-01-01")
                    $this->db->where('tbl_followup.NEXTFDATE <=', $to);
            } elseif ($dtype == 'Entrydate') {
                if($from != "" && $from != "1970-01-01")
                    $this->db->where('tbl_followup.ENTRY_DATE >=', $from);
                if($to != "" && $to != "1970-01-01")
                    $this->db->where('tbl_followup.ENTRY_DATE <=', $to);
            }
        }
        if ($dat != "" && $dtype != "" && $stype == "" && $sort == "" && $sr == "") {
            if ($dat != "" && $dtype != "") {
                if ($dtype == 'Nfdate') {
                    if($from != "" && $from != "1970-01-01") 
                        $this->db->where('tbl_followup.NEXTFDATE >=', $from);
                    if($to != "" && $to != "1970-01-01")
                        $this->db->where('tbl_followup.NEXTFDATE <=', $to);
                } elseif ($dtype == 'Entrydate') {
                    if($from != "" && $from != "1970-01-01")
                        $this->db->where('tbl_followup.ENTRY_DATE >=', $from);
                    if($to != "" && $to != "1970-01-01")
                        $this->db->where('tbl_followup.ENTRY_DATE <=', $to);
                }
            }
        }
        if ($dat != "" && $dtype != "" && $stype != "" && $sort == "" && $sr == "") {
            if ($dat != "" && $dtype != "" && $stype != "") {
                if ($dtype == 'Nfdate') {
                    $this->db->where('tbl_followup.NEXTFDATE >=', $from);
                    $this->db->where('tbl_followup.NEXTFDATE <=', $to);
                    $this->db->where('tbl_status.id', $stype);
                } else if ($dtype == 'Entrydate') {
                    $this->db->where('tbl_followup.ENTRY_DATE >=', $from);
                    $this->db->where('tbl_followup.ENTRY_DATE <=', $to);
                    $this->db->where('tbl_status.id', $stype);
                }
            }
        }
        if ($dat == "" && $dtype == "" && $stype != "" && $sort == "" && $sr == "") {
            $this->db->where('tbl_status.id', $stype);
        }
        if ($dat == "" && $dtype != "" && $stype != "" && $sort == "" && $sr == "") {
            $this->db->where('tbl_status.id', $stype);
        }
        if ($dat == "" && $dtype == "" && $stype == "" && $sort != "" && $sr == "") {
            if ($sort == 'Name') {
                $this->db->order_by('tbl_followup.NAME');
            }
        }
        if ($dat == "" && $dtype != "" && $stype == "" && $sort != "" && $sr == "") {
            if ($sort == 'Date' && $dtype == 'Nfdate') {
                $this->db->order_by('tbl_followup.NEXTFDATE');
            }
            if ($sort == 'Date' && $dtype == 'Entrydate') {
                $this->db->order_by('tbl_followup.ENTRY_DATE');
            }
        }
        if ($dat == "" && $dtype != "" && $stype != "" && $sort != "" && $sr == "") {
            if ($sort == 'Date' && $dtype == 'Nfdate' && $stype != "") {
                $this->db->order_by('tbl_followup.NEXTFDATE');
                $this->db->where('tbl_status.id', $stype);
            }
            if ($sort == 'Date' && $dtype == 'Entrydate' && $stype != "") {
                $this->db->order_by('tbl_followup.ENTRY_DATE');
                $this->db->where('tbl_status.id', $stype);
            }
            if ($sort == 'Name' && $stype != "") {
                $this->db->order_by('tbl_enquiry.NAME');
                $this->db->where('tbl_status.id', $stype);
            }
        }
        if ($dat != "" && $dtype != "" && $stype == "" && $sort != "" && $sr != "") {

            if ($sort == 'Date' && $dtype == 'Nfdate') {
                $this->db->order_by('tbl_followup.NEXTFDATE');
            }
            if ($sort == 'Date' && $dtype == 'Entrydate' && $stype != "") {
                $this->db->order_by('tbl_followup.ENTRY_DATE');
            }
            if ($sort == 'Name' && $stype != "") {
                $this->db->order_by('tbl_enquiry.NAME');
            }
        }
        if ($dat != "" && $dtype != "" && $stype != "" && $sort != "" && $sr == "") {
            $this->db->where('tbl_status.id', $stype);
        }
        if ($dat != "" && $dtype != "" && $stype == "" && $sort != "" && $sr == "") {
            if ($dtype == 'Nfdate' && $sort == 'Date') {
                $this->db->where('tbl_followup.NEXTFDATE >=', $from);
                $this->db->where('tbl_followup.NEXTFDATE <=', $to);
                $this->db->order_by('tbl_followup.NEXTFDATE');
            } elseif ($dtype == 'Entrydate' && $sort == 'Date') {
                $this->db->where('tbl_followup.ENTRY_DATE >=', $from);
                $this->db->where('tbl_followup.ENTRY_DATE <=', $to);
                $this->db->order_by('tbl_followup.ENTRY_DATE');
            } elseif ($dtype == 'Nfdate' && $sort == 'Name') {
                $this->db->where('tbl_followup.NEXTFDATE >=', $from);
                $this->db->where('tbl_followup.NEXTFDATE <=', $to);
                $this->db->order_by('tbl_enquiry.NAME');
            } elseif ($dtype == 'Entrydate' && $sort == 'Name') {
                $this->db->where('tbl_followup.ENTRY_DATE >=', $from);
                $this->db->where('tbl_followup.ENTRY_DATE <=', $to);
                $this->db->order_by('tbl_enquiry.NAME');
            }
        }
        if ($dat != "" && $dtype != "" && $stype != "" && $sort != "" && $sr == "") {
            if ($dtype == 'Nfdate' && $sort == 'Date' && $stype != "") {
                $this->db->where('tbl_followup.NEXTFDATE >=', $from);
                $this->db->where('tbl_followup.NEXTFDATE <=', $to);
                $this->db->order_by('tbl_followup.NEXTFDATE');
                $this->db->where('tbl_status.id', $stype);
            } elseif ($dtype == 'Entrydate' && $sort == 'Date') {
                $this->db->where('tbl_followup.ENTRY_DATE >=', $from);
                $this->db->where('tbl_followup.ENTRY_DATE <=', $to);
                $this->db->order_by('tbl_followup.ENTRY_DATE');
                $this->db->where('tbl_status.id', $stype);
            } elseif ($dtype == 'Nfdate' && $sort == 'Name') {
                $this->db->where('tbl_followup.NEXTFDATE >=', $from);
                $this->db->where('tbl_followup.NEXTFDATE <=', $to);
                $this->db->order_by('tbl_enquiry.NAME');
                $this->db->where('tbl_status.id', $stype);
            } elseif ($dtype == 'Entrydate' && $sort == 'Name') {
                $this->db->where('tbl_followup.ENTRY_DATE >=', $from);
                $this->db->where('tbl_followup.ENTRY_DATE <=', $to);
                $this->db->order_by('tbl_enquiry.NAME');
                $this->db->where('tbl_status.id', $stype);
            }
        }
        if ($dat == "" && $dtype == "" && $stype == "" && $sort == "" && $sr != "") {
            $this->db->like('tbl_enquiry.NAME', $sr);
        }
        if ($dat != "" && $dtype != "" && $stype == "" && $sort == "" && $sr != "") {
            if ($dat != "" && $dtype != "" && $sr != "") {
                if ($dtype == 'Nfdate') {
                    $this->db->where('tbl_followup.NEXTFDATE >=', $from);
                    $this->db->where('tbl_followup.NEXTFDATE <=', $to);
                    $this->db->order_by('tbl_followup.NEXTFDATE');
                    $this->db->like('tbl_enquiry.NAME', $sr);
                } elseif ($dtype == 'Entrydate') {
                    $this->db->where('tbl_followup.ENTRY_DATE >=', $from);
                    $this->db->where('tbl_followup.ENTRY_DATE <=', $to);
                    $this->db->order_by('tbl_followup.ENTRY_DATE');
                    $this->db->like('tbl_enquiry.NAME', $sr);
                }
            }
        }

        if ($dat == "" && $dtype == "" && $stype != "" && $sort == "" && $sr != "") {
            if ($stype != "" && $sr != "") {
                $this->db->like('tbl_enquiry.NAME', $sr);
                $this->db->where('tbl_status.id', $stype);
            }
        }

        if ($dat != "" && $dtype != "" && $stype != "" && $sort == "" && $sr != "") {
            if ($dat != "" && $dtype != "" && $stype != "" && $sr != "") {

                if ($dtype == 'Nfdate') {
                    $this->db->where('tbl_followup.NEXTFDATE >=', $from);
                    $this->db->where('tbl_followup.NEXTFDATE <=', $to);
                    $this->db->order_by('tbl_followup.NEXTFDATE');
                    $this->db->like('tbl_enquiry.NAME', $sr);
                    $this->db->where('tbl_status.id', $stype);
                } elseif ($dtype == 'Entrydate') {
                    $this->db->where('tbl_followup.ENTRY_DATE >=', $from);
                    $this->db->where('tbl_followup.ENTRY_DATE <=', $to);
                    $this->db->order_by('tbl_followup.ENTRY_DATE');
                    $this->db->like('tbl_enquiry.NAME', $sr);
                    $this->db->where('tbl_status.id', $stype);
                }
            }
        }
        if ($dat == "" && $dtype == "" && $stype == "" && $sort != "" && $sr != "") {
            if ($sort == 'Name') {
                $this->db->order_by('tbl_enquiry.NAME');
                $this->db->like('tbl_enquiry.NAME', $sr);
            }
        }
        if ($dat == "" && $dtype == "" && $stype != "" && $sort != "" && $sr != "") {
            if ($stype != "" && $sort != "" && $sr != "") {
                if ($sort == 'Name') {
                    $this->db->order_by('tbl_enquiry.NAME');
                    $this->db->like('tbl_enquiry.NAME', $sr);
                    $this->db->where('tbl_status.id', $stype);
                }
            }
        }
        if ($dat != "" && $dtype != "" && $stype == "" && $sort == "" && $sr != "") {
            if ($dat != "" && $dtype != "" && $sr != "") {
                if ($dtype == 'Nfdate') {
                    $this->db->where('tbl_followup.NEXTFDATE >=', $from);
                    $this->db->where('tbl_followup.NEXTFDATE <=', $to);
                    $this->db->like('tbl_enquiry.NAME', $sr);
                } elseif ($dtype == 'Entrydate') {
                    $this->db->where('tbl_followup.ENTRY_DATE >=', $from);
                    $this->db->where('tbl_followup.ENTRY_DATE <=', $to);
                    $this->db->like('tbl_enquiry.NAME', $sr);
                }
            }
        }

        if ($dat != "" && $dtype != "" && $stype == "" && $sort != "" && $sr != "") {
            if ($dat != "" && $dtype != "" && $sort != "" && $sr != "") {
                if ($dtype == 'Nfdate' && $sort == 'Name') {
                    $this->db->where('tbl_followup.NEXTFDATE >=', $from);
                    $this->db->where('tbl_followup.NEXTFDATE <=', $to);
                    $this->db->like('tbl_enquiry.NAME', $sr);
                    $this->db->order_by('tbl_enquiry.NAME');
                } elseif ($dtype == 'Entrydate' && $sort == 'Name') {
                    $this->db->where('tbl_followup.ENTRY_DATE >=', $from);
                    $this->db->where('tbl_followup.ENTRY_DATE <=', $to);
                    $this->db->like('tbl_enquiry.NAME', $sr);
                    $this->db->order_by('tbl_enquiry.NAME');
                } else if ($dtype == 'Nfdate' && $sort == 'Date') {
                    $this->db->where('tbl_followup.NEXTFDATE >=', $from);
                    $this->db->where('tbl_followup.NEXTFDATE <=', $to);
                    $this->db->like('tbl_enquiry.NAME', $sr);
                    $this->db->order_by('tbl_followup.NEXTFDATE');
                } elseif ($dtype == 'Entrydate' && $sort == 'Name') {
                    $this->db->where('tbl_followup.ENTRY_DATE >=', $from);
                    $this->db->where('tbl_followup.ENTRY_DATE <=', $to);
                    $this->db->like('tbl_enquiry.NAME', $sr);
                    $this->db->order_by('tbl_followup.ENTRY_DATE');
                }
            }
        }
        if ($dat != "" && $dtype != "" && $stype != "" && $sort != "" && $sr != "") {
            if ($dtype == 'Nfdate' && $sort == 'Name') {
                $this->db->where('tbl_followup.NEXTFDATE >=', $from);
                $this->db->where('tbl_followup.NEXTFDATE <=', $to);
                $this->db->like('tbl_enquiry.NAME', $sr);
                $this->db->where('tbl_status.id', $stype);
                $this->db->order_by('tbl_enquiry.NAME');
            } else if ($dtype == 'Entrydate' && $sort == 'Name') {
                $this->db->where('tbl_followup.ENTRY_DATE >=', $from);
                $this->db->where('tbl_followup.ENTRY_DATE <=', $to);
                $this->db->like('tbl_enquiry.NAME', $sr);
                $this->db->where('tbl_status.id', $stype);
                $this->db->order_by('tbl_enquiry.NAME');
            } else if ($dtype == 'Nfdate' && $sort == 'Date') {
                $this->db->where('tbl_followup.NEXTFDATE >=', $from);
                $this->db->where('tbl_followup.NEXTFDATE <=', $to);
                $this->db->like('tbl_enquiry.NAME', $sr);
                $this->db->where('tbl_status.id', $stype);
                $this->db->order_by('tbl_followup.NEXTFDATE');
            } else if ($dtype == 'Entrydate' && $sort == 'Date') {
                $this->db->where('tbl_followup.ENTRY_DATE >=', $from);
                $this->db->where('tbl_followup.ENTRY_DATE <=', $to);
                $this->db->like('tbl_enquiry.NAME', $sr);
                $this->db->where('tbl_status.id', $stype);
                $this->db->order_by('tbl_followup.ENTRY_DATE');
            }
        }
        
         $res = $this->db->get()->row();
//        $sql = $this->db->last_query();
//        $this->db->insert('tabl_query', array('query' => $sql));
        return $res->cnt;
    }

}

?>