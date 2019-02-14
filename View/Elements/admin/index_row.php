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
		<?php $this->BcBaser->link($this->BcBaser->getImg('admin/icn_tool_edit.png', array('width' => 24, 'height' => 24, 'alt' => '編集', 'class' => 'btn')), array('action' => 'edit', $data['Pmpage']['id']), array('title' => '編集')) ?>
		<?php $this->BcBaser->link($this->BcBaser->getImg('admin/icon_add_layerd.png', array('width' => 24, 'height' => 24, 'alt' => 'ユーザー追加', 'class' => 'btn')), array('action' => 'user_add', $data['Mypage']['id']), array('title' => 'ユーザー追加')) ?>
	</td>
	<td><?php $this->BcBaser->link($data['Mypage']['id'], array('plugin'=>'members', 'controller'=>'mypages', 'action'=>'edit/'.$data['Mypage']['id'])) ?></td>
	<td><?php $this->BcBaser->link($data['Mypage']['name'], array('controller'=>'pm_users', 'action' => 'index/'.$data['Pmpage']['id'])) ?></td>
	<td><?php echo $data['Pmpage']['company_name'] ?></td>
	<td><?php echo $this->BcTime->format('Y-m-d', $data['Mypage']['created']) ?><br />
		<?php echo $this->BcTime->format('Y-m-d', $data['Mypage']['modified']) ?></td>
</tr>