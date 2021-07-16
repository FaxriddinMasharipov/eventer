<?php

namespace frontend\controllers;
use Yii;
use yii\base\InvalidParamException;
use yii\data\ActiveDataProvider;
use yii\data\SqlDataProvider;
use yii\helpers\ArrayHelper;
use yii\web\BadRequestHttpException;
use yii\web\Controller;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;
use common\models\LoginForm;
use frontend\models\Obekt;
use frontend\models\S_xizmat;
use frontend\models\PasswordResetRequestForm;
use frontend\models\ResetPasswordForm;
use frontend\models\SignupForm;
use frontend\models\ContactForm;
use yii\data\Pagination;

/**
 * Site controller
 */
class SiteController extends Controller
{
    /**
     * {@inheritdoc}
     */
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'only' => ['logout', 'signup','index'],
                'rules' => [
                    [
                        'actions' => ['signup','index'],
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                    [
                        'actions' => ['logout'],
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
            ],
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'logout' => ['post'],
                ],
            ],
        ];
    }

    public function actions()
    {
        return [
            'error' => [
                'class' => 'yii\web\ErrorAction',
            ],
            'captcha' => [
                'class' => 'yii\captcha\CaptchaAction',
                'fixedVerifyCode' => YII_ENV_TEST ? 'testme' : null,
            ],
        ];
    }
    public function actionObektadd()
    {
        
        $deletid=Yii::$app->request->post('deletid');
        if($deletid!=''){
            Obekt::updateAll(['del_flag'=>0],['id'=>$deletid]);    
            return '-1';
        }
        $name=Yii::$app->request->post('name');
        $masul=Yii::$app->request->post('masul');
        $tel=Yii::$app->request->post('telefon');
        $obektid=Yii::$app->request->post('obektid');
        
        if ($obektid==0)
        {
            $mod = new obekt();
            $mod->user_id=Yii::$app->getUser()->id;
            $mod->name = $name;
            $mod->masul = $masul;
            $mod->tel = $tel;
            $mod->save();        
            $id=$mod->id;
        
        $a = '<tr style="background-color:#B6E8F8;" id="'.$id.'" class="slqator-'.$id.'">
                <td>
                   <span class="name'.$id.'">'.$name.'</span>
                </td>
                <td>
                <span  class="masul'.$id.'">'.$masul.'</span>
                </td>
                <td>
                <span  class="telefon'.$id.'">'.$tel.'</span>
                </td>
                <td>
                    <button type="button" class="edit btn btn-primary" data-toggle="modal" data-target="#myModal"><span class="glyphicon glyphicon-pencil"></span></button>
                </td>
                <td>
                <button type="button" class="delete btn btn-danger" data-toggle="modal" data-target="#modaldelete"><span class="glyphicon glyphicon-trash"></span></button>
                </td>
            </tr>';
          return $a;  
         }
         else
         {
             Obekt::updateAll([
                 'name'=>$name,
                 'masul'=>$masul,
                 'tel'=>$tel,
                ], ['id'=>$obektid]);
                 return $id;
         }
    }

    public function actionOfisiant()
    {date_default_timezone_set("Asia/Tashkent");
        $date1 = Yii::$app->request->post('date1');
        if(!$date1){date_default_timezone_set("Asia/Tashkent"); $date1 = date('Y-m-d');}
        $s = Asos::find()->select('user_id,count(id) as kol,sum(summa_ch) as summa_ch')->where(['sana'=>$date1])->andWhere(['del_flag'=>1])->andWhere(['>','diler_id',0])->groupBy('user_id')->all();
        return $this->render('ofisiant',[
            's'=>$s
        ]);
    }
      public function actionKsndel()
    {
        $deleteid=Yii::$app->request->post('deleteid');
        if($deleteid!=''){
            SlaveMain::updateAll(['del_flag'=>0],['id'=>$deleteid]);
            return -1;
        }
    }
    public function actionIndex()
    {
        //$obekt = ArrayHelper::map(Yii::$app->db->createCommand('SELECT id, name FROM obekt WHERE del_flag=1')->queryAll(), 'id', 'name');
        $obekt = Obekt::find()->select('*')
            ->where('del_flag=1')
            ->from('obekt')
            ->orderby(['id' => SORT_ASC])->all();
        return $this->render('index',['obekt' => $obekt]);
    }
    public function actionKirim(){
        $asos = Asos::find()->select('a.id,a.nomer,a.sana,d.nom as dilernom,a.diler_id,a.summa,kurs,sum_d,summa_ch')
            ->where('a.tur_oper in (1,3,4,5) and a.del_flag=1 and a.client_id ='.Yii::$app->getUser()->identity->client_id)
            ->from('asos a')->leftJoin('s_diler d','d.id=a.diler_id')
            ->orderby(['a.id' => SORT_ASC])->all();
        $dilerlar = ArrayHelper::map(Yii::$app->db->createCommand('SELECT id, concat(nom," ",telsms1) as nom FROM s_diler WHERE del_flag=1')->queryAll(), 'id', 'nom');
        $tovarlar = ArrayHelper::map(Yii::$app->db->createCommand('SELECT id, nom FROM s_tovar WHERE del_flag=1')->queryAll(), 'id', 'nom');
        return $this->render('kirim',['dilerlar' => $dilerlar,'tovarlar' => $tovarlar,'asos' => $asos]);

    }
    public function actionDillers(){

        $asos = Asos::find()->select('a.id,a.nomer,a.sana,d.nom as diler,a.diler_id,a.summa,kurs,sum_d,summa_ch')
            ->where('a.tur_oper in (1,3,4,5) and a.del_flag=1 and a.client_id ='.Yii::$app->getUser()->identity->client_id)
            ->from('asos a')->leftJoin('s_diler d','d.id=a.diler_id')
            ->orderby(['a.id' => SORT_ASC])->all();
        $dilerlar = ArrayHelper::map(Yii::$app->db->createCommand('SELECT id, concat(nom," ",telsms1) as nom FROM s_diler WHERE del_flag=1')->queryAll(), 'id', 'nom');
        $tovarlar = ArrayHelper::map(Yii::$app->db->createCommand('SELECT id, nom FROM s_tovar WHERE del_flag=1')->queryAll(), 'id', 'nom');
        return $this->render('dilers',['dilerlar' => $dilerlar,'tovarlar' => $tovarlar,'asos' => $asos]);

    }
    public function actionKriditorlar(){
        $slave = Sinv::find()->select('*')
            ->from('s_inv')
            ->all();
        return $this->render('kriditorlar',['slave' => $slave]);

    }
    public function actionHaridor(){
                $slave = Haridor::find()->select('*')
            ->from('s_haridor')
            ->where(['del_flag'=>1])
            ->all();
        return $this->render('haridor',['slave' => $slave]);
    }
    public function actionHaridorkirit()
    {
        $deletid=Yii::$app->request->post('deletid');
        if($deletid!=''){
            Haridor::updateAll(['del_flag'=>0],['id'=>$deletid]);
            return -1;
        }
        $hnom=Yii::$app->request->post('hnom');
        $htel=Yii::$app->request->post('htel');
        $haridorid=Yii::$app->request->post('haridorid');
        if ($haridorid==0) 
        {
            $mod = new Haridor();
            $mod->user_id=Yii::$app->getUser()->id;
            $mod->nom = $hnom;
            $mod->telsms1 = $htel;
            $mod->save();
            $id=$mod->id;

            return '<tr style="background-color:#B6E8F8;" id="'.$id.'" class="slqator-'.$id.'">
                        <td>
                            <span class="nom'.$id.'">'.$hnom.'</span>
                        </td>
                        <td>
                            <span class="telsms1'.$id.'">'.$htel.'</span>
                        </td>
                        <td>
                            <button type="button" class="edit btn btn-primary" data-toggle="modal" data-target="#myModal"><span class="glyphicon glyphicon-pencil"></span></button>
                        </td>
                        <td>
                        <button type="button" class="delete btn btn-danger" data-toggle="modal" data-target="#modaldelete"><span class="glyphicon glyphicon-trash"></span></button>
                        </td>
                    </tr>';

        }
        else
        {
            Haridor::updateAll(['nom'=>$hnom,'telsms1'=>$htel],['id'=>$haridorid]);
            return  $haridorid;
        }
    }
    public function actionMahsulot(){
        $tovar = STovar::find()->select('*')
            ->from('s_tovar')
            ->where(['client_id' => Yii::$app->getUser()->identity->client_id])
            ->andWhere(['del_flag'=>1])
            ->limit(100)
            ->all();
        
        $kat = ArrayHelper::map(Yii::$app->db->createCommand('SELECT id, nom FROM s_kat')->queryAll(), 'id', 'nom');
        $brend = ArrayHelper::map(Yii::$app->db->createCommand('SELECT id, nom FROM s_brend')->queryAll(), 'id', 'nom');
        $s_izm = ArrayHelper::map(Yii::$app->db->createCommand('SELECT id, nom FROM s_izm')->queryAll(), 'id', 'nom');
        $s_izm1 = ArrayHelper::map(Yii::$app->db->createCommand('SELECT id, nom FROM s_izm1')->queryAll(), 'id', 'nom');
        

        return $this->render('mahsulot',[
            'kat' => $kat,
            'brend' => $brend,
            's_izm' => $s_izm,
            's_izm1' => $s_izm1,
            'tovar' => $tovar]);

    }
    public function actionMahsulotadd()
    {
        
        $deletid=Yii::$app->request->post('deletid');
        if($deletid!=''){
            STovar::updateAll(['del_flag'=>0],['id'=>$deletid]);    
            return '-1';
        }
        $nom=Yii::$app->request->post('nom');
        $nom_sh=Yii::$app->request->post('nom_sh');
        $kat=Yii::$app->request->post('kat');
        if($kat=='') {$kat=0;}
        $kol_in=Yii::$app->request->post('kol_in');
        $brend=Yii::$app->request->post('brend');
        if($brend=='') {$brend=0;}
        $s_izm=Yii::$app->request->post('s_izm');
        if($s_izm=='') {$s_izm=0;}
        $s_izm1=Yii::$app->request->post('s_izm1');
        if($s_izm1=='') {$s_izm1=0;}
        $sena=Yii::$app->request->post('sena');
     //   $sena_d=Yii::$app->request->post('sena_d');
        $sotish=Yii::$app->request->post('sotish');
       // $sotish_d=Yii::$app->request->post('sotish_d');
        // $ulg1=Yii::$app->request->post('ulg1');
        // $ulg1_pl=Yii::$app->request->post('ulg1_pl');
        // $ulg2=Yii::$app->request->post('ulg2');
        // $ulg2_pl=Yii::$app->request->post('ulg2_pl');
        // $bank=Yii::$app->request->post('bank');
        $tkol=Yii::$app->request->post('tkol');
        $tkol_in=Yii::$app->request->post('tkol_in');
        $tovarid=Yii::$app->request->post('tovarid');
        if ($tovarid==0)
        {
        $mod = new STovar();
        $mod->user_id=Yii::$app->getUser()->id;
        $mod->client_id = Yii::$app->getUser()->identity->client_id;
        $mod->nom = $nom;
        $mod->nom_sh = $nom_sh;
        $mod->kol_in = $kol_in;
        
        $mod->kat = $kat;
        $mod->brend = $brend;
        $mod->izm_id = $s_izm;
        $mod->izm1 = $s_izm1;
        $mod->sena = $sena;
       // $mod->sena_d = $sena_d;
        $mod->sotish = $sotish;
       // $mod->sotish_d = $sotish_d;
        // $mod->ulg1 = $ulg1;
        // $mod->ulg1_pl = $ulg1_pl;
        // $mod->ulg2 = $ulg2;
        // $mod->ulg2_pl = $ulg2_pl;
        // $mod->bank = $bank;
        
        $mod->save();        
        $id=$mod->id;
        if ($tkol + $tkol_in > 0){

             $asos = Asos::find()->select('id')->where(['tur_oper'=>5 ])->one();            
            
            $mod = new AsosSlave();
            $mod->user_id=Yii::$app->getUser()->id;
            $mod->kol = $tkol;
         //   $mod->kol_in = $tkol_in;
            $mod->kol_ost = $tkol;
          //  $mod->kol_in_ost = $tkol_in;
            $mod->asos_id = $asos['id'];
            $mod->tovar_id = $id;
            $mod->save();
            return '-'+$id;
        }else{

        }
        
        $a = '<tr style="background-color:#B6E8F8;" id="'.$id.'" class="slqator-'.$id.'">
                <td>
                   <span class="nom'.$id.'">'.$nom.'</span>
                </td>
                <td hidden>
                <span  class="nom_sh'.$id.'" hidden>'.$nom_sh.'</span>
                </td>
                <td hidden>
                <span  class="kol_in'.$id.'" hidden>'.$kol_in.'</span>
                </td>
                <td hidden>
                <input type="text" class="katid'.$id.'" value="'.$kat.'" name="katt" hidden >
                <span  class="kat'.$id.'" hidden>'.$kat.'</span>
                </td>
                <td hidden>
                <input type="text" class="brendid'.$id.'" value="'.$brend.'" name="brendd" hidden >
                <span  class="brend'.$id.'" hidden>'.$brend.'</span>
                </td>
                <td hidden>
                <input type="text" class="izm_idid'.$id.'" value="'.$izm_id.'" name="izm_id" hidden >
                <span  class="izm_id'.$id.'" hidden>'.$izm_id.'</span>
                </td>       
                <td hidden>
                <input type="text" class="izm1id'.$id.'" value="'.$izm1.'" name="izm1" hidden >
                <span  class="izm1'.$id.'" hidden>'.$izm1.'</span>
                </td>       
                <td hidden>
                <span  class="sena'.$id.'" hidden>'.$sena.'</span>
                </td>   
                <td hidden>
                <span  class="sena_d'.$id.'" hidden>'.$sena_d.'</span>
                </td>     
                <td hidden>
                <span  class="sotish'.$id.'" hidden>'.$sotish.'</span>
                </td>
                 <td hidden>
                 <span  class="sotish_d'.$id.'" hidden>'.$sotish_d.'</span>
                 </td>
                 <td hidden>
                 <span  class="ulg1'.$id.'" hidden>'.$ulg1.'</span>
                 </td>
                 <td hidden>
                 <span  class="ulg1_pl'.$id.'" hidden>'.$ulg1_pl.'</span>
                 </td>
                 <td hidden>
                <span  class="ulg2'.$id.'" hidden>'.$ulg2.'</span>
                 </td>
                 <td hidden>
                <span  class="ulg2_pl'.$id.'" hidden>'.$ulg2_pl.'</span>
                 </td>
                 <td hidden>
                 <span  class="bank'.$id.'" hidden>'.$bank.'</span>
                 </td>
                   <td>
                   <?=ActiveForm::begin([action=>[site/mahsulotslave]])?>
                   
                   <input type="text" name="tnom" value="<?=$sl['.$nom.']?>" hidden>
                    
                    <button type ="submit" class="btn btn-success"><span class="glyphicon glyphicon-shopping-cart"></span></button>
                    <?= ActiveForm::end()?>
                </td>
                <td>
                    <button type="button" class="edit btn btn-primary" data-toggle="modal" data-target="#myModal"><span class="glyphicon glyphicon-pencil"></span></button>
                </td>
                <td>
                <button type="button" class="delete btn btn-danger" data-toggle="modal" data-target="#modaldelete"><span class="glyphicon glyphicon-trash"></span></button>
                </td>
            </tr>';
          return $a;  
         }
         else
         {
             STovar::updateAll([
                 'nom'=>$nom,
                 'nom_sh'=>$nom_sh,
                 'papka'=>$papka,
                 'kol_in'=>$kol_in,
                 'kat'=>$kat,
                 'brend'=>$brend,
                 'sena'=>$sena,
                 //'sena_d'=>$sena_d,
                 'sotish'=>$sotish,
                 //'sotish_d'=>$sotish_d,
                 //'ulg1'=>$ulg1,
                 //'ulg1_pl'=>$ulg1_pl,
                 //'ulg2'=>$ulg2,
                 //'ulg2_pl'=>$ulg2_pl,
                // 'bank'=>$bank
                ], ['id'=>$tovarid]);
                 return $id;
         }
        
    }
    public function actionMijozchange()
    {
        $haridor=Yii::$app->request->post('haridor');
        $jid=Yii::$app->request->post('jid');
        date_default_timezone_set("Asia/Tashkent");$date = date("Y-m-d");
        $s = \frontend\models\Asos::find()->where(['sana'=>$date])->andWhere(['diler_id'=>0])->andWhere(['user_id'=>Yii::$app->getUser()->id])->one();

        Asos::updateAll(['h_id'=>$haridor],['id'=>$s['id']]);
        return $s['id'];
    }
    public function actionSaveasos()
    {

        $delasosid=Yii::$app->request->post('delasosid');
        if($delasosid!=''){
            Asos::updateAll(['del_flag'=>0],['id'=>$delasosid]);    
            return '-1';
        }
        $nomer=Yii::$app->request->post('nomer');
        $sana=Yii::$app->request->post('sana');
        $diler=Yii::$app->request->post('diler');
        $jid=Yii::$app->request->post('jid');
        $dilername=Yii::$app->request->post('dilername');

        if ($jid==0)
        {
        $mod = new Asos();
        $mod->user_id=Yii::$app->getUser()->id;
        $mod->client_id = Yii::$app->getUser()->identity->client_id;
        $mod->diler_id = $diler;
        $mod->nomer = $nomer;
        $mod->sana = $sana;
        $mod->tur_oper = 1;
        $mod->save();
        $id=$mod->id;
        return '<tr style="background-color:#B6E8F8;" id="'.$id.'" class="slqator-'.$id.'">
                        <td>
                            <span class="nomer'.$id.'">'.$nomer.'</span>
                        </td>
                        <td>
                            <span class="sana'.$id.'">'.$sana.'</span>
                        </td>
                        <td>
                            <input class="dilernom'.$id.'"value="'.$diler.'" hidden />
                            <span class="dilername'.$id.'">'.$dilername.'</span>
                        </td>
                        <td class="one" >
                        </td>
                        <td class="two" >
                        </td>
                        <td class="three" >
                        </td>
                        <td>
                            <button type ="submit" class="btn btn-success" ><span class="glyphicon glyphicon-shopping-cart"></span></button>
                        </td>
                        <td>
                            <button type="button" class="asosedit btn btn-primary" data-toggle="modal" data-target="#asosmodal"><span class="glyphicon glyphicon-pencil"></span></button>
                        </td>
                        <td>                
                            <button type="button" class="delasos btn btn-danger" data-toggle="modal" data-target="#asosdel"><span class="glyphicon glyphicon-trash"></span></button>
                        </td>
                    </tr>';
        }
        else
        {
            Asos::updateAll(['diler_id'=>$diler,'sana'=>$sana,'nomer'=>$nomer],['id'=>$jid]);
            return $id;
        }
        
    }

        // $asos = Asos::find()->select('sum(summa_all) as summa_all,sum(kol+kol_in) as kol')
        //     ->where('del_flag=1 and asos_id='.$jid)->from('asos_slave')
        //     ->groupBy('asos_id')->all();
        // Asos::updateAll(['nomer' => $nomer,'sana' => $sana,'diler_id' => $diler,'changedate'=>date("Y-m-d"),'summa'=>$asos[summa_all],'kol'=>$asos[kol],'sum_d'=>0],['id'=>$jid]);
        // return $jid;
    
    public function actionSaqlaslave()
    {
        $deletid=Yii::$app->request->post('deletid');
        if($deletid!=''){
            AsosSlave::updateAll(['del_flag'=>0],['id'=>$deletid]);    
            return '-1';
        }

        $id=Yii::$app->request->post('id');
        $tovar_id=Yii::$app->request->post('tovar_id');
        $asosid=Yii::$app->request->post('asosid');
        $kol=Yii::$app->request->post('kol');
        $sena=Yii::$app->request->post('sena');
        $summa=$kol*$sena;
        $tovarnom=Yii::$app->request->post('tovarnom');

        if ($id==0) {
            $mod = new AsosSlave();
            $mod->tovar_id = $tovar_id;
            $mod->user_id=Yii::$app->getUser()->id;
            $mod->asos_id = $asosid;
            $mod->kol = $kol;
            $mod->summa = $kol*$sena;
            $mod->sena = $sena; 
            $mod->save();
            $id=$mod->id;
            return '<tr style="background-color:#B6E8F8;" id="'.$id.'" class="slqator-'.$id.'">
                        <td>
                            <input type="text" class="tid'.$id.'>" value="'.$id.'" name="asosid" hidden >
                            <span class="tovarnom'.$id.'">'.$tovarnom.'</span>

                        </td>
                        <td>
                            <span class="kol'.$id.'">'.$kol.'</span>
                        </td>
                        <td>
                            <span class="sena'.$id.'">'.$sena.'</span>
                        </td>
                        <td>
                            <span class="summa'.$id.'">'.$summa.'</span>
                        </td>
                        <td>
                            <button type="button" class="edit btn btn-primary" data-toggle="modal" data-target="#myModal"><span class="glyphicon glyphicon-pencil"></span></button>
                        </td>
                        <td>
                        <button type="button" class="delete btn btn-danger" data-toggle="modal" data-target="#mudalit"><span class="glyphicon glyphicon-trash"></span></button>
                        </td>
                    </tr>';

        
        }
        else
        {
            AsosSlave::updateAll(['tovar_id'=>$tovar_id,'kol'=>$kol,'sena'=>$sena,'summa'=>$summa],['id'=>$id]);
        }
        return $id;
    }//serialar
    public function actionSerialar(){
       
        $slave = Main::find()->select('main.id, main.serial, main.qrkod, t.nom as tnom, cl.nom as clnom')
            ->from('main')->leftJoin('s_tovar t','main.tovar_id=t.id')->leftJoin('s_client cl','main.clientid=cl.id')
            ->all();
        $s_tovar = ArrayHelper::map(Yii::$app->db->createCommand('SELECT id, nom FROM s_tovar ')->queryAll(), 'id', 'nom');
        $s_client = ArrayHelper::map(Yii::$app->db->createCommand('SELECT id, nom FROM s_client WHERE del_flag=1')->queryAll(), 'id', 'nom');
        return $this->render('serialar',['s_tovar' => $s_tovar,'s_client' => $s_client,'slave'=>$slave]);
    }
        public function actionSerialkirit(){

        $seriaid=Yii::$app->request->post('seriaid');
        $mseria=Yii::$app->request->post('mseria');
        $mqrkod=Yii::$app->request->post('mqrkod');
        $s_tovar=Yii::$app->request->post('s_tovar');
        $s_client=Yii::$app->request->post('s_client');
        if ($seriaid==0) 
        {
            $mod = new Main();
            $mod->user_id=Yii::$app->getUser()->id;
            $mod->serial = $mseria;
            $mod->qrkod = $mqrkod;
            $mod->tovar_id = $s_tovar;
            $mod->clientid = $s_client;
            $mod->save();
            $id=$mod->id;
            return '<tr style="background-color:#B6E8F8;" id="'.$id.'" class="slqator-'.$id.'">
                        <td>
                            <span class="main'.$id.'">'.$mseria.'</span>
                        </td>
                        <td>
                            <span class="qrkod'.$id.'">'.$mqrkod.'</span>
                        </td>
                        <td>
                            <span class="tnom'.$id.'">'.$s_tovar.'</span>
                        </td>
                        <td>
                            <span class="clnom'.$id.'">'.$s_client.'</span>
                        </td>
                        <td>
                            <button type="button" class="edit btn btn-primary" data-toggle="modal" data-target="#myModal"><span class="glyphicon glyphicon-pencil"></span></button>
                        </td>
                    </tr>';

        }
        else
        {
            Main::updateAll([
                    'serial' => $mseria,
                    'qrkod' => $mqrkod,
                    'tovar_id' => $s_tovar,
                    'clientid'=> $s_client,
                ],
                ['id'=>$seriaid]);
            return  $seriaid;
        }
    }
    public function actionTovarslave()
    {
        $shtrix = Yii::$app->request->get('shtrix'); 
        $seriya='';$tovarId='';
        
        if ($shtrix!=''){
            if(strlen($shtrix)!=13){
                $seriya=$shtrix.' bu shtrix kod emas !!!';$shtrix='';
            }
            else
            {
                $seriya=$shtrix.' shtrix topildi';
            }    
        }    
        //if($otdelId==null ){$otdelId='1';};

        date_default_timezone_set("Asia/Tashkent");$date = date("Y-m-d");
        $s = Asos::find()->where(['sana'=>$date])->andWhere(['diler_id'=>0])->andWhere(['user_id'=>Yii::$app->getUser()->id])->one();
        if ($s['sana'] == null) {
            $model = new Asos();
            $model->client_id = Yii::$app->getUser()->identity->client_id;
            $model->user_id = Yii::$app->getUser()->id;
            $model->xodim_id = Yii::$app->getUser()->id;
            $model->sana = $date;
            $model->diler_id = "0";
            $model->tur_oper = 2;
            $model->save();
            $s = Asos::find()->where(['sana' => $date])->andWhere(['diler_id' => 0])->andWhere(['user_id' => Yii::$app->getUser()->id])->one();
        }
        
        $asosid=Yii::$app->request->post('asosid');
        Asos::updateAll(['print_flag'=>0],['print_flag'=>-1]); //999 
        Asos::updateAll(['print_flag'=>-1],['id'=>$asosid]); 
        $deletid=Yii::$app->request->post('deletid');
        $mahsulotid=Yii::$app->request->post('mashulotid');
        if($deletid!=''){
            AsosSlave::updateAll(['del_flag'=>0],['id'=>$deletid]);    
            $query = AsosSlave::find()->select('count(id) as kol,summa(sotish) as jami')->from('asos_slave')->groupBy('asos_id')->where('asos_id=' + $asosid)->one();
            return $query;
            Asos::updateAll(['kol'=>$query['kol'],'summa'=>$query['jami']],['id'=>$asosid]);
            

            return json_encode($array);
        }

/*         $provider = new ActiveDataProvider([
               'query' => Post::find(),
                'pagination' => [
                'pageSize' => 20,
              ],
        ]);

 */
        $query = AsosSlave::find()->select('s.id,t.nom,s.tovar_id,kol,summa,s.sena')
            ->from('asos_slave s')->leftJoin('s_tovar t','s.tovar_id=t.id')->where(['asos_id'=>$asosid,'s.del_flag'=>1]);
        $countQuery = clone $query;
        $pages = new Pagination(['totalCount' => $countQuery->count(), 'pageSize' => 1]);
        $pages->pageSizeParam = false;
        $models = $query->offset($pages->offset)
        ->limit($pages->limit)
        ->all();



        {$tovarlar = ArrayHelper::map(Yii::$app->db->createCommand('SELECT id, nom FROM s_tovar WHERE del_flag=1')->queryAll(), 'id', 'nom');}
        return $this->render('tovarslave',['asosid' => $asosid,'mahsulotid' => $mahsulotid,'tovarlar' => $tovarlar,'models' => $models,
        'pages' => $pages,]
        
        );

    }
    public function actionMahsulotslave()
    {
        //$mahsulotid=Yii::$app->request->post('mashulotid');
        if($deletid!=''){
            AsosSlave::updateAll(['del_flag'=>0],['id'=>$deletid]);    
            $query = AsosSlave::find()->select('count(id) as kol,summa(sotish) as jami')->from('asos_slave')->groupBy('asos_id')->where('asos_id=' + $asosid)->one();
            return $query;
            Asos::updateAll(['kol'=>$query['kol'],'summa'=>$query['jami']],['id'=>$asosid]);
            

            return json_encode($array);

        }

        $tovarlar = ArrayHelper::map(Yii::$app->db->createCommand('SELECT id, nom FROM s_tovar WHERE del_flag=1')->queryAll(), 'id', 'nom');
        return $this->render('mahsulotslave',['tovarlar' => $tovarlar]);

    }
        public function actionXarajatturlari(){
       
        $slave = S_x_tur::find()->select('*')
            ->from('s_x_tur')
            ->all();
       

        return $this->render('xarajatturlari',['slave'=>$slave]);
    }// xarajatkirit
     public function actionXarajatkirit()
    {

        $xarajatid=Yii::$app->request->post('xarajatid');
        $xnom=Yii::$app->request->post('xnom');
        if ($xarajatid==0) 
        {
            $mod = new S_x_tur();
            $mod->nom = $xnom;
            $mod->status = 1;
            $mod->save();
            $id=$mod->id;

            return '<tr style="background-color:#B6E8F8;" id="'.$id.'" class="slqator-'.$id.'">
                        <td>
                            <span class="xnom'.$id.'">'.$xnom.'</span>
                        </td>
                        <td>
                            <button type="button" class="edit btn btn-primary" data-toggle="modal" data-target="#myModal"><span class="glyphicon glyphicon-pencil"></span></button>
                        </td>
                    </tr>';

        }
        else
        {
            S_x_tur::updateAll([
                'nom'=>$xnom,],['id'=>$xarajatid]);
            return  $xarajatid;
        }
    }
    public function actionMijozqosh()
    {
        $fio=Yii::$app->request->post('fio');$tel=Yii::$app->request->post('tel');$jid=Yii::$app->request->post('jid');
        $mod = new Haridor();$mod->client_id = Yii::$app->getUser()->identity->client_id;
        $mod->nom = $fio;$mod->telsms1 = $tel;$mod->save();$id=$mod->id;
        Asos::updateAll(['h_id'=>$id],['id'=>$jid]);
        return $id;
    }
    public function actionDilerqosh()
    {
        $fio=Yii::$app->request->post('fio');
        $tel=Yii::$app->request->post('tel');
        $jid=Yii::$app->request->post('jid');
        $mod = new Diler();$mod->client_id = Yii::$app->getUser()->identity->client_id;
        $mod->nom = $fio;$mod->telsms1 = $tel;
        $mod->save();$id=$mod->id;
        Asos::updateAll(['diler_id'=>$id],['id'=>$jid]);
        return $id;
    }
    public function actionDilermodal()
    {
        $fio=Yii::$app->request->post('fio');
        $tel=Yii::$app->request->post('tel');
        $mod = new Diler();$mod->client_id = Yii::$app->getUser()->identity->client_id;
        $mod->nom = $fio;$mod->telsms1 = $tel;
        $mod->save();$id=$mod->id;
        Asos::updateAll(['diler_id'=>$id],['id'=>$jid]);
        return $id;
    }
    public function actionDilerkirit()
    {
        $deletid=Yii::$app->request->post('deletid');
        if($deletid!=''){
            Diler::updateAll(['del_flag'=>0],['id'=>$deletid]);
            return -1;
        }
        $fio=Yii::$app->request->post('fio');
        $tel=Yii::$app->request->post('tel');
        $dilerid=Yii::$app->request->post('dilerid');
        if ($dilerid==0) 
        {
            $mod = new Diler();
            $mod->user_id=Yii::$app->getUser()->id;
            $mod->nom = $fio;
            $mod->telsms1 = $tel;
            $mod->save();
            $id=$mod->id;

            return '<tr style="background-color:#B6E8F8;" id="'.$id.'" class="slqator-'.$id.'">
                        <td>
                            <span class="nom'.$id.'">'.$fio.'</span>
                        </td>
                        <td>
                            <span class="telsms1'.$id.'">'.$tel.'</span>
                        </td>
                        <td>
                            <button type="button" class="edit btn btn-primary" data-toggle="modal" data-target="#myModal"><span class="glyphicon glyphicon-pencil"></span></button>
                        </td>
                        <td>
                        <button type="button" class="delete btn btn-danger" data-toggle="modal" data-target="#modaldelete"><span class="glyphicon glyphicon-trash"></span></button>
                        </td>
                    </tr>';

        }
        else
        {
            Diler::updateAll(['nom'=>$fio,'telsms1'=>$tel],['id'=>$dilerid]);
            return  $dilerid;
        }
    }
    public function actionKridittoradd()
    {
        $kriditnom=Yii::$app->request->post('kriditnom');
        $ktelefon=Yii::$app->request->post('ktelefon');
        $kriditorid=Yii::$app->request->post('kriditorid');
        if ($kriditorid==0) 
        {
            $mod = new Sinv();
            $mod->user_id=Yii::$app->getUser()->id;
            $mod->nom = $kriditnom;
            $mod->tel = $ktelefon;
            $mod->save();
            $id=$mod->id;

            return '<tr style="background-color:#B6E8F8;" id="'.$id.'" class="slqator-'.$id.'">
                        <td>
                            <span class="nom'.$id.'">'.$kriditnom.'</span>
                        </td>
                        <td>
                            <span class="tel'.$id.'">'.$ktelefon.'</span>
                        </td>
                        <td>
                            <button type="button" class="edit btn btn-primary" data-toggle="modal" data-target="#myModal"><span class="glyphicon glyphicon-pencil"></span></button>
                        </td>
                        <td>
                        <button type="button" class="delete btn btn-danger" data-toggle="modal" data-target="#modaldelete"><span class="glyphicon glyphicon-trash"></span></button>
                        </td>
                    </tr>';

        }
        else
        {
            Sinv::updateAll(['nom'=>$kriditnom,'tel'=>$ktelefon],['id'=>$kriditorid]);
            return  $kriditorid;
        }
    }
    public function actionTolovnomlar()
    {
        $s_vid = ArrayHelper::map(Yii::$app->db->createCommand('SELECT id, concat(nom," ") as nom FROM s_pl')->queryAll(), 'id', 'nom');
        $vo = ArrayHelper::map(Yii::$app->db->createCommand('SELECT id, nom  FROM s_x_tur ')->queryAll(), 'id', 'nom');
        $d_pl = ArrayHelper::map(Yii::$app->db->createCommand('SELECT id, d_pl FROM pl ')->queryAll(), 'id', 'd_pl');
        return $this->render('tolovnomlar',['s_vid' => $s_vid,'vo' => $vo,'d_pl'=>$d_pl,'pl' => $pl]);
      //tolovkirit
    }
    public function actionTolovkirit()
    {
        // Delete modal 
        $deletid=Yii::$app->request->post('deletid');
        if($deletid!=''){
            Pl::updateAll(['del_flag'=>0],['id'=>$deletid]);
            return -1;
        }
        // Qo'shish modal
        $tolovid=Yii::$app->request->post('tolovid');
        $s_vid=Yii::$app->request->post('s_vid');
        $vo=Yii::$app->request->post('vo');
        if($vo=='') {$vo=0;} 
        $n_pl=Yii::$app->request->post('n_pl');
        $d_pl=Yii::$app->request->post('d_pl');
        $sena_pl=Yii::$app->request->post('sena_pl');
        $kurs=Yii::$app->request->post('kurs');
        $sena_d=Yii::$app->request->post('sena_d');
        $prim=Yii::$app->request->post('prim');
        if ($tolovid==0) 
        {
            $mod = new Pl();
            $mod->user_id=Yii::$app->getUser()->id;
            $mod->vid = $s_vid;
            $mod->vo = $vo;
            $mod->n_pl = $n_pl;
            $mod->d_pl = $d_pl;
            $mod->sena_pl = $sena_pl;
            $mod->kurs = $kurs;
            $mod->sena_d = $sena_d;
            $mod->prim = $prim;
            $mod->save();
            $id=$mod->id;

            return '<tr style="background-color:#B6E8F8;" id="'.$id.'" class="slqator-'.$id.'">
                        <td>
                            <span class="n_pl'.$id.'">'.$n_pl.'</span>
                        </td>
                        <td>
                            <span class="d_pl'.$id.'">'.$d_pl.'</span>
                        </td>
                        <td>
                            <span class="sena_pl'.$id.'">'.$sena_pl.'</span>
                        </td>
                        <td>
                            <span class="sena_d'.$id.'">'.$sena_d.'</span>
                        </td>
                        <td>
                            <span class="ov'.$id.'">'.$harajat.'</span>
                        </td>
                        <td>
                            <button type="button" class="edit btn btn-primary" data-toggle="modal" data-target="#myModal"><span class="glyphicon glyphicon-pencil"></span></button>
                        </td>
                        <td>
                        <button type="button" class="delete btn btn-danger" data-toggle="modal" data-target="#modaldelete"><span class="glyphicon glyphicon-trash"></span></button>
                        </td>
                    </tr>';

        }
        else
        {
            // O'zgartirish modal
            Pl::updateAll([
                    'vid' => $s_vid,
                    'vo' => $vo,
                    'n_pl' => $n_pl,
                    'd_pl' => $d_pl,
                    'sena_pl' => $sena_pl,
                    'kurs' => $kurs,
                    'sena_d' => $sena_d,
                    'prim' => $prim
                    ],
                ['id'=>$tolovid]);
            return  $tolovid;
        }
    }
    public function actionMijozclear()
    {date_default_timezone_set("Asia/Tashkent");
        $s = Asos::find()->where(['sana' => date("Y-m-d")])->andWhere(['diler_id' => 0])->andWhere(['user_id' => Yii::$app->getUser()->id])->one();
        Asos::updateAll(['h_id' => null], ['id' => $s['id']]);
        return "ok";
    }

    public function actionNokboss()
    {
        $summa=+Yii::$app->request->post('summa');$jid=Yii::$app->request->post('jid');
        $qkirit=+Yii::$app->request->post('qkirit');
        $qtxt=+Yii::$app->request->post('qtxt');
        $chtxt=+Yii::$app->request->post('chtxt');
        if(Yii::$app->request->post('oper')=="Chegirma") {
            if ($chtxt > 0) {
                Asos::updateAll(['cheg' => 0], ['id' => $jid]);
            } else {
                Asos::updateAll(['cheg' => $summa], ['id' => $jid]);
            }
        }
        if(Yii::$app->request->post('oper')=="Qarz") {
            if ($qtxt > 0) {
                Asos::updateAll(['qarz_summa' => 0], ['id' => $jid]);
            } else {
                Asos::updateAll(['qarz_summa' => $summa], ['id' => $jid]);
            }
        }
        if($qkirit!=0){
            if($qkirit>0)
            {
                Asos::updateAll(['qarz_summa'=>$qkirit],['id'=>$jid]);
            }
            else
            {
                Asos::updateAll(['qarz_summa'=>$summa+$qkirit],['id'=>$jid]);
            }
        }
        if(Yii::$app->request->post('oper')=="Naqd"){
            Asos::updateAll(['sum_naqd_ch'=>$summa,'sum_naqd'=>$summa,'sum_plast_ch'=>0,'sum_plastik'=>0,'sum_epos_ch'=>0,'sum_epos'=>0],['id'=>$jid]);
        }
        if(Yii::$app->request->post('oper')=="Plastik"){
            Asos::updateAll(['sum_naqd_ch'=>0,'sum_naqd'=>0,'sum_plast_ch'=>$summa,'sum_plastik'=>$summa,'sum_epos_ch'=>0,'sum_epos'=>0],['id'=>$jid]);
        }
        if(Yii::$app->request->post('oper')=="Bank"){
            Asos::updateAll(['sum_naqd_ch'=>0,'sum_naqd'=>0,'sum_plast_ch'=>0,'sum_plastik'=>0,'sum_epos_ch'=>$summa,'sum_epos'=>$summa],['id'=>$jid]);
        }
        if(Yii::$app->request->post('oper')=="taqsimlash"){
            $nkirit=+Yii::$app->request->post('nkirit');
            $pkirit=+Yii::$app->request->post('pkirit');
            $bkirit=+Yii::$app->request->post('bkirit');
            $qkirit=+Yii::$app->request->post('qkirit');
            $chkirit=+Yii::$app->request->post('chkirit');
            if($nkirit>0 && $pkirit==0 && $bkirit==0){
                Asos::updateAll(['sum_naqd_ch'=>$nkirit,'sum_naqd'=>$nkirit,'sum_plast_ch'=>$summa-$nkirit,'sum_plastik'=>$summa-$nkirit,'sum_epos_ch'=>0,'sum_epos'=>0],['id'=>$jid]);
            }
            if($pkirit>0 && $nkirit==0 && $bkirit==0){
                Asos::updateAll(['sum_plast_ch'=>$pkirit,'sum_plastik'=>$pkirit,'sum_naqd_ch'=>$summa-$pkirit,'sum_naqd'=>$summa-$pkirit,'sum_epos_ch'=>0,'sum_epos'=>0],['id'=>$jid]);
            }
            if($bkirit>0 && $nkirit==0 && $pkirit==0){
                Asos::updateAll(['sum_epos_ch'=>$bkirit,'sum_epos'=>$bkirit,'sum_naqd_ch'=>$summa-$pkirit,'sum_naqd'=>$summa-$pkirit,'sum_plast_ch'=>0,'sum_plastik'=>0],['id'=>$jid]);
            }
            if($bkirit>0 && $nkirit==0 && $pkirit>0){
                Asos::updateAll(['sum_epos_ch'=>$bkirit,'sum_epos'=>$bkirit,'sum_naqd_ch'=>0,'sum_naqd'=>0,'sum_plast_ch'=>$pkirit,'sum_plastik'=>$pkirit],['id'=>$jid]);
            }
            if($bkirit>0 && $nkirit>0 && $pkirit==0){
                Asos::updateAll(['sum_epos_ch'=>$bkirit,'sum_epos'=>$bkirit,'sum_naqd_ch'=>$nkirit,'sum_naqd'=>$nkirit,'sum_plast_ch'=>0,'sum_plastik'=>0],['id'=>$jid]);
            }
            if($qkirit>0){
                Asos::updateAll(['qarz_summa'=>$qkirit],['id'=>$jid]);
            }
            if($chkirit>0){
                Asos::updateAll(['cheg'=>$chkirit,'summa_ch'=>$summa-$chkirit],['id'=>$jid]);
            }
        }
        if(Yii::$app->request->post('oper'))   {return 'ok';}
        if(Yii::$app->request->post('taqsimlash'))   {return 'ok';}
        $date1 = Yii::$app->request->post('date1');
        if(!$date1) {date_default_timezone_set("Asia/Tashkent");$date1 = date('Y-m-d');}
        $haridorlar = ArrayHelper::map(Yii::$app->db->createCommand('SELECT id, concat(nom,telsms1) as nom FROM s_haridor WHERE id>0 and del_flag=1')->queryAll(), 'id', 'nom');
        $s = Asos::find()->where(['>','print_flag',0])->andwhere(['sana'=>$date1])->andWhere(['del_flag'=>1])->andWhere(['>','diler_id',0])->orderBy('user_id')->all();
        return $this->render('nokboss',[
            's'=>$s,'haridorlar' => $haridorlar
        ]);
    }    
    public function actionPladd()
    {
        $n_pl=Yii::$app->request->post('n_pl');
        if($n_pl==null){
            $s = SClient::find()->where(['id'=>Yii::$app->getUser()->identity->client_id])->one();
            if ($s['last_pl_k']=='0' or $s['last_pl_k']==null)
                {$n_pl='1';}
            else
                {$n_pl=$s['last_pl_k']+1;}
            SClient::updateAll(['last_pl_k' => $s['last_pl_k']+1], ['id'=>Yii::$app->getUser()->identity->client_id]);
        }
        $d_pl=Yii::$app->request->post('d_pl');
        $vid=Yii::$app->request->post('vid');
        $sena_pl=Yii::$app->request->post('sena_pl');
        $sena_d=Yii::$app->request->post('sena_d');
        $prim=Yii::$app->request->post('prim');
        $h_id=Yii::$app->request->post('h_id');
        $mod = new Pl();
        $mod->n_pl = $n_pl;$mod->d_pl = $d_pl;$mod->h_id = $h_id;$mod->vid  = $vid;
        $mod->sena_pl=$sena_pl;$mod->sena_d = $sena_d;$mod->prim = $prim;
        $mod->user_id   = Yii::$app->getUser()->id;
        $mod->client_id = Yii::$app->getUser()->identity->client_id;
        $mod->save();//$tamom=$mod->id;
        return $n_pl;
    }
    public function actionPledit()
    {
        $id=Yii::$app->request->post('id');
        $n_pl=Yii::$app->request->post('n_pl');
        if($n_pl===null){
            $s = SClient::find()->where(['id'=>Yii::$app->getUser()->identity->client_id])->one();
            if ($s['last_pl_k']=='0' or $s['last_pl_k']==null)
                {$n_pl='1';}
            else
                {$n_pl=$s['last_pl_k']+1;}
            SClient::updateAll(['last_pl_k' => $s['last_pl_k']+1], ['id'=>Yii::$app->getUser()->identity->client_id]);
        }
        $d_pl=Yii::$app->request->post('d_pl');
        $vid=Yii::$app->request->post('vid');
        $sena_pl=Yii::$app->request->post('sena_pl');
        $sena_d=Yii::$app->request->post('sena_d');
        $prim=Yii::$app->request->post('prim');
        Pl::updateAll(['n_pl' => $n_pl, 'd_pl' => $d_pl, 'vid' => $vid, 'sena_pl' => $sena_pl, 'sena_d' => $sena_d, 'prim' => $prim], ['id' => $id]);
        return $n_pl;
    }
    public function actionTovaradd()
        {
            $kol=Yii::$app->request->post('kol'); $kol_in=Yii::$app->request->post('kol_in');
            $sot=Yii::$app->request->post('sot'); $sotin=Yii::$app->request->post('sotin');
            $esk=Yii::$app->request->post('esk'); date_default_timezone_set("Asia/Tashkent");$date = date("Y-m-d");
            $cldollar = SClient::find()->where(['id'=>Yii::$app->getUser()->identity->client_id])->one();
            $s = \frontend\models\Asos::find()->where(['sana'=>$date])->andWhere(['diler_id'=>0])->andWhere(['user_id'=>Yii::$app->getUser()->id])->one();
            if($s['sana'] == null){
                $model = new Asos();
                $model->client_id = Yii::$app->getUser()->identity->client_id;
                $model->user_id = Yii::$app->getUser()->id;$model->xodim_id = Yii::$app->getUser()->id;
                $model->sana = $date;$model->diler_id= "0";$model->tur_oper = 2;//$model->summa= $summa;
                $model->save();
                $s = \frontend\models\Asos::find()->where(['sana'=>$date])->andWhere(['diler_id'=>0])->andWhere(['user_id'=>Yii::$app->getUser()->id])->one();
            }
            $tek = AsosSlave::find()->select('*')->where(['id'=>$esk])->one();
            $drone = Yii::$app->request->post('drone');
            if ($drone=='1') { $ds='asos_slave.sotish = '+$tek['sotish'];}
            if ($drone=='2') { $ds='asos_slave.opt1  = '+$tek['opt1'];}
            if ($drone=='3') { $ds='asos_slave.opt1_pl  = '+$tek['opt1_pl'];}
            if ($drone=='4') { $ds='asos_slave.opt2  = '+$tek['opt2'];}
            if ($drone=='5') { $ds='asos_slave.opt2_pl  = '+$tek['opt2_pl'];}
            if ($drone=='6') { $ds='asos_slave.schet= '+$tek['schet'];}
            if ($drone=='') { $ds='asos_slave.sotish= '+$tek['sotish'];}
            
            $tek_all = AsosSlave::find()->select('asos_slave.*')->from('asos_slave,asos')
            ->where('asos.id = asos_slave.asos_id and asos_slave.del_flag = 1 and (asos.tur_oper=1 or asos.tur_oper=4 or asos.tur_oper=5) and (asos_slave.kol_ost>0 || asos_slave.kol_in_ost>0 ) and asos.client_id = ' .Yii::$app->getUser()->identity->client_id.' and tovar_id='.$tek['tovar_id'].' and '.$ds)->all();
            STovar::updateAll(['upakavka'=> null],['id'=>$tek['tovar_id']]);
            $t_sql = STovar::find()->select('*')->where(['id'=>$tek['tovar_id']])->one();
            $kol_jami = $kol * $t_sql['kol_in'] + $kol_in;
            $ost_jami = 0;
            foreach ($tek_all as $item){
                $ost_jami = $ost_jami + $item['kol_ost'] * $t_sql['kol_in'] + $item['kol_in_ost'];
            }
            if($ost_jami < $kol_jami){
                $kam = $ost_jami - $kol_jami;
                return $kam;
            }
            if($kol==0 && $kol_in==0){
                return 0;
            }
            foreach ($tek_all as $ost){
                $ost_jami = $ost['kol_ost'] * $t_sql['kol_in'] + $ost['kol_in_ost'];
                if($kol_jami>=$ost_jami){
                    $kol_jami = $kol_jami - $ost_jami;
                    //if($kol>$ost['kol_ost'] && $kolin>0){
                        $kol = (int)($ost_jami / $t_sql['kol_in']);
                        $kolin = $ost_jami - $kol*$t_sql['kol_in'];
                    //}
                    $j=$ost['sotish_d']+$ost['sotish_in_d'];
                    AsosSlave::updateAll(['kol_ost'=> 0,'kol_in_ost'=> 0],['id'=>$ost['id']]);
                    $mod = new AsosSlave();
                    $mod->tovar_nom = $t_sql['nom'];$mod->tovar_id = $ost['tovar_id'];
                    $mod->asos_id = $s['id'];$mod->user_id=Yii::$app->getUser()->id;
                    $mod->kol = $kol;$mod->kol_in = $kolin;
                    $mod->summa = $kol*$sot;$mod->summa_in = $kolin*$sotin;
                    if($cldollar['dollar']=='2' && $j>0)
                    {
                        $mod->sotish = $ost['sotish_d'];$mod->sotish_in = $ost['sotish_in_d'];
                        $mod->opt1 = $kol*$ost['sotish_d'] + $kolin*$ost['sotish_in_d'];
                        $mod->summa = $kol*$ost['sotish_d'];$mod->summa_in = $kolin*$ost['sotish_in_d'];
                    }
                    else
                    {
                        $mod->sotish = $sot;$mod->sotish_in = $sotin;
                        $mod->summa_all = $kol*$sot + $kolin*$sotin;
                        $mod->summa = $kol*$sot;$mod->summa_in = $kolin*$sotin;
                    }
                    $mod->sotish_d = $ost['sotish_d'];$mod->sotish_in_d = $ost['sotish_in_d'];
                    $mod->sena = $ost['sena'];$mod->sena_in = $ost['sena_in'];
                    $mod->sena_d = $ost['sena_d'];$mod->sena_in_d = $ost['sena_in_d'];
                    $mod->kol_ost = $ost['id'];$mod->kol_in_ost = 0;
                    $mod->izm_id = $ost['izm_id'];$mod->izm1 = $ost['izm1'];
                    $mod->save();$tamom=$mod->id;
                }
                elseif($kol_jami>0)
                {
                    $kol1 = (int)($kol_jami / $t_sql['kol_in']);
                    $kolin1 = $kol_jami - $kol1*$t_sql['kol_in'];
                    $kol_jami = $ost_jami - $kol_jami;
                    $kol = (int)($kol_jami / $t_sql['kol_in']);
                    $kolin = $kol_jami - $kol*$t_sql['kol_in'];
                    AsosSlave::updateAll(['kol_ost'=> $kol,'kol_in_ost'=> $kolin],['id'=>$ost['id']]);
                    $kol = $kol1;
                    $kolin = $kolin1;
                    $kol_jami = 0;
                    $j=$ost['sotish_d']+$ost['sotish_in_d'];
                    //return $j." dollar2";
                    $mod = new AsosSlave();
                    $mod->tovar_nom = $t_sql['nom'];$mod->tovar_id = $ost['tovar_id'];
                    $mod->asos_id = $s['id'];$mod->user_id=Yii::$app->getUser()->id;
                    $mod->kol = $kol;$mod->kol_in = $kolin;
                    if($cldollar['dollar']=='2' && $j>0)
                    {
                        $mod->sotish = $ost['sotish_d'];$mod->sotish_in = $ost['sotish_in_d'];
                        $mod->opt1 = $kol*$ost['sotish_d'] + $kolin*$ost['sotish_in_d'];
                        $mod->summa = $kol*$ost['sotish_d'];$mod->summa_in = $kolin*$ost['sotish_in_d'];
                    }
                    else
                    {
                        $mod->sotish = $sot;$mod->sotish_in = $sotin;
                        $mod->summa_all = $kol*$sot + $kolin*$sotin;
                        $mod->summa = $kol*$sot;$mod->summa_in = $kolin*$sotin;
                    }
                    $mod->sotish_d = $ost['sotish_d'];$mod->sotish_in_d = $ost['sotish_in_d'];
                    $mod->sena = $ost['sena'];$mod->sena_in = $ost['sena_in'];
                    $mod->sena_d = $ost['sena_d'];$mod->sena_in_d = $ost['sena_in_d'];
                    $mod->kol_ost = $ost['id'];$mod->kol_in_ost = 0;
                    $mod->izm_id = $ost['izm_id'];$mod->izm1 = $ost['izm1'];
                    $mod->save();$tamom=$mod->id;
                }
            }
            $ssum = AsosSlave::find()->select('count(tovar_id) as kol,sum(summa_all) as summa,sum(opt1) as opt1')
                ->Where(['asos_id'=>$s['id']])->groupBy('asos_id')->one();
            $sum_naqd = $ssum['summa'];
            $sum_d = $ssum['opt1'];
            $sum_naqd_ch = round($sum_naqd,0);$sum_d_ch = round($sum_d,2);
            $cheg_n = round($sum_naqd-$sum_naqd_ch,-2);$cheg_d = round($sum_d-$sum_d_ch,2);
            Asos::updateAll(['sum_plast_ch' => 0,'sum_epos_ch' => 0,'sum_epos' => 0,'sum_plastik' => 0,'sum_naqd' => $sum_naqd,'sum_naqd_ch' => $sum_naqd_ch,'cheg_n' => $cheg_n,'cheg_d' => $cheg_d,'summa_ch' => $sum_naqd_ch,'sum_d_ch' => $sum_d_ch,'kol' => $ssum['kol'],'summa' => $sum_naqd,'sum_d' => $sum_d],['id'=>$s['id']]);
            return $tamom;
        }
    public function actionCart(){
        $session = Yii::$app->session;
        if(isset($_POST['pid'])){
            $pid =$_POST['pid'];
//            $i=0;
//            if($_SESSION['cart2']){
//                foreach ($_SESSION['cart2'] as $item){
//                    $i++;
//                }
//                $_SESSION['cart2'][$i]=$pid;
//            }else{
            $_SESSION['new'][]=$pid;
//            }
        }

        $carts = AsosSlave::find()->where(['tovar_id'=>$session['new']])->all();
        return $this->render('cart',[
            'carts'=>$carts,
        ]);
    }
   public function actionAddnewslave()
    {
    	
           $mod = new AsosSlave();
                $mod->tovar_nom = "$nom";
                $mod->tovar_id = "2005";
                $mod->asos_id = 545;
                $mod->kol_in = 0;
                $mod->kol_in_ost = 0;
                $mod->kol_ost = 0;
                $mod->kol = 0;
                $mod->user_id=4;

                $mod->save();
    }

 
    public function actionAdd()
    {
        $asos = Yii::$app->request->post('asos_id');
        $idin = Yii::$app->request->post('id');
        $idsup = Yii::$app->request->post('idsup');
        $asosiy = Yii::$app->request->post('asosiy');
        $ichki = Yii::$app->request->post('ichki');
        $nom = Yii::$app->request->post('nom');
        $data = Yii::$app->request->post('data');


        $sotil = AsosSlave::find()->where(['asos_slave.del_flag'=>1])
            ->select('asos_slave.*,asos_slave.opt1 as sot,asos_slave.opt1_in as sotin')
            ->from('asos_slave')
            ->where(['asos_id'=>$asos])
            ->all();

        if($data){ 
            if(Yii::$app->getUser()->ustama==1)
            {$ustama='(asos_slave.sotish+s_tovar.ustama)';} else {$ustama='asos_slave.sotish';}
            $query = AsosSlave::find()->select('asos_slave.id as ids,'.$ustama.' as sot,asos_slave.sotish_in as sotin,asos_slave.kol_ost as kns,asos_slave.kol_in_ost as kolin,s_tovar.nom as nom , s_tovar.nom_sh as nom_sh ,s_tovar.id as idt, s_tovar.kol_in as tkol_in')
            ->from('asos_slave,asos,s_tovar')
            ->where('asos.id = asos_slave.asos_id and asos_slave.del_flag = 1 and (asos.tur_oper = 1 or asos.tur_oper=4 or asos.tur_oper=5) and (asos_slave.kol_ost>0 or asos_slave.kol_in_ost>0) and s_tovar.id = asos_slave.tovar_id and s_tovar.id = '.Yii::$app->request->post('data').' and asos.client_id = '.Yii::$app->getUser()->identity->client_id)->all();

            if(Yii::$app->request->post('ichki') || Yii::$app->request->post('asosiy')) {

                $mod = new AsosSlave();
                $mod->tovar_nom = $nom;
                $mod->tovar_id = $idin;
                $mod->asos_id = $asos;
                $mod->kol_in = $ichki;
                $mod->kol_in_ost = $idsup;
                $mod->kol_ost = $idsup;
                $mod->kol = $asosiy;
                $mod->user_id=Yii::$app->getUser()->id;

                $mod->save();

                $sotil = AsosSlave::find()->where(['asos_slave.del_flag'=>1])
                ->select('asos_slave.*,asos_slave.opt1 as sot,asos_slave.opt1_in as sotin')
                ->from('asos_slave')
                ->where(['asos_id'=>$asos])
                ->all();
                return $this->render('view',['asos'=>$asos, 'sotil'=>$sotil, 'query'=>$query]);
            }
            return $this->render('view',['asos'=>$asos, 'sotil'=>$sotil, 'query'=>$query]);
        }
        else
        {
            if(Yii::$app->getUser()->ustama==1)
            {$ustama='(asos_slave.sotish+s_tovar.ustama)';} else {$ustama='asos_slave.sotish';}
            $query = AsosSlave::find()->select('asos_slave.id as ids,'.$ustama.' as sot,asos_slave.sotish_in as sotin,asos_slave.kol_ost as kns,asos_slave.kol_in_ost as kolin,s_tovar.nom as nom , s_tovar.id as idt, s_tovar.kol_in as tkol_in')
                ->from('asos_slave,asos,s_tovar')
                ->where('asos.id = asos_slave.asos_id and asos_slave.del_flag = 1 and (asos.tur_oper=1 or asos.tur_oper=4 or asos.tur_oper=5) and (asos_slave.kol_ost>0 || asos_slave.kol_in_ost>0 ) and s_tovar.id = asos_slave.tovar_id and asos.client_id = ' .Yii::$app->getUser()->identity->client_id )
                ->limit(0)->all();
            if(Yii::$app->request->post('ichki') || Yii::$app->request->post('asosiy')) {
                $mod = new AsosSlave();
                $mod->tovar_nom = $nom;
                $mod->tovar_id = $idin;
                $mod->asos_id = $asos;
                $mod->kol_in_ost = $idsup;
                $mod->kol_ost = $idsup;
                $mod->kol_in = $ichki;
                $mod->kol = $asosiy;
                $mod->user_id=Yii::$app->getUser()->id;
                $mod->save();
                $sotil = AsosSlave::find()->where(['asos_slave.del_flag'=>1])
                ->select('asos_slave.*,asos_slave.opt1 as sot,asos_slave.opt1_in as sotin')
                ->from('asos_slave')
                ->where(['asos_id'=>$asos])
                ->all();
                return $this->render('view',['asos'=>$asos, 'sotil'=>$sotil, 'query'=>$query]);
            }
            return $this->render('view',['asos'=>$asos, 'sotil'=>$sotil, 'query'=>$query]);
        }
    }
    public function actionAddnew()
    {
        $haridor = Yii::$app->request->post('haridor');$drone = Yii::$app->request->post('drone');
        $otdelId = Yii::$app->request->post('otdel');$shtrix = Yii::$app->request->get('shtrix'); 
        $seriya='';$tovarId='';
        
        if ($shtrix!=''){
            if(strlen($shtrix)!=13){
                $seriya=$shtrix.' bu shtrix kod emas !!!';$shtrix='';
            }
            else
            {
                $seriya=$shtrix.' shtrix topildi';
            }    
        }    
        if($otdelId==null ){$otdelId='1';};

        date_default_timezone_set("Asia/Tashkent");$date = date("Y-m-d");
        $s = Asos::find()->where(['sana'=>$date])->andWhere(['diler_id'=>0])->andWhere(['user_id'=>Yii::$app->getUser()->id])->one();
        if ($s['sana'] == null) {
            $model = new Asos();
            $model->client_id = Yii::$app->getUser()->identity->client_id;
            $model->user_id = Yii::$app->getUser()->id;
            $model->xodim_id = Yii::$app->getUser()->id;
            $model->sana = $date;
            $model->diler_id = "0";
            $model->tur_oper = 2;
            $model->save();
            $s = Asos::find()->where(['sana' => $date])->andWhere(['diler_id' => 0])->andWhere(['user_id' => Yii::$app->getUser()->id])->one();
        }
        //Asos::updateAll(['h_id'=>$haridor],['id'=>$s['id']]);
        //if ($drone!='1' && empty($haridor)) {
        //    return $this->goBack();
        //}666
        if ($drone=='1') { $s='asos_slave.sotish as sot,asos_slave.sotish_in as sotin';}
        if ($drone=='2') { $s='asos_slave.opt1 as sot,asos_slave.opt1_in as sotin';}
        if ($drone=='3') { $s='asos_slave.opt1_pl as sot,asos_slave.opt1_pl_in as sotin';}
        if ($drone=='4') { $s='asos_slave.opt2 as sot,asos_slave.opt2_in as sotin';}
        if ($drone=='5') { $s='asos_slave.opt2_pl as sot,asos_slave.opt2_pl_in as sotin';}
        if ($drone=='6') { $s='asos_slave.schet as sot,asos_slave.schet_in as sotin';}
        if ($drone=='') { $s='asos_slave.sotish as sot,asos_slave.sotish_in as sotin';}


        $t=' s_tovar.otdel = '.$otdelId.' and ';
        $cldollar = SClient::find()->where(['id'=>Yii::$app->getUser()->identity->client_id])->one();
        $otdel = STOtdel::find()->all();
        $cld=$cldollar['dollar'];
        if($shtrix==''){
            $dataProvider = new SqlDataProvider([
            'sql' => 'SELECT asos_slave.id as ids,asos_slave.sotish_d,asos_slave.sotish_in_d,'.$s.',SUM(asos_slave.kol_ost) as kol_ost,SUM(asos_slave.kol_in_ost) as kol_in_ost,
            s_tovar.nom as nom , s_tovar.id as idt, s_tovar.kol_in as tkol_in from asos_slave,asos,s_tovar where '.$t.' asos.id = asos_slave.asos_id and asos_slave.del_flag = 1 and
             (asos.tur_oper=1 or asos.tur_oper=4 or asos.tur_oper=5) and (asos_slave.kol_ost>0 || asos_slave.kol_in_ost>0 ) and s_tovar.id = asos_slave.tovar_id and
              asos.client_id = ' .Yii::$app->getUser()->identity->client_id.' group by tovar_id,sot',
            'sort' => ['attributes' => [],],'pagination' => false,
        ]);}
        else
        {
            if($tovarId!=''){
                $dataProvider = new SqlDataProvider([
                'sql' => 'SELECT asos_slave.id as ids,asos_slave.sotish_d,asos_slave.sotish_in_d,'.$s.',SUM(asos_slave.kol_ost) as kol_ost,SUM(asos_slave.kol_in_ost) as kol_in_ost,
                s_tovar.nom as nom , s_tovar.id as idt, s_tovar.kol_in as tkol_in from asos,asos_slave,s_tovar where  asos.id = asos_slave.asos_id and asos_slave.del_flag = 1 and 
                asos.client_id = ' .Yii::$app->getUser()->identity->client_id.' and  (asos.tur_oper=1 or asos.tur_oper=4 or asos.tur_oper=5) and s_tovar.id = asos_slave.tovar_id and (asos_slave.kol_ost>0 || asos_slave.kol_in_ost>0) and 
                (s_tovar.id="'.$tovarId.'") group by tovar_id',
                'sort' => ['attributes' => [],],'pagination' => false,]);
    
            }
            else
            {
                $dataProvider = new SqlDataProvider([
                'sql' => 'SELECT asos_slave.id as ids,asos_slave.sotish_d,asos_slave.sotish_in_d,'.$s.',SUM(asos_slave.kol_ost) as kol_ost,SUM(asos_slave.kol_in_ost) as kol_in_ost,
                s_tovar.nom as nom , s_tovar.id as idt, s_tovar.kol_in as tkol_in from asos,asos_slave,s_tovar where  asos.id = asos_slave.asos_id and asos_slave.del_flag = 1 and 
                asos.client_id = ' .Yii::$app->getUser()->identity->client_id.' and  (asos.tur_oper=1 or asos.tur_oper=4 or asos.tur_oper=5) and s_tovar.id = asos_slave.tovar_id and (asos_slave.kol_ost>0 || asos_slave.kol_in_ost>0) and 
                (s_tovar.shtrix="'.$shtrix.'" or s_tovar.shtrix1="'.$shtrix.'" or s_tovar.shtrix2="'.$shtrix.'" or s_tovar.shtrix_full="'.$shtrix.'") group by tovar_id',
                'sort' => ['attributes' => [],],'pagination' => false,]);
            }
        }
        $models = $dataProvider->getModels();

        return $this->render('addnewkesh',
         [ 'd'=>$dataProvider,'ss'=>$s,'seriya'=>$seriya,'tt'=>$t,'models' => $models,'cld' => $cld,'otdel' => $otdel,'otdelId' => $otdelId,'drone'=>$drone]);
    }
    public function actionSottur(){
        $sottur=Yii::$app->request->post('sottur');date_default_timezone_set("Asia/Tashkent");$date = date("Y-m-d");
        $s = \frontend\models\Asos::find()->where(['sana'=>$date])->andWhere(['diler_id'=>0])->andWhere(['user_id'=>Yii::$app->getUser()->id])->one();
        Asos::updateAll(['sotuv_turi' => $sottur],['id'=>$s['id']]);
        return $s["id"];
    }
    public function actionUpdate(){

     		$asos =Yii::$app->request->post('assosiy');
     		$ichki =Yii::$app->request->post('ichki');
     		 $sotil = AsosSlave::find()->where(['id'=>Yii::$app->request->post('idup')])->one();
     		 
     		 $ap= AsosSlave::find()->where(['id'=>$sotil['kol_ost']])->one();

     		 AsosSlave::updateAll(['kol_ost'=>$ap['kol_ost']-$sotil['kol']+$asos,'kol_in_ost'=>$ap['kol_in_ost']-$sotil['kol_in']+$ichki],['id'=>$sotil['kol_ost']]);

     	 return $this->render('update',[

                'sotil'=>$sotil,
            ]);
		}
    
    public function actionKarzina(){

        $shtrix = Yii::$app->request->get('shtrix'); 
        $seriya='';$tovarId='';//$shtrix=substr($shtrix,8);
        if(strlen($shtrix)>13){
            $main=Main::find()->where(['serial'=>$shtrix])->one();
            if($main['serial']==null)
                {$seriya=$shtrix.' umuman topilmadi !!';}
            else
            {$sm = SlaveMain::find()->where(['main_id'=>$main[id]])->one();
                if($sm['id']=='')
                {$seriya=$shtrix.' topildi, lekin kirim qilinmagan';}
                else{
                    $as = AsosSlave::find()->where(['id'=>$sm['slave_id']])->one();
                    $tovarId=$as['tovar_id'];$seriya=$shtrix. " topildi " ;
                }
            }            
        }
        if($tovarId!=''){
        $kol=1; $kol_in=0;$sotin=0;
        date_default_timezone_set("Asia/Tashkent");
        $esk=$as['id']; $date = date("Y-m-d");
        $cldollar = SClient::find()->where(['id'=>Yii::$app->getUser()->identity->client_id])->one();
        $s = \frontend\models\Asos::find()->where(['sana'=>$date])->andWhere(['diler_id'=>0])->andWhere(['user_id'=>Yii::$app->getUser()->id])->one();
        if($s['sana'] == null){
            $model = new Asos();
            $model->client_id = Yii::$app->getUser()->identity->client_id;
            $model->user_id = Yii::$app->getUser()->id;$model->xodim_id = Yii::$app->getUser()->id;
            $model->sana = $date;$model->diler_id= "0";$model->tur_oper = 2;//$model->summa= $summa;
            $model->save();
            $s = \frontend\models\Asos::find()->where(['sana'=>$date])->andWhere(['diler_id'=>0])->andWhere(['user_id'=>Yii::$app->getUser()->id])->one();
        }
        $tek = AsosSlave::find()->select('*')->where(['id'=>$esk])->one();
        $drone = $s['sotuv_turi'];
        if ($drone=="1") { $ds='asos_slave.sotish = '.$tek['sotish'];$sot=$tek['sotish'];}
        if ($drone=='2') { $ds='asos_slave.opt1  = '.$tek['opt1'];$sot=$tek['opt1'];}
        if ($drone=='3') { $ds='asos_slave.opt1_pl  = '.$tek['opt1_pl'];$sot=$tek['opt1_pl'];}
        if ($drone=='4') { $ds='asos_slave.opt2  = '.$tek['opt2'];$sot=$tek['opt2'];}
        if ($drone=='5') { $ds='asos_slave.opt2_pl  = '.$tek['opt2_pl'];$sot=$tek['opt2_pl'];}
        if ($drone=='6') { $ds='asos_slave.schet= '.$tek['schet'];$sot=$tek['schet'];}
        if ($drone=='' or $drone==null) { $ds='asos_slave.sotish= '.$tek['sotish'];$sot=$tek['sotish'];}
        
        $tek_all = AsosSlave::find()->select('asos_slave.*')->from('asos_slave,asos')
        ->where('asos.id = asos_slave.asos_id and asos_slave.del_flag = 1 and (asos.tur_oper=1 or asos.tur_oper=4 or asos.tur_oper=5) and (asos_slave.kol_ost>0 || asos_slave.kol_in_ost>0 ) and asos.client_id = ' .Yii::$app->getUser()->identity->client_id.' and tovar_id='.$tek['tovar_id'].' and '.$ds)->all();
        STovar::updateAll(['upakavka'=> null],['id'=>$tek['tovar_id']]);
        $t_sql = STovar::find()->select('*')->where(['id'=>$tek['tovar_id']])->one();
        
        $kol_jami = $kol * $t_sql['kol_in'] + $kol_in;
        $ost_jami = 0;
        foreach ($tek_all as $item){
            $ost_jami = $ost_jami + $item['kol_ost'] * $t_sql['kol_in'] + $item['kol_in_ost'];
        }
        if($tek['del_flag']==0){ 
            $seriya='asos_slave da o`chgan,lekin seriya omborida qolgan = slave_main.slave_id = '.$tek['id'];
            return $seriya;
        }
        if($ost_jami < $kol_jami){
            $kam = $ost_jami - $kol_jami;
            $seriya = $seriya.', lekin sotilgan';
            //debug($tek_all);
        }
        foreach ($tek_all as $ost){
            $ost_jami = $ost['kol_ost'] * $t_sql['kol_in'] + $ost['kol_in_ost'];
            if($kol_jami>=$ost_jami){
                $kol_jami = $kol_jami - $ost_jami;
                //if($kol>$ost['kol_ost'] && $kolin>0){
                    $kol = (int)($ost_jami / $t_sql['kol_in']);
                    $kolin = $ost_jami - $kol*$t_sql['kol_in'];
                //}
                $j=$ost['sotish_d']+$ost['sotish_in_d'];
                AsosSlave::updateAll(['kol_ost'=> 0,'kol_in_ost'=> 0],['id'=>$ost['id']]);
                $jas= AsosSlave::find()->where(['asos_slave.del_flag'=>1])
                ->select('asos_slave.*,asos_slave.opt1 as sot,asos_slave.opt1_in as sotin')
                ->from('asos_slave')
                ->where(['asos_id'=>$s['id']])
                ->andwhere(['tovar_id'=>$tovarId])
                ->andwhere(['kol_ost'=>$ost['id']])
                ->orderby(['asos_slave.id' => SORT_DESC])
                ->one();
                
                if($jas['id']=='')
                {
                $mod = new AsosSlave();
                $mod->tovar_nom = $t_sql['nom'];$mod->tovar_id = $ost['tovar_id'];
                $mod->asos_id = $s['id'];$mod->user_id=Yii::$app->getUser()->id;
                $mod->kol = $kol;$mod->kol_in = $kolin;
                $mod->summa = $kol*$sot;$mod->summa_in = $kolin*$sotin;
                if($cldollar['dollar']=='2' && $j>0)
                {
                    $mod->sotish = $ost['sotish_d'];$mod->sotish_in = $ost['sotish_in_d'];
                    $mod->opt1 = $kol*$ost['sotish_d'] + $kolin*$ost['sotish_in_d'];
                    $mod->summa = $kol*$ost['sotish_d'];$mod->summa_in = $kolin*$ost['sotish_in_d'];
                }
                else
                {
                    $mod->sotish = $sot;$mod->sotish_in = $sotin;
                    $mod->summa_all = $kol*$sot + $kolin*$sotin;
                    $mod->summa = $kol*$sot;$mod->summa_in = $kolin*$sotin;
                }
                $mod->sotish_d = $ost['sotish_d'];$mod->sotish_in_d = $ost['sotish_in_d'];
                $mod->sena = $ost['sena'];$mod->sena_in = $ost['sena_in'];
                $mod->sena_d = $ost['sena_d'];$mod->sena_in_d = $ost['sena_in_d'];
                $mod->kol_ost = $ost['id'];$mod->kol_in_ost = 0;
                $mod->izm_id = $ost['izm_id'];$mod->izm1 = $ost['izm1'];
                $mod->save();$tamom=$mod->id;
                }
                else
                {
                    
                    AsosSlave::updateAll(['kol'=> $jas['kol']+1],['id'=>$jas['id']]);
                    $tamom=$jas['id'];
                }
                $mod = new SlaveMain();
                $mod->slave_id = $tamom;$mod->main_id = $main['id'];
                $mod->client_id = Yii::$app->getUser()->identity->client_id;$mod->user_id=Yii::$app->getUser()->id;
                $mod->changedate = $sana;$mod->deldate = $sana;
                $mod->save();
            }
            elseif($kol_jami>0)
            {
                $kol1 = (int)($kol_jami / $t_sql['kol_in']);
                $kolin1 = $kol_jami - $kol1*$t_sql['kol_in'];
                $kol_jami = $ost_jami - $kol_jami;
                $kol = (int)($kol_jami / $t_sql['kol_in']);
                $kolin = $kol_jami - $kol*$t_sql['kol_in'];
                AsosSlave::updateAll(['kol_ost'=> $kol,'kol_in_ost'=> $kolin],['id'=>$ost['id']]);
                $kol = $kol1;
                $kolin = $kolin1;
                $kol_jami = 0;
                $j=$ost['sotish_d']+$ost['sotish_in_d'];
                //333
                $s = Asos::find()->where(['sana'=>$date])->andWhere(['diler_id'=>0])->andWhere(['user_id'=>Yii::$app->getUser()->id])->one();
                $jas= AsosSlave::find()->where(['asos_slave.del_flag'=>1])
                ->select('asos_slave.*,asos_slave.opt1 as sot,asos_slave.opt1_in as sotin')
                ->from('asos_slave')
                ->where(['asos_id'=>$s['id']])
                ->andwhere(['tovar_id'=>$tovarId])
                ->andwhere(['kol_ost'=>$ost['id']])
                ->orderby(['asos_slave.id' => SORT_DESC])
                ->one();
                
                if($jas['id']=='')
                {
                $mod = new AsosSlave();
                $mod->tovar_nom = $t_sql['nom'];$mod->tovar_id = $ost['tovar_id'];
                $mod->asos_id = $s['id'];$mod->user_id=Yii::$app->getUser()->id;
                $mod->kol = $kol;$mod->kol_in = $kolin;
                if($cldollar['dollar']=='2' && $j>0)
                {
                    $mod->sotish = $ost['sotish_d'];$mod->sotish_in = $ost['sotish_in_d'];
                    $mod->opt1 = $kol*$ost['sotish_d'] + $kolin*$ost['sotish_in_d'];
                    $mod->summa = $kol*$ost['sotish_d'];$mod->summa_in = $kolin*$ost['sotish_in_d'];
                }
                else
                {
                    $mod->sotish = $sot;$mod->sotish_in = $sotin;
                    $mod->summa_all = $kol*$sot + $kolin*$sotin;
                    $mod->summa = $kol*$sot;$mod->summa_in = $kolin*$sotin;
                }
                $mod->sotish_d = $ost['sotish_d'];$mod->sotish_in_d = $ost['sotish_in_d'];
                $mod->sena = $ost['sena'];$mod->sena_in = $ost['sena_in'];
                $mod->sena_d = $ost['sena_d'];$mod->sena_in_d = $ost['sena_in_d'];
                $mod->kol_ost = $ost['id'];$mod->kol_in_ost = 0;
                $mod->izm_id = $ost['izm_id'];$mod->izm1 = $ost['izm1'];
                $mod->save();$tamom=$mod->id;
                }
                else
                {
                    
                    AsosSlave::updateAll(['kol'=> $jas['kol']+1],['id'=>$jas['id']]);
                    $tamom=$jas['id'];
                }
                $mod = new SlaveMain();
                $mod->slave_id = $tamom;$mod->main_id = $main['id'];
                $mod->client_id = Yii::$app->getUser()->identity->client_id;$mod->user_id=Yii::$app->getUser()->id;
                $mod->changedate = $sana;$mod->deldate = $sana;
                $mod->save();
            }
        }
        $ssum = AsosSlave::find()->select('count(tovar_id) as kol,sum(summa_all) as summa,sum(opt1) as opt1')
            ->Where(['asos_id'=>$s['id']])->groupBy('asos_id')->one();
        $sum_naqd = $ssum['summa'];
        $sum_d = $ssum['opt1'];
        $sum_naqd_ch = round($sum_naqd,0);$sum_d_ch = round($sum_d,2);
        $cheg_n = round($sum_naqd-$sum_naqd_ch,-2);$cheg_d = round($sum_d-$sum_d_ch,2);
        Asos::updateAll(['sum_plast_ch' => 0,'sum_epos_ch' => 0,'sum_epos' => 0,'sum_plastik' => 0,'sum_naqd' => $sum_naqd,'sum_naqd_ch' => $sum_naqd_ch,'cheg_n' => $cheg_n,'cheg_d' => $cheg_d,'summa_ch' => $sum_naqd_ch,'sum_d_ch' => $sum_d_ch,'kol' => $ssum['kol'],'summa' => $sum_naqd,'sum_d' => $sum_d],['id'=>$s['id']]);
    }


        $otdelId = Yii::$app->request->post('otdel');
        if($otdelId==''){$otdelId='1';};
        $ichki      = Yii::$app->request->post('ichkison');
        $kololdin   = Yii::$app->request->post('kolinjoriy');
        $koljo      = Yii::$app->request->post('koljoriy');
        $ostatid    = Yii::$app->request->post('idsup');

        $haridorlar = ArrayHelper::map(Yii::$app->db->createCommand("SELECT id, concat(nom,' ',telsms1) as nom FROM s_haridor WHERE id>1 and del_flag=1")->queryAll(), 'id', 'nom');
        if($koljo){
            if($koljo < 1){
                if(Yii::$app->getUser()->identity->ustama==1)
                {$ustama='(asos_slave.sotish+s_tovar.ustama)';} else {$ustama='asos_slave.sotish';}
                $query = AsosSlave::find()->select('asos_slave.id as ids,'.$ustama.' as sot,asos_slave.sotish_in as sotin,asos_slave.kol_ost as kns,asos_slave.kol_in_ost as kolin,s_tovar.nom as nom , s_tovar.id as idt, s_tovar.kol_in as tkol_in')
                    ->from('asos_slave,asos,s_tovar')
                    ->where('asos.id = asos_slave.asos_id and asos_slave.del_flag = 1 and (asos.tur_oper=1 or asos.tur_oper=4 or asos.tur_oper=5) and (asos_slave.kol_ost>0 || asos_slave.kol_in_ost>0 ) and s_tovar.id = asos_slave.tovar_id and asos.client_id = ' .Yii::$app->getUser()->identity->client_id )
                    ->limit(1000)->all();
                Yii::$app->session->setFlash('success', "Taqsimlab bulmaydi asosiy 1 dan kam!");
                return $this->render('view',['query'=>$query]);
            }
        }
        if($kololdin < $ichki){
            $sleve= AsosSlave::find()->where(['id'=>$ostatid])->one();
            $kol =$sleve['kol_ost']-1;
            $kolin =$sleve['kol_in_ost']+1000;
            AsosSlave::updateAll(['kol_in_ost'=>$kolin,'kol_ost'=>$kol],['id'=>$ostatid]);
            if(Yii::$app->getUser()->identity->ustama==1)
            {$ustama='(asos_slave.sotish+s_tovar.ustama)';} else {$ustama='asos_slave.sotish';}
            $query = AsosSlave::find()->select('asos_slave.id as ids,'.$ustama.' as sot,asos_slave.sotish_in as sotin,asos_slave.kol_ost as kns,asos_slave.kol_in_ost as kolin,s_tovar.nom as nom , s_tovar.id as idt, s_tovar.kol_in as tkol_in')
                ->from('asos_slave,asos,s_tovar')
                ->where('asos.id = asos_slave.asos_id and asos_slave.del_flag = 1 and (asos.tur_oper=1 or asos.tur_oper=4 or asos.tur_oper=5) and (asos_slave.kol_ost>0 || asos_slave.kol_in_ost>0 ) and s_tovar.id = asos_slave.tovar_id and asos.client_id = ' .Yii::$app->getUser()->identity->client_id )
                ->limit(1000)->all();
            Yii::$app->session->setFlash('success', "Ichki son taqsimlandi!");
            return $this->render('view',['query'=>$query]);
        }
 		$ides = Yii::$app->request->post('ides');
        $koles = Yii::$app->request->post('koles');
        $kolines = Yii::$app->request->post('kolines');
        $idjo = Yii::$app->request->post('idjo');
        $koljo = Yii::$app->request->post('kol');
        $kolinjo = Yii::$app->request->post('kolin');
        $sotishjo = Yii::$app->request->post('sotishjo');
        $sotishinjo = Yii::$app->request->post('sotishinjo');
        
        $eskikolkolin =AsosSlave::find()->where(['id'=>$ides])->one();
        STovar::updateAll(['upakavka'=> null],['id'=>$eskikolkolin['tovar_id']]);
        $anc=$eskikolkolin['kol_ost']+$koles-$koljo;
        $ancin=$eskikolkolin['kol_in_ost']+$kolines-$kolinjo;

        AsosSlave::updateAll(['kol_ost'=>$anc],['id'=>$ides]);
        AsosSlave::updateAll(['kol'=>$koljo,'summa'=>$koljo*$sotishjo,'summa_in'=>$kolinjo*$sotishinjo,'summa_all'=>$koljo*$sotishjo+$kolinjo*$sotishinjo],['id'=>$idjo]);

        if($kolines > 0){
            AsosSlave::updateAll(['kol_in_ost'=>$ancin],['id'=>$ides]);
            AsosSlave::updateAll(['kol_in' => $kolinjo, 'summa_in' => $kolinjo * $sotishinjo, 'summa_all' => $koljo * $sotishjo + $kolinjo * $sotishinjo], ['id' => $idjo]);
        }
        if(Yii::$app->getUser()->identity->ustama==1)
            {$ustama='(asos_slave.sotish+s_tovar.ustama)';} else {$ustama='asos_slave.sotish';}
            $query = AsosSlave::find()->select('asos_slave.id as ids,'.$ustama.' as sot,asos_slave.sotish_in as sotin,asos_slave.kol_ost as kns,asos_slave.kol_in_ost as kolin,s_tovar.nom as nom , s_tovar.id as idt, s_tovar.kol_in as tkol_in')
                ->from('asos_slave,asos,s_tovar')
                ->where('asos.id = asos_slave.asos_id and asos_slave.del_flag = 1 and (asos.tur_oper=1 or asos.tur_oper=4 or asos.tur_oper=5) and (asos_slave.kol_ost>0 or asos_slave.kol_in_ost>0) and s_tovar.id = asos_slave.tovar_id and asos.client_id = ' .Yii::$app->getUser()->identity->client_id )
                ->limit(1000)->all();

        $asosiy = Yii::$app->request->post('asosiyson');
        $ichki = Yii::$app->request->post('ichkison');
        if(Yii::$app->request->post('tkol')){	    
	    if(Yii::$app->request->post('tkol') < Yii::$app->request->post('asosiyson')){
		Yii::$app->session->setFlash('success', "Tovar soni noto'g'ri ");
            return $this->render('view',['query'=>$query,]);}
    	}
   		if(Yii::$app->request->post('tkol') and Yii::$app->request->post('tkolin')){
    	   if(Yii::$app->request->post('tkol') < Yii::$app->request->post('asosiyson') and Yii::$app->request->post('tkolin')< $ichki)
            {$this->redirect('/site/add');}
    	}

        if(Yii::$app->request->post('andnacdel')) {
            $andnacdel = Yii::$app->request->post('andnacdel');
            AsosSlave::deleteAll(['asos_id' => $andnacdel]);
            $this->redirect(['/site/index']);
        }
        $idjo = Yii::$app->request->post('iddel');
        $koldel = Yii::$app->request->post('koldel');
        $kolindel = Yii::$app->request->post('kolindel');
        $kolinjoriy = Yii::$app->request->post('kolinjoriy');
        $koljoriy   = Yii::$app->request->post('koljoriy');
        $ostatid    = Yii::$app->request->post('idsup');
        $idav=Yii::$app->request->post('idav');
        $ap= AsosSlave::find()->where(['id'=>$idav])->one();
        AsosSlave::updateAll(['kol_ost'=>$ap['kol_ost']+$koldel,'kol_in_ost'=>$ap['kol_in_ost']+$kolindel],['id'=>$idav]);
        date_default_timezone_set("Asia/Tashkent");$date = date("Y-m-d");
        $s = Asos::find()->where(['sana'=>$date])->andWhere(['diler_id'=>0])->andWhere(['user_id'=>Yii::$app->getUser()->id])->one();
        $idup = Yii::$app->request->post('idup');
        $kol = Yii::$app->request->post('kol');
        $kolin = Yii::$app->request->post('kolin');

        if(Yii::$app->request->post('andnac')) {
            $andnac = Yii::$app->request->post('andnac');
            $garaj = Yii::$app->request->post('garaj');
            Asos::updateAll(['diler_id' => 1], ['id' => $andnac]);
            SClient::updateAll(['garaj' => $garaj], ['id'=>Yii::$app->getUser()->identity->client_id]);
            $this->redirect(['/site/index']);
        }
        if(Yii::$app->request->post('andchek')) {
            $andnac = Yii::$app->request->post('andchek');
            $garaj = Yii::$app->request->post('garaj');
            Asos::updateAll(['diler_id' => 1,'print_flag' => 2], ['id' => $andnac]);
            SClient::updateAll(['garaj' => $garaj], ['id'=>Yii::$app->getUser()->identity->client_id]);
            $this->redirect(['/site/index']);
        }
        if(Yii::$app->request->post('andfaktur')) {
            $garaj = Yii::$app->request->post('garaj');
            $andnac = Yii::$app->request->post('andfaktur');
            SClient::updateAll(['garaj' => $garaj], ['id'=>Yii::$app->getUser()->identity->client_id]);
            Asos::updateAll(['diler_id' => 1,'print_flag' => 3], ['id' => $andnac]);
            $this->redirect(['/site/index']);
        }
        if(Yii::$app->request->post('iddel')) {
        	STovar::updateAll(['upakavka'=> null],['id'=>$ap['tovar_id']]);
	        AsosSlave::deleteAll(['id'=>$idjo]);
	        SlaveMain::deleteAll(['slave_id'=>$idjo]);
	        AsosSlave::updateAll(['kol'=>$kol,'kol_in'=>$kolin],['id'=>$idup]);
        }
        date_default_timezone_set("Asia/Tashkent");$date = date("Y-m-d");
        $id = Yii::$app->request->post('tavarid'); $asosid = Yii::$app->request->post('asosid');
        $asosiy = Yii::$app->request->post('asosiyson'); $ichki = Yii::$app->request->post('ichkison');
        $kolost = $koljoriy-$asosiy; $kolinost = $kolinjoriy-$ichki;
        AsosSlave::updateAll(['kol_ost'=>$kolost,'kol_in_ost'=>$kolinost],['id'=>$ostatid]);
        $nom = Yii::$app->request->post('tavarnomi');
        $otdel = STOtdel::find()->all();
        if(Yii::$app->request->post('asosiyson') || Yii::$app->request->post('ichkison')) {
            $model = new AsosSlave();
            $model->tovar_nom = $nom;
            $model->tovar_id = $id;
            $model->asos_id = $s['id'];
            $model->kol_ost = $ostatid;
            $model->kol_in_ost = -1;
            if($asosiy==null){
                $model->kol = 0;
            }
            else{
                $model->kol = $asosiy;
            }
            if($ichki==null){
                $model->kol_in = 0;
            }
            else{
                $model->kol_in = $ichki;
            }
            if($asosiy==null){
                $model->summa = 0;
            }
            else{
                $model->summa = $asosiy*Yii::$app->request->post('sot');
            }
            if($ichki==null){
                $model->summa_in = 0;
            }
            else{
                $model->summa_in = Yii::$app->request->post('sotin')*$ichki;
            }
            if($asosiy==null){
                $model->sotish = 0;
            }
            else{
                $model->sotish = Yii::$app->request->post('sot');
            }
            if($ichki==null){
                $model->sotish_in = 0;
            }
            else{
                $model->sotish_in = Yii::$app->request->post('sotin');
            }

            $model->summa_all = Yii::$app->request->post('sotin')*$ichki + Yii::$app->request->post('sot')*$asosiy;
            $model->user_id=Yii::$app->getUser()->id;
            $model->save();

            $s = Asos::find()->where(['sana'=>$date])->andWhere(['user_id'=>Yii::$app->getUser()->id])->andWhere(['diler_id'=>0])->one();

            $sotil = AsosSlave::find()->where(['asos_slave.del_flag'=>1])
            ->select('asos_slave.*,asos_slave.opt1 as sot,asos_slave.opt1_in as sotin')
            ->from('asos_slave')
            ->where(['asos_id'=>$s['id']])
            ->orderby(['asos_slave.id' => SORT_DESC])
            ->all();
            //111

            $ssum = AsosSlave::find()->select('count(tovar_id) as kol,sum(summa_all) as summa')->Where(['asos_id'=>$s['id']])->groupBy('asos_id')->one();
            $sum_naqd = $ssum['summa'];
            $sum_naqd_ch = round($sum_naqd,0);
            $cheg_n = round($sum_naqd-$sum_naqd_ch,-2);
            Asos::updateAll(['sum_plast_ch' => 0,'sum_epos_ch' => 0,'sum_epos' => 0,'sum_plastik' => 0,'sum_naqd' => $sum_naqd,'sum_naqd_ch' => $sum_naqd_ch,'cheg_n' => $cheg_n,'summa_ch' => $sum_naqd_ch,'kol' => $ssum['kol'],'summa' => $sum_naqd],['id'=>$s['id']]);
            return $this->render('index',[

                'sotil'=>$sotil,
                'asosid'=>$asosid,
                'haridorlar' => $haridorlar,
                'ostatid'=> $ostatid
            ]);
        }
        $s = Asos::find()->where(['sana'=>$date])->andWhere(['user_id'=>Yii::$app->getUser()->id])->andWhere(['diler_id'=>0])->one();

 /*        $sotil = AsosSlave::find()->where(['asos_slave.del_flag'=>1])
            ->select('asos_slave.*,asos_slave.opt1 as sot,asos_slave.opt1_in as sotin')
            ->from('asos_slave')->where(['asos_id'=>$s['id']])->orderby(['asos_slave.id' => SORT_DESC])->all();
  */    
         $sotil = AsosSlave::find()->where(['asos_slave.del_flag'=>1])
            ->select('asos_slave.*,asos_slave.id as ids,slave_main.id as sm_id,asos_slave.opt1 as sot,asos_slave.opt1_in as sotin')
            ->from('asos_slave')->leftjoin('slave_main','asos_slave.id=slave_main.slave_id')
            ->where(['asos_id'=>$s['id']])
            ->orderby(['asos_slave.id' => SORT_DESC])->all();
        return $this->render('index',["seriya"=>$seriya,'sotil'=>$sotil, 'asosid'=>$asosid, 'ostatid'=> $ostatid,
            'haridorlar' => $haridorlar,'otdel' => $otdel,'otdelId' => $otdelId,] );
    }
    public function actionOmbor()
    {

        $dataProvider = new SqlDataProvider([
            'sql' => 'SELECT s.kol_ost as kolOost, z.nom as znom,d.nom as dnom,s.kol_ost*s.sena as q,s.kol_in_ost*s.sena_in as q_in, s.kol_ost*s.sena+s.kol_in_ost*s.sena_in as q_all,s.kol*s.sotish+s.kol_in*s.sotish_in as sotiladi,s.*,t.nom as s_tovar,z.nom as s_zavod,d.nom as s_diler
            FROM asos a,asos_slave s,s_tovar t,s_zavod z,s_diler d 
            where (a.tur_oper=1 or a.tur_oper=4 or a.tur_oper=5)
            
            and d.id=a.diler_id and z.id=t.zavod_id and t.id=s.tovar_id
            and a.id=s.asos_id and s.del_flag=1
            
            order by t.nom,s.srok',
            'sort' => [
                'attributes' => [],
            ],
            'pagination' => false,
        ]);
        $models = $dataProvider->getModels();

        $dataProvider2 = new SqlDataProvider([
            'sql' => 'SELECT nom FROM s_diler',
            'pagination' => false,
        ]);
        $models2 = $dataProvider2->getModels();

        return $this->render('ombor', [
            'dataProvider' => $dataProvider,
            'models' => $models,
            'models2' => $models2,
        ]);
    }
    public function actionClientQarz()
    {
        $haridor = Yii::$app->request->post('haridor');
        $date1 = Yii::$app->request->post('date1');
        $date2 = Yii::$app->request->post('date2');
        if(!$haridor) $haridor='1';date_default_timezone_set("Asia/Tashkent");
        if(!$date1) $date1 = date('Y-m-01');
        if(!$date2) $date2 = date('Y-m-d');

        $b = Yii::$app->db->createCommand('SELECT IFNULL(SUM(qarz_summa),0)+IFNULL(SUM(sum_epos_ch),0) as summa FROM asos WHERE del_flag=1 AND tur_oper=2 AND h_id="'.$haridor.'" AND sana<"'.$date1.'"')->queryOne();
        $b2=0;
        $e = Yii::$app->db->createCommand('SELECT sena_pl, vid FROM pl WHERE del_flag=1 AND h_id="'.$haridor.'" AND d_pl<"'.$date1.'"')->queryAll();
        foreach ($e as $item) {
            if($item['vid']==7 || $item['vid']==17 || $item['vid']==20) $b2+=$item['sena_pl'];
            else if($item['vid']==8 || $item['vid']==18) $b['summa']+=$item['sena_pl'];
        }
        $danq = $b['summa'] - $b2;

        $b = Yii::$app->db->createCommand('SELECT IFNULL(SUM(qarz_summa),0)+IFNULL(SUM(sum_epos_ch),0) as summa FROM asos WHERE del_flag=1 AND tur_oper=2 AND h_id="'.$haridor.'" AND sana BETWEEN "'.$date1.'" AND "'.$date2.'"')->queryOne();
        $b2=0;
        $e = Yii::$app->db->createCommand('SELECT sena_pl, vid FROM pl WHERE del_flag=1 AND h_id="'.$haridor.'" AND d_pl BETWEEN "'.$date1.'" AND "'.$date2.'" ')->queryAll();
        foreach ($e as $item) {
            if($item['vid']==7 || $item['vid']==17 || $item['vid']==20) $b2+=$item['sena_pl'];
            else if($item['vid']==8 || $item['vid']==18) $b['summa']+=$item['sena_pl'];
        }
        $gachaq = $b['summa'] - $b2;

        $haridorlar = ArrayHelper::map(Yii::$app->db->createCommand('SELECT id, nom FROM s_haridor WHERE id>1 and del_flag=1')->queryAll(), 'id', 'nom');

        $query = Asos::find()->where('del_flag=1')->andWhere('tur_oper=2')->andWhere(['h_id' => $haridor])->andWhere(['between', 'sana', $date1, $date2]);
        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $s_pl = ArrayHelper::map(Yii::$app->db->createCommand('SELECT id, nom FROM s_pl WHERE id in (7,8,20)')->queryAll(), 'id', 'nom');
        
        $pl = Yii::$app->db->createCommand('SELECT u.fio,n_pl,pl.id,d_pl,pl.vid,s_pl.nom as nom,prim,sena_pl,sena_d,sena_pl,sena_d FROM pl,s_pl,user u WHERE u.id=pl.user_id and pl.del_flag=1 AND pl.vid=s_pl.id and pl.h_id="'.$haridor.'" AND pl.d_pl BETWEEN "'.$date1.'" AND "'.$date2.'" order by pl.id desc')->queryAll();

        //$pl = Pl::find()->where(['between', 'd_pl', $date1, $date2])->andWhere('del_flag=1')->andWhere(['h_id' => $haridor])->all();

        return $this->render('client-qarz', [
            'danq' => $danq,
            'chiqim' => (int)$b['summa'],
            'kirim' => $b2,
            'gachaq' => $gachaq,
            'haridorlar' => $haridorlar,
            'dataProvider' => $dataProvider,
            'pl' => $pl,
            's_pl' => $s_pl,

            //'dataProvider2' => $dataProvider2,
        ]);
    }

    public function actionKun()
    {
        //$obekt = ArrayHelper::map(Yii::$app->db->createCommand('SELECT id, name FROM obekt WHERE del_flag=1')->queryAll(), 'id', 'name');
        $xizmat = S_xizmat::find()->select('*')
            ->from('s_xizmat')
            ->orderby(['id' => SORT_ASC])->all();
        return $this->render('kun',['xizmat' => $xizmat]);
    }
    public function actionView($id){


        $query = AsosSlave::find()->where(['asos_slave.del_flag'=>1])
            ->select('asos_slave.id as ids,asos_slave.sotish as sot,asos_slave.sotish_in as sotin,asos_slave.kol_ost as kns,asos_slave.kol_in_ost as kolin,s_tovar.nom as nom , s_tovar.id as idt, s_tovar.kol_in as tkol_in')
            ->innerJoin('asos','asos.id = asos_slave.asos_id and (asos.tur_oper=1 or asos.tur_oper=4 or asos.tur_oper=5)')
            ->innerJoin('s_tovar','s_tovar.id = asos_slave.tovar_id and (asos_slave.kol_ost>0 or asos_slave.kol_in_ost>0) and (s_tovar.shtrix='.$id.' or s_tovar.shtrix1='.$id.' or s_tovar.shtrix2='.$id.' or s_tovar.shtrix_full='.$id.' )')
            ->all();

        return $this->render('view',[

            'query'=>$query,

        ]);
    }
    public function actionLogin()
    {
        if (!Yii::$app->user->isGuest) {
            return $this->goHome();
        }
        $model = new LoginForm();
        if ($model->load(Yii::$app->request->post()) && $model->login()) {
            return $this->goBack();
        } else {
            $model->password = '';

            return $this->render('login', [
                'model' => $model,
            ]);
        }
    }

    public function actionLogout()
    {
        Yii::$app->user->logout();
        return $this->goHome();
    }
    public function actionContact()
    {
        $model = new ContactForm();
        if ($model->load(Yii::$app->request->post()) && $model->validate()) {
            if ($model->sendEmail(Yii::$app->params['adminEmail'])) {
                Yii::$app->session->setFlash('success', 'Thank you for contacting us. We will respond to you as soon as possible.');
            } else {
                Yii::$app->session->setFlash('error', 'There was an error sending your message.');
            }

            return $this->refresh();
        } else {
            return $this->render('contact', [
                'model' => $model,
            ]);
        }
    }
    public function actionAbout()
    {
        return $this->render('about');
    }
    public function actionSignup()
    {
        $model = new SignupForm();
        if ($model->load(Yii::$app->request->post())) {
            if ($user = $model->signup()) {
                if (Yii::$app->getUser()->login($user)) {
                    return $this->goHome();
                }
            }
        }
        $slave = User::find()->select('*')
            ->from('user')
            ->all();
        $s_client = ArrayHelper::map(Yii::$app->db->createCommand('SELECT id, nom FROM s_client WHERE del_flag=1')->queryAll(), 'id', 'nom');
        $knom = Yii::$app->request->post('s_client');
        $mod = new User();
        $mod->client_id = $knom;
        $mod->save();
        return $this->render('signup', [
            'model' => $model,
            'slave'=>$slave,
            's_client'=>$s_client,
        ]);
    }
    public function actionRequestPasswordReset()
    {
        $model = new PasswordResetRequestForm();
        if ($model->load(Yii::$app->request->post()) && $model->validate()) {
            if ($model->sendEmail()) {
                Yii::$app->session->setFlash('success', 'Check your email for further instructions.');
                return $this->goHome();
            } else {
                Yii::$app->session->setFlash('error', 'Sorry, we are unable to reset password for the provided email address.');
            }
        }

        return $this->render('requestPasswordResetToken', [
            'model' => $model,
        ]);
    }
    public function actionResetPassword($token)
    {
        try {
            $model = new ResetPasswordForm($token);
        } catch (InvalidParamException $e) {
            throw new BadRequestHttpException($e->getMessage());
        }
        if ($model->load(Yii::$app->request->post()) && $model->validate() && $model->resetPassword()) {
            Yii::$app->session->setFlash('success', 'New password saved.');
            return $this->goHome();
        }
        return $this->render('resetPassword', [
            'model' => $model,
        ]);
    }
}
