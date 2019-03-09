
<?php echo $this->BcForm->create('Pmtotal') ?>
<?php echo $this->BcForm->input('Pmtotal.id', array('type' => 'hidden')) ?>
<div class="section">
	<table cellpadding="0" cellspacing="0" class="form-table">
		<tr>
			<th class="col-head" width="150">Pmtotal</th>
			<td class="col-input">
				id : <?php echo $this->request->data['Pmtotal']['id'] ?><br>
				mypage_id : <?php echo $this->request->data['Pmtotal']['mypage_id'] ?><br>
				pmpage_id : <?php echo $this->request->data['Pmtotal']['pmpage_id'] ?><br>
				締め日 : <?php echo $this->request->data['Pmtotal']['yyyymm'] ?><br>
				請求額 : <?php echo $this->request->data['Pmtotal']['total'] ?><br>
				status : <?php echo $this->request->data['Pmtotal']['status'] ?><br>
				mail_submit : <?php echo $this->request->data['Pmtotal']['mail_submit'] ?><br>
				invoice_submit : <?php echo $this->request->data['Pmtotal']['invoice_submit'] ?><br>
				payment_date : <?php echo $this->request->data['Pmtotal']['payment_date'] ?><br>
				mf_billing_id : <?php echo $this->request->data['Pmtotal']['mf_billing_id'] ?><br>
			</td>
		</tr>
		<tr>
			<th class="col-head" width="150">status</th>
			<td class="col-input">
				<?php echo $this->BcForm->input('Pmtotal.status', array('type'=>'select', 'options'=>$status, 'empty'=>'---')) ?>
				<?php echo $this->BcForm->error('Pmtotal.status') ?>
			</td>
		</tr>
		<tr>
			<th class="col-head" width="150">payment_date</th>
			<td class="col-input">
				<?php echo $this->BcForm->datepicker('Pmtotal.payment_date') ?>
				<?php echo $this->BcForm->error('Pmtotal.payment_date') ?>
			</td>
		</tr>
		<tr>
			<th class="col-head" width="150">明細</th>
			<td class="col-input">
				<?php foreach($UserTotals as $total): ?>
					<?php echo $total['UserTotal']['name'].' : '.$total['UserTotal']['total']; ?><br>
				<?php endforeach; ?>
			</td>
		</tr>
		
	</table>
</div>
<!-- button -->
<div class="submit">
<?php echo $this->BcForm->submit('編集', array('div' => false, 'class' => 'button')) ?>
</div>
<?php echo $this->BcForm->end() ?>

<div class="section">
<ul>
	<li></li>
	<li></li>
	<li></li>
</ul>
</div>