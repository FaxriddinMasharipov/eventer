<?php
use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
use frontend\models\Asos;
use frontend\models\AsosSlave;
use frontend\models\User;
use kartik\date\DatePicker;
use frontend\models\Haridor;
$this->title="Kirim";
$date = date('Y-m-d');
?>
<div  style="text-align: center;margin: 2px; background-color: rgba(43,106,246,0.77);">
    <table class="asosnew table table-bordered" id="users">
         <tbody>
          <tr>
            <th>Nomer
                <button  data-toggle="modal" data-target="#asosmodal"  class="addasos btn btn-success">+</button>
            </th>
                <th>Summa</th>
                <th>Mol etkazuvchi</th>
                <th class="one" >Summa</th>
                <th class="two" >Kurs</th>
                <th class="three" >Dollar</th>
                <th colspan='3' text-align='center'>Funksiyalar</th>
            </tr>
        </tbody>
        <?php
        $i = 0;
        foreach ($asos as $item):
            ?>
            <?php ActiveForm::begin(['action'=>['site/tovarslave']])?>
            <tr style="background-color:#B6E8F8;" id="<?=$item['id'];?>" class="chekqator-<?=$item['id'];?>">
                <td>
                   <span class="nomer<?=$item->id?>"> <?=$item['nomer']?></span>
                    <input type="text" value="<?=$item->id?>" class="asos" name="asosid" hidden>
                    <input type="text" value="<?=$item->diler_id?>" class="diler<?=$item->id?>" name="diler" hidden >
                    <input type="number" value="<?=$item->nomer?>" name="nomer"  hidden>
                    <input type="text" value="<?=$item->sana?>" name="sana"  hidden>
                    <input type="text" value="<?=$item['dilernom']?>" name="dilernomi" hidden>
                </td>
                <td>
                    <span class="sana<?=$item->id?>"><?=$item['sana']?></span><br>
                </td>
                <td>
                    <input class="dilernom<?=$item->id?>" value="<?=$item->diler_id?>" hidden />
                    <span class="dilername<?=$item->id?>"><?=$item['dilernom']?></span>
                </td>
                <td class="one" >
                    <?=$item['summa']?>
                </td>
                <td class="two">
                    <?=$item['kurs']?>
                </td>
                <td class="three">
                    <?=$item['dollar']?>
                </td>
                <td>
                     <button type ="submit" class="btn btn-success" ><span class="glyphicon glyphicon-shopping-cart"></span></button>
                     <?php ActiveForm::end()?>
                </td>
                <td>
                    <button type="button" class="asosedit btn btn-primary" data-toggle="modal" data-target="#asosmodal"><span class="glyphicon glyphicon-pencil"></span></button>
                </td>
                <td>                
                    <button type="button" class="delasos btn btn-danger" data-toggle="modal" data-target="#asosdel"><span class="glyphicon glyphicon-trash"></span></button>
                </td>
            </tr>
        <?php endforeach;?>
    </table>
</div>
<div class="container mt-3">
    <div class="modal fade" id="asosmodal">
        <div class="modal-dialog">
        <div class="modal-content">
        <div class="modal-header">
            <h4 class='mavzu modal-title'>O'zgartirish</h4>
            <button type="button" class="close" data-dismiss="modal">×</button>
        </div>
        <div class="modal-body">
            <form method="post">  
                    
                 <br><label>Nomer</label>  
                 <input type="text" name="mnomer" id="mnomer" class="form-control" />  
                 <label>Sana</label> 
                 <?php 
                 echo DatePicker::widget([
                     'name' => 'msana',
                     'id' => 'msana',
                     'value' => $item["sana"],
                    'options' => ['placeholder' => 'Sanani tanlang...'],
                    'pluginOptions' => ['format' => 'yyyy-mm-dd','todayHighlight' => true]]);
                ?><br>
                 <label>Diller</label>
                 <?php
                    echo \kartik\select2\Select2::widget([
                    'name' => 'mdiler',
                    'id' => 'mdiler',
                    'data' => $dilerlar,
                    'value'=>0,
                    'options' => ['placeholder' => 'Mol etkazuvchi nomi...','style'=>['; display:""', 'width' => '80%']],
                    'pluginOptions' => ['allowClear' => true ]]);
                 ?>

                <input type="hidden" name="masosid" id="masos_id" /> 
            </form>      
            <div class="modal-footer">
                <button type="submit" name="saqla" class="saqla btn btn-success">Saqla</button>  
                <button type="button" class="btn btn-danger" data-dismiss="modal">Bekor qilish</button>
            </div>
        </div>
    </div>
  </div>  
