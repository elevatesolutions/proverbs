<?php
use yii\helpers\Html;
use kartik\select2\Select2;
use app\models\ApplicantForm;
use app\models\ActiveRecord;
use app\models\StudentForm;
use yii\helpers\ArrayHelper;
use yii\bootstrap\ActiveForm;
?>

<div class="payment-form">
    <?php $form = ActiveForm::begin(); ?>
    <div class="row">
        <div class="container form-input-wrapper">
            <?= $form->field($model, 'transaction', ['inputTemplate' => '<label style="color: #555; padding-right: 15px;">Card</label>{input}'])
                ->checkbox($options = ['id' => 'it', 'class' => 'js-sw js-switch-small-green tsw', 
                'value' => 1,
                'data-switchery' => true, 
                ])->label(false) 
            ?>
         </div>
     </div>
    <div class="row">
        <div class="container form-input-wrapper">
            <div class="col-lg-4 col-md-4 col-sm-12">
                
            </div>
        </div>
    </div>
    <div class="row">
        <div class="container form-input-wrapper">
            <div class="col-lg-3 col-md-3 col-sm-12"><?= $form->field($model, 'paid_amount',  ['inputTemplate' => '<div class="input-group"><span class="input-group-addon"><span class="">Amount</span></span></span>{input}</div>', 'inputOptions' => ['placeholder' => '0']])->label(false)->textInput() ?></div>
        </div>
    </div>
    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
        <?= Html::a(Yii::t('app', 'Cancel'), ['/payments'], ['class' => 'btn btn-default']) ?>
    </div>
    <?php ActiveForm::end(); ?>
</div>
<?php
$sw = <<< JS
$(document).ready(function(){
    var switches = Array.prototype.slice.call(document.querySelectorAll('.js-switch'));

    switches.forEach(function(html) {
      var switchery = new Switchery(html);
    });

    var hash = '#';
    var blank = '';

    function syncValue(object){
        if(object.value !== object.previousElementSibling){
            object.previousElementSibling.value = object.value;
        }
    }

    $('input.js-sw').each(function(){
        var elem = $(this).attr('class').split(' ').pop();
        var temp = '.' + $(this).attr('class').split(' ').pop();
        
        var elem = document.querySelector(temp);
        
        syncValue(elem);

        elem.onchange = function() { 
            if(elem.checked){
                $(hash + elem.id).val(0);
                $(hash + elem.id).prev().val(0);
            } else {
                $(hash + elem.id).val(1);
                $(hash + elem.id).prev().val(1);
            }
        };
    });
});
JS;
$this->registerJs($sw);
?>