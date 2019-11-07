<?php

namespace App\Services;

use App\User;


class LibraryService
{

    public function givePermissionTo($folder,$request){
        $folder->permitted()->sync($request->staff);
        foreach ($folder->permitted()->get() as $staff) {
            $staff->user->syncPermissions('folder-crud');
        }
    }


}   