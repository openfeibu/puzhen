<?php

namespace app\store\service\user_equipment;

use app\store\model\UserEquipment as UserEquipmentModel;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use PhpOffice\PhpSpreadsheet\IOFactory;


/**
 * 订单导出服务类
 * Class Export
 * @package app\store\service\user_equipment
 */
class Export
{
    /**
     * 表格标题
     * @var array
     */
    private $tileArray = [
        '用户', '联系人', '手机号', '购买日期','茶电器', '序列号', '只换不修剩余时间', '保修剩余时间',
    ];

    /**
     * 订单导出
     * @param $list
     */
    public function userEquipmentList($list)
    {
        // 表格内容
        $dataArray = [];
        foreach ($list as $user_equipment) {
            /* @var UserEquipmentModel $user_equipment */
            $dataArray[] = [
                '用户' => $this->filterValue($user_equipment['user']['nickName']),
                '联系人' => $this->filterValue($user_equipment['linkname']),
                '手机号' => $this->filterValue($user_equipment['phone']),
                '购买日期' => $this->filterValue($user_equipment['buy_date']),
                '茶电器' => $this->filterEquipment($user_equipment['equipment']),
                '序列号' => $this->filterValue($user_equipment['equipment_sn']),
                '只换不修剩余时间' => $this->filterValue($user_equipment['change_days_text']),
                '保修剩余时间' => $this->filterValue($user_equipment['warranty_days_text']),
            ];
        }
        // 导出csv文件
        $filename = 'user_equipment-' . date('YmdHis');

        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();
        //表头
        //设置单元格内容
        $titCol = 'A';
        foreach ($this->tileArray as $key => $value) {
            // 单元格内容写入
            $sheet->setCellValue($titCol . '1', $value);
            $spreadsheet->getActiveSheet()->getColumnDimension($titCol)->setAutoSize(true);
            $titCol++;
        }
        $row = 2; // 从第二行开始
        foreach ($dataArray as $item) {
            $dataCol = 'A';
            // 单元格内容写入
            foreach ($this->tileArray as $title)
            {
                $sheet->setCellValue($dataCol . $row, $item[$title]);$dataCol++;
            }

            $row++;
        }

        header('Content-Type: application/vnd.ms-excel');
        header('Content-Disposition: attachment;filename="' . $filename . '.xlsx"');
        header('Cache-Control: max-age=0');
        $writer = new Xlsx($spreadsheet);
        $writer->save('php://output');
        //删除清空：
        $spreadsheet->disconnectWorksheets();

        //return export_excel($filename . '.csv', $this->tileArray, $dataArray);
    }

    /**
     * 格式化茶电器信息
     * @param $equipment
     * @return string
     */
    private function filterEquipment($equipment)
    {
        $content = '';
        $content .= "茶电器名称：{$equipment['equipment_name']}\n";
        $content .= "茶电器型号：{$equipment['model']}\n";
        return $content;
    }

    /**
     * 表格值过滤
     * @param $value
     * @return string
     */
    private function filterValue($value)
    {
        return "\t" . $value . "\t";
    }

    /**
     * 日期值过滤
     * @param $value
     * @return string
     */
    private function filterTime($value)
    {
        if (!$value) return '';
        return $this->filterValue(date('Y-m-d H:i:s', $value));
    }

}