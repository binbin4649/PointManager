
<?php echo $this->Session->flash(); ?>

<h1 class="h5 py-3 mb-3 text-secondary">
	月額履歴：<?php echo $Mypage['Mypage']['name'] ?>
</h1>
<div class="my-3 mx-sm-5">
	<table class="table">
		<thead>
			<tr>
				<td>年月</td>
				<td>金額</td>
			</tr>
		</thead>
		<tbody>
		<?php foreach($UserTotals as $UserTotal): ?>
		<tr>
			<td class="align-middle"><?php echo date('Y-m', strtotime($UserTotal['UserTotal']['yyyymm'])) ?></td>
			<td class="align-middle"><?php echo number_format($UserTotal['UserTotal']['total']) ?></td>
		</tr>
		<?php endforeach; ?>
		</tbody>
	</table>
	<?php $this->BcBaser->pagination('simple'); ?>
</div>
<div class="my-3 mx-sm-5 text-center">
	<?php echo $this->BcBaser->link('ユーザー一覧へ', '/point_manager/pm_users/', ['class'=>'btn btn-outline-primary btn-e', 'role'=>'button']) ?>
</div>
<div class="my-3 mx-sm-5">
	<small>当月分は表示されません。過去に精算された履歴を参照できます。</small>
</div>