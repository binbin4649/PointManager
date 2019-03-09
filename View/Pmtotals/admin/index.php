<?php echo $this->BcForm->create('Pmtotal') ?>
会員番号:<?php echo $this->BcForm->input('Pmtotal.mypage_id', array('type'=>'text', 'size'=>5)) ?>　
status:<?php echo $this->BcForm->input('Pmtotal.status', array('type'=>'select', 'options'=>$status)) ?>　
<?php echo $this->BcForm->submit('　検索　', array('div' => false, 'class' => 'button', 'style'=>'padding:4px;')) ?>
<?php echo $this->BcForm->end() ?>

<div id="DataList">
<?php $this->BcBaser->element('pagination') ?>
<table cellpadding="0" cellspacing="0" class="list-table" id="ListTable">
<thead>
	<tr>
		<th>pmtotal_id</th>
		<th>id:name</th>
		<th>yyyymm</th>
		<th>total</th>
		<th>status</th>
	</tr>
</thead>
<tbody>
	<?php if (!empty($Pmtotal)): ?>
		<?php foreach ($Pmtotal as $data): ?>
			<?php
			//状態
			if ($data['Mypage']['status'] == 0) {
			  $status = 'class=""';
			} else {
			  $status = 'class="disablerow"';
			}
			?>
			<tr <?php echo $status ?>>
				<td><?php $this->BcBaser->link($data['Pmtotal']['id'], array('plugin'=>'point_manager', 'controller'=>'pmtotals', 'action'=>'edit/'.$data['Pmtotal']['id'])) ?></td>
				<td><?php echo $data['Mypage']['id'].' : '.$data['Pmpage']['company_name'] ?></td>
				<td><?php echo $data['Pmtotal']['yyyymm'] ?></td>
				<td><?php echo $data['Pmtotal']['total'] ?></td>
				<td><?php echo $data['Pmtotal']['status'] ?></td>
			</tr>
		<?php endforeach; ?>
	<?php else: ?>
		<tr>
			<td colspan="8"><p class="no-data">データが見つかりませんでした。</p></td>
		</tr>
	<?php endif; ?>
</tbody>
</table>
</div>
<p></p>