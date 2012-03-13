<h1>Layout Generator</h1>
<?php $form=$this->beginWidget('CCodeForm', array('model'=>$model)); ?>
 
    <div class="row">
        <?php echo $form->labelEx($model,'layoutName'); ?>
        <?php echo $form->textField($model,'layoutName',array('size'=>65)); ?>
        <div class="tooltip">
            Layout name must only contain word characters.
        </div>
        <?php echo $form->error($model,'layoutName'); ?>
    </div>
 
<?php $this->endWidget(); ?>