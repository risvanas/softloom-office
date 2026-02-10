<ul class="main-navigation-menu">
    <?php
    $sql = "select * from tbl_menu where P_MENU_ID='' and SOURCE='active' and DEL_FLAG=1";
    $query = $this->db->query($sql);
    $sess_array = $this->session->userdata('logged_in');
    $user_type = $sess_array['user_type'];
    foreach ($query->result() as $row) {
        if ($row->SUB_MENU == 'Dashboard') {
            ?>

            <li class="active open"> <a href="<?php echo site_url($row->URL); ?>"><i class="<?php echo $row->ICON; ?>"></i> <span class="title"> <?php echo $row->SUB_MENU; ?> </span><span class="selected"></span> </a> </li>
            <?php
        } else {
            if ($row->SUB_MENU == 'Backup' && $user_type == 'ADMIN') {
                ?>
                <li> <a href="javascript:void(0)"><i class="<?php echo $row->ICON; ?>"></i> <span class="title"> <?php echo $row->SUB_MENU; ?> </span><i class="icon-arrow"></i> <span class="selected"></span> </a>
                    <ul class="sub-menu">
                        <?php
                        $sql1 = "select * from tbl_menu where P_MENU_ID=$row->MENU_ID and SOURCE='active' and DEL_FLAG=1";
                        $query1 = $this->db->query($sql1);

                        foreach ($query1->result() as $row1) {
                            if ($row1->URL == 'menu_permition' && $user_type == 'ADMIN') {
                                ?>
                                <li> <a href="<?php echo site_url($row1->URL); ?>"> <span class="title"> <?php echo $row1->SUB_MENU; ?> </span> </a> </li>
                                <?php
                            }
                            if ($row1->URL != 'menu_permition') {
                                ?>
                                <li> <a href="<?php echo site_url($row1->URL); ?>"> <span class="title"> <?php echo $row1->SUB_MENU; ?> </span> </a> </li>
                                <?php
                            }
                        }
                        ?>
                    </ul>
                </li>
                <?php
            }
            if ($row->SUB_MENU != 'Backup') {
                ?>
                <li> <a href="javascript:void(0)"><i class="<?php echo $row->ICON; ?>"></i> <span class="title"> <?php echo $row->SUB_MENU; ?> </span><i class="icon-arrow"></i> <span class="selected"></span> </a>
                    <ul class="sub-menu">
                        <?php
                        $sql1 = "select * from tbl_menu where P_MENU_ID=$row->MENU_ID and SOURCE='active' and DEL_FLAG=1";
                        $query1 = $this->db->query($sql1);

                        foreach ($query1->result() as $row1) {
                            if ($row1->URL == 'menu_permition' && $user_type == 'ADMIN') {
                                ?>
                                <li> <a href="<?php echo site_url($row1->URL); ?>"> <span class="title"> <?php echo $row1->SUB_MENU; ?> </span> </a> </li>
                                <?php
                            }
                            if ($row1->URL != 'menu_permition') {
                                ?>
                                <li> <a href="<?php echo site_url($row1->URL); ?>"> <span class="title"> <?php echo $row1->SUB_MENU; ?> </span> </a> </li>
                                    <?php
                                }
                            }
                            ?>
                    </ul>
                </li>
                <?php
            }
        }
    }
    ?>
</ul>