<?php $this->BcBaser->css(array('Members.members'), array('inline' => false)); ?>
<?php
if ($this->Session->check('Message.auth')) {
	$this->Session->flash('auth');
}
?>
<?php $this->BcBaser->flash() ?>
<div id="AlertMessage" class="message" style="display:none"></div>
<h1 class="h5 border-bottom py-3 mb-1 mb-md-3 text-secondary">管理者編集</h1>
<h2 class="h6 border-bottom py-3 mb-1 mb-md-3 text-secondary">ログイン情報</h2>
<?php echo $this->BcForm->create('PmUser', array('class' => 'form-group')) ?>
<div class="row mb-3">
	<div class="col-md-4 text-md-right">
		<?php echo $this->BcForm->label('Mypage.id', '会員番号') ?>
	</div>
	<div class="col-md-4">
		<?php echo $this->request->data['Mypage']['id'] ?>
		<?php echo $this->BcForm->input('Mypage.id', array('type' => 'hidden')) ?>
		<?php echo $this->BcForm->input('Pmpage.id', array('type' => 'hidden')) ?>
	</div>
	<div class="col-md-4"></div>
</div>
<div class="row mb-3">
	<div class="col-md-4 text-md-right">
		<?php echo $this->BcForm->label('Mypage.email', 'メールアドレス') ?>
	</div>
	<div class="col-md-6">
		<?php echo $this->BcForm->input('Mypage.email', array('type'=>'text', 'class' => 'form-control')) ?>
		<small class="form-text">(ログインID)</small>
		<?php echo $this->BcForm->error('Mypage.email') ?>
	</div>
	<div class="col-md-2"></div>
</div>
<div class="row mb-3">
	<div class="col-md-4 text-md-right">
		<?php echo $this->BcForm->label('Mypage.password', 'パスワード') ?>
	</div>
	<div class="col-md-4">
		<?php echo $this->BcForm->input('Mypage.password', array('type'=>'password', 'class' => 'form-control', 'placeholder'=>'半角英数、6文字以上。')) ?>
		<small class="form-text text-danger">変更する場合のみ入力してください。</small>
		<?php echo $this->BcForm->error('Mypage.password') ?>
	</div>
	<div class="col-md-4">
		<?php echo $this->BcForm->input('Mypage.password_confirm', array('type'=>'password', 'class'=>'form-control', 'placeholder'=>'Retype password')) ?>
	</div>
</div>
<h2 class="h6 border-bottom py-3 mb-1 mb-md-3 text-secondary">会社・担当者</h2>
<div class="row mb-3">
	<div class="col-md-4 text-md-right">
		<?php echo $this->BcForm->label('Pmpage.company_name', '会社名') ?>
	</div>
	<div class="col-md-6">
		<?php echo $this->BcForm->input('Pmpage.company_name', array('type'=>'text', 'class' => 'form-control')) ?>
		<?php echo $this->BcForm->error('Pmpage.company_name') ?>
	</div>
	<div class="col-md-2"></div>
</div>
<div class="row mb-3">
	<div class="col-md-4 text-md-right">
		<?php echo $this->BcForm->label('Mypage.zip', '郵便番号') ?>
	</div>
	<div class="col-md-4">
		<?php echo $this->BcForm->input('Mypage.zip', array('type'=>'text', 'class' => 'form-control')) ?>
		<?php echo $this->BcForm->error('Mypage.zip') ?>
	</div>
	<div class="col-md-4"></div>
</div>
<div class="row mb-3">
	<div class="col-md-4 text-md-right">
		<?php echo $this->BcForm->label('Pmpage.prefecture', '都道府県') ?>
	</div>
	<div class="col-md-4">
		<?php echo $this->BcForm->input('Pmpage.prefecture', array('type'=>'select', 'options'=>$prefecture, 'empty'=>'---', 'class'=>'form-control')) ?>
		<?php echo $this->BcForm->error('Pmpage.prefecture') ?>
	</div>
	<div class="col-md-4"></div>
