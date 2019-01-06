<?php $this->BcBaser->css(array('Members.members'), array('inline' => false)); ?>
<?php
if ($this->Session->check('Message.auth')) {
	$this->Session->flash('auth');
}
?>
<?php $this->BcBaser->flash() ?>
<div id="AlertMessage" class="message" style="display:none"></div>
<h1 class="h5 border-bottom py-3 mb-1 mb-md-3 text-secondary"><?php echo $this->pageTitle ?></h1>
<?php echo $this->BcForm->create('PmUser', array('class' => 'form-group')) ?>
<div class="row mb-3">
	<div class="col-md-4 text-md-right">
		<?php echo $this->BcForm->label('Mypage.id', '会員番号') ?>
	</div>
	<div class="col-md-4">
		<?php echo $this->request->data['Mypage']['id'] ?>
		<?php echo $this->BcForm->input('Mypage.id', array('type' => 'hidden')) ?>
	</div>
	<div class="col-md-4"></div>
</div>

<div class="row mb-3">
	<div class="col-md-4 text-md-right">
		<?php echo $this->BcForm->label('Mypage.name', '名前') ?>
	</div>
	<div class="col-md-4">
		<?php echo $this->BcForm->input('Mypage.name', array('type'=>'text', 'class' => 'form-control')) ?>
		<small class="form-text text-muted">カタカナ</small>
		<?php echo $this->BcForm->error('Mypage.name') ?>
	</div>
	<div class="col-md-4"></div>
</div>
<div class="row mb-3">
	<div class="col-md-4 text-md-right">
		<?php echo $this->BcForm->label('Mypage.email', 'メールアドレス') ?>
	</div>
	<div class="col-md-4">
		<?php echo $this->BcForm->input('Mypage.email', array('type'=>'text', 'class' => 'form-control')) ?>
		<?php echo $this->BcForm->error('Mypage.email') ?>
	</div>
	<div class="col-md-4"></div>
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
<div class="row mb-3">
	<div class="col-md-4 text-md-right">
	</div>
	<div class="col-md-4 form-check form-check-inline mx-4 mx-sm-2">
		<?php echo $this->BcForm->input('Mypage.delete', array('type'=>'checkbox', 'class' => 'form-check-input mr-3')) ?>
		<label class="form-check-label">ユーザー削除</label>
	</div>
	<div class="col-md-4"></div>
</div>
<div class="text-center my-3 pt-3">
	<?php echo $this->BcForm->submit('編集', array('div' => false, 'class' => 'btn btn-lg btn-primary btn-e', 'id' => 'BtnLogin')) ?>
</div>
<?php echo $this->BcForm->end() ?>

<div class="my-3 p-1 p-sm-4">
	<small>
		ユーザー削除は取り消すことができません。十分ご注意ください。<br>
		削除すると、そのユーザーの今後の予約も全て削除されます。<br>
		未精算のポイントが残っている場合、精算が完了するまで一覧には表示され、精算後に非表示となります。
	</small>
</div>