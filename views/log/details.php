<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\Log */

$this->title = $details[0]['name'] . ' - ' . $details[0]['updated_at'];
$this->params['breadcrumbs'][] = ['label' => 'История редактирование', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
?>
<div class="log-view">
    <h2>ТЕКУЩЕЕ СОСТОЯНИЕ</h2>
    <table class="table table-bordered">
        <tr>
            <th>Название страницы</th>
            <th>Описание страницы</th>
            <th>Превью страницы (изображение)</th>
            <th>HTML контент страницы</th>
        </tr>
        <tr>
            <td><?= $details[0]['name'] ?></td>
            <td><?= $details[0]['description'] ?></td>
            <td><a href="/uploads/preview/<?= $details[0]['preview'] ?>"><?= $details[0]['preview'] ?></a></td>
            <td><?= $details[0]['content'] ?></td>
        </tr>
    </table>
    <hr>
    <?php foreach($details as $detail): ?>
    <h2>СОСТОЯНИЕ в <?= $detail['sss'] ?></h2>
    <table class="table table-bordered">
        <tr>
            <th>Название страницы</th>
            <th>Описание страницы</th>
            <th>Превью страницы (изображение)</th>
            <th>HTML контент страницы</th>
        </tr>
        <tr>
            <?php $jsondata = json_decode($detail['attr_name']) ?>
            <td><?= $jsondata->name ?></td>
            <td><?= $jsondata->description ?></td>
            <td><a href="/uploads/preview/<?= $jsondata->preview ?>"><?= $jsondata->preview ?></a></td>
            <td><?= $jsondata->content ?></td>
        </tr>
    </table>
    <?php endforeach; ?>
</div>
