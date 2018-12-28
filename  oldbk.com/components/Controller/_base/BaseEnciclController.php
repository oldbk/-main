<?php
/**
 * Created by PhpStorm.
 * User: me
 * Date: 13.12.16
 * Time: 20:11
 */

namespace components\Controller\_base;


use components\Component\Config;
use components\Component\Slim\Middleware\ClientScript\ClientScript;
use components\Model\LibraryCategory;
use components\Model\LibraryPage;

class BaseEnciclController extends BaseController
{
    /** @var string */
    protected $layout = 'encicl';
    protected $menu;

    protected $title = '�����: ���������� ���� - ������� ���������� ������ ������ ���� | ������ ��������� � ���������� ����';
    protected $description = '';

    public function render($_view, $_data_ = null, $_return = false)
    {
        $this->app->view()->appendLayoutData(array(
            'page_title' => $this->title,
            'page_description' => $this->description
        ));

        return parent::render($_view, $_data_, $_return);
    }

    protected function beforeAction($action)
    {
        if($this->cache === false || $this->htmlCache === null) {
            $category_ids = array();
            $Categories = LibraryCategory::findAll(array(
                'condition' => 'is_enabled = 1',
                'order' => 'order_position asc'
            ), array('id', 'title'))->asArray();
            foreach ($Categories as $Category) {
                $category_ids[] = $Category['id'];
            }

            $PagesByCategory = array();
            if($category_ids) {
                $Pages = LibraryPage::findAll(array(
                    'condition' => 'category_id in ('.LibraryPage::getIN($category_ids).') and (is_enabled = 1 or 1=?)',
                    'order' => 'order_position asc'
                ), array_merge($category_ids, array((int)Config::admins())), array('id', 'category_id', 'page_title', 'dir'))->asArray();
                foreach ($Pages as $Page) {
                    if(!isset($PagesByCategory[$Page['category_id']])) {
                        $PagesByCategory[$Page['category_id']] = array();
                    }
                    $PagesByCategory[$Page['category_id']][] = $Page;
                }
            }

            $this->app->view()->appendLayoutData(array(
                'categories' => $Categories,
                'pages_by_category' => $PagesByCategory
            ));
        }

        return parent::beforeAction($action); // TODO: Change the autogenerated stub
    }

    protected function loadCssAndScripts()
    {
        $this->app->clientScript
            ->registerCssFile('/assets/bootstrap/css/bootstrap.min.css')
            ->registerCssFile('/assets/iconic/css/open-iconic-bootstrap.min.css')
            ->registerCssFile('/assets/adaptive/css/kp-new-style.css')
            ->registerCssFile('/assets/adaptive/css/img.min.css')
            ->registerCssFile('/assets/forum/css/pill.css')
            ->registerCssFile('/assets/encicl/css/encicl.css');

        $this->app->clientScript
            ->registerJsFile('/assets/jquery/jquery.min.js', ClientScript::JS_POSITION_BEGIN)
            ->registerJsFile('/assets/encicl/js/encicl.js', ClientScript::JS_POSITION_BEGIN)
            ->registerJsFile('/js/gatracking/gat.js', ClientScript::JS_POSITION_BEGIN)
            ->registerJsFile('/assets/scrollpos-styler/scrollPosStyler.js', ClientScript::JS_POSITION_END)
            ->registerJsFile('/assets/scrollup/dist/jquery.scrollUp.min.js', ClientScript::JS_POSITION_END)
            ->registerJsFile('/assets/bootstrap/js/bootstrap.bundle.js', ClientScript::JS_POSITION_END);
    }
}