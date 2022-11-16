<?php

namespace app\api\model;

use think\Cache;
use app\common\library\wechat\WxUser;
use app\common\exception\BaseException;
use app\common\model\User as UserModel;
use app\api\model\dealer\Referee as RefereeModel;
use app\api\model\dealer\Setting as DealerSettingModel;
use app\api\model\UserWechatAccount as UserWechatAccountModel;

/**
 * 用户模型类
 * Class User
 * @package app\api\model
 */
class User extends UserModel
{
    private $token;

    /**
     * 隐藏字段
     * @var array
     */
    protected $hidden = [
        'open_id',
        'is_delete',
        'wxapp_id',
        'create_time',
        'update_time'
    ];

    /**
     * 获取用户信息
     * @param $token
     * @return null|static
     * @throws \think\exception\DbException
     */
    public static function getUser($token)
    {
        $openId = Cache::get($token)['openid'];
        $user_id = Cache::get($token)['user_id'];
        //$wechat_account = UserWechatAccountModel::detail(['openid' => $openId]);
        return self::detail(['user_id' => $user_id], ['address', 'addressDefault', 'grade']);
    }

    /**
     * 用户登录
     * @param array $post
     * @return string
     * @throws BaseException
     * @throws \think\Exception
     * @throws \think\exception\DbException
     */
    public function login($post)
    {
        // 微信登录 获取session_key
        $session = $this->wxlogin($post['code']);
        // 自动注册用户
        $refereeId = $post['referee_id'] ?? null;
        $userInfo = json_decode(htmlspecialchars_decode($post['user_info']), true);
        $user_id = $this->register($session['openid'], $session['unionid'], $userInfo, $refereeId);
        // 生成token (session3rd)
        $session['user_id'] = $user_id;
        $this->token = $this->token($session['openid']);
        // 记录缓存, 7天
        Cache::set($this->token, $session, 86400 * 7);
        return $user_id;
    }

    /**
     * 获取token
     * @return mixed
     */
    public function getToken()
    {
        return $this->token;
    }

    /**
     * 微信登录
     * @param $code
     * @return array|mixed
     * @throws BaseException
     * @throws \think\exception\DbException
     */
    private function wxlogin($code)
    {
        // 获取当前小程序信息
        $wxConfig = Wxapp::getWxappCache();
        // 验证appid和appsecret是否填写
        if (empty($wxConfig['app_id']) || empty($wxConfig['app_secret'])) {
            throw new BaseException(['msg' => '请到 [后台-小程序设置] 填写appid 和 appsecret']);
        }
        // 微信登录 (获取session_key)
        $WxUser = new WxUser($wxConfig['app_id'], $wxConfig['app_secret']);
        if (!$session = $WxUser->sessionKey($code)) {
            throw new BaseException(['msg' => $WxUser->getError()]);
        }
        return $session;
    }

    /**
     * 生成用户认证的token
     * @param $openid
     * @return string
     */
    private function token($openid)
    {
        $wxapp_id = self::$wxapp_id;
        // 生成一个不会重复的随机字符串
        $guid = \getGuidV4();
        // 当前时间戳 (精确到毫秒)
        $timeStamp = microtime(true);
        // 自定义一个盐
        $salt = 'token_salt';
        return md5("{$wxapp_id}_{$timeStamp}_{$openid}_{$guid}_{$salt}");
    }

