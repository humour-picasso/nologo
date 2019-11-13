<?php
/**
 * @link http://www.yiiframework.com/
 * @copyright Copyright (c) 2008 Yii Software LLC
 * @license http://www.yiiframework.com/license/
 */

namespace app\api\modules\filters;

use Yii;
use yii\base\ActionEvent;
use yii\base\Behavior;
use yii\web\Controller;
use yii\web\MethodNotAllowedHttpException;

/**
 * VerbFilter is an action filter that filters by HTTP request methods.
 *
 * It allows to define allowed HTTP request methods for each action and will throw
 * an HTTP 405 error when the method is not allowed.
 *
 * To use VerbFilter, declare it in the `behaviors()` method of your controller class.
 * For example, the following declarations will define a typical set of allowed
 * request methods for REST CRUD actions.
 *
 * ```php
 * public function behaviors()
 * {
 *     return [
 *         'verbs' => [
 *             'class' => \yii\filters\VerbFilter::className(),
 *             'actions' => [
 *                 'index'  => ['get'],
 *                 'view'   => ['get'],
 *                 'create' => ['get', 'post'],
 *                 'update' => ['get', 'put', 'post'],
 *                 'delete' => ['post', 'delete'],
 *             ],
 *         ],
 *     ];
 * }
 * ```
 *
 * @see http://www.w3.org/Protocols/rfc2616/rfc2616-sec14.html#sec14.7
 * @author Carsten Brandt <mail@cebe.cc>
 * @since 2.0
 */
class VerbFilter extends Behavior
{
    /**
     * @var array this property defines the allowed request methods for each action.
     * For each action that should only support limited set of request methods
     * you add an entry with the action id as array key and an array of
     * allowed methods (e.g. GET, HEAD, PUT) as the value.
     * If an action is not listed all request methods are considered allowed.
     *
     * You can use `'*'` to stand for all actions. When an action is explicitly
     * specified, it takes precedence over the specification given by `'*'`.
     *
     * For example,
     *
     * ```php
     * [
     *   'create' => ['get', 'post'],
     *   'update' => ['get', 'put', 'post'],
     *   'delete' => ['post', 'delete'],
     *   '*' => ['get'],
     * ]
     * ```
     */
    public $actions = [];


    public $cors = [
        'Origin' => ['*'],
        //'Access-Control-Request-Method' => ['GET', 'POST', 'PUT', 'PATCH', 'DELETE', 'HEAD', 'OPTIONS'],
        'Access-Control-Request-Headers' => ['*'],
        'Access-Control-Allow-Credentials' => null,
        'Access-Control-Max-Age' => 86400,
        'Access-Control-Expose-Headers' => [],
    ];


    /**
     * Declares event handlers for the [[owner]]'s events.
     * @return array events (array keys) and the corresponding event handler methods (array values).
     */
    public function events()
    {
        return [Controller::EVENT_BEFORE_ACTION => 'beforeAction'];
    }

    /**
     * @param ActionEvent $event
     * @return bool
     * @throws MethodNotAllowedHttpException when the request method is not allowed.
     */
    public function beforeAction($event)
    {
        $action = $event->action->id;
        $request = Yii::$app->request;
        $response = Yii::$app->response;

        //____ get $verbs
        isset($this->actions[$action]) || array_unshift($this->actions[$action],'options');
        in_array('options',$this->actions[$action]) || array_unshift($this->actions[$action],'options');
        $verbs = $this->actions[$action];

        if(isset($verbs['key'])){
            unset($verbs['key']);
        }
        if(isset($verbs['urlKey'])){
            unset($verbs['urlKey']);
        }
        if(is_array($verbs[count($verbs)-1])){
            $cors = array_pop($verbs);
            $this->cors = array_merge($this->cors,$cors);
        }
        $this->cors['Access-Control-Request-Method'] = array_map('strtoupper',$verbs);

        //____ validate current method
        $allowed = array_map('strtoupper', $verbs);
        $currentVerb = Yii::$app->getRequest()->getMethod();

        if (!in_array($currentVerb, $allowed)) {
            $event->isValid = false;
            $this->customizeMethodNotAllowedHttpException($allowed);
        }

        //____push success
        $corsObject = new Cors;
        $corsObject->cors = $this->cors;
        $corsObject->beforeAction($event->action);

        if($request->isOptions){
            $response->statusCode = 200;
            $response->data=[];
            $response->send();
            exit();
        }

        return $event->isValid;
    }

    public function customizeMethodNotAllowedHttpException($allowed)
    {
        Yii::$app->getResponse()->getHeaders()->set('Allow', implode(', ', $allowed));
        throw new MethodNotAllowedHttpException('Method Not Allowed. This url can only handle the following request methods: ' . implode(', ', $allowed) . '.');
    }

}
