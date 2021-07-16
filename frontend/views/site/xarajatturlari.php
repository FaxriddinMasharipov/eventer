<?php
use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
use frontend\models\S_x_tur;
use frontend\models\Main;
use frontend\models\SClient;
use frontend\models\User;
use kartik\date\DatePicker;
$this->title="Serialar";
$date = date('Y-m-d');
?>
<div  style="margin: 2px; background-color: rgba(43,106,246,0.77);">
    <table class="xarajatadd table table-bordered">
        <tbody>
         <tr>
            <th>Xarajat turlari <button  data-toggle="modal" data-target="#myModal" class="addmodal btn btn-success">+</button></th>
           
            <th colspan='2' text-align='center'>Funksiyalar</th>
        </tr>
           
        </tbody>
        <?php
        $i = 0;
        foreach ($slave as $sl):
            ?>
            <tr style="background-color:#B6E8F8;" id="<?=$sl['id'];?>" class="slqator-<?=$sl['id'];?>">
                <td>
                    <span class="xnom<?=$sl['id'];?>"><?=$sl['nom']?></span>
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
            <h4 class="modal-title">Xarajat qo'shish</h4>
            <button type="button" class="close" data-dismiss="modal">×</button>
        </div>
        <div class="modal-body">
            <form method="post">  
                <label>Xarajat nomi</label><br>
                <input type="text" id="xnom" class=" form-control" />
                <input type="hidden"  id="xarajatid"/>
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
   $('.xarajatadd').on('click','.edit', function (e) {
        e.preventDefault();
        var jid=$(this).parent().parent().attr('id');
        $("#xarajatid").val(jid);
        $("#xnom").val($(".xnom"+jid).html());
   }); 

   $(document).find('.addmodal').on('click', function(e){
        e.preventDefault();
        $("#xarajatid").val(0);
        $("#xnom").val('');
    }); 
    $(document).find('.modalsave').on('click',function(e){
       e.preventDefault();
       $.ajax({
            url: '<?php echo Yii::$app->request->baseUrl.'/site/xarajatkirit'?>',
            type: 'POST',
            data:{
                    xarajatid: $("#xarajatid").val(),
                    xnom: $("#xnom").val(),
                },
            success: function(data){
                if ($("#xarajatid").val() !=0) {
                	
                    $(".xnom"+$("#xarajatid").val()).html($("#xnom").val());
                }
                else 
                {
                  $('.xarajatadd > tbody:last').append(data);
                }                
                $('#myModal').modal('toggle');
            },
            error: function(){
                alert("xatolik yuz berdi !!!");
            } 
        });
    });
</script>
