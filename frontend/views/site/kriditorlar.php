<?php
use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
use frontend\models\Sinv;
use frontend\models\User;
use kartik\date\DatePicker;
$this->title="Kriditorlar";
$date = date('Y-m-d');
?>
<div  style="text-align: center;margin: 2px; background-color: rgba(43,106,246,0.77);">
    <table class="kriditoradd table table-bordered">
        <tbody>
         <tr>
            <th>Kriditor nomi <button  data-toggle="modal" data-target="#myModal" class="addmodal btn btn-success">+</button></th>
            <th>Telefon raqami</th>
            <th>STIR</th>
            <th colspan='2' text-align='center'>Funksiyalar</th>
            <!-- ZD:Hamma ustunlar senterga tekislansin -->
<<<<<<< Updated upstream
=======
            <!-- FM:OK -->
            na gap
>>>>>>> Stashed changes
        </tr>
           
        </tbody>
        <?php
        $i = 0;
        foreach ($slave as $sl):
            ?>
            <tr style="background-color:#B6E8F8;" id="<?=$sl['id'];?>" class="slqator-<?=$sl['id'];?>">
                <td>
                    <span class="nom<?=$sl['id'];?>"><?=$sl['nom']?></span>
                </td>
                <td>
                    <span class="tel<?=$sl['id'];?>" ><?=$sl['tel']?></span>
                </td>
                <td>
                    <span class="inn<?=$sl['id'];?>" ><?=$sl['tel']?></span>
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
            <h4 class="modal-title">Kriditor qo'shish</h4>
            <button type="button" class="close" data-dismiss="modal">×</button>
        </div>
        <div class="modal-body">
            <form method="post">  
                <label>Kriditor nomi</label><br>
                <input type="text" id="kriditnom" class=" form-control" />
                <br><label>Telefon raqam</label>  
                <input type="number"  id="ktelefon" class=" form-control" />
                <input type="hidden"  id="kriditorid"/>
                
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
   
   $('.kriditoradd').on('click','.edit', function (e) {
        e.preventDefault();
        var jid=$(this).parent().parent().attr('id');
        $("#kriditorid").val(jid);
        $("#kriditnom").val($(".nom"+jid).html());
        $("#ktelefon").val($(".tel"+jid).html());
   }); 

   $(document).find('.addmodal').on('click', function(e){
        e.preventDefault();
        $("#kriditorid").val(0);
        $("#kriditnom").val('');
        $("#ktelefon").val('');
   }); 
   
   $(document).find('.modalsave').on('click',function(e){
        e.preventDefault();
        $fio=$("#kriditnom").val();    
        $tel=$("#ktelefon").val();
        if($fio==''){alert('Diler nomi kiritilmagan !!!');exit;}
        if($tel==''){alert('Diler telefon raqami kiritilmagan !!!');exit;}
       $.ajax({
            url: '<?php echo Yii::$app->request->baseUrl.'/site/kridittoradd'?>',
            type: 'POST',
            data: {kriditnom:$("#kriditnom").val(),ktelefon:$("#ktelefon").val(),kriditorid:$("#kriditorid").val()},
            success: function(data){
                if ($("#kriditorid").val() !=0) {
                	
                    $(".nom"+$("#kriditorid").val()).html($("#kriditnom").val());
                    $(".tel"+$("#kriditorid").val()).html($("#ktelefon").val());
                }
                else 
                {
                  $('.kriditoradd > tbody:last').append(data);
                }                
                $('#myModal').modal('toggle');
            
            },
            error: function(){
                alert("xatolik yuz berdi !!!");
            } 
        });
    });
</script>
