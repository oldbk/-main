<?php
namespace components\Controller;
use components\Component\Config;
use \components\Controller\_base\MainController;
use components\Helper\CurrencyHelper;
use components\Model\Bank;
use components\Model\BankHistory;
use components\Model\Effect;
use components\Model\NewDelo;
use components\Model\PhantomEnter;
use components\Model\user\UserPhantom as UserPhantomAuth;
use database\DB;

/**
 * Created by PhpStorm.
 * User: nnikitchenko
 * Date: 18.11.2015
 *
 */
class PhantomController extends MainController
{
    /** @var UserPhantomAuth */
    protected $user;

    public function beforeAction($action)
    {
        $r = parent::beforeAction($action); // TODO: Change the autogenerated stub
        if($this->user->battle != 0)
            $this->redirect('/fbattle.php');

        if($this->user->room != Config::ROOM_PHANTOM && $action != 'enter')
            $this->redirect('/main.php');

        return $r;
    }

    protected function getUser()
    {
        $this->user = UserPhantomAuth::findByPk($this->get('session')->get('uid'))->asModel();
    }

    public function enterAction()
    {
        if(Config::init()->phantom_enter_cost_type == CurrencyHelper::CURRENCY_EKR && !$this->user->bank) {
            $this->app->flash('error', '��� ����� � ��������� �������, �� ������ �������� ����. <br>
                ��� ����� ������������� � �����');
            $this->app->redirect($this->app->urlFor('znahar', array('action' => 'index')));
        }

        /** @var DB $db */
        $db = $this->get('db');
        $db->beginTransaction();
        try {
            if(!$this->user->enter(Config::ROOM_PHANTOM)) {
                throw new \Exception();
            }
            $time = new \DateTime();
            $_data = array(
                'user_id' => $this->user->id,
                'cost' => Config::init()->phantom_enter_cost,
                'currency' => Config::init()->phantom_enter_cost_type,
                'currency_title' => CurrencyHelper::getTitle(Config::init()->phantom_enter_cost_type),
                'enter_at' => $time->getTimestamp(),
            );
            if(!PhantomEnter::insert($_data)) {
                throw new \Exception();
            }

            if(Config::init()->phantom_enter_cost_type == CurrencyHelper::CURRENCY_EKR) {
                if($this->user->bank['ekr'] < Config::init()->phantom_enter_cost) {
                    throw new \Exception();
                }

                $_data = array(
                    'owner' => $this->user->id,
                    'owner_login' => $this->user->login,
                    'owner_balans_do' => $this->user->bank['ekr'],
                    'owner_balans_posle' => $this->user->bank['ekr'] - Config::init()->phantom_enter_cost,
                    'target' => 0,
                    'target_login' => '������',
                    'type' => 323,
                    'sum_rep' => 0,
                    'sum_ekr' => Config::init()->phantom_enter_cost,
                    'bank_id' => $this->user->bank['id'],
                    'add_info' => sprintf('������ ��: %s ���. ����� %s ���.', $this->user->bank['ekr'], $this->user->bank['ekr'] - Config::init()->phantom_enter_cost),
                    'sdate' => time(),
                );
                if(!NewDelo::addNew($_data)) {
                    throw new \Exception();
                }

                $data = array('ekr' => $this->user->bank['ekr'] - Config::init()->phantom_enter_cost);
                if(!Bank::update($data, 'owner = ? and id = ?', array($this->user->id, $this->user->bank['id']))) {
                    throw new \Exception();
                }

                $time = new \DateTime();
                $data = array(
                    'date' => $time->getTimestamp(),
                    'bankid' => $this->user->bank['id'],
                    'text' => sprintf(
                        '���������� ����� ������ � ������� <b>%s ���.</b>, �������� <b>0 ��.</b> <i>(�����: %s ��., %s ���.)</i>',
                        Config::init()->phantom_enter_cost, $this->user->bank['cr'], $this->user->bank['ekr'] - Config::init()->phantom_enter_cost
                    ),
                );
                if(!BankHistory::insert($data)) {
                    throw new \Exception();
                }
            } else {
                if($this->user->money < Config::init()->phantom_enter_cost) {
                    throw new \Exception();
                }

                $_data = array(
                    'owner' => $this->user->id,
                    'owner_login' => $this->user->login,
                    'owner_balans_do' => $this->user->money,
                    'owner_balans_posle' => $this->user->money - Config::init()->phantom_enter_cost,
                    'target' => 0,
                    'target_login' => '������',
                    'type' => 170,
                    'sum_kr' => Config::init()->phantom_enter_cost,
                    'item_count' => 0,
                    'sdate' => time(),
                    'add_info' => '����� �� ���� � ��������� �������!'
                );

                if(!NewDelo::addNew($_data)) {
                    throw new \Exception();
                }

                $this->user->money -= Config::init()->phantom_enter_cost;
                $this->user->save();
            }

            $db->commit();
        } catch (\Exception $ex) {
            $db->rollBack();

            $this->app->flash('error', '�� ������� ����� � �������!');
            $this->app->redirect($this->app->urlFor('znahar', array('action' => 'index')));
        }

        $this->app->redirect($this->app->urlFor('phantom', array('action' => 'index')));
    }

    public function indexAction()
    {
        $this->render('index', array('user' => $this->user));
    }
}