</div>
<div class="row mb-3">
	<div class="col-md-4 text-md-right">
		<?php echo $this->BcForm->label('Mypage.address_1', '住所1') ?>
	</div>
	<div class="col-md-8">
		<?php echo $this->BcForm->input('Mypage.address_1', array('type'=>'text', 'class' => 'form-control')) ?>
		<small class="form-text">市区町村、町名番地</small>
		<?php echo $this->BcForm->error('Mypage.address_1') ?>
	</div>
</div>
<div class="row mb-3">
	<div class="col-md-4 text-md-right">
		<?php echo $this->BcForm->label('Mypage.address_2', '住所2') ?>
	</div>
	<div class="col-md-8">
		<?php echo $this->BcForm->input('Mypage.address_2', array('type'=>'text', 'class' => 'form-control')) ?>
		<small class="form-text">建物、階数、部屋番号</small>
		<?php echo $this->BcForm->error('Mypage.address_2') ?>
	</div>
</div>
<div class="row mb-3">
	<div class="col-md-4 text-md-right">
		<?php echo $this->BcForm->label('Mypage.tel', '電話番号') ?>
	</div>
	<div class="col-md-4">
		<?php echo $this->BcForm->input('Mypage.tel', array('type'=>'text', 'class' => 'form-control')) ?>
		<?php echo $this->BcForm->error('Mypage.tel') ?>
	</div>
	<div class="col-md-4"></div>
</div>
<div class="row mb-3">
	<div class="col-md-4 text-md-right">
		<?php echo $this->BcForm->label('Mypage.name', '担当者名') ?>
	</div>
	<div class="col-md-4">
		<?php echo $this->BcForm->input('Mypage.name', array('type'=>'text', 'class' => 'form-control')) ?>
		<?php echo $this->BcForm->error('Mypage.name') ?>
	</div>
	<div class="col-md-4"></div>
</div>
<div class="row mb-3">
	<div class="col-md-4 text-md-right">
		<?php echo $this->BcForm->label('Pmpage.department_name', '担当部署名') ?>
	</div>
	<div class="col-md-4">
		<?php echo $this->BcForm->input('Pmpage.department_name', array('type'=>'text', 'class' => 'form-control')) ?>
		<?php echo $this->BcForm->error('Pmpage.department_name') ?>
	</div>
	<div class="col-md-4"></div>
</div>
<div class="row mb-3">
	<div class="col-md-4 text-md-right">
		<?php echo $this->BcForm->label('Pmpage.position_name', '担当役職名') ?>
	</div>
	<div class="col-md-4">
		<?php echo $this->BcForm->input('Pmpage.position_name', array('type'=>'text', 'class' => 'form-control')) ?>
		<?php echo $this->BcForm->error('Pmpage.position_name') ?>
	</div>
	<div class="col-md-4"></div>
</div>
<h2 class="h6 border-bottom py-3 text-secondary">請求先情報</h2>
<div class="mb-3">
	<small>
		請求先が上記会社情報と異なる場合に入力してください。
	</small>
</div>
<div class="row mb-3">
	<div class="col-md-4 text-md-right">
		<?php echo $this->BcForm->label('Pmpage.invoice_company_name', '請求先会社名') ?>
	</div>
	<div class="col-md-6">
		<?php echo $this->BcForm->input('Pmpage.invoice_company_name', array('type'=>'text', 'class' => 'form-control')) ?>
		<?php echo $this->BcForm->error('Pmpage.invoice_company_name') ?>
	</div>
	<div class="col-md-2"></div>
</div>
<div class="row mb-3">
	<div class="col-md-4 text-md-right">
		<?php echo $this->BcForm->label('Pmpage.invoice_zip', '請求先郵便番号') ?>
	</div>
	<div class="col-md-4">
		<?php echo $this->BcForm->input('Pmpage.invoice_zip', array('type'=>'text', 'class' => 'form-control')) ?>
		<?php echo $this->BcForm->error('Pmpage.invoice_zip') ?>
	</div>
	<div class="col-md-4"></div>
</div>
<div class="row mb-3">
	<div class="col-md-4 text-md-right">
		<?php echo $this->BcForm->label('Pmpage.invoice_prefecture', '都道府県') ?>
	</div>
	<div class="col-md-4">
		<?php echo $this->BcForm->input('Pmpage.invoice_prefecture', array('type'=>'select', 'options'=>$prefecture, 'empty'=>'---', 'class'=>'form-control')) ?>
		<?php echo $this->BcForm->error('Pmpage.invoice_prefecture') ?>
	</div>
	<div class="col-md-4"></div>
