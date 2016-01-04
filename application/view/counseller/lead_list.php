<table>
	<thead>
		<th>
			First Name
			</th>
			<th>
				Middle Name
			</th>
			<th>
				Last Name
			</th>
			<th>
				Address
			</th>
			<th>
				Mobile No
			</th>
			<th>
				Action
			</th>
		<thead>
			<tbody>
  <?php foreach ($leadlist as $lead) { ?>
<tr>
	<td><?php echo $lead->lead_first_name; ?></td>
		<td><?php echo $lead->lead_middle_name; ?></td>
			<td><?php echo $lead->lead_last_name; ?></td>
				<td><?php echo $lead->lead_address; ?></td>
					<td><?php echo $lead->lead_mobile_no; ?></td>
					<td><a href="<?php echo URL . 'counseller/editlead/' . htmlspecialchars($lead->lead_id, ENT_QUOTES, 'UTF-8'); ?>"><button>Edit</button></a></td>
					<td><?php if(is_null($lead->next_followup_date) || empty($lead->next_followup_date) || !isset($lead->next_followup_date)){ ?>
						<form method="post" action="<?php echo URL; ?>counseller/addfollowupaction/<?php echo htmlspecialchars($lead->lead_id, ENT_QUOTES, 'UTF-8'); ?>">
							<input type="date" name="followup_date" /> <input type="submit" value="Set Followup" />
						</form>
				<?php	}else if(strtotime($lead->next_followup_date)>strtotime(date("Y/m/d"))){?>
					<label> <?php echo $lead->next_followup_date; ?></label>
				<?php}else{ ?>
				<!--<input type="date" name="followup_date" /> <input type="submit" value="Set Followup" />-->
			<?php	} ?></td>
	</tr>
<?php } ?>

</tbody>
</table>