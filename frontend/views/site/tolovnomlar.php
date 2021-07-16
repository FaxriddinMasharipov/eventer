<?php
use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
use frontend\models\Diler;
use frontend\models\Pl;
use frontend\models\User;
use kartik\date\DatePicker;
$this->title="To'lovnomalar";
$date = date('Y-m-d');
?>
<div  style="text-align: center;margin: 2px; background-color: rgba(43,106,246,0.77);">
    <table class="tolovadd table table-bordered">
        <tbody>
         <tr>
            <th>Nomer <button  data-toggle="modal" data-target="#myModal" class="addmodal btn btn-success">+</button></th>
            <th>Sana </th>
            <th>Summa</th>
            <th>Dollar</th>
            <th>Harajat</th>
            <th colspan='2' text-align='center'>Funksiyalar</th>
        </tr>
           
        </tbody>
        <?php
        $slave = Pl::find()->select('*')
            ->from('pl')
            ->where(['pl.del_flag'=>1])
            ->all();
        $i = 0;
        foreach ($slave as $sl):
            ?>
            <tr style="background-color:#B6E8F8;" id="<?=$sl['id'];?>" class="slqator-<?=$sl['id'];?>">
                <td>
                    <span class="n_pl<?=$sl['id'];?>"><?=$sl['n_pl']?></span>
                </td>
                <td>
                    <span class="d_pl<?=$sl['id'];?>" ><?=$sl['d_pl']?></span>
                </td>
                <td>
                    <span class="sena_pl<?=$sl['id'];?>" ><?=$sl['sena_pl']?></span>
                </td>
                <td>
                    <span class="sena_d<?=$sl['id'];?>" ><?=$sl['sena_d']?></span>
                </td>
                <td>
                    <span class="vo<?=$sl['id'];?>"><?=$sl['vo']?></span>
                </td>
                <td hidden >
                    <input class="s_vidnom<?=$sl['id'];?>" value="<?=$sl['vid']?>" hidden />
                    <span class="s_vid<?=$sl['id'];?>"><?=$sl['vid']?></span>
                </td>
                <td hidden>
                    <span class="kurs<?=$sl['id'];?>"><?=$sl['kurs']?></span>
                </td>
                <td hidden>
                    <span class="prim<?=$sl['id'];?>"><?=$sl['prim']?></span>
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
            <h4 class="modal-title">To'lovnoma qo'shish</h4>
            <button type="button" class="close" data-dismiss="modal">×</button>
        </div>
        <div class="modal-body">
            <form method="post">  
               <table class="table table-bordered">
                    <tr>
                        <th style="width:75px;">Tolov turi</th>
                        <th><?php echo \kartik\select2\Select2::widget([
                                'name' => 's_vid',
                                'id' => 's_vid',
                                'data' => $s_vid,
                                'value'=>0,
                                'options' => ['placeholder' => '...','style'=>['; display:""', 'width' => '90%']],
                                'pluginOptions' => ['allowClear' => true]]);
                                ?>
                        </th>
                     
                        <th style="width:75px;">Brend</th> 
                        <th><?php echo \kartik\select2\Select2::widget([
                                'name' => 'vo',
                                'id' => 'vo',
                                'data' => $vo,
                                'value'=>0,
                                'options' => ['placeholder' => '...','style'=>['; display:""', 'width' => '90%']],
                                'pluginOptions' => ['allowClear' => true]]);
                            ?>
                        </th>
                    </tr>
                    <tr>               
                        <th>Nomer:</th>
                        <th>
                            <input style="text-align:center" type="number" name="n_pl" id="n_pl" class=" form-control" />
                        </th>
                        <th>Sana:</th>
                        <th>
                            <?php 
                                  echo DatePicker::widget([
                                    'name' => 'd_pl',
                                    'id' => 'd_pl',
                                    'value' => $item["d_pl"],
                                    'options' => ['placeholder' => 'Sanani tanlang...'],
                                    'pluginOptions' => ['format' => 'yyyy-mm-dd','todayHighlight' => true]]);
                            ?>
                        </th>
                    </tr> 
                    <tr>    
                        <th>Summa:</th>
                        <th>
                            <input style=" text-align:center" type="number" name="sena_pl" id="sena_pl" class=" form-control"/>
                        </th>
                        <th>Kurs:</th>
                        <th>
                            <input style=" text-align:center" type="number" name="kurs" id="kurs" class=" form-control"/>
                        </th>                           
                    </tr> 
                    <tr>
                    <th>Dollar</th>
                      <th>
                            <input style=" text-align:center" type="number" name="sena_d" id="sena_d" class=" form-control"/>
                      </th>
                      <th>Izoh</th>
                      <th>
                            <input type="textarea" name="prim" id="prim" class=" form-control"/>
                      </th>
                    </tr>
                    <input type="hidden" name="tolovid" id="tolovid"/>

                </table>                                  
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
   
   $('.tolovadd').on('click','.edit', function (e) {
        e.preventDefault();
        var jid=$(this).parent().parent().attr('id');
        $("#tolovid").val(jid);        
        //$("#s_vid").select2().val($(".s_vid"+jid).html()).trigger("change");
        $("#s_vid").select2().val($(".s_vidnom"+jid).val()).trigger("change");
        $("#n_pl").val($(".n_pl"+jid).html());
        $("#d_pl").val($(".d_pl"+jid).html());
        $("#sena_pl").val($(".sena_pl"+jid).html());
        $("#kurs").val($(".kurs"+jid).html());
        $("#prim").val($(".prim"+jid).html());
        $("#sena_d").val($(".sena_d"+jid).html());
        $("#vo").val($(".vo"+jid).html());
   }); 

   $(document).find('.addmodal').on('click', function(e){
        e.preventDefault();
        $("#tolovid").val(0);
        $("#s_vid").select2().val('').trigger("change");
        $("#vo").select2().val('').trigger("change");
        $("#n_pl").val('');
        $("#d_pl").val('');
        $("#sena_pl").val('');
        $("#kurs").val('');
        $("#sena_d").val('');
        $("#prim").val('');
   }); 
   
   $(document).find('.modalsave').on('click',function(e){
    e.preventDefault();
       $.ajax({
            url: '<?php echo Yii::$app->request->baseUrl.'/site/tolovkirit'?>',
            type: 'POST',
            data: {
                tolovid: $("#tolovid").val(),
                s_vid: $("#s_vid").val(),
                vo: $("#vo").val(),
                n_pl: $("#n_pl").val(),
                d_pl: $("#d_pl").val(),
                sena_pl: $("#sena_pl").val(),
                kurs: $("#kurs").val(),
                sena_d: $("#sena_d").val(),
                prim: $("#prim").val(),
            },
            success: function(data){
                if ($("#tolovid").val() !=0) {
                	
                    $(".n_pl"+$("#tolovid").val()).html($("#n_pl").val());
                    $(".sena_pl"+$("#tolovid").val()).html($("#sena_pl").val());
                    $(".kurs"+$("#tolovid").val()).html($("#kurs").val());
                    $(".d_pl"+$("#tolovid").val()).html($("#d_pl").val());
                    $(".sena_d"+$("#tolovid").val()).html($("#sena_d").val());
                    $(".prim"+$("#tolovid").val()).html($("#prim").val());
                }
                else 
                {
                  $('.tolovadd > tbody:last').append(data);
                }                
                $('#myModal').modal('toggle');
            
            },
            error: function(){
                alert("xatolik yuz berdi !!!");
            } 
        });
    });
   
    $('.tolovadd').on('click','.delete', function (e) {
        e.preventDefault();
        var jid=$(this).parent().parent().attr('id');
        $("#deleteid").val(jid);
   }); 

   $(document).find('.deletesave').on('click', function(e){
        e.preventDefault();
        $.ajax({
            url: '<?php echo Yii::$app->request->baseUrl.'/site/tolovkirit'?>',
            type: 'POST',
            data: {deletid:$("#deleteid").val()},
            success: function(data){
            $('#modaldelete').modal('toggle');
            $('.slqator-'+$("#deleteid").val()).hide();


            },error: function(){
                alert("xatolik yuz berdi !!!");
            } 

        });   
    });
</script>
