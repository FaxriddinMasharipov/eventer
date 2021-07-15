<?php

namespace frontend\controllers;

use dosamigos\qrcode\lib\Enum;
use frontend\models\SMijoz;
use Yii;
use yii\base\InvalidParamException;
use yii\db\Exception;
use yii\web\BadRequestHttpException;
use yii\web\Controller;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;
use common\models\LoginForm;
use frontend\models\PasswordResetRequestForm;
use frontend\models\ResetPasswordForm;
use frontend\models\SignupForm;
use frontend\models\ContactForm;
use dosamigos\qrcode\formats\MailTo;
use dosamigos\qrcode\QrCode;
use yii\web\Cookie;

/**
 * Site controller
 */
class SiteController extends Controller
{
    /**
     * {@inheritdoc}
     */

    public function init()
    {
        parent::init();

        $lang = Yii::$app->request->cookies->get('lang');
        if (isset($lang))
            Yii::$app->language = Yii::$app->request->cookies->get('lang');
        else
            Yii::$app->language = "ru";
    }

    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'only' => ['logout', 'signup'],
                'rules' => [
                    [
                        'actions' => ['signup'],
                        'allow' => true,
                        'roles' => ['?'],
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

    /**
     * {@inheritdoc}
     */
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

    /**
     * Displays homepage.
     *
     * @return mixed
     */
    public function actionIndex()
    {
        $this->layout = 'mainindex';
        $model = new SMijoz();

        return $this->render('index', [

            'model' => $model
        ]);

    }
    public function actionLink()

    {


        return $this->render('link');


    }
    public function actionTqrcode()

    {


        $tel =Yii::$app->request->post('tel');

        if(Yii::$app->request->post('tel')){

            $qrcode = SMijoz::find()->andFilterWhere(['like','tel',$tel])->one();

            $res = $qrcode['qrkod'];
              QrCode::png(getText($res), "image/$res.png", Enum::QR_ECLEVEL_L, 30, 2, false);
            return $this->render('tqrcode',[

                'res'=>$res
            ]);

        }
    }

    public function actionAccept()
    {


        return $this->render('accept');

    }

    public function actionSend()
    {
        $email = Yii::$app->request->post('email');

         $path = 'http://reg.teda.uz/frontend/web/image/'.Yii::$app->request->post('qrcode').".png";
    
            //Yii::$app->mailer->compose()->
            //setFrom(['hujaev28@gmail.com' => "Tadbir munosabati bilan!!!"])
            //    ->setTo($email)
            //    ->setSubject('Qrcode')
            //    ->setTextBody('Qrcode')
            //    ->attach($path)
            //    ->send();
      

        $this->redirect('/site/accept');
    }

    public function actionQrcode()
    {
        $email = Yii::$app->request->post('email');
        
        $this->layout = 'mainindex';

        $post = "ict" . (rand(900000, 999999));
        $email = Yii::$app->request->post("email");

            $model = new SMijoz();
            $model->fio = Yii::$app->request->post("name");
            $model->tashkilot = Yii::$app->request->post('tash');
            $model->lavozim = Yii::$app->request->post("lav");
            $model->email = Yii::$app->request->post("email");
            $model->tel = Yii::$app->request->post("tel");
            $model->vvod_tur = "3";
            $model->user_id = "1";
            $model->new_date = Yii::$app->request->post("created_at");
            $model->tadbir_id = Yii::$app->request->post("tadbir");
            $model->message_id = Yii::$app->request->post("sel");
            $model->davlat_id = Yii::$app->request->post("dav");
            $model->obl_id = Yii::$app->request->post("obl");
            $model->qrkod = $post;
            $model->save();
             QrCode::png(getText($post), "image/$post.png", Enum::QR_ECLEVEL_L, 30, 2, false);
            $email = Yii::$app->request->post('email');

            $path = 'http://reg.teda.uz/frontend/web/image/'.$post.".png";
    
                 Yii::$app->mailer->compose()->
                  setFrom(['sales@ictnews.uz' => "ICTWEEKUZBEKISTAN 2019 - Подтверждение регистрации"])
                ->setTo($email)
                ->setSubject('ICTWEEKUZBEKISTAN 2019 - Подтверждение регистрации')
                ->setHtmlBody('<p>&nbsp;</p>
<p><strong>ICTWEEKUZBEKISTAN</strong><strong> 2019 - Подтверждение  регистрации</strong><strong> </strong></p>
<p><strong>&nbsp;</strong></p>
<p>_______________________________________________________________<strong> </strong></p>
<p><strong>Здравствуйте, <br />
      <br />
</strong>Благодарим Вас за регистрацию в качестве посетителя Недели информационно-коммуникационных технологий  Узбекистана.</p>
<p>&nbsp;</p>
<p>Полученный QR-CODEнеобходимо обменять на именной бейджпосетителя ICTWEEK  UZBEKISTAN 2019 в офисе организаторов до 24 сентября, или в дни проведения Недели  в одной из регистрационных зон.</p>
<p>&nbsp;</p>
<p>QR-CODE предназначен для прохода на Форум DIGITALUZBEKISTAN, а также для прохода и посещения выставки ICTEXPO 2019в Павильон №1, 2 (25-27 сентября). Ваш QR-CODEбудет считан при входе с вашего именного бейджа.</p>
<p><strong>&nbsp;</strong></p>
<p><strong>Для посещения Форума </strong><strong>DIGITALUZBEKISTAN</strong><strong>:</strong><strong> </strong></p>
<p>&nbsp;</p>
<p>1.Распечатайте или сохраните  полученный QR-CODE.</p>
<p>2. Сотрудник регистрационной службы в  одной из зон регистрации считает ваш QR-CODEи выдаст именной бейдж.Или вы можете получить именной  бейдж по вашему QR-CODE в</p>
<p>офисе организаторов.</p>
<p>3. При отсутствии с собой QR-CODEнеобходимо будет пройти  регистрацию, в одной из регистрационных зонНедели.</p>
<p><strong>&nbsp;</strong></p>
<p><strong>QR</strong><strong>-</strong><strong>CODE</strong><strong> является именным и не подлежит передаче  третьим лицам.</strong> </p>
<p>&nbsp;</p>
<p>В случае некорректного отображения QR-CODE сохраните его в виде изображения  на Ваш компьютер.После этого откройте  сохраненный файл и распечатайте его.</p>
<p>&nbsp;</p>
<p><strong>*Каждый вход в Павильоны  будет доступен только при наличии </strong><strong>QR</strong><strong>-</strong><strong>CODE</strong><strong> и именного бейджа с возможностью считывания. Вы  можете получить именной бейдж в одной из  зон регистрации у входов на Форум и Выставку. При посещении Форума</strong><strong>DigitalUzbekistan</strong><strong> 25сентября необходимо пройти регистрацию на Форум  отдельно. Посещение Форума доступно только с бейджем «Участник». С бейджиком  «Посетитель» Выставки проход на кейтеринг-зону будет невозможен. Просим не  терять </strong><strong>QR</strong><strong>-</strong><strong>CODE</strong><strong>и обменять на именной  бейджик. </strong></p>
<p><br />
  С уважением,</p>
<p>ОрганизаторыICTWEEKUzbekistan 2019</p>
<p>E-mail:&nbsp;<a href="mailto:info@ictweek.uz">info@ictweek.uz</a><br />
  _______________________________________________________________</p>
<p>Пожалуйста, не отвечайте на это письмо,  т.к. оно сгенерировано автоматически. Длясвязииспользуйте e-mail&nbsp;<a href="mailto:info@ictweek.uz">info@ictweek.uz</a>. </p>
<p>&nbsp;</p>
<p>Адреспроведения ICTWEEK UZBEKISTAN 2019:</p>
<p>ГородТашкент, Юнусабадскийрайон, проспектАмираТемура, 107 (ориентир: гостиница International Hotel Tashkent, Японскийсад,  м.Бодомзар) 25сентября, НВК «Узэкспоцентр»</p>
<p>&nbsp;</p>
<p><a name="_GoBack" id="_GoBack"></a><strong>&nbsp;</strong></p>')
                
                ->attach($path)
                ->send();  
            

//            QrCode::png(getText($post));
           

            return $this->render('qrcode', [

                'post' => $post,
                'email' => $email

            ]);

        }
    /**
     * Logs in a user.
     *
     * @return mixed
     */
//    public function actionLogin()
//    {
//        if (!Yii::$app->user->isGuest) {
//            return $this->goHome();
//        }
//
//        $model = new LoginForm();
//        if ($model->load(Yii::$app->request->post()) && $model->login()) {
//            return $this->goBack();
//        } else {
//            $model->password = '';
//
//            return $this->render('login', [
//                'model' => $model,
//            ]);
//        }
//    }

    /**
     * Logs out the current user.
     *
     * @return mixed
     */
    public function actionLogout()
    {
        Yii::$app->user->logout();

        return $this->goHome();
    }

    /**
     * Displays contact page.
     *
     * @return mixed
     */
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

    /**
     * Displays about page.
     *
     * @return mixed
     */
    public function actionAbout()
    {
        return $this->render('about');
    }

    /**
     * Signs user up.
     *
     * @return mixed
     */
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

        return $this->render('signup', [
            'model' => $model,
        ]);
    }

    /**
     * Requests password reset.
     *
     * @return mixed
     */
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

    /**
     * Resets password.
     *
     * @param string $token
     * @return mixed
     * @throws BadRequestHttpException
     */
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

    public function actionLanguage($lang)
    {

        Yii::$app->language = $lang;
        $cookie = new Cookie([
            'name' => 'lang',
            'value' => $lang
        ]);
        Yii::$app->getResponse()->getCookies()->add($cookie);
        return $this->redirect(Yii::$app->request->referrer);
    }
}
