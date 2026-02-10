<?php

class Pagination extends MX_Controller {

    function __construct() {
        parent::__construct();
//        $this->load->helper('date');
//        $this->load->helper(array('form', 'template'));
//        $this->template->set_template('admin_template');
//        $this->load->library('form_validation');
//        $this->load->library('user_agent');
    }

    function create_pagination($item_per_page, $current_page, $total_records, $total_pages) {
        $pagination = '';
        if ($total_pages > 0 && $total_pages != 1 && $current_page <= $total_pages) { //verify total pages and current page number
            $pagination .= '<div class="col-md-6">
                <div style="display: inline-block;padding-left: 0;margin: 20px 0;border-radius: 4px;">
                        Item per page
                            <select style="padding: 5px;" id="item_per_page" name="item_per_page" onchange="search_data(event,this.options[this.selectedIndex].value,1)">
                                <option value="10"';
            if ($item_per_page == 10) {
                $pagination .= ' selected';
            }
            $pagination .= '>10</option>
                                <option value="25"';
            if ($item_per_page == 25) {
                $pagination .= ' selected';
            }
            $pagination .= '>25</option>
                                <option value="50"';
            if ($item_per_page == 50) {
                $pagination .= ' selected';
            }
            $pagination .= '>50</option>
                                <option value="100"';
            if ($item_per_page == 100) {
                $pagination .= ' selected';
            }
            $pagination .= '>100</option>
                            </select>
                            </div>
                        </div>
                        <div class="col-md-6">
                        <div class="dataTables_paginate paging_bootstrap"><ul class="pagination">';

            $right_links = $current_page + 3;
            $previous = $current_page - 3; //previous link
            $next = $current_page + 1; //next link
            $first_link = true; //boolean var to decide our first link

            if ($current_page > 1) {
                $previous_link = $current_page - 1;
                $pagination .= '<li class="first"><a href="#" onclick="search_data(event,' . $item_per_page . ',1)" title="First">&laquo;</a></li>'; //first link
                $pagination .= '<li><a href="#" onclick="search_data(event,' . $item_per_page . ',' . $previous_link . ')" title="Previous">&lt;</a></li>'; //previous link
                for ($i = ($current_page - 2); $i < $current_page; $i++) { //Create left-hand side links
                    if ($i > 0) {
                        $pagination .= '<li><a href="#" onclick="search_data(event,' . $item_per_page . ',' . $i . ')">' . $i . '</a></li>';
                    }
                }
                $first_link = false; //set first link to false
            }

            if ($first_link) { //if current active page is first link
                $pagination .= '<li class="active"><a>' . $current_page . '</a></li>';
            } elseif ($current_page == $total_pages) { //if it's the last active link
                $pagination .= '<li class="active"><a>' . $current_page . '</a></li>';
            } else { //regular current link
                $pagination .= '<li class="active"><a>' . $current_page . '</a></li>';
            }

            for ($i = $current_page + 1; $i < $right_links; $i++) { //create right-hand side links
                if ($i <= $total_pages) {
                    $pagination .= '<li><a href="#" onclick="search_data(event,' . $item_per_page . ',' . $i . ')">' . $i . '</a></li>';
                }
            }
            if ($current_page < $total_pages) {
                $next_link = $current_page + 1;
                $pagination .= '<li><a href="#" onclick="search_data(event,' . $item_per_page . ',' . $next_link . ')" >&gt;</a></li>'; //next link
                $pagination .= '<li class="last"><a href="#" onclick="search_data(event,' . $item_per_page . ',' . $total_pages . ')" title="Last">&raquo;</a></li>'; //last link
            }

            $pagination .= '</ul></div></div>';
        }
        return $pagination; //return pagination links
    }
}

?>