<h1>Content Generator</h1>
<?php $form=$this->beginWidget('CCodeForm', array('model'=>$model)); ?>
 
    <div class="row">
        <?php echo $form->labelEx($model,'contentName'); ?>
        <?php echo $form->textField($model,'contentName',array('size'=>65)); ?>
        <div class="tooltip">
            Content class name must only contain word characters.
        </div>
        <?php echo $form->error($model,'contentName'); ?>
    </div>
    <div class="row">
        <?php echo $form->labelEx($model,'contentId'); ?>
        <?php echo $form->textField($model,'contentId',array('size'=>65)); ?>
        <div class="tooltip">
            Content ID must only contain word characters.
        </div>
        <?php echo $form->error($model,'contentId'); ?>
    </div>
 
<?php $this->endWidget(); ?>