<?php
/* @var $this BlogController */
/* @var $model Posts */

$this->breadcrumbs=array(
        'Posts' => $this->createUrl("/blog/posts"),
    'All Unpublished posts',
);
?>
<h1>Unpublished Posts</h1>
<p>Listing of all unpublished posts</p>
<div id="table-holder">
    <?php $this->widget('zii.widgets.grid.CGridView', array(
        'id'=>'all-my-tasks-grid',
        'dataProvider'=>$model->search(),
        'summaryText' => '<button id="publish">Publish</button>&nbsp;<button id="delete">Delete</button>&nbsp;',
        'selectableRows'=>0,
        'columns'=>array(
            array(
                'id'=>'id',
                'class'=>'CCheckBoxColumn',
                'selectableRows' => '50',
            ),
            array(
                'name' => 'title',
                'htmlOptions'=> array('align'=>'center'),
            ),
            array(
                'name' => 'excerpt',
            ),
            array(
                'name' => 'category',
            ),
            array(
                'name' => 'author',
            ),
            array(
                'name' => 'Created On',
                'value' => '$data->PostDate'
            ),
        ),
    )); ?>
</div>