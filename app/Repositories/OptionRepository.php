<?php

namespace App\Repositories;
use App\Models\Option;

class OptionRepository implements OptionRepositoryInterface {

    private $option;

    //public function __construct(Option $option) {
    public function __construct() {
        $this->option = app('App\Models\Option');
    }

    public function createOption($key, $value, $group = '') {
        $option = $this->option;
        $existed = $option->find($key);
        if ($existed) {
            return false;
        }
        return $option->create([
                    'key' => $key,
                    'value' => serialize($value),
                    'group' => $group
        ]);
    }

    public function updateOption($key, $value, $group) {
        $option = $this->option;
        $option = $option->find($key);
        $option->value = serialize($value);
        if(!empty($group))
            $option->group = $group;
        return $option->save();
    }

    public function createOrReplaceOption($key, $value, $group = '') {
        $option = $this->option;
        $existed = $option->find($key);
        if ($existed) {
            $existed->value = serialize($value);
            return $existed->save();
        }
        return $option->create([
                    'key' => $key,
                    'value' => serialize($value),
                    'group' => $group
        ]);
    }

    public function getOption($key) {
        $option = $this->option;
        $option = $option->find($key);
        if(!empty($option)){
            $option = $option->value;
            return unserialize($option);
        }
        return null;
    }

    public function getGroupOption($group) {
        return $this->option->where('group', $group)->get();
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
    
    public function extract($value) {
        return unserialize($value);
    }

    public function getAllService(){
        return $this->getOption('all_services');
    }
}
