<div class="form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'notes-form',
	'enableAjaxValidation'=>false,
)); ?>

<!--	<p class="note">Fields with <span class="required">*</span> are required.</p>-->

	<?php echo $form->errorSummary($model); ?>

	<div class="row">
		<?php echo $form->labelEx($model,'name'); ?>
		<?php echo $form->textArea($model,'name',array('rows'=>6, 'cols'=>50)); ?>
		<?php echo $form->error($model,'name'); ?>
	</div>

    <div class="row">
        <?php echo $form->labelEx($model,'tags'); ?>
        <?php $this->widget('CAutoComplete', array(
            'model'=>$model,
//            'canSetProperty'=> 'false',
            'attribute'=>'tags',
            'url'=>array('suggestTags'),
            'multiple'=>true,
            'htmlOptions'=>array('size'=>50),
        )); ?>
<!--        <p class="hint">Please separate different tags with commas.</p>-->
        <?php echo $form->error($model,'tags'); ?>
    </div>

<!--	<div class="row">-->
<!--		--><?php //echo $form->labelEx($model,'status'); ?>
<!--		--><?php //echo $form->textArea($model,'status',array('rows'=>6, 'cols'=>50)); ?>
<!--		--><?php //echo $form->error($model,'status'); ?>
<!--	</div>-->
<!---->
<!--	<div class="row">-->
<!--		--><?php //echo $form->labelEx($model,'create_time'); ?>
<!--		--><?php //echo $form->textField($model,'create_time'); ?>
<!--		--><?php //echo $form->error($model,'create_time'); ?>
<!--	</div>-->
<!---->
<!--	<div class="row">-->
<!--		--><?php //echo $form->labelEx($model,'update_time'); ?>
<!--		--><?php //echo $form->textField($model,'update_time'); ?>
<!--		--><?php //echo $form->error($model,'update_time'); ?>
<!--	</div>-->

	<div class="row buttons">
		<?php echo CHtml::submitButton($model->isNewRecord ? 'Create' : 'Save'); ?>
	</div>

    <div class = "row buttons">
        <?php

        echo CHtml::encode(Yii::app()->createUrl('profilepic/create'));

        ?>

    </div>


<?php $this->endWidget(); ?>

</div><!-- form -->