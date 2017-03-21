<?php

namespace App\Repositories;
use App\Models\Option;

class OptionRepository implements OptionRepositoryInterface {

    private $option;

    public function __construct(Option $option) {
        $this->option = $option;
    }

    public function createOption($key, $value) {
        $option = $this->option;
        $existed = $option->find($key);
        if ($existed) {
            return false;
        }
        return $option->create([
                    'key' => $key,
                    'value' => serialize($value)
        ]);
    }

    public function updateOption($key, $value) {
        $option = $this->option;
        $option = $option->find($key);
        $option->value = serialize($value);
        return $option->save();
    }

    public function createOrReplaceOption($key, $value) {
        $option = $this->option;
        $existed = $option->find($key);
        if ($existed) {
            $existed->value = serialize($value);
            return $existed->save();
        }
        return $option->create([
                    'key' => $key,
                    'value' => serialize($value)
        ]);
    }

    public function getOption($key) {
        $option = $this->option;
        $option = $option->find($key);
        if(isset($option)){
            $option = $option->value;
            return unserialize($option);
        }
        return null;
        
    }

    public function deleteOption($key) {
        return $this->option->find($key)->delete();
    }

    public function _getParams($data, $paramkey = 'paramkey', $param_prefix = 'param_') {
        if(empty($data[$paramkey]))
            return [];
        $arr = [];
        $length = strlen($param_prefix);
        foreach ($data as $key => $value) {
            $nkey = substr($key, $length);
            if (substr($key, 0, $length) == $param_prefix) {
                $arr[$nkey] = $value;
            }
        }
        return [
            'key' => $data[$paramkey],
            'value' => $arr,
        ];
    }

}
