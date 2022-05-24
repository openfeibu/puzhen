<?php

namespace app\store\service\goods;

use app\store\model\Goods as GoodsModel;
use app\store\model\Category as CategoryModel;
use app\store\model\Factory as FactoryModel;
use \PhpOffice\PhpSpreadsheet\IOFactory;
use \PhpOffice\PhpSpreadsheet\Spreadsheet;

class Import
{
    private $error;

    /**
     * 表格标题
     * @var array
     */
    public $title_arr = [
        'factory_name' => '工厂名称','category_name' => '产品分类','goods_name' => '产品名称','selling_point' => '产品卖点','goods_no' => "产品编码",'ref_price' => "参考零售价",'weight' => '产品重量(Kg)'
    ];

    public $column_key = [
        'A','B','C','D','E','F','G','H','I','J','K','L','M','N','O','P','Q','R','S','T','U','V','W','X','Y','Z'
    ];

    public function goodsList()
    {
        if(!isset($_FILES['myfile']))
        {
            $this->error = '请上传文件';
            return false;
        }
        //获取表格的大小，限制上传表格的大小5M
        $file_size = $_FILES['myfile']['size'];
        if ($file_size > 10 * 1024 * 1024) {
            $this->error = '文件大小不能超过10M';
            return false;
        }
        //限制上传表格类型
        $fileExtendName = substr(strrchr($_FILES['myfile']["name"], '.'), 1);
        //application/vnd.ms-excel  为xls文件类型
        if (!in_array($fileExtendName,["xls","xlsx","csv"])) {
            $this->error = '必须为excel表格，且必须为xls、xlsx、csv格式！';
            return false;
        }
        // 有Xls和Xlsx和Cvs格式三种
        if ($fileExtendName=="xls")
        {
            $objReader = IOFactory::createReader('Xls');
        }elseif ($fileExtendName=="xlsx")
        {
            $objReader = IOFactory::createReader('Xlsx');
        }elseif ($fileExtendName=="csv")
        {
            $objReader = IOFactory::createReader('Csv');
        }

        if (is_uploaded_file($_FILES['myfile']['tmp_name'])) {
            // 有Xls和Xlsx格式两种

            $filename = $_FILES['myfile']['tmp_name'];
            $objPHPExcel = $objReader->load($filename);  //$filename可以是上传的表格，或者是指定的表格
            $sheet = $objPHPExcel->getSheet(0);   //excel中的第一张sheet
            $highestRow = $sheet->getHighestRow();       // 取得总行数
            $highestColumn = $sheet->getHighestColumn();   // 取得总列数
            $highestColumnIndex = \PhpOffice\PhpSpreadsheet\Cell\Coordinate::columnIndexFromString($highestColumn); // e.g. 5

            $title_value_arr = [];
            $key_arr = [];
            for ($j = 1; $j <= $highestColumnIndex; $j++) {
                $title_value_arr[] = $title = $objPHPExcel->getActiveSheet()->getCell($this->column_key[$j-1] . "1")->getValue();
                $key = array_search($title,$this->title_arr);
                if(!$key)
                {
                    $this->error = $title." 字段错误！请务必严格按照表格字段。";
                    return false;
                }

                $key_arr[$key] = $this->column_key[$j-1];
            }

            $categoryModel = new CategoryModel;
            $factoryModel = new FactoryModel;
            $category_list = $categoryModel->column('category_id','name');
            $factory_list = $factoryModel->where('is_delete',0)->column('factory_id','factory_name');

            //循环读取excel表格，整合成数组。如果是不指定key的二维，就用$data[i][j]表示。
            for ($j = 2; $j <= $highestRow; $j++) {
                foreach ($key_arr as $key => $column)
                {
                    $value = $objPHPExcel->getActiveSheet()->getCell($column . $j)->getValue();
                    if($key == 'factory_name')
                    {
                        if(!isset($factory_list[$value]))
                        {
                            $this->error = "第".($j)."行 系统未发现该工厂！请检查。";
                            return false;
                        }
                        $data[$j-2]['factory_id'] = $factory_list[$value];
                    }elseif ($key == 'category_name')
                    {
                        if(!isset($category_list[$value]))
                        {
                            $this->error = "第".($j)."行 系统未发现该分类！请检查。";
                            return false;
                        }
                        $data[$j-2]['category_id'] = $category_list[$value];
                    }else{
                        $data[$j-2][$key] = $value ?? '';
                    }
                }
            }

            foreach ($data as $key=> $item)
            {
                $goodsModel = new GoodsModel;
                if(!$goodsModel->add($item))
                {
                    $this->error = '上传成功'.($key).'行。第'.($key+2).'行错误：'.$goodsModel->getError();
                    return false;
                }
            }
            return true;
        }

    }
    public function import()
    {
        //$keys 例子
        // $atr = array(
        //     array("订单号","order_num"),
        //     array("年级","grade"),
        //     array("姓名","user_name"),
        // );

        // 有Xls和Xlsx和Cvs格式三种
        if ($Extension=="xls")
        {
            $reader = IOFactory::createReader('Xls');
        }elseif ($Extension=="xlsx")
        {
            $reader = IOFactory::createReader('Xlsx');
        }elseif ($Extension=="csv")
        {
            $reader = IOFactory::createReader('Csv');
        }
        //载入excel文件
        $excel = $reader->load($filePath);
        //读取第一张表
        $sheet = $excel->getSheet(0);
        //获取总行数
        $row_num = $sheet->getHighestRow();
        //获取总列数
        $col_num = $sheet->getHighestColumn();

        $count = ord($col_num);
        $count = $count - 64;

        for($i=2;$i<=$row_num;$i++){                                    //循环行数
            for( $x = 0; $x < $count; $x++ ){                           //循环列数
                $letter = strtoupper(chr($x + 65));         //字母
                $name = $excel->getActiveSheet()->getCell($letter.'1')->getValue();         //获取 表头名称
                foreach ($keys as $key => $value) {
                    if( $value[0] == $name){
                        $data[$i-2][$value[1]] = $excel->getActiveSheet()->getCell($letter.$i)->getValue();
                        break;
                    }
                }
            }
        }
        return $data;
    }
    /**
     * 返回模型的错误信息
     * @access public
     * @return string|array
     */
    public function getError()
    {
        return $this->error;
    }
}