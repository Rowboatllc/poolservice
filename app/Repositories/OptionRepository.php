<?php

namespace App\Repositories;

class OptionRepository {

    private $option;
    
    public function __construct() {
        $this->option = app('App\Models\Options');
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

    public function getOption($key) {
        $option = $this->option;
        $option = $option->find($key);
        $option = $option->value;
        return unserialize($option);
    }

    public function deleteOption($key) {
        return $this->option->find($key)->delete();
    }

}
