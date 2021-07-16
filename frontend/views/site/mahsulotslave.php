<?php
use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
use frontend\models\Asos;
use frontend\models\AsosSlave;
use frontend\models\User;
use kartik\date\DatePicker;
use frontend\models\Haridor;
use yii\data\Pagination;
use yii\widgets\LinkPager;
$this->title="Tovarlar";
$date = date('Y-m-d');
$mahsulotid=Yii::$app->request->post('mashulotid');
$tnom=Yii::$app->request->post('tnom');
?>
    <div class="container mt-6">
	<a class=" btn btn-success" href="mahsulot"><span class="glyphicon glyphicon-arrow-left"></span></a><br>
	<br><p>Tovar nomi: <input  type="text" value="<?=$tnom?>" /></p>
	</div>
<div  style="text-align: center;margin: 2px; background-color: rgba(43,106,246,0.77);">
    <table class="asoss table table-bordered">
        <tbody>
         <tr>
         	<input type="text" value="<?=$asosid;?>" name="asosid" id="asosid" hidden>
            <th>Tovar nomi <button  data-toggle="modal" data-target="#myModal" class="addslave btn btn-success">+</button></th>
            <th>Soni</th>
            <th>Narxi</th>
            <th>Summasi</th>
            <th colspan='2' text-align='center'>Funksiyalar</th>
        </tr>
           
        </tbody>
        <?php
            $slave = AsosSlave::find()->select('s.id,t.nom,s.tovar_id,kol,summa,s.sena')
            ->from('asos_slave s')->leftJoin('s_tovar t','s.tovar_id=t.id')
            ->where(['tovar_id'=>$mahsulotid,'s.del_flag'=>1])
            ->all();
        $i = 0;
        foreach ($slave as $sl):
            ?>
            <tr style="background-color:#B6E8F8;" id="<?=$sl['id'];?>" class="slqator-<?=$sl['id'];?>">
                
                <td>
                    <input type="text" class="tid<?=$sl->id?>" value="<?=$sl->tovar_id?>" name="asosid" hidden >
                    <span class="tovarnom<?=$sl['id'];?>"><?=$sl['nom']?></span> 
                </td>
                <td>
                    <span class="kol<?=$sl['id'];?>"><?=$sl['kol']?></span>
                </td>
                <td>
                    <span class="sena<?=$sl['id'];?>" ><?=$sl['sena']?></span>
                </td>
                <td>
                    <span class="summa<?=$sl['id'];?>"><?=$sl['summa']?></span>
                </td>
                <td>
                    <button type="button" class="edit btn btn-primary" data-toggle="modal" data-target="#myModal"><span class="glyphicon glyphicon-pencil"></span></button>
                </td>
                <td>
                     <button type="button" class="delete btn btn-danger" data-toggle="modal" data-target="#mudalit"><span class="glyphicon glyphicon-trash"></span></button>
                </td>
            </tr>     
        <?php endforeach;?>
    </table>
</div>
<div class="container mt-3">
    <div class="modal fade" id="myModal">
        <div class="modal-dialog">
        <div class="modal-content">
      
        <!-- Modal Header -->
        <div class="modal-header">
            <h4 class="modal-title">O'zgartirish</h4>
            <button type="button" class="close" data-dismiss="modal">×</button>
        </div>
        
        <!-- Modal body -->
        <div class="modal-body">
            <form method="post">  
                 <label>Tovar nomi</label><br>  
                 <?php
                    echo \kartik\select2\Select2::widget([
                    'name' => 'mtovar',
                    'id' => 'mtovar',
                    'data' => $tovarlar,
                    'value'=>0,
                    'options' => ['placeholder' => 'Tovar nomi...','style'=>['; display:""']],
                    'pluginOptions' => ['allowClear' => true]]);?>   
                 <br><label>Tovar soni</label>  
                 <input type="text" name="mkol" id="mkol" class="form-control" />  
                 <label>Narxi</label>  
                 <input type="text" name="msena" id="msena" class="form-control" />  
                 <!-- <label>Summa</label> -->  
                 <!-- <input type="text" name="msumma" id="msumma" hidden/> -->
                 <input type="hidden" name="mid" id="mid" />  
                 <input type="hidden" name="masosid" id="masosid" />  
            </form>      
            <!-- Modal footer -->
            <div class="modal-footer">
                <button type="submit" name="modalsave" class="modalsave btn btn-success">Saqla</button>  
                <button type="button" class="btn btn-danger" data-dismiss="modal">Bekor qilish</button>
            </div>
        </div>
    </div>
  </div>  
