<?php
/* @var $this ToDoController */
/* @var $model Events */


if($model->isNewRecord){
    $this->breadcrumbs=array(
        'All Events' => $this->createUrl('/events/'),
        'Attendees'
    );
}else{
    $this->breadcrumbs=array(
        'All Events' => $this->createUrl('/events/'),
        $model->title => $this->createUrl('/events/view',['id'=>$model->id]),
        'Attendees'
    );
}
?>
<h1>All Attendees</h1>
<p>List of attendees</p>
<?php $this->renderPartial('_attendee',['attendeeModel'=>$attendeeModel]);?>

<br>
<div id="table-holder">
    <h5>Event Attendees Lising</h5>
    <?php $this->widget('zii.widgets.grid.CGridView', array(
        'id'=>'all-my-tasks-grid',
        'dataProvider'=>EventAttendees::model()->getAllByEvent($attendeeModel->event_id),
        'summaryText' => 'Event Attendees &nbsp;<button id="delete-attendees">Delete Attendees</button>&nbsp;',
        'selectableRows'=>0,
        'columns'=>array(
            array(
                'id'=>'id',
                'class'=>'CCheckBoxColumn',
                'selectableRows' => '50',
            ),
            array(
                'name' => 'first_name',
            ),
            array(
                'name' => 'last_name',

            ),
            array(
                'name' => 'email',
            ),
            array(
                'name' => 'contact',
            ),
            array(
                'name' => 'Event',
                'value' => '$data->eventname'
            ),
        ),
    )); ?>
</div>
<script>
    $(document).ready(function(){
        $('#table-holder').on('click','#delete-attendees',function(){
            var val = [];
            $('input[name=\"id[]\"]:checked:enabled').each(function(i){
                val[i] = $(this).val();
            });
            if(val.length == 0){
                alert('Please select at least one record!');
                return false;
            }else {
                var c = confirm('Are you sure you want to delete these attendees?');
                if( c ){
                    var ids  = 'ids/'+val.join(',');
                    $.get('/events/DeleteAttendees/'+ids)
                        .done(function(){
                            $.fn.yiiGridView.update("all-my-tasks-grid", {
                                data: $(this).serialize()
                            });
                        });
                }
            }
            return false;
        });
    });
</script>