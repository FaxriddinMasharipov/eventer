
<?php
use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
$this->title = 'Ombordagi mahsulotlar';
echo $seriya;

?>
<div class="buttons"><input type="text" name = "salom" id="myInput" onkeyup="myFunction()" placeholder="Tovar nomi !!!">    
    <button id="toza" class="fa fa-undo"></button>
    <?php ActiveForm::begin(['action'=>['/site/addnew']])?>
    <input type="text"  class = "drone" value="<?=$drone?>" name="drone">
    <?php $i=0; foreach ($otdel as $item) { $i++?>
        <input type='radio' id='otdel<?=$item['id']?>' class="otdel" name='otdel' value='<?=$item['id']?>'
               <?php if($otdelId==$item['id']) {echo 'checked';}?>
        ><label for='otdel<?=$item['id']?>'><?=$item['nom']?></label>
    <?php }?>
        <button style="margin-top: 0px" class="btn btn-primary"><i class="fa fa-search"></i></button>
    <?php ActiveForm::end()?>
</div>
<div class="baza" style="background-color: white; padding: 3px">
    <table border="1" style="padding: 5px"  id="myTable">
        <?php $s='';$i=0; foreach ($models as $ite) { $i++?>
            <?php
            $s.="<tr id= ".$ite['ids']."><td><span class='tovar_nom".$ite['ids']."';>". $ite['nom']." ( ". $ite['kol_ost'].":";
            if(($cld=2) & ($ite['sotish_d']+$ite['sotish_in_d']>0) )    { $s.= (float)$ite['sotish_d'];}
            else                {$s.= (int)$ite['sot'];}
            if($ite['tkol_in'] > 1)
            { $s.="|"; $s.=$ite['kol_in_ost'].":".(int)$ite['sotin'];
                ?>
            <?php }?>
            <?php $s.=")</span>";
            $s.="</td>
            <td> <button id=".$ite["ids"]." style='border: 2px;' class='Saqla'><i class='fa fa-floppy-o fa-2x'></i></button></td>
            <td> 
                <input id=".$ite["ids"]." class='kol".$ite['ids']."' name='kol' style='width: 50px; margin:  0px 15px 0px 15px; text-align: center' type='number' name='asosiy' value=''>
                <input id=".$ite["ids"]." class='sot".$ite['ids']."' name='sot' type='number' name='sot' value='".$ite['sot']."' hidden>
            </td>";
            ?>
            <?php
            if($ite['tkol_in'] > 1){ ?>
                <?php
                $s.="<td> 
                <input id=".$ite["ids"]." class='kol_in".$ite['ids']."' name='kol_in' style='width: 50px; margin:  0px 15px 0px 15px; text-align: center' type='number' name='ichki' value=''>
                <input id=".$ite["ids"]." class='sotin".$ite['ids']."' name='sotin' type='number' name='sotin' value='".$ite['sotin']."' hidden>
                </td>";
                ?>

            <?php }?>

            <?php
            $s.="</tr>";


            ?>

        <?php }?>
        <?php
        echo  $s;

        ?>

    </table>
</div>
<style>
table tr th {
    vertical-align: middle;
    text-align: center;
}

#myInput {
    /*background-image: url('/css/searchicon.png'); !* Add a search icon to input *!*/
    /*background-position: 10px 12px; !* Position the search icon *!*/
    /*background-repeat: no-repeat; !* Do not repeat the icon image *!*/
    width: 50%; /* Full-width */
    font-size: 14px; /* Increase font-size */
    /*padding: 6px 20px 6px 40px; !* Add some padding *!*/
    padding: 6px 10px;
    border: 1px solid #ddd; /* Add a grey border */
    margin-bottom: 12px; /* Add some space below the input */
    border-radius: 4px;
}

#myTable {
    border-collapse: collapse; /* Collapse borders */
    width: 100%; /* Full-width */
    border: 1px solid #ddd; /* Add a grey border */
    /*font-size: 18px; !* Increase font-size *!*/
}
</style>
<script>
    function myAndroid() {
        Android.showToast('111');
    }
function myFunction() {
    var input, filter, table, tr, td, i, txtValue;
    input = document.getElementById("myInput");
    filter = input.value.toUpperCase();
    if (filter.length<2) return;
    table = document.getElementById("myTable");
    tr = table.getElementsByTagName("tr");
    var s1,s2,qidir;
    s1 = filter;s2 = filter;
    if(s1.toUpperCase().indexOf(' ') > -1)
    {            
        s1 = s1.substr(0,filter.toUpperCase().indexOf(' '));   
        s2 = s2.substr(filter.toUpperCase().indexOf(' '),50);
    }
    else
    {s2 = '';}
    for (i = 0; i < tr.length; i++) {
        td = tr[i].getElementsByTagName("td")[0];
        if (td) {
            txtValue = td.textContent || td.innerText;
            if (txtValue.toUpperCase().indexOf(s1) > -1) {
                if (s2==='') {
                    tr[i].style.display = "";
                }
                else
                {
                    if (txtValue.toUpperCase().indexOf(s2) > -1) {
                        tr[i].style.display = "";
                    }
                    else
                    {
                        tr[i].style.display = "none";
                    }
                }


            } else {
                tr[i].style.display = "none";
            }
        }
    }
}
function abc2(n) {
    n += "";
    n = new Array(4 - n.length % 3).join("U") + n;
    return n.replace(/([0-9U]{3})/g, "$1 ").replace(/U/g, "");
}

jQuery(document).ready(function ($) {
});
</script>

<script type="text/javascript">

$('#toza').on('click', function(e){
    e.preventDefault();
    input = document.getElementById("myInput");
    $("#myInput").val('');$("#myInput").focus();
    return false;
});      
$('.otdelj').on('click', function(e){
    //e.preventDefault();
    //var data = $(this).serialize();
    //alert($(this).attr('value'));
    //$('.otdel input:checked').removeAttr('checked');
    //$('input[name="otdel"][value=$(this).attr('value')]').prop('checked', true);
    //$("input:radio[value='2']").prop('checked',true);
    //$('input[name="otdel"][value="1"]').prop('checked', '');
    //$('input[name="otdel"][value="2"]').prop('checked', checked);
    //$("#otdel1").attr('checked', 'checked');
    //$("#otdel3").attr('checked', 'checked');
    //window.location.href = window.location.href;
    //location.reload();
    //history.go(0);



});
$('.Saqla').on('click', function(e){
    e.preventDefault();
    var data = $(this).serialize();
    var jid=$(this).attr('id');
    $.ajax({url: '<?php echo Yii::$app->request->baseUrl. '/site/tovaradd' ?>',
        type: 'POST',
        data: {drone:$(".drone").val(),kol:$(".kol"+jid).val(),kol_in:$(".kol_in"+jid).val(),esk:$(this).attr('id'),sot:$(".sot"+jid).val(),sotin:$(".sotin"+jid).val()},
        success: function(data){
            //$(".tovar_nom"+jid).html($data);
            if (data <= 0)
                {alert('Tovar soni kam = ' + data); }
            else
                {$(".tovar_nom"+jid).css("color",'blue');$(".kol"+jid).val('');$(".kol_in"+jid).val('');}
        }
        ,error: function(data){
            $(".tovar_nom"+jid).html("Hat0=".data);
            $(".tovar_nom"+jid).css("color",'red');
        }
    });
    return false;
});

</script>