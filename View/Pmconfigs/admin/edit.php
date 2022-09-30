<?php echo $this->BcForm->create('Pmconfig') ?>
<?php echo $this->BcForm->input('Pmconfig.id', array('type' => 'hidden')) ?>
<div class="section">
	<table cellpadding="0" cellspacing="0" class="form-table">
		<tr>
			<th colspan="2">MFクラウド請求書APIの情報</th>
		</tr>
		<tr>
			<th class="col-head" width="150">created<br>modified</th>
			<td class="col-input">
				<?php if(isset($this->request->data['Pmconfig'])): ?>
					<?php echo $this->request->data['Pmconfig']['created'] ?><br>
					<?php echo $this->request->data['Pmconfig']['modified'] ?>
				<?php endif; ?>
			</td>
			</td>
		</tr>
		<tr>
			<th class="col-head" width="150">client_id</th>
			<td class="col-input">
				<?php echo $this->BcForm->input('Pmconfig.client_id', array('type'=>'text')) ?>
				<?php echo $this->BcForm->error('Pmconfig.client_id') ?></td>
			</td>
		</tr>
		<tr>
			<th class="col-head" width="150">client_secret</th>
			<td class="col-input">
				<?php echo $this->BcForm->input('Pmconfig.client_secret', array('type'=>'text')) ?>
				<?php echo $this->BcForm->error('Pmconfig.client_secret') ?></td>
			</td>
		</tr>
		<tr>
			<th class="col-head" width="150">refresh_token</th>
			<td class="col-input">
				<?php echo $this->BcForm->input('Pmconfig.refresh_token', array('type'=>'text')) ?>
				<?php echo $this->BcForm->error('Pmconfig.refresh_token') ?></td>
			</td>
		</tr>
		<tr>
			<th class="col-head" width="150">access_token</th>
			<td class="col-input">
				<?php echo $this->BcForm->input('Pmconfig.access_token', array('type'=>'text')) ?>
				<?php echo $this->BcForm->error('Pmconfig.access_token') ?></td>
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