    /**
     * 自动注册用户
     * @param $openId
     * @param $unionId
     * @param $data
     * @param int $refereeId
     * @return mixed
     * @throws \Exception
     * @throws \think\exception\DbException
     */
    private function register($openId, $unionId, $data, $refereeId = null)
    {
        $weappAccount = UserWechatAccountModel::detail(['open_id' => $openId,'type' => 'weapp']);
        // 老系统没有union_id，做兼容更新
        // 之前登录但是没有union_id，更新union_id。
        if($weappAccount && $unionId && !$weappAccount['union_id'])
        {
            // 保存/更新用户记录
            $weappAccount->allowField(true)->save(array_merge($data, [
                'open_id' => $openId,
                'union_id' => $unionId,
                'wxapp_id' => self::$wxapp_id,
                'type' => 'weapp',
            ]));
        }

        $wechatWebAccount = UserWechatAccountModel::detail(['union_id' => $unionId,'type' => 'web']);
        $fromWechatWebAccount = 0;
	    $this->startTrans();
	    try {
	        //todo 应该先判断是否存在小程序用户
            //有微信用户直接登录
            $weappAccountModel = $weappAccount ?: new UserWechatAccountModel;
            //$from_weapp_account = 0;
            if($weappAccount)
            {
                $user = self::detail(['user_id' => $weappAccount['user_id']]);
                $model = $user ?: $this;
                $existUser = $user ? 1 : 0;
                //$from_weapp_account = 1;
            }else{
                //判断是否注册过网页
                if($wechatWebAccount)
                {
                    //主用户
                    $user = self::detail(['user_id' => $wechatWebAccount['user_id']]);
                    $model = $user ?: $this;
                    $existUser = $user ? 1 : 0;
                    $fromWechatWebAccount = 1;
                }else{
                    $model = $this;
                    $existUser = 0;
                    $model->allowField(true)->save(array_merge($data, [
                        'wxapp_id' => self::$wxapp_id
                    ]));

                }

            }

            $model->allowField(true)->save(array_merge($data, [
                'open_id' => $openId,
                'wxapp_id' => self::$wxapp_id
            ]));

            $weappAccountModel->allowField(true)->save(array_merge($data, [
                'open_id' => $openId,
                'union_id' => $unionId,
                'wxapp_id' => self::$wxapp_id,
                'user_id' => $model['user_id'],
                'type' => 'weapp',
            ]));

            $fromWechatWebAccount ? $wechatWebAccount->allowField(true)->save([
                'wxapp_id' => self::$wxapp_id,
                'user_id' => $model['user_id'],
                'type' => 'web',
            ]) : '';
            if (!$existUser && $refereeId > 0) {
                RefereeModel::createRelation($model['user_id'], $refereeId);
            }

            /*
            // 查询微信用户（包含小程序，网页，公众号h5，移动应用）是否已存在
            $wechat_account = UserWechatAccountModel::detail(['union_id' => $unionId]);
		    //存在微信用户
		    if($wechat_account)
		    {
		        //主用户
		        $user = self::detail(['user_id' => $wechat_account['user_id']]);
			    $existUser = $user ? 1 : 0;
			    $model = $user ?: $this;

			    if(!$existUser)
			    {
                    //不存在主用户，注册用户
				    $model->allowField(true)->save(array_merge($data, [
					    'wxapp_id' => self::$wxapp_id
				    ]));
				    //微信用户绑定主用户
                    $wechat_account->allowField(true)->save([
                        'wxapp_id' => self::$wxapp_id,
                        'user_id' => $model['user_id'],
                        'type' => 'weapp',
                    ]);
			    }
                $weappAccountModel = $weappAccount ?: new UserWechatAccountModel;
			    // 保存/更新用户记录
                $weappAccountModel->allowField(true)->save(array_merge($data, [
				    'open_id' => $openId,
				    'union_id' => $unionId,
				    'wxapp_id' => self::$wxapp_id,
				    'user_id' => $model['user_id'],
				    'type' => 'weapp',
			    ]));
			    // 记录推荐人关系
			    if (!$existUser && $refereeId > 0) {
				    RefereeModel::createRelation($model['user_id'], $refereeId);
			    }
            }else{
			    $model = $this;
			    $model->allowField(true)->save(array_merge($data, [
				    'wxapp_id' => self::$wxapp_id
			    ]));
			    $wechat_account = new UserWechatAccountModel;
			    $wechat_account->allowField(true)->save(array_merge($data, [
				    'open_id' => $openId,
				    'union_id' => $unionId,
				    'wxapp_id' => self::$wxapp_id,
				    'user_id' => $model['user_id'],
				    'type' => 'weapp',
			    ]));
			    // 记录推荐人关系
			    if ($refereeId > 0) {
				    RefereeModel::createRelation($model['user_id'], $refereeId);
			    }
            }
            */
            $this->commit();

        } catch (\Exception $e) {
		    $this->rollback();
		    throw new BaseException(['msg' => $e->getMessage()]);
	    }
	    
	    return $model['user_id'];
    }

    /**
     * 个人中心菜单列表
     * @return array
     */
    public function getMenus()
    {
        $menus = [
            'address' => [
                'name' => '收货地址',
                'url' => 'pages/address/index',
                'icon' => 'map'
            ],
            'coupon' => [
                'name' => '领券中心',
                'url' => 'pages/coupon/coupon',
                'icon' => 'lingquan'
            ],
            'my_coupon' => [
                'name' => '我的优惠券',
                'url' => 'pages/user/coupon/coupon',
                'icon' => 'youhuiquan'
            ],
            'sharing_order' => [
                'name' => '拼团订单',
                'url' => 'pages/sharing/order/index',
                'icon' => 'pintuan'
            ],
            'my_bargain' => [
                'name' => '我的砍价',
                'url' => 'pages/bargain/index/index?tab=1',
                'icon' => 'kanjia'
            ],
            'dealer' => [
                'name' => '分销中心',
                'url' => 'pages/dealer/index/index',
                'icon' => 'fenxiaozhongxin'
            ],
            'help' => [
                'name' => '我的帮助',
                'url' => 'pages/user/help/index',
                'icon' => 'help'
            ],
        ];
        // 判断分销功能是否开启
        if (DealerSettingModel::isOpen()) {
            $menus['dealer']['name'] = DealerSettingModel::getDealerTitle();
        } else {
            unset($menus['dealer']);
        }
        return $menus;
    }

}
