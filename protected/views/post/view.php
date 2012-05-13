<?php
$this->breadcrumbs=array(
	$model->title,
);

$this->menu=array(
	array('label'=>'Manage Post', 'url'=>array('admin')),
    array('label'=>'Manage Comment', 'url'=>array('/comment/admin')),
);
?>

<h1>View Post #<?php echo $model->id; ?></h1>

<?php $this->widget('zii.widgets.CDetailView', array(
	'data'=>$model,
	'attributes'=>array(
		'id',
		'title',
		'content',
		'status',
		'tags',
		'create_time',
		'update_time',
		'user_id',
	),
)); ?>

<!-- Comments -->
<h1>Comments</h1>
<?php $this->widget('zii.widgets.CListView', array(
	'dataProvider'=>$dataProvider,
	'itemView'=>'../comment/_view',
)); ?>

<?php
$user = Yii::app()->user;
if ($user->hasFlash('comment')) {
    echo $user->getFlash('comment');
}
?>
<?php $this->renderPartial('../comment/_form', array('model'=>$modelComment));?>