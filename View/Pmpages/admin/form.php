<div id="SubMenu" class="clearfix">
	<table class="sub-menu">
		<tr>
			<th>PointManager</th>
			<td>
				<ul class="cleafix">
					<li><a href="/admin/point_manager/pmpages/">PM一覧</a></li>
					<li><a href="/admin/point_manager/pmpages/add">PM新規追加</a></li>
				</ul>
			</td>
		</tr>
	</table>
</div>
<!-- form -->
<?php  
	if(isset($this->request->data['Mypage']['password'])){
		unset($this->request->data['Mypage']['password']);
	}
?>
<?php echo $this->BcForm->create('Pmpage') ?>
<?php echo $this->BcForm->input('Pmpage.mypage_id', array('type' => 'hidden')) ?>
<?php echo $this->BcForm->input('Pmpage.id', array('type' => 'hidden')) ?>
<?php echo $this->BcForm->input('Mypage.id', array('type' => 'hidden')) ?>
<div class="section">
	<table cellpadding="0" cellspacing="0" class="form-table">
		<tr>
			<th colspan="2">ログイン情報(必須)</th>
		</tr>
		<tr>
			<th class="col-head" width="150">担当者名</th>
			<td class="col-input">
				<?php echo $this->BcForm->input('Mypage.name', array('type'=>'text')) ?>
				<?php echo $this->BcForm->error('Mypage.name') ?></td>
			</td>
		</tr>
		<tr>
			<th class="col-head" width="150">メールアドレス</th>
			<td class="col-input">
				<?php echo $this->BcForm->input('Mypage.email', array('type'=>'text', 'size'=>'40')) ?>
				<br><small>(ログインID)</small>
				<?php echo $this->BcForm->error('Mypage.email') ?></td>
			</td>
		</tr>
		<tr>
			<th class="col-head" width="150">パスワード</th>
			<td class="col-input">
				<?php echo $this->BcForm->input('Mypage.password', array('type'=>'text')) ?>
				<br><small>新規登録、または変更する場合のみ入力</small>
				<?php echo $this->BcForm->error('Mypage.password') ?></td>
			</td>
		</tr>
		
		<tr>
			<th colspan="2">取引先</th>
		</tr>
		<tr>
			<th class="col-head" width="150">会社名</th>
			<td class="col-input">
				<?php echo $this->BcForm->input('Pmpage.company_name', array('type'=>'text', 'size'=>'40')) ?>
				<?php echo $this->BcForm->error('Pmpage.company_name') ?></td>
			</td>
		</tr>
		<tr>
			<th class="col-head" width="150">部署名</th>
			<td class="col-input">
				<?php echo $this->BcForm->input('Pmpage.department_name', array('type'=>'text')) ?>
				<?php echo $this->BcForm->error('Pmpage.department_name') ?></td>
			</td>
		</tr>
		<tr>
			<th class="col-head" width="150">役職名</th>
			<td class="col-input">
				<?php echo $this->BcForm->input('Pmpage.position_name', array('type'=>'text')) ?>
				<?php echo $this->BcForm->error('Pmpage.position_name') ?></td>
			</td>
		</tr>
		<tr>
			<th class="col-head" width="150">郵便番号</th>
			<td class="col-input">
				<?php echo $this->BcForm->input('Mypage.zip', array('type'=>'text')) ?>
				<?php echo $this->BcForm->error('Mypage.zip') ?></td>
			</td>
		</tr>
		<tr>
			<th class="col-head" width="150">都道府県</th>
			<td class="col-input">
				<?php echo $this->BcForm->input('Pmpage.prefecture', array('type'=>'select', 'empty'=>'---', 'options'=>$prefecture)) ?>
				<?php echo $this->BcForm->error('Pmpage.prefecture') ?></td>
			</td>
		</tr>
		<tr>
			<th class="col-head" width="150">住所1</th>
			<td class="col-input">
				<?php echo $this->BcForm->input('Mypage.address_1', array('type'=>'text', 'size'=>'60')) ?>
				<?php echo $this->BcForm->error('Mypage.address_1') ?></td>
			</td>
		</tr>
		<tr>
			<th class="col-head" width="150">住所2</th>
			<td class="col-input">
				<?php echo $this->BcForm->input('Mypage.address_2', array('type'=>'text', 'size'=>'60')) ?>
				<?php echo $this->BcForm->error('Mypage.address_2') ?></td>
			</td>
		</tr>
		<tr>
			<th class="col-head" width="150">電話</th>
			<td class="col-input">
				<?php echo $this->BcForm->input('Mypage.tel', array('type'=>'text')) ?>
				<?php echo $this->BcForm->error('Mypage.tel') ?></td>
			</td>
		</tr>
		
		<tr>
			<th colspan="2">請求先</th>
		</tr>
		<tr>
			<th class="col-head" width="150">請求会社名</th>
			<td class="col-input">
				<?php echo $this->BcForm->input('Pmpage.invoice_company_name', array('type'=>'text', 'size'=>'40')) ?>
				<?php echo $this->BcForm->error('Pmpage.invoice_company_name') ?></td>
			</td>
		</tr>
		<tr>
			<th class="col-head" width="150">請求部署名</th>
			<td class="col-input">
				<?php echo $this->BcForm->input('Pmpage.invoice_department_name', array('type'=>'text')) ?>
				<?php echo $this->BcForm->error('Pmpage.invoice_department_name') ?></td>
			</td>
		</tr>
		<tr>
			<th class="col-head" width="150">請求役職名</th>
			<td class="col-input">
				<?php echo $this->BcForm->input('Pmpage.invoice_position_name', array('type'=>'text')) ?>
				<?php echo $this->BcForm->error('Pmpage.invoice_position_name') ?></td>
			</td>
		</tr>
		<tr>
			<th class="col-head" width="150">請求担当者名</th>
			<td class="col-input">
				<?php echo $this->BcForm->input('Pmpage.invoice_name', array('type'=>'text')) ?>
				<?php echo $this->BcForm->error('Pmpage.invoice_name') ?></td>
			</td>
		</tr>
		<tr>
			<th class="col-head" width="150">請求電話</th>
			<td class="col-input">
				<?php echo $this->BcForm->input('Pmpage.invoice_tel', array('type'=>'text')) ?>
				<?php echo $this->BcForm->error('Pmpage.invoice_tel') ?></td>
			</td>
		</tr>
		<tr>
			<th class="col-head" width="150">請求郵便番号</th>
			<td class="col-input">
				<?php echo $this->BcForm->input('Pmpage.invoice_zip', array('type'=>'text')) ?>
				<?php echo $this->BcForm->error('Pmpage.invoice_zip') ?></td>
			</td>
		</tr>
		<tr>
			<th class="col-head" width="150">都道府県</th>
			<td class="col-input">
				<?php echo $this->BcForm->input('Pmpage.invoice_prefecture', array('type'=>'select', 'empty'=>'---', 'options'=>$prefecture)) ?>
				<?php echo $this->BcForm->error('Pmpage.invoice_prefecture') ?></td>
			</td>
		</tr>
		<tr>
			<th class="col-head" width="150">請求住所1</th>
			<td class="col-input">
				<?php echo $this->BcForm->input('Pmpage.invoice_address_1', array('type'=>'text', 'size'=>'60')) ?>
				<?php echo $this->BcForm->error('Pmpage.invoice_address_1') ?></td>
			</td>
		</tr>
		<tr>
			<th class="col-head" width="150">請求住所2</th>
			<td class="col-input">
				<?php echo $this->BcForm->input('Pmpage.invoice_address_2', array('type'=>'text', 'size'=>'60')) ?>
				<?php echo $this->BcForm->error('Pmpage.invoice_address_2') ?></td>
			</td>
		</tr>
		<tr>
			<th class="col-head" width="150">請求メール</th>
			<td class="col-input">
				<?php echo $this->BcForm->input('Pmpage.invoice_email', array('type'=>'text')) ?>
				<?php echo $this->BcForm->error('Pmpage.invoice_email') ?></td>
			</td>
		</tr>
		<tr>
			<th colspan="2"></th>
		</tr>
		<tr>
			<th class="col-head" width="150">MEMO</th>
			<td class="col-input">
				<?php echo $this->BcForm->input('Pmpage.memo', array('type'=>'textarea')) ?>
				<?php echo $this->BcForm->error('Pmpage.memo') ?></td>
			</td>
		</tr>
	</table>
</div>
<!-- button -->
<div class="submit">
<?php echo $this->BcForm->submit('編集', array('div' => false, 'class' => 'button')) ?>
</div>
<?php echo $this->BcForm->end() ?>

<div class="section">
<ul>
	<li>[2018-12-27] </li>
	<li></li>
	<li></li>
</ul>
</div>