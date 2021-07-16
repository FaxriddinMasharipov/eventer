<?php
use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
use frontend\models\Main;
use frontend\models\SClient;
use frontend\models\User;
use kartik\date\DatePicker;
$this->title="Serialar";
$date = date('Y-m-d');
?>
<div  style="margin: 2px; background-color: rgba(43,106,246,0.77);">
    <table class="serialadd table table-bordered">
        <tbody>
         <tr>
            <th>Serialar <button  data-toggle="modal" data-target="#myModal" class="addmodal btn btn-success">+</button></th>
            <th>Quer kod</th>
            <th>Tovar nomi</th>
            <th>Korxona </th>
            <th colspan='2' text-align='center'>Funksiyalar</th>
        </tr>
           
        </tbody>
        <?php
        $i = 0;
        foreach ($slave as $sl):
            ?>
            <tr style="background-color:#B6E8F8;" id="<?=$sl['id'];?>" class="slqator-<?=$sl['id'];?>">
                <td>
                    <span class="main<?=$sl['id'];?>"><?=$sl['serial']?></span>
                </td>   
                <td>
                    <span class="qrkod<?=$sl['id'];?>"><?=$sl['qrkod']?></span>
                </td>             
                <td>
                    <input class="tovarnom<?=$sl['id'];?>" value="<?=$sl['tnom']?>" hidden />
                    <span class="tnom<?=$sl['id'];?>"><?=$sl['tnom']?></span>
                </td>             
                <td>
                    <input class="clientnom<?=$sl['id'];?>" value="<?=$sl['clnom']?>" hidden />
                    <span class="clnom<?=$sl['id'];?>"><?=$sl['clnom']?></span>
                </td>             
                <td>
                    <button type="button" class="edit btn btn-primary" data-toggle="modal" data-target="#myModal"><span class="glyphicon glyphicon-pencil"></span></button>
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
            <h4 class="modal-title">Seria qo'shish</h4>
            <button type="button" class="close" data-dismiss="modal">×</button>
        </div>
        <div class="modal-body">
            <form method="post">  
                <label>Seria</label><br>
                <input type="text" name="mseria" id="mseria" class=" form-control" />
                <br><label>Quer kod</label>  
                <input type="number" name="mqrkod" id="mqrkod" class=" form-control" />
               <label>Tolov turi</label>
                        <?php echo \kartik\select2\Select2::widget([
                                'name' => 's_tovar',
                                'id' => 's_tovar',
                                'data' => $s_tovar,
                                'value'=>0,
                                'options' => ['placeholder' => '...','style'=>['; display:""', 'width' => '90%']],
                                'pluginOptions' => ['allowClear' => true]]);?><br>
                        <label>Brend</label><br>
                        <?php echo \kartik\select2\Select2::widget([
                                'name' => 's_client',
                                'id' => 's_client',
                                'data' => $s_client,
                                'value'=>0,
                                'options' => ['placeholder' => '...','style'=>['; display:""', 'width' => '90%']],
                                'pluginOptions' => ['allowClear' => true]]);?>
                <input type="hidden" name="seriaid" id="seriaid"/>
                
                <div class="modal-footer">
                    <button type="submit" name="modalsave" class="modalsave btn btn-success">Saqla</button>  
                    <button type="button" class="btn btn-danger" data-dismiss="modal">Bekor qilish</button>
                </div>
            </form>
        </div>
    </div>
  </div>  
</div>
<script type="text/javascript">
   $('.serialadd').on('click','.edit', function (e) {
        e.preventDefault();
        var jid=$(this).parent().parent().attr('id');
        $("#seriaid").val(jid);
        $("#mseria").val($(".main"+jid).html());
        $("#mqrkod").val($(".qrkod"+jid).html());
        $("#s_tovar").select2().val($(".tovarnom"+jid).val()).trigger("change");
        $("#s_client").select2().val($(".clientnom"+jid).val()).trigger("change");

   }); 

   $(document).find('.addmodal').on('click', function(e){
        e.preventDefault();
        $("#seriaid").val(0);
        $("#mseria").val('');
        $("#mqrkod").val('');
        $("#s_tovar").select2().val('').trigger("change");
        $("#s_client").select2().val('').trigger("change");
    }); 
    $(document).find('.modalsave').on('click',function(e){
       e.preventDefault();
       $.ajax({
            url: '<?php echo Yii::$app->request->baseUrl.'/site/serialkirit'?>',
            type: 'POST',
            data:{
                    seriaid: $("#seriaid").val(),
                    mseria: $("#mseria").val(),
                    mqrkod: $("#mqrkod").val(),
                    s_tovar: $("#s_tovar").val(),
                    s_client: $("#s_client").val(),
                },
            success: function(data){
                if ($("#seriaid").val() !=0) {
                	
                    $(".main"+$("#seriaid").val()).html($("#mseria").val());
                    $(".qrkod"+$("#seriaid").val()).html($("#mqrkod").val());
                    $(".tnom"+$("#seriaid").val()).html($("#s_tovar").val());
                    $(".clnom"+$("#seriaid").val()).html($("#s_client").val());
                }
                else 
                {
                  $('.serialadd > tbody:last').append(data);
                }                
                $('#myModal').modal('toggle');
            },
            error: function(){
                alert("xatolik yuz berdi !!!");
            } 
        });
    });
</script>