</div>
<div class="container">
  <div class="modal fade" id="asosdel">
    <div class="modal-dialog modal-sm">
      <div class="modal-content">
         <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal">&times;</button>
            <h4>O'chirish</h4>
        </div>
        <div class="modal-body">
          <h5>Siz haqiqatdan ham o'chirmoqchimisiz ?</h5>
          <input type="hidden" name="delasosid" id="delasosid"/>
        </div>
        <div class="modal-footer">
          <button type="button" name="delasossave" class="delasossave btn btn-success">O'chirish</button>
          <button type="button" class="btn btn-danger" data-dismiss="modal">Bekor qil </button>
        </div>
      </div>
    </div>
  </div>
</div>
<style>
@media (max-width:320px) {
    .one{
        display: none;
    }
    .two{
        display: none;
    }
    .three{
        display: none;
    }
}
@media (max-width:480px) {
    .one{
        display: none;
    }
    .two{
        display: none;
    }
    .three{
        display: none;
    }
}
</style>
<script type="text/javascript">

   $('.asosnew').on('click','.delasos', function (e){
        e.preventDefault();
        var jid=$(this).parent().parent().attr('id');
        $("#delasosid").val(jid);
   }); 
   $('.delasossave').on('click', function(e){
        e.preventDefault();
        $.ajax({
            url: '<?php echo Yii::$app->request->baseUrl.'/site/saveasos'?>',
            type: 'POST',
            data: {delasosid:$("#delasosid").val()},
            success: function(data){
             $('#asosdel').modal('toggle');
             $('.chekqator-'+$("#delasosid").val()).hide();
            },error: function(){
                alert("xatolik yuz berdi !!!");
            } 

        });   
    });
    $('.asosnew').on('click','.asosedit', function (e){
        e.preventDefault();
        var jid=$(this).parent().parent().attr('id');
        $("#masos_id").val(jid);
        $("#mdiler").select2().val($(".dilernom"+jid).val()).trigger("change");
        $("#msana").val($(".sana"+jid).html());
        $("#mnomer").val($(".nomer"+jid).html());
   }); 
    $('.addasos').on('click', function(e){
        e.preventDefault();
        $("#masos_id").val(0);
        $("#mnomer").val('');
        $("#msana").val('');
        $(".mavzu").text('Qoshish');
        $("#mdiler").select2().val('').trigger("change");
    }); 
    $(document).find('.saqla').on('click', function(e){
        e.preventDefault();
        $jid=$("#masos_id").val();
        $nomer=$("#mnomer").val();
        $sana=$("#msana").val();
        $diler=$("#mdiler").val();
        //alert($(".select2-selection__rendered").html());
        if($nomer==''){alert('Nomer kiritilmagan');exit;}
        if($sana==''){alert('= sana no`to`gri');exit;}
        if($diler==''){alert('Diler kiritilmagan');exit;}
        $.ajax({
            url: '<?php echo Yii::$app->request->baseUrl. '/site/saveasos'?>',
            type: 'POST',
            data: {nomer:$nomer,
                sana:$sana,
                diler:$diler,
                jid:$jid,
                dilername:$(".select2-selection__rendered").html(),
            },
            success: function(data){
                if ($("#masos_id").val() !=0) {
                    $(".nomer"+$("#masos_id").val()).html($("#mnomer").val());
                    $(".sana"+$("#masos_id").val()).html($("#msana").val());
                    $(".dilername"+$("#masos_id").val()).html($(".select2-selection__rendered").html());
                }
                else {
                    $('.asosnew > tbody:last').append(data);
                }            
                $('#asosmodal').modal('toggle');
            }
            ,error: function(){
                alert("xatolik yuz berdi !!!");
            }
        });
    });
</script>
