<h1>
	Leads to Follow today
</h1>

  <?php foreach ($leadlist as $lead) { ?>
<tr>
	<td><?php echo $lead->lead_first_name; ?></td>
		<td><?php echo $lead->lead_middle_name; ?></td>
			<td><?php echo $lead->lead_last_name; ?></td>
				<td><?php echo $lead->lead_address; ?></td>
					<td><?php echo $lead->lead_mobile_no; ?></td>
					<td><a href="<?php echo URL . 'counseller/editlead/' . htmlspecialchars($lead->lead_id, ENT_QUOTES, 'UTF-8'); ?>"><button>Add Followup</button></a></td>
					
	</tr>
<?php } ?>