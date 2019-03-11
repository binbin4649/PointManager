
<!-- form -->
<?php  
	if(isset($this->request->data['Mypage']['password'])){
		unset($this->request->data['Mypage']['password']);
	}
	if(isset($this->request->data['Pmpage'])){
		$Pmpage = $this->request->data['Pmpage'];
	}
?>
<?php echo $this->BcForm->create('Pmpage') ?>
<?php echo $this->BcForm->input('Pmpage.mypage_id', array('type' => 'hidden')) ?>
<?php echo $this->BcForm->input('Pmpage.id', array('type' => 'hidden')) ?>
<?php echo $this->BcForm->input('Pmpage.mf_department_id', array('type' => 'hidden')) ?>
<?php echo $this->BcForm->input('Pmpage.mf_partner_id', array('type' => 'hidden')) ?>
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
				<?php echo $this->BcForm->error('Mypage.name') ?>
			</td>
		</tr>
		<tr>
			<th class="col-head" width="150">メールアドレス</th>
			<td class="col-input">
				<?php echo $this->BcForm->input('Mypage.email', array('type'=>'text', 'size'=>'40')) ?>
				<br><small>(ログインID)</small>
				<?php echo $this->BcForm->error('Mypage.email') ?>
			</td>
		</tr>
		<tr>
			<th class="col-head" width="150">パスワード</th>
			<td class="col-input">
				<?php echo $this->BcForm->input('Mypage.password', array('type'=>'text')) ?>
				<br><small>新規登録、または変更する場合のみ入力</small>
				<?php echo $this->BcForm->error('Mypage.password') ?>
			</td>
		</tr>
		
		<tr>
			<th colspan="2">取引先</th>
		</tr>
		<tr>
			<th class="col-head" width="150">MF</th>
			<td class="col-input">
				partner_id : <?php if(!empty($Pmpage['mf_partner_id'])) echo $Pmpage['mf_partner_id'] ?><br>
				department_id : <?php if(!empty($Pmpage['mf_department_id'])) echo $Pmpage['mf_department_id'] ?>
			</td>
		</tr>
		<tr>
			<th class="col-head" width="150">会社名</th>
			<td class="col-input">
				<?php echo $this->BcForm->input('Pmpage.company_name', array('type'=>'text', 'size'=>'40')) ?>
				<?php echo $this->BcForm->error('Pmpage.company_name') ?>
			</td>
		</tr>
		<tr>
			<th class="col-head" width="150">部署名</th>
			<td class="col-input">
				<?php echo $this->BcForm->input('Pmpage.department_name', array('type'=>'text')) ?>
				<?php echo $this->BcForm->error('Pmpage.department_name') ?>
			</td>
		</tr>
		<tr>
			<th class="col-head" width="150">役職名</th>
			<td class="col-input">
				<?php echo $this->BcForm->input('Pmpage.position_name', array('type'=>'text')) ?>
				<?php echo $this->BcForm->error('Pmpage.position_name') ?>
			</td>
		</tr>
		<tr>
			<th class="col-head" width="150">郵便番号</th>
			<td class="col-input">
				<?php echo $this->BcForm->input('Mypage.zip', array('type'=>'text')) ?>
				<?php echo $this->BcForm->error('Mypage.zip') ?>
			</td>
		</tr>
		<tr>
			<th class="col-head" width="150">都道府県</th>
			<td class="col-input">
				<?php echo $this->BcForm->input('Pmpage.prefecture', array('type'=>'select', 'empty'=>'---', 'options'=>$prefecture)) ?>
				<?php echo $this->BcForm->error('Pmpage.prefecture') ?>
			</td>
		</tr>
		<tr>
			<th class="col-head" width="150">住所1</th>
			<td class="col-input">
				<?php echo $this->BcForm->input('Mypage.address_1', array('type'=>'text', 'size'=>'60')) ?>
				<?php echo $this->BcForm->error('Mypage.address_1') ?>
			</td>
		</tr>
		<tr>
			<th class="col-head" width="150">住所2</th>
			<td class="col-input">
				<?php echo $this->BcForm->input('Mypage.address_2', array('type'=>'text', 'size'=>'60')) ?>
				<?php echo $this->BcForm->error('Mypage.address_2') ?>
			</td>
		</tr>
		<tr>
			<th class="col-head" width="150">電話</th>
			<td class="col-input">
				<?php echo $this->BcForm->input('Mypage.tel', array('type'=>'text')) ?>
				<?php echo $this->BcForm->error('Mypage.tel') ?>
			</td>
		</tr>
		
		<tr>
			<th colspan="2">請求先</th>
		</tr>
		<tr>
			<th class="col-head" width="150">請求会社名</th>
			<td class="col-input">
				<?php echo $this->BcForm->input('Pmpage.invoice_company_name', array('type'=>'text', 'size'=>'40')) ?>
				<?php echo $this->BcForm->error('Pmpage.invoice_company_name') ?>
			</td>
		</tr>
		<tr>
			<th class="col-head" width="150">請求部署名</th>
			<td class="col-input">
				<?php echo $this->BcForm->input('Pmpage.invoice_department_name', array('type'=>'text')) ?>
				<?php echo $this->BcForm->error('Pmpage.invoice_department_name') ?>
			</td>
		</tr>
		<tr>
			<th class="col-head" width="150">請求役職名</th>
			<td class="col-input">
				<?php echo $this->BcForm->input('Pmpage.invoice_position_name', array('type'=>'text')) ?>
				<?php echo $this->BcForm->error('Pmpage.invoice_position_name') ?>
			</td>
		</tr>
		<tr>
			<th class="col-head" width="150">請求担当者名</th>
			<td class="col-input">
				<?php echo $this->BcForm->input('Pmpage.invoice_name', array('type'=>'text')) ?>
				<?php echo $this->BcForm->error('Pmpage.invoice_name') ?>
			</td>
		</tr>
		<tr>
			<th class="col-head" width="150">請求電話</th>
			<td class="col-input">
				<?php echo $this->BcForm->input('Pmpage.invoice_tel', array('type'=>'text')) ?>
				<?php echo $this->BcForm->error('Pmpage.invoice_tel') ?>
			</td>
		</tr>
		<tr>
			<th class="col-head" width="150">請求郵便番号</th>
			<td class="col-input">
				<?php echo $this->BcForm->input('Pmpage.invoice_zip', array('type'=>'text')) ?>
				<?php echo $this->BcForm->error('Pmpage.invoice_zip') ?>
			</td>
		</tr>
		<tr>
			<th class="col-head" width="150">都道府県</th>
			<td class="col-input">
				<?php echo $this->BcForm->input('Pmpage.invoice_prefecture', array('type'=>'select', 'empty'=>'---', 'options'=>$prefecture)) ?>
				<?php echo $this->BcForm->error('Pmpage.invoice_prefecture') ?>
			</td>
		</tr>
		<tr>
			<th class="col-head" width="150">請求住所1</th>
			<td class="col-input">
				<?php echo $this->BcForm->input('Pmpage.invoice_address_1', array('type'=>'text', 'size'=>'60')) ?>
				<?php echo $this->BcForm->error('Pmpage.invoice_address_1') ?>
			</td>
		</tr>
		<tr>
			<th class="col-head" width="150">請求住所2</th>
			<td class="col-input">
				<?php echo $this->BcForm->input('Pmpage.invoice_address_2', array('type'=>'text', 'size'=>'60')) ?>
				<?php echo $this->BcForm->error('Pmpage.invoice_address_2') ?>
			</td>
		</tr>
		<tr>
			<th class="col-head" width="150">請求メール</th>
			<td class="col-input">
				<?php echo $this->BcForm->input('Pmpage.invoice_email', array('type'=>'text')) ?>
				<?php echo $this->BcForm->error('Pmpage.invoice_email') ?>
			</td>
		</tr>
		<tr>
			<th colspan="2"></th>
		</tr>
		<tr>
			<th class="col-head" width="150">MEMO</th>
			<td class="col-input">
				<?php echo $this->BcForm->input('Pmpage.memo', array('type'=>'textarea')) ?>
				<?php echo $this->BcForm->error('Pmpage.memo') ?>
			</td>
		</tr>
		<tr>
			<th colspan="2">追加請求明細</th>
		</tr>
		<tr>
			<th class="col-head" width="150">明細名1</th>
			<td class="col-input">
				<?php echo $this->BcForm->input('Pmpage.other_payoff_name1', array('type'=>'text')) ?>
				<?php echo $this->BcForm->error('Pmpage.other_payoff_name1') ?>
			</td>
		</tr>
		<tr>
			<th class="col-head" width="150">明細金額1</th>
			<td class="col-input">
				<?php echo $this->BcForm->input('Pmpage.other_payoff_total1', array('type'=>'text')) ?>
				<?php echo $this->BcForm->error('Pmpage.other_payoff_total1') ?>
			</td>
		</tr>
		<tr>
			<th class="col-head" width="150">明細名2</th>
			<td class="col-input">
				<?php echo $this->BcForm->input('Pmpage.other_payoff_name2', array('type'=>'text')) ?>
				<?php echo $this->BcForm->error('Pmpage.other_payoff_name2') ?>
			</td>
		</tr>
		<tr>
			<th class="col-head" width="150">明細金額2</th>
			<td class="col-input">
				<?php echo $this->BcForm->input('Pmpage.other_payoff_total2', array('type'=>'text')) ?>
				<?php echo $this->BcForm->error('Pmpage.other_payoff_total2') ?>
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
	<li>追加請求明細：月額保守とか、毎月定額で請求する明細。2つまで登録可能。明細名と金額のセットで有効。</li>
	<li>請求メール：カンマ区切りで複数指定可。</li>
	<li>マネーフォワード：登録はされるけど、更新はされない。MFの管理画面から直接更新する。</li>
</ul>
</div>