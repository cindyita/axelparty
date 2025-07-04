<?php 
require_once 'model.php';

class FormController {
    public static function confirm() {
        $data = json_decode(file_get_contents("php://input"), true);

        if (!$data || !isset($data['idguest'], $data['confirm'])) {
            echo json_encode(['success' => false, 'error' => 'Datos incompletos']);
            exit;
        }

        $success = DBModel::saveConfirm(
            $data['idguest'],
            $data['confirm'],
            $data['extras'],
            $data['congrats']
        );

        echo json_encode(['success' => $success]);
    }

    public static function addGuest(){
        $data = json_decode(file_get_contents("php://input"), true);

        if (!$data || !isset($data['name'])) {
            echo json_encode(['success' => false, 'error' => 'Datos incompletos']);
            exit;
        }

        $success = DBModel::saveGuest(
            $data['name'],
            $data['contact'],
            $data['active']
        );

        if($success){
            $id = DBModel::lastId();
            echo json_encode(['success' => $success, 'id' => $id]);
        }else{
            echo json_encode(['success' => false, 'error' => 'Error No se pudo guardar']);
            exit;
        }

    }

    public static function addGuestInactive(){
        $data = json_decode(file_get_contents("php://input"), true);

        if (!$data || !isset($data['name'])) {
            echo json_encode(['success' => false, 'error' => 'Datos incompletos']);
            exit;
        }

        $success = DBModel::saveGuest(
            $data['name'],
            $data['contact'],
            0
        );

        if($success){
            $id = DBModel::lastId();
            echo json_encode(['success' => $success, 'id' => $id]);
        }else{
            echo json_encode(['success' => false, 'error' => 'Error No se pudo guardar']);
            exit;
        }

    }

    public static function getGuests(){
        $guests = DBModel::getAllGuests();
        echo json_encode($guests);
    }

    public static function deleteGuest($id){
        $success = DBModel::deleteGuest($id);
        if($success){
            $id = DBModel::lastId();
            echo json_encode(['success' => $success, 'id' => $id]);
        }else{
            echo json_encode(['success' => false, 'error' => 'Error No se pudo eliminar']);
            exit;
        }
    }

    public static function updateGuest(){
        $data = json_decode(file_get_contents("php://input"), true);

        $success = DBModel::updateGuest(
            $data['id'],
            $data['name'],
            $data['contact']
        );

        if($success){
            echo json_encode(['success' => $success, 'id' => $data['id']]);
        }else{
            echo json_encode(['success' => false, 'error' => 'Error No se pudo guardar']);
            exit;
        }

    }

    public static function inviteRequest($id){
        $success = DBModel::inviteRequest($id);
        if($success){
            echo json_encode(['success' => $success]);
        }else{
            echo json_encode(['success' => false, 'error' => 'Error No se pudo eliminar']);
            exit;
        }
    }
}
