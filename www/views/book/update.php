<?php

use yii\helpers\Html;

/** @var yii\web\View $this */
/** @var app\request\BookUpdateRequest $request */

$this->title = 'Update Book: ' . $request->name;
$this->params['breadcrumbs'][] = ['label' => 'Books', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $request->name, 'url' => ['view', 'id' => $request->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="book-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'request' => $request,
    ]) ?>

</div>
