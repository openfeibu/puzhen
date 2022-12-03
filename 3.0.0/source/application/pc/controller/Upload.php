<?php

namespace app\pc\controller;

use app\pc\model\UploadFile;
use app\common\library\storage\Driver as StorageDriver;
use app\pc\model\Setting as SettingModel;

/**
 * 文件库管理
 * Class Upload
 * @package app\store\controller
 */
class Upload extends Controller
{
    private $config;
    private $user;
    /**
     * 构造方法
     * @throws \app\common\exception\BaseException
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\ModelNotFoundException
     * @throws \think\exception\DbException
     */
    public function _initialize()
    {
        parent::_initialize();
        // 存储配置信息
        $this->config = SettingModel::getItem('storage');
        $this->user = $this->getUser();
    }

    /**
     * 图片上传接口
     * @param int $group_id
     * @return array
     * @throws \think\Exception
     */
    public function image($group_id = -1)
    {
        // 实例化存储驱动
        $StorageDriver = new StorageDriver($this->config);
        // 设置上传文件的信息
        $StorageDriver->setUploadFile('iFile');
        // 上传图片
        if (!$StorageDriver->upload()) {
            return $this->renderError([],lang('upload_image.failed'. ' '.$StorageDriver->getError()));
        }

        // 图片上传路径
        $fileName = $StorageDriver->getFileName();
        // 图片信息
        $fileInfo = $StorageDriver->getFileInfo();
        // 添加文件库记录
        $uploadFile = $this->addUploadFile($fileName, $fileInfo, 'image');
        // 图片上传成功
        return $this->renderSuccess($uploadFile->visible(['file_id','file_path']),lang('upload_image.success'));
    }

    /**
     * 添加文件库上传记录
     * @param $fileName
     * @param $fileInfo
     * @param $fileType
     * @return array
     */
    private function addUploadFile($fileName, $fileInfo, $fileType)
    {
        // 存储引擎
        $storage = $this->config['default'];
        // 存储域名
        $fileUrl = $this->config['engine'][$storage]['domain'] ?? '';
        $model = new UploadFile;
        $model->add([
            'storage' => $storage,
            'file_url' => $fileUrl,
            'file_name' => $fileName,
            'file_size' => $fileInfo['size'],
            'file_type' => $fileType,
            'extension' => pathinfo($fileInfo['name'], PATHINFO_EXTENSION),
            'is_user' => 1,
            'user_id' => $this->user['user_id'],
        ]);
        return $model;
        /*
        if ($storage === 'local') {
            $filePath = base_url() . 'uploads/' . $fileName;
        }else{
            $filePath = $fileUrl . '/' . $fileName;
        }

        return [
            'group_id' => $group_id > 0 ? (int)$group_id : 0,
            'storage' => $storage,
            'file_url' => $fileUrl,
            'file_name' => $fileName,
            'file_size' => $fileInfo['size'],
            'file_type' => $fileType,
            'file_path' => $filePath,
            'extension' => pathinfo($fileInfo['name'], PATHINFO_EXTENSION),
        ];
        */
    }

}
