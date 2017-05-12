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
        
        $orderBy = $this->getOrderBy($query, $data);
        $query = $this->bindData($query, [':orderby'=>$orderBy]);
        //dd($query);
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
            for($i=0; $i<count($searchable); $i++) {
                if($i==0) {
                    $list->where($searchable[$i], 'like', '%' . $searchvalue . '%' );
                    continue;
                }
                $list->orWhere($searchable[$i], 'like', '%' . $searchvalue . '%' );
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
        if($searchfield!='')
            return ' and '. $searchfield. " like '%$searchvalue%' ";
        $searchable = (array)$searchable;
        $where = '';
        if($searchfield=='' && count($searchable)){
            for($i=0; $i<count($searchable); $i++) {
                if($i==0) {
                    $where = $where . ' and '. $searchable[$i]. " like '%$searchvalue%' ";
                    continue;
                }
                $where = $where . ' or '. $searchable[$i]. " like '%$searchvalue%' ";
            }
            return $where; 
        }
        return '';
    }
    
    public function getOrderBy($query, $data) {
        if(empty($data['orderfield']))
            return '';
        $field = $data['orderfield'];
        $direction = (empty($data['orderdir']) ? 'asc' : $data['orderdir']);
        return  ' order by '. $field .' '. $direction;
    }
    
}
