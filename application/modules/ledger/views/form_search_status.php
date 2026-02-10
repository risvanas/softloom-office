
      <!--<div class="col-md-2">-->
        <div class="form-group" id="h1">
          <label class="control-label"> Sub Account</label>
          <select class="form-control" name="txt_sub_account" id="txt_sub_account">
            <option value="">Select</option>
            <?php
				foreach($sub_status->result() as $res)
				{
					?>
            <option value="<?php echo $res->ACC_ID;?>"><?php echo $res->ACC_NAME;?></option>
            <?php
				}
				?>
          </select>
        </div>
      <!--</div>-->
	  <!--</div>-->