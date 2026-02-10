<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
        <title>trial balance</title>
    </head>

    <body>
        <form action="" method="post">
            <p>select date</p>
            <span class="input-icon input-icon-right">
                <input autocomplete="off" type="text" data-date-format="dd-mm-yyyy" data-date-viewmode="years" class="form-control date-picker" name="date" id=			"date"   />
                <i class="icon-calendar"></i> </span>
            <input type="button" value="Get P&L" onclick="disp_table()">

        </form>
        <div id="table">
        </div>
    </body>
</html>
<script>

    jQuery(document).ready(function () {
        Main.init();
        FormElements.init();

    });



</script>
<script>
    function disp_table()
    {
        $.ajax({
            type: "POST",
            data: {date: $('#date').val()},
            url: "<?php echo site_url('profit_and_loss/calculation') ?>",
            success: function (data)
            {
                $('#table').html(data);
            }
        });

    }

</script>
