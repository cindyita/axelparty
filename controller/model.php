<?php

require_once __DIR__ . '/../data.php';

class DBModel {
    private static $pdo;

    public static function connect() {
        if (!self::$pdo) {
            try {
                self::$pdo = new PDO('sqlite:' . DB_PATH);
                self::$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
                self::$pdo->exec("PRAGMA foreign_keys = ON;");

                // TABLAS
                self::$pdo->exec("CREATE TABLE IF NOT EXISTS guests (
                    id INTEGER PRIMARY KEY AUTOINCREMENT,
                    name TEXT NOT NULL,
                    contact TEXT,
                    active INTEGER DEFAULT 1
                )");

                self::$pdo->exec("CREATE TABLE IF NOT EXISTS confirmation (
                    id INTEGER PRIMARY KEY AUTOINCREMENT,
                    id_guest INTEGER NOT NULL UNIQUE,
                    confirm TEXT,
                    extras INTEGER,
                    congrats TEXT,
                    date_confirm DATETIME DEFAULT CURRENT_TIMESTAMP,
                    FOREIGN KEY(id_guest) REFERENCES guests(id) ON DELETE CASCADE
                )");
            } catch (Exception $e) {
                die("Error de base de datos: " . $e->getMessage());
            }
        }

        return self::$pdo;
    }

    public static function saveGuest($name, $contact, $active) {
        try {
            $pdo = self::connect();
            $stmt = $pdo->prepare("INSERT INTO guests (name, contact, active) VALUES (:name, :contact,:active)");
            $result = $stmt->execute([
                ':name' => $name,
                ':contact' => $contact,
                ':active'=> $active
            ]);
            return $result ? true : false;
        } catch (PDOException $e) {
            error_log("Error en saveGuest: " . $e->getMessage());
            return false;
        }
    }

    public static function saveConfirm($idguest, $confirm, $extras, $congrats) {
        try {
            $pdo = self::connect();
            $stmt = $pdo->prepare("
                INSERT INTO confirmation (id_guest, confirm, extras, congrats, date_confirm)
                VALUES (:id_guest, :confirm, :extras, :congrats, :date_confirm)
                ON CONFLICT(id_guest) DO UPDATE SET
                    confirm = excluded.confirm,
                    extras = excluded.extras,
                    congrats = excluded.congrats,
                    date_confirm = excluded.date_confirm
            ");
            $datetime = (new DateTime('now', new DateTimeZone('America/Mexico_City')))->format('Y-m-d H:i:s');
            $stmt->execute([
                ':id_guest' => $idguest,
                ':confirm' => $confirm,
                ':extras' => intval($extras),
                ':congrats' => $congrats,
                ':date_confirm' => $datetime
            ]);
            return true;
        } catch (PDOException $e) {
            error_log("DB ERROR: " . $e->getMessage());
            echo json_encode(['success' => false, 'error' => $e->getMessage()]);
            return false;
        }
    }

    public static function getAllGuests() {
        $pdo = self::connect();
        $stmt = $pdo->query("SELECT 
                g.id, g.name, g.contact, 
                CASE 
                    WHEN c.confirm IS NOT NULL THEN 
                        c.confirm || ' (' || strftime('%d-%m-%Y', c.date_confirm) || ')' || 
                        CASE WHEN c.extras > 0 THEN ' [+' || c.extras || ']' ELSE '' END
                    ELSE NULL
                END AS confirm,
                c.congrats, g.active
            FROM guests g
            LEFT JOIN confirmation c ON c.id_guest = g.id
            ORDER BY g.id DESC
        ");
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public static function getAllGuestsActive() {
        $pdo = self::connect();
        $stmt = $pdo->query("SELECT 
                g.id, g.name, g.contact, 
                CASE 
                    WHEN c.confirm IS NOT NULL THEN 
                        c.confirm || ' (' || strftime('%d-%m-%Y', c.date_confirm) || ')' || 
                        CASE WHEN c.extras > 0 THEN ' [+' || c.extras || ']' ELSE '' END
                    ELSE NULL
                END AS confirm,
                c.congrats, g.active
            FROM guests g
            LEFT JOIN confirmation c ON c.id_guest = g.id
            WHERE g.active = 1
            ORDER BY g.id DESC
        ");
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public static function getGuestById($id_guest) {
        $pdo = self::connect();
        $stmt = $pdo->prepare("SELECT id, name, contact FROM guests WHERE id = :id");
        $stmt->execute([':id' => $id_guest]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public static function deleteGuest($id){
        $pdo = DBModel::connect();
        $stmt = $pdo->prepare("DELETE FROM guests WHERE id = :id");
        return $stmt->execute([':id' => $id]);
    }

    public static function updateGuest($id, $name, $contact) {
        try {
            $pdo = self::connect();
            $stmt = $pdo->prepare("
                UPDATE guests
                SET name = :name, contact = :contact
                WHERE id = :id
            ");
            $result = $stmt->execute([
                ':id' => $id,
                ':name' => $name,
                ':contact' => $contact
            ]);
            return $result;
        } catch (PDOException $e) {
            error_log("Error en updateGuest: " . $e->getMessage());
            return false;
        }
    }

    public static function inviteRequest($id) {
        try {
            $pdo = self::connect();
            $stmt = $pdo->prepare("
                UPDATE guests
                SET active = 1
                WHERE id = :id
            ");
            $result = $stmt->execute([
                ':id' => $id
            ]);
            return $result;
        } catch (PDOException $e) {
            error_log("Error al invitar: " . $e->getMessage());
            return false;
        }
    }

    public static function lastId(){
        $pdo = self::connect();
        return $pdo->lastInsertId();
    }

}
