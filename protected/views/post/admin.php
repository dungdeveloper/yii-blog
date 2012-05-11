<?php
$this->breadcrumbs = array(
    'Manage',
);

$this->menu = array(
    array('label' => 'List Post', 'url' => array('index')),
    array('label' => 'Create Post', 'url' => array('create')),
);
?>

<h1>Manage Posts</h1>

<?php
$this->widget('zii.widgets.grid.CGridView', array(
    'id' => 'post-grid',
    'dataProvider' => $model->search(),
    'filter' => $model,
    'columns' => array(
        'title',
        array(
            'name' => 'status',
            'value' => '$data->getStatusName()',
            'filter' => $model->getStatusArray(),
        ),
        array(
            'name' => 'create_time',
            'value' => '$data->showCreateTime()',
            'filter' => $model->getCreateTimeArray(),
        ),
        array(
            'class' => 'CButtonColumn',
            'header' => 'Actions',            
        ),
    ),
));
?>
