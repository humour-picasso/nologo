<?php
/**
 * @link http://www.yiiframework.com/
 * @copyright Copyright (c) 2008 Yii Software LLC
 * @license http://www.yiiframework.com/license/
 */


namespace api\modules\filters;

use yii\filters\auth\QueryParamAuth;

/**
 * QueryParamAuth is an action filter that supports the authentication based on the access token passed through a query parameter.
 *
 * @author Qiang Xue <qiang.xue@gmail.com>
 * @since 2.0
 */
class CustomQueryParamAuth extends QueryParamAuth
{
    /**
     * @var string the parameter name for passing the access token
     */
    public $tokenParam = 'ACCESSTOKEN';


    /**
     * @inheritdoc
     */
    public function authenticate($user, $request, $response)
    {


        $accessToken = $request->headers->get($this->tokenParam);

        if ($accessToken != '') {
            $identity = $user->loginByAccessToken($accessToken, get_class($this));

            if ($identity !== null) {
                return $identity;
            }
        }
        if ($accessToken !== null) {
            $this->handleFailure($response);
        }

        return null;

    }
}
