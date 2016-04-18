<?php

use yii\helpers\Html;
use app\models\UiListView;
use yii\widgets\Pjax;
/* @var $this yii\web\View */
/* @var $searchModel app\models\ApplicantFormSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Students';
?>
<p></p>
<div class="ui two column stackable grid">
    <div class="twelve wide rounded column">
        <div class="panel panel-default">
            <div class="panel-body">
            <div class="pull-left"><h4>Students</h4></div>
            <div class="pull-right"><?= Html::a('<i class="icon plus"></i>',['create'],['class' => 'ui large green icon button']) ?></div>
            <p></p>
            <br>
            <?= Html::a('','#',['id' => 'trig', 'class' => 'hidden']) ?>
            <?php Pjax::begin(['id' => 'student-list', 'timeout' => 5000, 'enablePushState' => false]); ?>
                <?= UiListView::widget([
                       'dataProvider' => $dataProvider,
                        'itemView' => '_list',
                    ]); ?>
            <?php Pjax::end(); ?>
            </div>
        </div>
    </div>
    <div class="four wide column">
        <?= $this->render('_search', ['model' => $searchModel]) ?>
    </div>
</div>
<?= $this->render('_pjax')?>