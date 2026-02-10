
      <div class="footer clearfix">
			<div class="footer-inner">
				2013 &copy; clip-one by cliptheme.
			</div>
			<div class="footer-items">
				<span class="go-top"><i class="clip-chevron-up"></i></span>
			</div>
		</div>
        
        
        <script>
		$("#items").on('click', '.delete', function () {
			var rowCount = $('#items tr').length;
			if (rowCount == 8){
				$(".delete").hide();	
			}
			if(rowCount != 7)
			{
				$(this).closest('tr').remove();
    			update_total();
			}
			else
			{
				$(".delete").hide();	
				alert(rowCount);
			}
		});
		</script>