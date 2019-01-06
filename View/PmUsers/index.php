
<?php echo $this->Session->flash(); ?>

<h1 class="h5 py-3 mb-3 text-secondary">ユーザー一覧</h1>
<div class="my-3 mx-sm-5">
	<table class="table">
		<thead>
			<tr>
				<td>会員番号</td>
				<td>お名前</td>
				<td>ポイント</td>
				<td></td>
			</tr>
		</thead>
		<tbody>
		<?php foreach($pmusers as $user): ?>
		<tr>
			<td class="align-middle text-muted"><small><?php echo $user['Mypage']['id'] ?></small></td>
			<td class="align-middle"><?php echo $user['Mypage']['name'] ?></td>
			<td class="align-middle"><?php echo $user['PointUser']['point'] ?></td>
			<td>
				<?php if($user['Mypage']['status'] != '2'): ?>
				<?php echo $this->BcBaser->link('編集', '/point_manager/pm_users/edit/'.$user['Mypage']['id'], ['class'=>'btn btn-sm btn-outline-primary btn-e', 'role'=>'button']) ?>
				<?php else: ?>
					削除
				<?php endif; ?>
			</td>
		</tr>
		<?php endforeach; ?>
		</tbody>
	</table>
	<?php $this->BcBaser->pagination('simple'); ?>
</div>
