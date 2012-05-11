<?php
$this->breadcrumbs=array(
	'Comments'=>array('index'),
	'Manage',
);

$this->menu=array(
	array('label'=>'List Comment', 'url'=>array('index')),
	array('label'=>'Create Comment', 'url'=>array('create')),
);

?>

<h1>Manage Comments</h1>

<?php $this->widget('zii.widgets.grid.CGridView', array(
	'id'=>'comment-grid',
	'dataProvider'=>$model->with('post')->search(),
	'filter'=>$model,
	'columns'=>array(
		'author_name',
		'author_email',
		'author_url',
		'content',
		array(
            'name' => 'status',
            'value' => '$data->getStatusName()',
            'filter' => Comment::model()->getStatusArray(),
        ),
		array(
            'name' => 'create_time',
            'value' => '$data->showCreateTime()',
            'filter' => Comment::model()->getCreateTimeArray(),
        ),
		array(
            'name' => 'post_title',
            'value' => '$data->getPostLink()',
            'type' => 'html',
        ),
		array(
            'header' => 'Actions',
			'class'=>'CButtonColumn',
		),
	),
)); ?>
