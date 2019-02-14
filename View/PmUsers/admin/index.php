
<div id="DataList">
<?php $this->BcBaser->element('pagination') ?>
<table cellpadding="0" cellspacing="0" class="list-table" id="ListTable">
<thead>
	<tr>
		<th class="list-tool"></th>
		<th><?php echo $this->Paginator->sort('Mypage.id', array('asc' => $this->BcBaser->getImg('admin/blt_list_down.png', array('alt' => '昇順', 'title' => '昇順')) . ' 会員番号', 'desc' => $this->BcBaser->getImg('admin/blt_list_up.png', array('alt' => '降順', 'title' => '降順')) . ' 会員番号'), array('escape' => false, 'class' => 'btn-direction')) ?></th>
		<th><?php echo $this->Paginator->sort('Mypage.name', array('asc' => $this->BcBaser->getImg('admin/blt_list_down.png', array('alt' => '昇順', 'title' => '昇順')) . ' 名前', 'desc' => $this->BcBaser->getImg('admin/blt_list_up.png', array('alt' => '降順', 'title' => '降順')) . ' 名前'), array('escape' => false, 'class' => 'btn-direction')) ?></th>
		<th>point</th>
		<th><?php echo $this->Paginator->sort('Mypage.created', array('asc' => $this->BcBaser->getImg('admin/blt_list_down.png', array('alt' => '昇順', 'title' => '昇順')) . ' 登録日', 'desc' => $this->BcBaser->getImg('admin/blt_list_up.png', array('alt' => '降順', 'title' => '降順')) . ' 登録日'), array('escape' => false, 'class' => 'btn-direction')) ?><br />
			<?php echo $this->Paginator->sort('Mypage.modified', array('asc' => $this->BcBaser->getImg('admin/blt_list_down.png', array('alt' => '昇順', 'title' => '昇順')) . ' 更新日', 'desc' => $this->BcBaser->getImg('admin/blt_list_up.png', array('alt' => '降順', 'title' => '降順')) . ' 更新日'), array('escape' => false, 'class' => 'btn-direction')) ?></th>
	</tr>
</thead>
<tbody>
	<?php if (!empty($PmUsers)): ?>
		<?php foreach ($PmUsers as $data): ?>
			<?php
			//状態
			if ($data['Mypage']['status'] == 0) {
			  $status = 'class=""';
			} else {
			  $status = 'class="disablerow"';
			}
			?>
			<tr <?php echo $status ?>>
				<td class="row-tools">
					<?php //$this->BcBaser->link($this->BcBaser->getImg('admin/icn_tool_edit.png', array('width' => 24, 'height' => 24, 'alt' => '編集', 'class' => 'btn')), array('action' => 'edit', $data['Pmpage']['id']), array('title' => '編集')) ?>
					<?php //$this->BcBaser->link($this->BcBaser->getImg('admin/icon_add_layerd.png', array('width' => 24, 'height' => 24, 'alt' => 'ユーザー追加', 'class' => 'btn')), array('action' => 'user_add', $data['Mypage']['id']), array('title' => 'ユーザー追加')) ?>
				</td>
				<td><?php echo $data['Mypage']['id'] ?></td>
				<td><?php echo $data['Mypage']['name'] ?></td>
				<td><?php echo $data['PointUser']['point'] ?></td>
				<td><?php echo $this->BcTime->format('Y-m-d', $data['Mypage']['created']) ?><br />
					<?php echo $this->BcTime->format('Y-m-d', $data['Mypage']['modified']) ?></td>
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