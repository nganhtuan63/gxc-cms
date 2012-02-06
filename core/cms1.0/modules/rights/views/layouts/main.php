<?php $this->beginContent(Rights::module()->appLayout); ?>

<div id="rights" class="container">

	<div id="content">

		<?php if( $this->id!=='install' ): ?>
                       <?php Yii::app()->controller->menu= array(
                                    array(
                                            'label'=>Rights::t('core', 'Assignments'),
                                            'url'=>array('assignment/view'),
                                            'itemOptions'=>array('class'=>'item-assignments'),
                                            'linkOptions'=>array('class'=>'button'),
                                    ),
                                    array(
                                            'label'=>Rights::t('core', 'Permissions'),
                                            'url'=>array('authItem/permissions'),
                                            'itemOptions'=>array('class'=>'item-permissions'),
                                            'linkOptions'=>array('class'=>'button'),
                                    ),
                                    array(
                                            'label'=>Rights::t('core', 'Roles'),
                                            'url'=>array('authItem/roles'),
                                            'itemOptions'=>array('class'=>'item-roles'),
                                            'linkOptions'=>array('class'=>'button'),
                                    ),
                                    array(
                                            'label'=>Rights::t('core', 'Tasks'),
                                            'url'=>array('authItem/tasks'),
                                            'itemOptions'=>array('class'=>'item-tasks'),
                                            'linkOptions'=>array('class'=>'button'),
                                    ),
                                    array(
                                            'label'=>Rights::t('core', 'Operations'),
                                            'url'=>array('authItem/operations'),
                                            'itemOptions'=>array('class'=>'item-operations'),
                                            'linkOptions'=>array('class'=>'button'),
                                    ),
                            ); 
                       ?>
			

		<?php endif; ?>

		<?php $this->renderPartial('/_flash'); ?>

		<?php echo $content; ?>

	</div><!-- content -->

</div>

<?php $this->endContent(); ?>