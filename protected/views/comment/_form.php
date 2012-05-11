<div class="form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'comment-form',
	'enableAjaxValidation'=>false,
)); ?>

	<p class="note">Fields with <span class="required">*</span> are required.</p>

	<?php echo $form->errorSummary($model); ?>

	<div class="row">
		<?php echo $form->labelEx($model,'author_name'); ?>
		<?php echo $form->textField($model,'author_name',array('size'=>60,'maxlength'=>256)); ?>
		<?php echo $form->error($model,'author_name'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'author_email'); ?>
		<?php echo $form->textField($model,'author_email',array('size'=>60,'maxlength'=>256)); ?>
		<?php echo $form->error($model,'author_email'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'author_url'); ?>
		<?php echo $form->textField($model,'author_url',array('size'=>60,'maxlength'=>256)); ?>
		<?php echo $form->error($model,'author_url'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'content'); ?>
		<?php echo $form->textArea($model,'content',array('rows'=>10, 'cols'=>50)); ?>
		<?php echo $form->error($model,'content'); ?>
	</div>
    
    <?php if ($this->action->id == 'update'): ?>
        <div class="row">
            <?php echo $form->labelEx($model,'status'); ?>
            <?php echo $form->dropDownList($model,'status', $model->getStatusArray()); ?>
            <?php echo $form->error($model,'status'); ?>
        </div>    
    <?php endif; ?>

	<div class="row buttons">
		<?php echo CHtml::submitButton($model->isNewRecord ? 'Submit' : 'Save'); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- form -->