<?php
/**
 * マジックリンク専用レイアウト
 * タイトルタグを変えただけ。
 */
?>
<?php $this->BcBaser->docType('html5') ?>
<html>
<head>
	<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
	<?php $this->BcBaser->charset() ?>
	<title><?php echo $ml_title ?></title>
	<?php $this->BcBaser->js(array()); ?>
	<?php $this->BcBaser->scripts() ?>
	<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.0/css/bootstrap.min.css" integrity="sha384-9gVQ4dYFwwWSjIDZnLEWnxCjeSWFphJiwGPXr1jddIhOegiu1FwO5qRGvFXOdJZ4" crossorigin="anonymous">
	<link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.0.10/css/all.css" integrity="sha384-+d0P83n9kaQMCwj8F4RJB66tzIwOKmrdb46+porD/OvrJ+37WqIM7UoBtwHO6Nlg" crossorigin="anonymous">
	<?php $this->BcBaser->css(array('style', 'jpn.min.css')) ?>
	
	<script src="https://code.jquery.com/jquery-3.3.1.min.js" integrity="sha256-FgpCb/KJQlLNfOu91ta32o/NMZxltwRo8QtmkMRdAu8=" crossorigin="anonymous"></script>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.0/umd/popper.min.js" integrity="sha384-cs/chFZiN24E4KMATLdqdvsezGxaGsi4hLGOzlXwp5UZB1LY//20VyM2taTB4QvJ" crossorigin="anonymous"></script>
	<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.0/js/bootstrap.min.js" integrity="sha384-uefMccjFJAIv6A+rW+L4AHf99KvxDjWSu1z9VI8SKNVmz4sk7buKt/6v9KI65qnm" crossorigin="anonymous"></script>
	<script src="https://cdn.jsdelivr.net/jquery.loadingoverlay/latest/loadingoverlay.min.js"></script>
	<script>
      $(function() {
          $("form").on('submit', function(){
              $.LoadingOverlay("show");
          });
      });
    </script>
</head>
<body id="<?php $this->BcBaser->contentsName() ?>">
	<!-- /Elements/header.php -->
	<?php $this->BcBaser->header() ?>
	<main role="main">
	
	<?php if ($this->BcBaser->isHome()): ?>
		<div class="jumbotron jumbotron-extend align-text-bottom">
			<div class="pt-sm-1 pt-5">
			    <h4 class="display-4 mt-sm-1 mt-5 pt-sm-1 pt-5">Perfect time!</h4>
			    <p class="lead">nice work!</p>
			</div>
			
		</div>
	<?php endif ?>
	<div class="container my-3 my-sm-5">
	<div class="row">
		<div class="col-md-9">
			<?php $this->BcBaser->flash() ?>
			<?php $this->BcBaser->content() ?>
		</div>
		<div class="col-md-3">
			<!-- /Elements/widget_area.php -->
			<?php $this->BcBaser->widgetArea() ?>
		</div>
	</div>

	</div>
	<!-- /Elements/footer.php -->
	<?php $this->BcBaser->footer() ?>
	</main>

<?php //$this->BcBaser->func() ?>
</body>
</html>
