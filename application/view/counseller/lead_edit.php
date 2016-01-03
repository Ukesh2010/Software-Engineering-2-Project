<form action="<?php echo URL; ?>counseller/editleadaction/<?php echo htmlspecialchars($lead->lead_id, ENT_QUOTES, 'UTF-8'); ?>" method="POST">
	First Name:<input type="text" name="first_name" value="<?php echo $lead->lead_first_name; ?>"/><br>
	Middle Name:<input type="text" name="middle_name" value="<?php echo $lead->lead_middle_name; ?>"/><br>
	Last Name:<input type="text" name="last_name" value="<?php echo $lead->lead_last_name; ?>"/><br>
	Address:<input type="text" name="address" value="<?php echo $lead->lead_address; ?>"/><br>
	Mobile No:<input type="text" name="mobile_no" value="<?php echo $lead->lead_mobile_no; ?>" /><br>
	<input  type="submit" value="Edit Lead"  />
	</form>