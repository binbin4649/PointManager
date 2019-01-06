
━━━━━━━━━━━━━━━━━━━━━━━━━━
ユーザー新規登録
━━━━━━━━━━━━━━━━━━━━━━━━━━

会員番号：<?php echo $PmUser['mypage_id']."\n" ?>
お名前：<?php echo $Mypage['name']."\n" ?>
メールアドレス：<?php echo $Mypage['email']."\n" ?>
パスワード：<?php echo $Mypage['password']."\n" ?>

ログインはこちら
<?php echo $this->BcBaser->siteUrl(); ?>members/mypages/login


登録者（管理者）
<?php echo $Admin['name']."\n" ?>
<?php echo $Admin['email']."\n" ?>



【使い方】
ユーザーのログイン、簡単ログインの設定方法
<?php echo $this->BcBaser->siteUrl(); ?>feature/user_login

コールの設定方法
<?php echo $this->BcBaser->siteUrl(); ?>feature/call_setting

コールの予約方法
<?php echo $this->BcBaser->siteUrl(); ?>feature/call_reserve

コールの一括予約のやり方
<?php echo $this->BcBaser->siteUrl(); ?>feature/call_bulk_reserve

ユーザー編集について
<?php echo $this->BcBaser->siteUrl(); ?>feature/user_edit
