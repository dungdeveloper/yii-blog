<?php
$this->breadcrumbs = array('Login');
?>

<h1>Login</h1>

<div class="form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'login-form-login-form',
	'enableAjaxValidation'=>false,
)); ?>

	<p class="note">Fields with <span class="required">*</span> are required.</p>

	<?php echo $form->errorSummary($model); ?>

	<div class="row">
		<?php echo $form->labelEx($model,'email'); ?>
		<?php echo $form->textField($model,'email', array('size'=>40)); ?>
		<?php echo $form->error($model,'email'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'password'); ?>
		<?php echo $form->passwordField($model,'password', array('size'=>40)); ?>
		<?php echo $form->error($model,'password'); ?>
	</div>

	<div class="row rememberMe">
        <?php echo $form->checkBox($model,'rememberMe'); ?>
		<?php echo $form->labelEx($model,'rememberMe'); ?>		
		<?php echo $form->error($model,'rememberMe'); ?>
	</div>


	<div class="row buttons">
		<?php echo CHtml::submitButton('Submit'); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- form -->