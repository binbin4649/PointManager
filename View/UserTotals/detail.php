
<?php echo $this->Session->flash(); ?>

<h1 class="h5 py-3 mb-3 text-secondary">
	請求明細：<?php echo date('Y-m', strtotime($Pmtotal['Pmtotal']['yyyymm'])) ?>
	<?php if($Pmtotal['Pmtotal']['status'] == 'forward'): ?>
		（繰越）
	<?php endif; ?>
</h1>
<div class="my-3 mx-sm-5">
	<table class="table">
		<thead>
			<tr>
				<td> </td>
				<td>単価</td>
				<td>数量</td>
				<td>価格</td>
			</tr>
		</thead>
		<tbody>
		<?php 
			$name_head = '';
			$head_total = 0;
		?>
		<?php foreach($UserTotals as $UserTotal): ?>
			<?php if(isset($UserTotal['UserTotal']['name_head'])): ?>
				<?php if($UserTotal['UserTotal']['name_head'] != $name_head && $head_total > 1): ?>
					<tr>
						<td class="align-middle small text-muted">(<?php echo $name_head.' 小計'; ?>)</td>
						<td class="align-middle"></td>
						<td class="align-middle"></td>
						<td class="align-middle small text-muted">(<?php echo number_format($head_total); ?>)</td>
					</tr>
					<?php 
						$head_total = 0;
						$name_head = $UserTotal['UserTotal']['name_head'];
					?>
				<?php elseif(empty($name_head)): ?>
					<?php $name_head = $UserTotal['UserTotal']['name_head']; ?>
				<?php endif; ?>
				<?php $head_total = $head_total + $UserTotal['UserTotal']['total']; ?>
			<?php endif; ?>
			<tr>
				<td class="align-middle"><?php echo $UserTotal['UserTotal']['name']; ?></td>
				<td class="align-middle"><?php echo $UserTotal['UserTotal']['unit_price']; ?></td>
				<td class="align-middle"><?php echo $UserTotal['UserTotal']['quantity']; ?></td>
				<td class="align-middle"><?php echo number_format($UserTotal['UserTotal']['total']); ?></td>
			</tr>
		<?php endforeach; ?>
		<tr>
			<td colspan="2">
			<?php if($Pmtotal['Pmtotal']['status'] == 'forward'): ?>
				繰越の場合、先月ご利用分（繰越）を含んだ合計になります。
			<?php endif; ?>
			</td>
			<td class="text-center">合計</td>
			<td><?php echo number_format($Pmtotal['Pmtotal']['total']) ?></td>
		</tr>
		</tbody>
	</table>
</div>
<div class="my-3 mx-sm-5 text-right">
	<?php if($pdf_file): ?>
		<?php 
			echo $this->BcBaser->link('請求書PDFダウンロード', '/point_manager/files/pdf/'.$pdf_file, ['download'=>$pdf_file]); 
		?>
	<?php endif; ?>
</div>
<div class="my-3 mx-sm-5 text-center">
	<?php echo $this->BcBaser->link('請求履歴一覧へ', '/point_manager/pmtotals/', ['class'=>'btn btn-outline-primary btn-e', 'role'=>'button']) ?>
</div>