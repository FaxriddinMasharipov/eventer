<?php

/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */
/* @var $model \frontend\models\SignupForm */

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
use frontend\models\User;

$this->title = '';

?>
<div  style="margin: 2px; background-color: rgba(43,106,246,0.77);">
    <table class="useradd table table-bordered">
        <tbody>
         <tr>
            <th>Nomi <button  data-toggle="modal" data-target="#myModal" class="addmodal btn btn-success">+</button></th>
            <th>Email</th>
            <th colspan='2' text-align='center'>Funksiyalar</th>
        </tr>
           
        </tbody>
        <?php
        $i = 0;
        foreach ($slave as $sl):
            ?>
            <tr style="background-color:#B6E8F8;" id="<?=$sl['id'];?>" class="slqator-<?=$sl['id'];?>">
                <td>
                    <span class="main<?=$sl['id'];?>"><?=$sl['username']?></span>
                </td>   
                <td>
                    <span class="qrkod<?=$sl['id'];?>"><?=$sl['email']?></span>
                </td>             
                <td>
                    <button type="button" class="edit btn btn-primary" data-toggle="modal" data-target="#myModal"><span class="glyphicon glyphicon-pencil"></span></button>
                </td>
                <td>
                    <button type="button" class="delete btn btn-danger" data-toggle="modal" data-target="#modaldelete"><span class="glyphicon glyphicon-trash"></span></button>
                </td>              
            </tr>                                
        <?php endforeach;?>
    </table>
</div>
<div class="container mt-3">
    <div class="modal fade" id="myModal">
        <div class="modal-dialog">
        <div class="modal-content">
        <div class="modal-header">
            <h4 class="modal-title">User qo'shish</h4>
            <button type="button" class="close" data-dismiss="modal">×</button>
        </div>
        <div class="modal-body">
            <?php $form = ActiveForm::begin(['id' => 'form-signup']); ?>

                <?= $form->field($model, 'username')->textInput(['autofocus' => true]) ?>

                <?= $form->field($model, 'email') ?>

                <?= $form->field($model, 'password')->passwordInput() ?>
                 <label>Korxona</label>
                 <?php
                    echo \kartik\select2\Select2::widget([
                    'name' => 's_client',
                    'id' => 's_client',
                    'data' => $s_client,
                    'value'=>0,
                    'options' => ['placeholder' => 'Korxona nomi...','style'=>['; display:""', 'width' => '80%']],
                    'pluginOptions' => ['allowClear' => true ]]);
                 ?><br>
                <div class="modal-footer">
                    <?= Html::submitButton('Saqlash', ['class' => 'btn btn-success', 'name' => 'signup-button']) ?>
                    <button type="button" class="btn btn-danger" data-dismiss="modal">Bekor qilish</button>
                </div>
            <?php ActiveForm::end(); ?>
        </div>
    </div>
</div>
           
        </div>
    </div>
  </div>  
</div>
<div class="container">
  <div class="modal fade" id="modaldelete">
    <div class="modal-dialog modal-sm">
      <div class="modal-content">
         <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal">&times;</button>
            <h4>O'chirish</h4>
        </div>
        <div class="modal-body">
          <h5>Siz haqiqatdan ham o'chirmoqchimisiz ?</h5>
          <input type="hidden" name="deleteid" id="deleteid"/>
        </div>
        <div class="modal-footer">
          <button type="button" name="deletesave" class="deletesave btn btn-success">O'chirish</button>
          <button type="button" class="btn btn-danger" data-dismiss="modal">Bekor qil </button>
        </div>
      </div>
    </div>
  </div>
</div>
<script type="text/javascript">
/*    $(document).find('.addmodal').on('click', function(e){
        e.preventDefault();
        $("#s_client").val('');
   });  */
/*     $(document).find('.modalsave').on('click',function(e){
        e.preventDefault();
        $s_client = $("#s_client").val();    
       $.ajax({
            url: '<?php echo Yii::$app->request->baseUrl.'/site/signup'?>',
            type: 'POST',
            data: {s_client: $s_client},
            success: function(data){}
                 if ($("#dilerid").val() !=0) {
                	
                    $(".nom"+$("#dilerid").val()).html($("#dnom").val());
                    $(".telsms1"+$("#dilerid").val()).html($("#dtelefon").val());
                }
                else 
                {
                  $('.dileradd > tbody:last').append(data);
                }                
                $('#myModal').modal('toggle');
            
            },
            error: function(){
                alert("xatolik yuz berdi !!!");
            }  
        });
    }); */
</script>