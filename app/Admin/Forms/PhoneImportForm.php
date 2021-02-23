<?php

namespace App\Admin\Forms;
use  App\Models\Phone;
use Box\Spout\Common\Exception\IOException;
use Box\Spout\Common\Exception\UnsupportedTypeException;
use Dcat\Admin\Http\JsonResponse;
use Dcat\Admin\Widgets\Form;
use Dcat\EasyExcel\Excel;
use Exception;
use League\Flysystem\FileNotFoundException;

class PhoneImportForm extends Form
{
    /**
     * 处理表单提交逻辑
     * @param array $input
     * @return JsonResponse
     */
    public function handle(array $input): JsonResponse
    {
        $file = $input['file'];
        $file_path = public_path('uploads/' . $file);
        try {
            $rows = Excel::import($file_path)->first()->toArray();
            foreach ($rows as $row) {
                try {
                    if (!empty($row['姓名']) && !empty($row['电话']) ) {
                        $category =Phone::where('phone', $row['电话'])->first();
                        if (empty($category)) {
                            $device_records = new Phone();
                            $device_records->phone = $row['电话'];
                            $device_records->name = $row['姓名'];
                        // 这里导入判断空值，不能使用 ?? null 或者 ?? '' 的方式，写入数据库的时候
                        // 会默认为插入''而不是null，这会导致像price这样的double也是插入''，就会报错
                        // 其实price应该插入null
                        if (!empty($row['IP'])) {
                            $device_records->IP = $row['IP'];
                        }

                        if (!empty($row['提交页面'])) {
                            $device_records->host = $row['提交页面'];
                        }
                        if (!empty($row['数据来源'])) {
                            $device_records->referer = $row['数据来源'];
                        }
                        if (!empty($row['备注'])) {
                            $device_records->remark = $row['备注'];
                        }

                        $device_records->save();
                        }
                    }
                    else {
                        return $this->response()
                            ->error('缺少必要的字段！');
                    }
                }
                catch (Exception $exception) {
                    continue;
                }
            }
            $return = $this
                ->response()
                ->success('文件导入成功！')
                ->refresh();
        } catch (IOException $e) {
            $return = $this
                ->response()
                ->error('文件读写失败：' . $e->getMessage());
        } catch (UnsupportedTypeException $e) {
            $return = $this
                ->response()
                ->error('不支持的文件类型：' . $e->getMessage());
        } catch (FileNotFoundException $e) {
            $return = $this
                ->response()
                ->error('文件不存在：' . $e->getMessage());
        }

        return $return;
    }

    /**
     * 构造表单
     */
    public function form()
    {
        $this->file('file', '表格文件')
            ->accept('xls,xlsx,csv')
            ->autoUpload()
            ->required()
            ->help('导入支持xls、xlsx、csv文件，且表格头必须使用【姓名，电话，IP，提交页面，数据来源，备注】。');
    }
}
