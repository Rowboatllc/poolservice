<?php

namespace App\Common;
use DB;

trait Pagination {
    
    private $perPage = 5;
    
    public function pagingSort($list, $data, $isCustomQuery = false, $searchable=[]) {
        return $isCustomQuery ? $this->pagingSortCustom($list, $data, $searchable) : $this->pagingSortEloquent($list, $data, $searchable);
    }
    
    public function pagingSortCustom($query, $data, $searchable) {
        $where = $this->getWhere($data, $searchable);
        $query = $this->bindData($query, [':where'=>$where]);
        
        $orderBy = $this->getOrderBy($query, $data, $searchable);
        $query = $this->bindData($query, [':orderby'=>$orderBy]);
        $page = empty($data['page']) ? 1 : (int)$data['page'];
        $perPage = $this->perPage;
        return $this->paginate($query, $page, $perPage);
    }
    
    public function pagingSortEloquent($list, $data, $searchable) {
        $list = $this->search($list, $data, $searchable);
        if(!empty($data['orderfield'])) {
            $field = $data['orderfield'];
            $direction = (empty($data['orderdir']) ? 'asc' : $data['orderdir']);
            $list = $list->orderBy($field, $direction);
        }
        $page = empty($data['page']) ? 1 : (int)$data['page'];
        $perPage = $this->perPage;
        return $list->paginate($perPage);
    }
    
    // Pagination for custom query
    public function paginate($query, $page, $perPage) {
        $list = DB::select(DB::raw($query));
        $list = (array)$list;
        $offSet = ($page * $perPage) - $perPage;
        $itemsForCurrentPage = array_slice($list, $offSet, $perPage, false);
        return new \Illuminate\Pagination\LengthAwarePaginator($itemsForCurrentPage, count($list), $perPage, $page);
    }

    public function search($list, $data, $searchable) {
        $searchvalue = empty($data['searchvalue']) ? '' : $data['searchvalue'];
        $searchfield = empty($data['searchfield']) ? '' : $data['searchfield'];
        if($searchvalue=='')
            return $list;
        if($searchfield!='')
            return $list->where($searchfield, 'like', '%' . $searchvalue . '%' );
        $searchable = (array)$searchable;
        if($searchfield=='' && count($searchable)){
            $i=0;
            foreach($searchable as $k => $v) {
                if($i==0) {
                    $list->where($v, 'like', '%' . $searchvalue . '%' );
                    $i=1;
                    continue;
                }
                $list->orWhere($v, 'like', '%' . $searchvalue . '%' );
            }
            return $list; 
        }
        return $list;
    }
    
    public function bindData($tpl, $params) {
        return strtr($tpl, $params);
    }
    
    public function getWhere($data, $searchable) {
        $searchvalue = empty($data['searchvalue']) ? '' : $data['searchvalue'];
        $searchfield = empty($data['searchfield']) ? '' : $data['searchfield'];
        
        if($searchvalue=='')
            return '';
        if($searchfield!='') {
            if( in_array($searchfield, array_keys($searchable)) && (!empty($searchable[$searchfield])) )
                $searchfield = $searchable[$searchfield];
            return ' and '. $searchfield. " like '%$searchvalue%' ";
        }
        $searchable = (array)$searchable;
        $where = '';
        if($searchfield=='' && count($searchable)){
            $i=0;
            foreach($searchable as $k => $v) {
                if($i==0) {
                    $where = $where . ' and '. $v. " like '%$searchvalue%' ";
                    $i=1;
                    continue;
                }
                $where = $where . ' or '. $v. " like '%$searchvalue%' ";
            }
            return $where; 
        }
        return '';
    }
    
    public function getOrderBy($query, $data, $searchable) {
        if(empty($data['orderfield']))
            return '';
        $field = $data['orderfield'];
        if(in_array($field, array_keys($searchable))) {
            if(!empty($searchable[$field]))
                $field = $searchable[$field];
            // else $field=key 
        }
        $direction = (empty($data['orderdir']) ? 'asc' : $data['orderdir']);
        return  ' order by '. $field .' '. $direction;
    }
    
}
