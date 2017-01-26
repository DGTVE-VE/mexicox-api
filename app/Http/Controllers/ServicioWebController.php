<?php

namespace App\Http\Controllers;

use DB;
use Illuminate\Http\Request;
use App\Http\Requests;
use App\Model\log_api;

class ServicioWebController extends Controller {

    public function curso(Request $request, $token,$course_id) {
        $cliente = DB::table('cliente_api')->where('key', '=', $token)->get();
//        print_r ($cliente);
        if (!empty($cliente)) {
            ///alimentación de log             
            $log_api = new log_api();
            $log_api->cliente_api_id = $cliente[0]->id;
            $log_api->servicio = $request->path();
            $log_api->save();
            ///consulta de recurso        
            $id = base64_decode($course_id);
            $curso = DB::table('vm_perfil_usuario')
                    ->where('course_id', '=', $id)->get();
            return response()->json($curso);
        } else {
            return response('Usuario no aceptado');
        }
    }

    public function progreso(Request $request, $token, $student_id, $course_id) {
        $cliente = DB::table('cliente_api')->where('key', '=', $token)->get();
//        print_r ($cliente);
        if (!empty($cliente)) {
            ///alimentación de log             
            $log_api = new log_api();
            $log_api->cliente_api_id = $cliente[0]->id;
            $log_api->servicio = $request->path();
            $log_api->save();
            ///consulta de recurso
            $curso = base64_decode($course_id);
            $user = DB::table('courseware_studentmodule')
                    ->where('student_id', '=', $student_id)
                    ->where('course_id', '=', $curso)->get();
            return response()->json($user);
        } else {
            return response('Usuario no aceptado');
        }
    }

    public function historial(Request $request, $token, $student_module_id) {
        $cliente = DB::table('cliente_api')->where('key', '=', $token)->get();
//        print_r ($cliente);
        if (!empty($cliente)) {
            ///alimentación de log             
            $log_api = new log_api();
            $log_api->cliente_api_id = $cliente[0]->id;
            $log_api->servicio = $request->path();
            $log_api->save();
            ///consulta de recurso            
            $modulo = DB::table('courseware_studentmodulehistory')
                    ->where('student_module_id', '=', $student_module_id)->get();
            return response()->json($modulo);
        } else {
            return response('Usuario no aceptado');
        }
    }

}

//http://localhost/mexicox-api/public/user/r3QxMvAXVgM2nB/progreso/16/Q0lOVkVTVEFWL0NJTlZFU1RBVi0yMDE2LTAxLzIwMTYtUzE=