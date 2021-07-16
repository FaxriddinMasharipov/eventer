<?php
use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
use frontend\models\Diler;
use frontend\models\User;
use kartik\date\DatePicker;
$this->title="Dillerlar";
$date = date('Y-m-d');
?>
<div  style="text-align: center;margin: 2px; background-color: rgba(43,106,246,0.77);">
    <table class="dileradd table table-bordered">
        <tbody>
         <tr>
            <th>Diller nomi <button  data-toggle="modal" data-target="#myModal" class="addmodal btn btn-success">+</button></th>
            <th>Telefon raqami</th>
            <th colspan='2' text-align='center'>Funksiyalar</th>
        </tr>
           
        </tbody>
        <?php
        $slave = Diler::find()->select('*')
            ->from('s_diler')
            ->where(['s_diler.del_flag'=>1])
            ->all();
        $i = 0;
        foreach ($slave as $sl):
            ?>
            <tr style="background-color:#B6E8F8;" id="<?=$sl['id'];?>" class="slqator-<?=$sl['id'];?>">
                <td>
                    <span class="nom<?=$sl['id'];?>"><?=$sl['nom']?></span>
                </td>
                <td>
                    <span class="telsms1<?=$sl['id'];?>" ><?=$sl['telsms1']?></span>
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
            <h4 class="modal-title">Diller qo'shish</h4>
            <button type="button" class="close" data-dismiss="modal">×</button>
        </div>
        <div class="modal-body">
            <form method="post">  
                <label>Diller nomi</label><br>
                <input type="text" name="dnom" id="dnom" class=" form-control" />
                <br><label>Telefon raqam</label>  
                <input type="number" name="dtelefon" id="dtelefon" class=" form-control" />
                <input type="hidden" name="dilerid" id="dilerid"/>
                
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
   
   $('.dileradd').on('click','.edit', function (e) {
        e.preventDefault();
        var jid=$(this).parent().parent().attr('id');
        $("#dilerid").val(jid);
        $("#dnom").val($(".nom"+jid).html());
        $("#dtelefon").val($(".telsms1"+jid).html());
   }); 

   $(document).find('.addmodal').on('click', function(e){
        e.preventDefault();
        $("#dilerid").val(0);
        $("#dnom").val('');
        $("#dtelefon").val('');
   }); 
   
   $(document).find('.modalsave').on('click',function(e){
        e.preventDefault();
        $fio=$("#dnom").val();    
        $tel=$("#dtelefon").val();
        if($fio==''){alert('Diler nomi kiritilmagan !!!');exit;}
        if($tel==''){alert('Diler telefon raqami kiritilmagan !!!');exit;}
       $.ajax({
            url: '<?php echo Yii::$app->request->baseUrl.'/site/dilerkirit'?>',
            type: 'POST',
            data: {fio:$("#dnom").val(),tel:$("#dtelefon").val(),dilerid:$("#dilerid").val()},
            success: function(data){
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
    });
   
    $('.dileradd').on('click','.delete', function (e) {
        e.preventDefault();
        var jid=$(this).parent().parent().attr('id');
        $("#deleteid").val(jid);
   }); 

   $(document).find('.deletesave').on('click', function(e){
        e.preventDefault();
        $.ajax({
            url: '<?php echo Yii::$app->request->baseUrl.'/site/dilerkirit'?>',
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
