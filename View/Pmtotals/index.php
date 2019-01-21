
<?php echo $this->Session->flash(); ?>

<h1 class="h5 py-3 mb-3 text-secondary">請求履歴一覧</h1>
<div class="my-3 mx-sm-5">
	<table class="table">
		<thead>
			<tr>
				<td>年月</td>
				<td>金額</td>
				<td></td>
			</tr>
		</thead>
		<tbody>
		<?php foreach($Pmtotals as $Pmtotal): ?>
		<tr>
			<td class="align-middle"><?php echo date('Y-m', strtotime($Pmtotal['Pmtotal']['yyyymm'])) ?></td>
			<td class="align-middle">
				<?php echo number_format($Pmtotal['Pmtotal']['total']) ?>
				<?php if($Pmtotal['Pmtotal']['status'] == 'forward'): ?>
					<small>(繰越)</small>
				<?php endif; ?>
			</td>
			<td>
				<?php echo $this->BcBaser->link('明細', '/point_manager/user_totals/detail/'.$Pmtotal['Pmtotal']['yyyymm'], ['class'=>'btn btn-sm btn-outline-primary btn-e', 'role'=>'button']) ?>
			</td>
		</tr>
		<?php endforeach; ?>
		</tbody>
	</table>
	<?php $this->BcBaser->pagination('simple'); ?>
</div>