</div>
<div class="row mb-3">
	<div class="col-md-4 text-md-right">
		<?php echo $this->BcForm->label('Pmpage.invoice_address_1', '請求先住所1') ?>
	</div>
	<div class="col-md-8">
		<?php echo $this->BcForm->input('Pmpage.invoice_address_1', array('type'=>'text', 'class' => 'form-control')) ?>
		<small class="form-text">市区町村、町名番地</small>
		<?php echo $this->BcForm->error('Pmpage.invoice_address_1') ?>
	</div>
</div>
<div class="row mb-3">
	<div class="col-md-4 text-md-right">
		<?php echo $this->BcForm->label('Pmpage.invoice_address_2', '請求先住所2') ?>
	</div>
	<div class="col-md-8">
		<?php echo $this->BcForm->input('Pmpage.invoice_address_2', array('type'=>'text', 'class' => 'form-control')) ?>
		<small class="form-text">建物、階数、部屋番号</small>
		<?php echo $this->BcForm->error('Pmpage.invoice_address_2') ?>
	</div>
</div>
<div class="row mb-3">
	<div class="col-md-4 text-md-right">
		<?php echo $this->BcForm->label('Pmpage.invoice_tel', '請求先電話番号') ?>
	</div>
	<div class="col-md-4">
		<?php echo $this->BcForm->input('Pmpage.invoice_tel', array('type'=>'text', 'class' => 'form-control')) ?>
		<?php echo $this->BcForm->error('Pmpage.invoice_tel') ?>
	</div>
	<div class="col-md-4"></div>
</div>
<div class="row mb-3">
	<div class="col-md-4 text-md-right">
		<?php echo $this->BcForm->label('Pmpage.invoice_name', '請求先担当者名') ?>
	</div>
	<div class="col-md-4">
		<?php echo $this->BcForm->input('Pmpage.invoice_name', array('type'=>'text', 'class' => 'form-control')) ?>
		<?php echo $this->BcForm->error('Pmpage.invoice_name') ?>
	</div>
	<div class="col-md-4"></div>
</div>
<div class="row mb-3">
	<div class="col-md-4 text-md-right">
		<?php echo $this->BcForm->label('Pmpage.invoice_department_name', '請求先部署名') ?>
	</div>
	<div class="col-md-4">
		<?php echo $this->BcForm->input('Pmpage.invoice_department_name', array('type'=>'text', 'class' => 'form-control')) ?>
		<?php echo $this->BcForm->error('Pmpage.invoice_department_name') ?>
	</div>
	<div class="col-md-4"></div>
</div>
<div class="row mb-3">
	<div class="col-md-4 text-md-right">
		<?php echo $this->BcForm->label('Pmpage.invoice_position_name', '請求先担当役職名') ?>
	</div>
	<div class="col-md-4">
		<?php echo $this->BcForm->input('Pmpage.invoice_position_name', array('type'=>'text', 'class' => 'form-control')) ?>
		<?php echo $this->BcForm->error('Pmpage.invoice_position_name') ?>
	</div>
	<div class="col-md-4"></div>
</div>
<div class="row mb-3">
	<div class="col-md-4 text-md-right">
		<?php echo $this->BcForm->label('Pmpage.invoice_email', '請求先メールアドレス') ?>
	</div>
	<div class="col-md-6">
		<?php echo $this->BcForm->input('Pmpage.invoice_email', array('type'=>'text', 'class' => 'form-control')) ?>
		<?php echo $this->BcForm->error('Pmpage.invoice_email') ?>
	</div>
	<div class="col-md-2"></div>
</div>


<div class="text-center my-3 pt-3">
	<?php echo $this->BcForm->submit('編集', array('div' => false, 'class' => 'btn btn-lg btn-primary btn-e', 'id' => 'BtnLogin')) ?>
</div>
<?php echo $this->BcForm->end() ?>

<div class="my-3 p-1 p-sm-4">
	<small>
		請求メールは、カンマ区切りで複数アドレス入力することができます。
	</small>
</div>