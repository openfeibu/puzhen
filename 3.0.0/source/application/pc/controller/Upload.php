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
            return json(['code' => 0, 'msg' => '图片上传失败' . $StorageDriver->getError()]);
        }

        // 图片上传路径
        $fileName = $StorageDriver->getFileName();
        // 图片信息
        $fileInfo = $StorageDriver->getFileInfo();
        // 添加文件库记录
        $uploadFile = $this->addUploadFile($group_id, $fileName, $fileInfo, 'image');
        // 图片上传成功
        return json(['code' => 1, 'msg' => '图片上传成功', 'data' => $uploadFile]);
    }

    /**
     * 添加文件库上传记录
     * @param $group_id
     * @param $fileName
     * @param $fileInfo
     * @param $fileType
     * @return array
     */
    private function addUploadFile($group_id, $fileName, $fileInfo, $fileType)
    {
        // 存储引擎
        $storage = $this->config['default'];
        // 存储域名
        $fileUrl = isset($this->config['engine'][$storage]['domain'])
            ? $this->config['engine'][$storage]['domain'] : '';
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
    }

}
