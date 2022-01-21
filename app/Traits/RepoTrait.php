<?php

namespace App\Traits;

trait RepoTrait {

    /**
     * @param $query
     * @param array|null $selection
     * @param int|null $paginate
     * @param array $order
     * @param bool $first
     * @return mixed
     *
     * This method handles all query responses from the DB
     */
    public function modify($query, array $selection, $paginate=null, array $order=[], $first=false){

        if(count($selection)>0){
            $query->select($selection);
        }

        if(count($order)===2){
            $query->orderBy($order[0],$order[1]);
        }

        if(!empty($paginate)){
            return $query->paginate($paginate)->onEachSide(2);
        }else{
            if($first){
                return $query->first();
            }
            return $query->get();
        }


    }

}