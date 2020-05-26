<?php

use yii\helpers\Html;
use yii\grid\GridView;
use kartik\daterange\DateRangePicker;
/* @var $this yii\web\View */
/* @var $searchModel app\models\LogSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Список изменений';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="log-index">


<!--    <p>-->
<!--        --><?//= Html::a('Create Log', ['create'], ['class' => 'btn btn-success']) ?>
<!--    </p>-->

    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn', 'header' => '№'],
            //'page_id',
            [
                'attribute' => 'page_id',
                'format' => 'html',
                'filter' => $pages,
                'value' => 'page.name'
            ],
            [
                'attribute' => 'updated_at',
                'format' => 'raw',
                'filter' => DateRangePicker::widget([
                    'name'=>'date_range_1',
                    'convertFormat'=>true,
                    'pluginOptions'=>[
                        'timePicker'=>false,
                        'timePickerIncrement'=>15,
                        'locale'=>['format'=>'Y-m-d']
                    ]
                ]),
            ],
            [
                'attribute' => 'updated_by',
                'format' => 'raw',
                'filter' => $users,
                'value' => 'user.username'
            ],
            [
                'attribute' => 'update_description:ntext',
                'format' => 'html',
                'value' => function($model){
                    return '<a href=/log/details?page_id='.$model->page_id.'>'.$model->update_description.'</a>';
                }
            ],
            //'status',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>


</div>
