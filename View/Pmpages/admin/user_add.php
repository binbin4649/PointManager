<!-- form -->
<?php echo $this->BcForm->create('Pmpage') ?>
<?php echo $this->BcForm->input('Mypage.id', array('type' => 'hidden', 'value' => $Mypage['Mypage']['id'])) ?>
<div class="section">
	<table cellpadding="0" cellspacing="0" class="form-table">
		<tr>
			<th colspan="2">既存ユーザー任意紐付け</th>
		</tr>
		<tr>
			<th class="col-head" width="150">PM 担当者</th>
			<td class="col-input">
				<?php echo $Mypage['Mypage']['id'] ?> : 
				<?php echo $Mypage['Mypage']['name'] ?>
			</td>
		</tr>
		<tr>
			<th class="col-head" width="150">紐付け既存ユーザー</th>
			<td class="col-input">
				<?php echo $this->BcForm->input('Pmpage.add_user', array('type'=>'text')) ?>
				<br><small>紐付ける既存ユーザーの会員番号を入力。</small>
				<?php echo $this->BcForm->error('Pmpage.add_user') ?></td>
			</td>
		</tr>
	</table>
</div>
<!-- button -->
<div class="submit">
<?php echo $this->BcForm->submit('追加', array('div' => false, 'class' => 'button')) ?>
</div>
<?php echo $this->BcForm->end() ?>

<div class="section">
<ul>
	<li>「新規追加」「削除」は、マイページから。</li>
	<li></li>
	<li></li>
</ul>
</div>