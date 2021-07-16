<?php
use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
use frontend\models\Diler;
use frontend\models\AsosSlave;
use frontend\models\STovar;
use frontend\models\User;
use kartik\checkbox\CheckboxX;
use kartik\date\DatePicker;
$this->title="Mahsulot";
$date = date('Y-m-d');
?>
<?php
$search = Yii::$app->request->post('search');
if (!$search=="") {
     $tovar = STovar::find()->select('*')
            ->from('s_tovar')
            ->where(['client_id' => Yii::$app->getUser()->identity->client_id])
            ->andWhere(['del_flag'=>1])->andWhere( 'nom like "%'.$search.'%"')
            ->limit(100)
            ->all();
}
?>
<div  style="text-align: center;margin: 5px; pading: 5px; background-color: rgba(43,106,246,0.77);">
    <table class="tableadd table table-bordered">
        <tbody>
         <tr>
            <th><?php ActiveForm::begin(['action'=>['site/mahsulot']])?>
                Tovar nomi 
                    <button data-toggle="modal" data-target="#myModal" class="tovaradd btn btn-success">+</button>
                    <input type="text" style="width:50%; text-align:center" id="input" name="search" placeholder="izlash" >
                    <button type="submit"  class="qidir btn btn-success"><span class="glyphicon glyphicon-search"></span></button>
            </th>
                    <?php ActiveForm::end()?>           
            <th colspan='3'style="text-align: center" >Funksiyalar</th>

        </tr>
           
        </tbody>
        <?php
        $i = 0;
        foreach ($tovar as $sl):
            ?>
            <tr style="background-color:#B6E8F8;" id="<?=$sl['id'];?>" class="slqator-<?=$sl['id'];?>">
                <td style="text-align: left" >
                    <span  class="nom<?=$sl['id'];?>"><?=$sl['nom']?></span>
                </td>
                <td hidden>
                <span  class="nom_sh<?=$sl['id'];?>" hidden><?=$sl['nom_sh']?></span>
                </td>
                <td hidden>
                <span  class="kol_in<?=$sl['id'];?>" hidden><?=$sl['kol_in']?></span>
                </td>
                <td hidden>
                <input type="text" class="katid<?=$sl->id?>" value="<?=$sl['kat']?>" name="katt" hidden >
                <span  class="kat<?=$sl['id'];?>" hidden><?=$sl['kat']?></span>
                </td>
                <td hidden>
                <input type="text" class="brendid<?=$sl->id?>" value="<?=$sl['brend']?>" name="brendd" hidden >
                <span  class="brend<?=$sl['id'];?>" hidden><?=$sl['brend']?></span>
                </td>
                <td hidden>
                <input type="text" class="izm_idid<?=$sl->id?>" value="<?=$sl['izm_id']?>" name="izm_id" hidden >
                <span  class="izm_id<?=$sl['id'];?>" hidden><?=$sl['izm_id']?></span>
                </td>       
                <td hidden>
                <input type="text" class="izm1id<?=$sl->id?>" value="<?=$sl['izm1']?>" name="izm1" hidden >
                <span  class="izm1<?=$sl['id'];?>" hidden><?=$sl['izm1']?></span>
                </td>       
                <td hidden>
                <span  class="sena<?=$sl['id'];?>" hidden><?=$sl['sena']?></span>
                </td> 
                <td hidden>
                <span  class="sena_d<?=$sl['id'];?>" hidden><?=$sl['sena_d']?></span>
                </td>     
                <td hidden>
                <span  class="sotish<?=$sl['id'];?>" hidden><?=$sl['sotish']?></span>
                </td>
                <td hidden>
                <span  class="sotish_d<?=$sl['id'];?>" hidden><?=$sl['sotish_d']?></span>
                </td>
                <td hidden>
                <span  class="ulg1<?=$sl['id'];?>" hidden><?=$sl['ulg1']?></span>
                </td>
                <td hidden>
                <span  class="ulg1_pl<?=$sl['id'];?>" hidden><?=$sl['ulg1_pl']?></span>
                </td>
                <td hidden>
                <span  class="ulg2<?=$sl['id'];?>" hidden><?=$sl['ulg2']?></span>
                </td>
                <td hidden>
                <span  class="ulg2_pl<?=$sl['id'];?>" hidden><?=$sl['ulg2_pl']?></span>
                </td>
                <td hidden>
                <span  class="bank<?=$sl['id'];?>" hidden><?=$sl['bank']?></span>
                </td>
                <td>
                    <?php ActiveForm::begin(['action'=>['site/mahsulotslave']])?>
                    <input type="text" name="tnom" value="<?=$sl['nom']?>" hidden>
                    
                    <button type ="submit" class="btn btn-success"><span class="glyphicon glyphicon-shopping-cart"></span></button>
                    <?php ActiveForm::end()?>
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
<div class="container mt-2">
    <div class="modal fade" id="myModal">
        <div class="modal-dialog">
        <div class="modal-content">
        <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal">×</button>
        </div>
        <div class="modal-body">
            <form method="post">
            <table class="table">
            <tr>  
                <th>Nomi</th>
                <th colspan="2" ><input type="text" name="nom" id="nom" class=" form-control" /></th>
            </tr>
            <tr>      
                <th scope="col" >Qisqa</th>
                <th scope="col" ><input type="text" name="nom_sh" id="nom_sh" class=" form-control" /></th>
                <th scope="col" ><input type="number" name="kol_in" id="kol_in" class=" form-control" placeholder="soni"/></th>
            </tr>
            </table>
                <table class="table table-bordered">
                    <tr>
                        <th style="width:75px;">Turi</th>
                        <th><?php echo \kartik\select2\Select2::widget([
                                'name' => 'kat',
                                'id' => 'kat',
                                'data' => $kat,
                                'value'=>0,
                                'options' => ['placeholder' => '...','style'=>['; display:""', 'width' => '90%']],
                                'pluginOptions' => ['allowClear' => true]]);
                                ?>
                        </th>
                    </tr>  
                    <tr>   
                        <th style="width:75px;">Brend</th>
                        <th><?php echo \kartik\select2\Select2::widget([
                                'name' => 'brend',
                                'id' => 'brend',
                                'data' => $brend,
                                'value'=>0,
                                'options' => ['placeholder' => '...','style'=>['; display:""', 'width' => '90%']],
                                'pluginOptions' => ['allowClear' => true,
                                'width' => '80%' 
                                ]]);
                            ?>
                        </th>
                    </tr>
                    <tr>    
                        <th style="width:75px;">O'lchov birligi</th>
                        <th>
                        <?php                 
                            echo \kartik\select2\Select2::widget([
                                'name' => 's_izm',
                                'id' => 's_izm',
                                'data' => $s_izm,
                                'value'=>0,
                                'options' => ['placeholder' => '...','style'=>['; display:""', 'width' => '90%']],
                                'pluginOptions' => ['allowClear' => true,
                                'width' => '80%'
                                ]]);?>
                        </th>
                         <th style="width:75px;">Ichki o'lchov birligi</th>
                        <th>
                        <?php                 
                            echo \kartik\select2\Select2::widget([
                                'name' => 's_izm1',
                                'id' => 's_izm1',
                                'data' => $s_izm1,
                                'value'=>0,
                                'options' => ['placeholder' => '...','style'=>['; display:""', 'width' => '90%']],
                                'pluginOptions' => ['allowClear' => true,
                                'width' => '80%'
                                ]]);?>
                        </th>
                    </tr>
                </table>                                  
                <table class="table table-bordered"> 
                    <tr>               
                        <th>Kirim:</th>
                        <th><input style="text-align:center" type="number" name="sena" id="sena" class=" form-control" />
                        </th>
                        <th>Sotish:</th>
                        <th>
                            <input style=" text-align:center" type="number" name="sotish" id="sotish" class=" form-control" />
                        </th>
                    </tr>
                    <!-- <tr>    
                        <th>KirimD:</th>
                        <th>
                            <input style=" text-align:center" type="number" name="sena_d" id="sena_d" class=" form-control"/>
                        </th>
                        <th>SotD:</th>
                        <th>
                            <input style=" text-align:center" type="number" name="sotish_d" id="sotish_d" class=" form-control"/>
                        </th>
                           
                    </tr> -->
                </table>
                <!-- <table class="table table-bordered">
                    <tr>
                         <th>Ulg 1:</th>
                         <th>
                            <input style=" text-align:center" type="number" name="ulg1" id="ulg1" class=" form-control" />
                         </th>
                         <th>Ulg 1pl:</th>
                         <th>
                            <input style="text-align:center" type="number" name="ulg1_pl" id="ulg1_pl" class=" form-control"/>
                         </th>
                    </tr>
                    <tr>     
                         <th>Ulg 2:</th>
                         <th>
                            <input style="text-align:center" type="number" name="ulg2" id="ulg2" class=" form-control"/>
                         </th>
                         <th>Ulg 2pl:</th>
                        <th>
                            <input style="text-align:center" type="number" name="ulg2_pl" id="ulg2_pl" class=" form-control"/>
                        </th>
                        </tr>
                        <th>Bank:</th>
                        <th>
                            <input style="text-align:center" type="number" name="bank" id="bank" class=" form-control"/>
                        </th>
                </table> -->
                <table class="table"> 
                    <tr>      
                        <th colspan="2" scope="col"  >Dastlabki qoldiq uchun</th>
                        <td scope="col" ><input type="number" name="tkol" id="tkol" class=" form-control" placeholder="soni" /></td>
                        <td scope="col" ><input type="number" name="tkol_in" id="tkol_in" class=" form-control" placeholder="soni"/></td>
                    </tr>
                </table>
                <input type="hidden" name="tovarid" id="tovarid"/>
                
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
   $('.tableadd').on('click','.tovaradd', function (e) {
        e.preventDefault();
        $("#tovarid").val(0);
        $("#nom").val('');
        $("#nom_sh").val('');
        $("#kol_in").val(1);
        $("#kat").select2().val('').trigger("change");
        $("#brend").select2().val('').trigger("change");
        $("#s_izm").select2().val('').trigger("change");
        $("#s_izm1").select2().val('').trigger("change");
        $("#sena").val('');
     //   $("#sena_d").val('');
        $("#sotish").val('');
     //   $("#sotish_d").val('');
        // $("#ulg1").val('');
        // $("#ulg1_pl").val('');
        // $("#ulg2").val('');
        // $("#ulg2_pl").val('');
        // $("#bank").val('');
        $("#tkol").val('');
        $("#tkol_in").val('');
   }); 
   
   $(document).find('.modalsave').on('click',function(e){
        e.preventDefault();
        $tovarid = $("#tovarid").val();
        $nom = $("#nom").val();
        $nom_sh = $("#nom_sh").val();
        $kat = $("#kat").val();
        $kol_in = $("#kol_in").val();
        $brend = $("#brend").val();
        $s_izm = $("#s_izm").val();
        $s_izm1 = $("#s_izm1").val();
        $sena = $("#sena").val();
      //  $sena_d = $("#sena_d").val();
        $sotish = $("#sotish").val();
       // $sotish_d = $("#sotish_d").val();
        // $ulg1 = $("#ulg1").val();
        // $ulg1_pl = $("#ulg1_pl").val();
        // $ulg2 = $("#ulg2").val();
        // $ulg2_pl = $("#ulg2_pl").val();
        // $bank = $("#bank").val();
        $tkol = $("#tkol").val();
        $tkol_in = $("#tkol_in").val();
        //if($fio==''){alert('Diler nomi kiritilmagan !!!');exit;}
        //if($tel==''){alert('Diler telefon raqami kiritilmagan !!!');exit;}
       $.ajax({
            url: '<?php echo Yii::$app->request->baseUrl.'/site/mahsulotadd'?>',
            type: 'POST',
            data: {
                nom:$nom,
                nom_sh:$nom_sh,
                kat:$kat,
                kol_in:$kol_in,
                brend:$brend,
                s_izm:$s_izm,
                s_izm1:$s_izm1,
                sena:$sena,
                sotish:$sotish,
                // ulg1:$ulg1,
                // ulg1_pl:$ulg1_pl,
                // ulg2:$ulg2,
                // ulg2_pl:$ulg2_pl,
                // bank:$bank,
                tkol:$tkol,
             //   tkol_in:tkol_in,
                tovarid:$tovarid,
            },
            success: function(data){   
                if ($("#tovarid").val() !=0) {
                	$(".nom"+$("#tovarid").val()).html($("#nom").val());
                }
                else 
                {
                  $('.tableadd > tbody:last').append(data);
                }                
                $('#myModal').modal('toggle');
            
            },
            error: function(){
                alert("xatolik yuz berdi !!!");
            } 
        });
    });

    $('.tableadd').on('click','.edit', function(e){
        e.preventDefault();
        var jid=$(this).parent().parent().attr('id');
        $("#tovarid").val(jid);
        $("#nom").val($(".nom"+jid).html());
        $("#nom_sh").val($(".nom_sh"+jid).html());
        $("#kol_in").val($(".kol_in"+jid).html());
        $("#kat").select2().val($(".katid"+jid).val()).trigger("change");
        $("#brend").select2().val($(".brendid"+jid).val()).trigger("change");
        $("#s_izm").select2().val($(".izm_idid"+jid).val()).trigger("change");
        $("#s_izm1").select2().val($(".s_izm1id"+jid).val()).trigger("change");
        $("#sena").val($(".sena"+jid).html());
        $("#sena_d").val($(".sena_d"+jid).html());
        $("#sotish").val($(".sotish"+jid).html());
        $("sotish_d").val($(".sotish_d"+jid).html());
        $("#ulg1").val($(".ulg1"+jid).html());
        $("#ulg1_pl").val($(".ulg1_pl"+jid).html());
        $("#ulg2").val($(".ulg2"+jid).html());
        $("#ulg2_pl").val($(".ulg2_pl"+jid).html());
        $("#bank").val($(".bank"+jid).html());
        $("#tkol").val('');
        $("#tkol_in").val('');
 
   }); 



    $('.tableadd').on('click','.delete', function (e)  {
        e.preventDefault();
        var jid=$(this).parent().parent().attr('id');
        $("#deleteid").val(jid);
   }); 

   $(document).find('.deletesave').on('click', function(e){
        e.preventDefault();
        $.ajax({
            url: '<?php echo Yii::$app->request->baseUrl.'/site/mahsulotadd'?>',
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
$('#input').keypress(function(e) {
  if (e.which == 13) {
    $('.qidir').submit();
    return false;
  }
  });
</script>
