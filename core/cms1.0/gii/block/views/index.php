<h1>Block Generator</h1>
<?php $form=$this->beginWidget('CCodeForm', array('model'=>$model)); ?>
 
    <div class="row">
        <?php echo $form->labelEx($model,'blockName'); ?>
        <?php echo $form->textField($model,'blockName',array('size'=>65)); ?>
        <div class="tooltip">
            Block name must only contain word characters.
        </div>
        <?php echo $form->error($model,'blockName'); ?>
    </div>
 
<?php $this->endWidget(); ?>