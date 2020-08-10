<?php
namespace app\controllers;

use Yii;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\web\Response;
use yii\filters\VerbFilter;
use app\models\LoginForm;
use app\models\ContactForm;
use \app\models\Money;

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
                'only' => ['logout'],
                'rules' => [
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
     * @return string
     */
    public function actionIndex()
    {
        return $this->render('index');
    }

    /**
     * Login action.
     *
     * @return Response|string
     */
    public function actionLogin()
    {
        if (!Yii::$app->user->isGuest) {
            return $this->goHome();
        }

        $model = new LoginForm();
        if ($model->load(Yii::$app->request->post()) && $model->login()) {
            return $this->goBack();
        }

        $model->password = '';
        return $this->render('login', [
                'model' => $model,
        ]);
    }

    /**
     * Logout action.
     *
     * @return Response
     */
    public function actionLogout()
    {
        Yii::$app->user->logout();

        return $this->goHome();
    }

    public function actionMoney()
    {

        if (Yii::$app->user->isGuest) {
            \Yii::$app->session->setFlash('warning', 'You should sign in!', false);

            return $this->redirect(['login']);
        }

        if (file_exists(\Yii::getAlias('@webroot') . '/stat/site-money.html')) {
            return file_get_contents(\Yii::getAlias('@webroot') .'/stat/site-money.html');
        }
        
        $this->layout = 'free';
        $cache = Yii::$app->cache;
        
        $xml = $cache->get('xml_money');
        
        if (empty($xml)) {
            $xml = file_get_contents('http://www.cbr.ru/scripts/XML_daily.asp'); 
            $cache->set('xml_money', $xml);
        }
        
        $money = $cache->get('money');

        if (empty($money)) { 
            $money = \bobchengbin\Yii2XmlRequestParser\Xml2Array::go($xml, '1', 'attribute');
            $cache->set('money', $money);
        }
        $tomorrow = date_modify(new \DateTime(), '+1 day');
        $tomorrow = date_format($tomorrow, 'd.m.Y');
        $date = $money['ValCurs']['attr']['Date'];
        foreach ($money['ValCurs']['Valute'] as $valute) {

            $find = Money::find()->where('money_Name=:valute',[':valute' => $valute['Name']['value']])
                    ->one();
            if (!empty($find)) {
                $money = $find;
            } else {
                $money = new Money();
                $money->money_attr = $valute['attr']['ID'];
                $money->money_NumCode = $valute['NumCode']['value'];
                $money->money_CharCode = $valute['CharCode']['value'];
                $money->money_Nominal = $valute['Nominal']['value'];
                $money->money_Name = $valute['Name']['value'];
                $money->save();
            }
            
            $count = new \app\models\MoneyCount();
            $count->count = $valute['Value']['value'];
            $count->id_money = (string) $money->id_money;
            $count->data = $date;
            $count->save();
        }
       
        
        $money = Money::find()->select('money.*, money_count.*')
                ->leftJoin('money_count', 'money_count.id_money=money.id_money')
                ->where('money_count.data=:date', [':date' => date('d.m.Y')])
                ->orWhere('money_count.data=:date', [':date' => $tomorrow])
                ->asArray()->all();
        
        if (empty($money)) {
            $cache->set('money', false);
            $cache->set('xml_money', false);
            
            return $this->redirect(['money']);
        }

        return $this->render('money', ['money' => $money]);
    }

    /**
     * Displays contact page.
     *
     * @return Response|string
     */
    public function actionContact()
    {
        $model = new ContactForm();
        if ($model->load(Yii::$app->request->post()) && $model->contact(Yii::$app->params['adminEmail'])) {
            Yii::$app->session->setFlash('contactFormSubmitted');

            return $this->refresh();
        }
        return $this->render('contact', [
                'model' => $model,
        ]);
    }

    /**
     * Displays about page.
     *
     * @return string
     */
    public function actionAbout()
    {
        return $this->render('about');
    }
}
