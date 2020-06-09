<?php
/* @var $this EventsController */
/* @var $model Events */


$this->breadcrumbs=array(
    'All Events' => $this->createUrl('/events/'),
    $model->title => $this->createUrl('/events/view/',['id'=>$model->id]),
    'Registration'
);
?>
    <h1>Register to <?php echo $model->title;?></h1>
    <p>Register to event</p>
<?php $this->renderPartial('_attendee',['attendeeModel'=>$attendeeModel,'model'=>$model]);?>