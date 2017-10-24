<?php

namespace API\Common;

use Illuminate\Support\Facades\DB;

trait DomainTransaction {

    private static $transactionSuccess = false;
    private static $isStarted = false;
    private static $firstCaller = null;

    public function transactionBegin() {
        if (self::$isStarted === true) {
            self::$transactionSuccess = false;
            return;
        }

        self::$firstCaller = __METHOD__;
        self::$isStarted = true;
        DB::beginTransaction();
    }

    public function transactionSuccess() {
        self::$transactionSuccess = true;
    }

    public function transactionEnd() {
        if (self::$firstCaller !== get_class()) {
            return;
        }

        if (self::$transactionSuccess) {
            DB::commit();
        } else {
            DB::rollback();
        }

        $this->reset();
    }
    
    private function reset(){
        self::$transactionSuccess = false;
        self::$isStarted = false;
        self::$firstCaller = null;
    }

}