</div>
<div class="container">
  <div class="modal fade" id="mudalit">
    <div class="modal-dialog modal-sm">
      <div class="modal-content">
         <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal">&times;</button>
            <h4>O'chirish</h4>
        </div>
        <div class="modal-body">
          <h5>Siz haqiqatdan ham o'chirmoqchimisiz ?</h5>
          <input type="hidden" name="mslaveid" id="mslaveid"/>
        </div>
        <div class="modal-footer">
          <button type="button" name="insert" class="delsave btn btn-success">O'chirish</button>
          <button type="button" class="btn btn-danger" data-dismiss="modal">Bekor qil </button>
        </div>
      </div>
    </div>
  </div>
</div>
<style>
.center{
    text-align:center;
    margin: 4px;
}
</style>
<script type="text/javascript">
    //$('.taxrir').on('click', function(e){
    $('.asoss').on('click','.edit', function (e) {
        e.preventDefault();
        var jid=$(this).parent().parent().attr('id');
        $("#mid").val(jid);
        //$("#mtovar").val('');
        $("#mtovar").select2().val($(".tid"+jid).val()).trigger("change");
        $("#mkol").val($(".kol"+jid).html());
       // $("#msumma").val($(".summa"+jid).html());
        $("#msena").val($(".sena"+jid).html());
   }); 
   $('.asoss').on('click','.delete', function(e){
        e.preventDefault();
        var jid=$(this).parent().parent().attr('id');
        $("#mslaveid").val(jid);
   }); 
   $(document).find('.addslave').on('click', function(e){
        e.preventDefault();
        $("#mid").val(0);
        $("#mtovar").val('');
        $("#masosid").val($("#asosid").val());
        $("#mkol").val('');
        //$("#msumma").val('');
        $("#msena").val('');
   }); 
     $('.delsave').on('click', function(e){
        e.preventDefault();
        $.ajax({
            url: '<?php echo Yii::$app->request->baseUrl.'/site/tovarslave'?>',
            type: 'POST',
            data: {deletid:$("#mslaveid").val()},
            success: function(data){
             $('#mudalit').modal('toggle');
             $('.slqator-'+$("#mslaveid").val()).hide();
             alert(data);
         /*    var json = $.parseJSON(data);
             alert(json.html);*/
             
            },error: function(){
                alert("xatolik yuz berdi !!!");
            } 

        });   
    });
    $('.modalsave').on('click',function(e){
        var kol = parseInt($("#mkol").val());
        var sena = parseFloat($("#msena").val());
        var natija = kol * sena;
        natijaStr =  String(natija);
       $.ajax({
            url: '<?php echo Yii::$app->request->baseUrl.'/site/saqlaslave'?>',
            type: 'POST',
            data: {id:$("#mid").val(),asosid:$("#masosid").val(),tovar_id:$("#mtovar").val(),kol:$("#mkol").val(),sena:$("#msena").val(),tovarnom:$(".select2-selection__rendered").html().substring(47)},
            success: function(data){
                if ($("#mid").val() !=0) {
                	$(".tovarnom"+$("#mid").val()).html($(".select2-selection__rendered").html());
                    $(".tovar_id"+$("#mid").val()).html($("#mtovar").val());
                    $(".kol"+$("#mid").val()).html($("#mkol").val());
                    $(".sena"+$("#mid").val()).html($("#msena").val());
                    $(".summa"+$("#mid").val()).html(natijaStr);
                    
                }
                else {
                    $('.asoss > tbody:last').append(data);
                  
                    }            
            
                
                $('#myModal').modal('toggle');
            }
            ,error: function(){
                alert("xatolik yuz berdi !!!");
            } 
            });
    });
</script>
