<?php $this->BcBaser->css(array('Point.point'), array('inline' => false)); ?>
<?php echo $this->Session->flash(); ?>
<?php  
	$past_ym = [];
	$past_ym[date('Ym')] = date('Y年n月');
	$past_ym[date('Ym', strtotime(date('Y-m-01').'-1 month'))] = date('Y年n月', strtotime(date('Y-m-01').'-1 month'));
	$past_ym[date('Ym', strtotime(date('Y-m-01').'-2 month'))] = date('Y年n月', strtotime(date('Y-m-01').'-2 month'));
	//$ym[date('Ym', strtotime(date('Y-m-01').'-3 month'))] = date('Y年n月', strtotime(date('Y-m-01').'-3 month'));
?>
<h1 class="h5 border-bottom py-2 mb-3 text-secondary"><?php echo $now_date ?> : ポイント履歴</h1>
<div class="row mx-3">
	<?php foreach($past_ym as $key=>$val): ?>
		<div class"col"><a href="/point_manager/pm_users/point_book/<?php echo $key ?>" class="btn btn-outline-primary btn-sm btn-e mx-1"><?php echo $val ?></a></div>
	<?php endforeach; ?>
</div>
<div class="my-3 mx-1">
	<?php if($books): ?>
	<div class="table-responsive">
	<small>
	<table class="table table-sm text-nowrap">
		<thead>
			<tr>
				<th scope="col ">Date</th>
				<th scope="col">No.</th>
				<th scope="col">名前</th>
				<th scope="col">Action</th>
				<th scope="col">ポイント</th>
				<th scope="col">ポイント計</th>
			</tr>
		</thead>
		<tbody>
		<?php foreach($books as $book): ?>
			<tr>
			<td scope="row"><?php echo $book['PointBook']['created']; ?></td>
			<td scope="row"><?php echo $book['Mypage']['id']; ?></td>
			<td scope="row"><?php echo $book['Mypage']['name']; ?></td>
			<td><?php echo $book['PointBook']['reason']; ?></td>
			<td class="text-right"><?php echo number_format($book['PointBook']['point']); ?></td>
			<td class="text-right"><?php echo number_format($book['PointBook']['point_balance']); ?></td>
			</tr>
		<?php endforeach; ?>
		</tbody>
	</table>
	</small>
	</div>
	<?php else: ?>
		<p>no data.</p>
	<?php endif; ?>
	<?php $this->BcBaser->pagination('simple'); ?>
</div>
<div class="my-3 mx-3">
	<p>
		<a class="btn btn-outline-secondary btn-sm btn-e" data-toggle="collapse" href="#descriptionOfTable" role="button" aria-expanded="false" aria-controls="collapseExample">
		表：各項目の説明
  		</a>
  		<a href="/point_manager/pm_users/download/<?php echo $ym ?>" class="btn btn-outline-secondary btn-sm btn-e ml-3">CSVダウンロード</a>
	</p>
	<div class="collapse" id="descriptionOfTable">
		<small>
		<ul>
			<li>Date：ポイントが増減した時の日時</li>
			<li>No.：会員番号</li>
			<li>名前：ユーザー名</li>
			<li>Action：ポイント増減した内容</li>
			<li>ポイント：増減したポイント</li>
			<li>ポイント計：その時点でのポイントの累計</li>
		</ul>
		</small>
	</div>
</div>