<div name="div-block-content-<?php echo $block_model->id;?>">
    <?php echo CHtml::label(Block::getLabel($block_model,'menu_id'),''); ?>
    <?php echo CHtml::dropDownList("Block[menu_id]",
                                $block_model->menu_id,
                                MenuBlock::findMenu(),
                               array(
                                'id'=>'Block-menu_id',
                                 )); ?>
    <?php echo $form->error($model,'menu_id'); ?>
</div>