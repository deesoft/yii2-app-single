<?php

use yii\web\View;
use yii\helpers\Html;

/* @var $this View */
?>
<h1>migrate/<?= $id ?></h1>
<?= Html::beginForm() ?>
<div class="row">
    <div class="col-md-12">
        <table class="table table-striped">
            <thead>
                <tr>
                    <th style="width: 60%">Migrations</th>
                    <th>#</th>
                </tr>
            </thead>
            <tbody id="migration-list">
                <?php foreach ($migrations as $migration): ?>
                    <tr>
                        <td><?= $migration ?></td>
                        <td><?= Html::checkbox('migrations[]', false, ['value' => substr($migration, 1, 13)]) ?></td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
    <div class="col-md-12">
        <?= Html::submitButton('Execute', ['class' => $id == 'up' ? 'btn btn-success' : 'btn btn-danger']) ?>
    </div>
    <div class="col-md-12">
        <?= isset($result) ? $result : '' ?>
    </div>
</div>
<?= Html::endForm(); ?>
