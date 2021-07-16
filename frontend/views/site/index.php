<?php
use kartik\select2\Select2;
use yii\bootstrap\ActiveForm;
use yii\helpers\Html;
$this->title = '';
?>
<?php
$date = date("Y-m-d");
?>
<div  style="text-align: center;margin: 2px; background-color: rgba(43,106,246,0.77);">
    <table class="obektadd table table-bordered">
    <tbody>
        <tr>
            <th>Toyxonalar (Eventer) !!!  16.07.21 dasturi<button  data-toggle="modal" data-target="#myModal" class="addmodal btn btn-success">+</button></th><th>Ma`sul shaxs</th><th>Telefon</th><th colspan='2'>Amallar</th>
        </tr>
    </tbody>
       <?php $i=0;
       foreach ($obekt as $ob){ $i++?>
            <tr style="background-color:#B6E8F8;" id="<?=$ob['id'];?>" class="slqator-<?=$ob['id'];?>">
                <td> <span class="name<?=$ob['id'];?>"><?=$ob['name']?></span></td>
                
                <td><span class="masul<?=$ob['id'];?>"><?=$ob['masul']?></span></td>
                <td><span class="telefon<?=$ob['id'];?>"><?=$ob['tel']?></span></td>
                <td>
                    <input type="text" value="<?=$ob->id?>" name="iddel" hidden>
                    <button type="button" class="edit btn btn-primary" data-toggle="modal" data-target="#myModal"><span class="glyphicon glyphicon-pencil"></span></button>
                </td>
                <td>
                     <button type="button" class="df btn btn-danger" data-toggle="modal" data-target="#modaldelete"><span class="glyphicon glyphicon-trash"></span></button>
                </td>
                

           </tr>
        <?php } ?>
    <hr style="color: #00b3ee">
</div>

<div class="container mt-3">
    <div class="modal fade" id="myModal">
        <div class="modal-dialog">
        <div class="modal-content">
        <div class="modal-header">
            <h4 class="shapka modal-title">Obekt qo'shish</h4>
            <button type="button" class="close" data-dismiss="modal">×</button>
        </div>
        <div class="modal-body">
            <form method="post">  
            <label>To`yxona nomi</label><br>
                <input type="text" name="name" id="name" class=" form-control" />
                <br><label>Ma`sul shaxs</label>  
                <input type="text" name="masul" id="masul" class=" form-control" />
                <br><label>Telefon raqam</label>  
                <input type="number" name="telefon" id="telefon" class=" form-control" />
                <input type="hidden" name="obektId" id="obektId"/>

                
                <div class="modal-footer">
                    <button type="submit" name="modalsave" class="modalsave btn btn-success">Saqla</button>  
                    <button type="button" class="btn btn-danger" data-dismiss="modal">Bekor qilish</button>
                </div>
            </form>
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
$(document).find('.addmodal').on('click', function(e){
    e.preventDefault();
    $("#obektId").val(0);
    $(".shapka").html('Yangi ob`ekt');
    $("#name").val('');
    $("#masul").val('');
    $("#telefon").val('');
});
$('.obektadd').on('click','.edit', function (e) {
        e.preventDefault();
        var jid=$(this).parent().parent().attr('id');
        $(".shapka").html('Tahrirlash');
        $("#obektId").val(jid);
        $("#name").val($(".name"+jid).html());
        $("#masul").val($(".masul"+jid).html());
        $("#telefon").val($(".telefon"+jid).html());
}); 
$(document).find('.modalsave').on('click',function(e){
        e.preventDefault();
        $name=$("#name").val();    
        $masul=$("#masul").val();
        $telefon=$("#telefon").val();

        if($name==''){alert('Obekt nomi kiritilmagan !!!');exit;}
        $.ajax({
            url: '<?php echo Yii::$app->request->baseUrl.'/site/obektadd'?>',
            type: 'POST',
            data: {name:$("#name").val(),masul:$("#masul").val(),telefon:$("#telefon").val(),obektid:$("#obektId").val()},
            success: function(data){    
                if ($("#obektId").val() != 0) { 
                    $(".name"+$("#obektId").val()).html($("#name").val());
                    $(".telefon"+$("#obektId").val()).html($("#telefon").val());
                    $(".masul"+$("#obektId").val()).html($("#masul").val());
                }
                else 
                {
                  $('.obektadd > tbody:last').append(data);
                }                
                $('#myModal').modal('toggle');
            
            },
            error: function(){
                alert("xatolik yuz berdi !!!");
            } 
        });
    }); 

    $('.obektadd').on('click','.df', function (e) {
        e.preventDefault();
        var jid=$(this).parent().parent().attr('id');
        $("#deleteid").val(jid);
    });
    $(document).find('.deletesave').on('click', function(e){
        e.preventDefault();
        $.ajax({
            url: '<?php echo Yii::$app->request->baseUrl.'/site/obektadd'?>',
            type: 'POST',
            data: {deletid:$("#deleteid").val()},
            success: function(data){
            $('#modaldelete').modal('toggle');
            $('.slqator-'+$("#deleteid").val()).hide();
         /*    var json = $.parseJSON(data);
             alert(json.html);*/
             
            },error: function(){
                alert("xatolik yuz berdi !!!");
            } 

        });   
    }); 
</script>
