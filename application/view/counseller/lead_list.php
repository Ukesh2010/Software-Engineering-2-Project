  <?php foreach ($leadlist as $lead) { ?>
<tr>
	<td><?php echo $lead->lead_first_name; ?></td>
		<td><?php echo $lead->lead_middle_name; ?></td>
			<td><?php echo $lead->lead_last_name; ?></td>
				<td><?php echo $lead->lead_address; ?></td>
					<td><?php echo $lead->lead_mobile_no; ?></td>
</tr>
<?php } ?>