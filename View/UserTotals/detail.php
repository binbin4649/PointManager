
<?php echo $this->Session->flash(); ?>

<h1 class="h5 py-3 mb-3 text-secondary">
	請求明細：<?php echo date('Y-m', strtotime($Pmtotal['Pmtotal']['yyyymm'])) ?>
</h1>
<div class="my-3 mx-sm-5">
	<table class="table">
		<thead>
			<tr>
				<td>明細</td>
				<td>金額</td>
			</tr>
		</thead>
		<tbody>
		<?php foreach($UserTotals as $UserTotal): ?>
		<tr>
			<td class="align-middle"><?php echo $UserTotal['UserTotal']['name'] ?></td>
			<td class="align-middle"><?php echo number_format($UserTotal['UserTotal']['total']) ?></td>
		</tr>
		<?php endforeach; ?>
		<tr>
			<td class="text-center">合計</td>
			<td><?php echo number_format($Pmtotal['Pmtotal']['total']) ?></td>
		</tr>
		</tbody>
	</table>
</div>
<div class="my-3 mx-sm-5 text-center">
	<?php echo $this->BcBaser->link('請求履歴一覧へ', '/point_manager/pmtotals/', ['class'=>'btn btn-outline-primary btn-e', 'role'=>'button']) ?>
</div>