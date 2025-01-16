<?php
namespace App\Controllers;

use App\Core\Controller;
require_once __DIR__ . '/../models/Notification.php';
require_once __DIR__ . '/../models/db.php';
require_once __DIR__ . '/../core/Controller.php';
class NotificationController extends Controller {
    private $notificationModel;

    public function __construct() {
        $database = new Database();
        $conn = $database->connect();
        $this->notificationModel = new Notification($conn);
    }

    /**
     * Récupère les notifications d'un membre spécifique.
     *
     * @param int $userId L'ID du membre.
     * @return array Les notifications du membre.
     */
    public function getUserNotifications($userId) {
        return $this->notificationModel->getUserNotifications($userId);
    }
    public function getAllNotifications() {
        return $this->notificationModel->getAllNotifications();
    }

    /**
     * Retourne l'icône FontAwesome en fonction du type de notification.
     *
     * @param string $type Le type de notification.
     * @return string L'icône FontAwesome.
     */
    public function getNotificationIcon($type) {
        switch ($type) {
            case 'Événement':
                return 'fa-calendar-check-o';
            case 'Promotion':
                return 'fa-tag';
            case 'Renouvellement':
                return 'fa-exclamation-circle';
            default:
                return 'fa-bell';
        }
    }
    /**
     * Formate la date de la notification pour afficher "Il y a X temps".
     *
     * @param string $date La date de la notification.
     * @return string La date formatée.
     */
    public function formatNotificationTime($date) {
        $now = new DateTime();
        $notificationDate = new DateTime($date);
        $interval = $now->diff($notificationDate);

        if ($interval->y > 0) {
            return "Il y a " . $interval->y . " an(s)";
        } elseif ($interval->m > 0) {
            return "Il y a " . $interval->m . " mois";
        } elseif ($interval->d > 0) {
            return "Il y a " . $interval->d . " jour(s)";
        } elseif ($interval->h > 0) {
            return "Il y a " . $interval->h . " heure(s)";
        } elseif ($interval->i > 0) {
            return "Il y a " . $interval->i . " minute(s)";
        } else {
            return "À l'instant";
        }
    }
    public function createNotification($id_membre, $id_type_notification, $titre, $contenu) {
        $this->notificationModel->id_membre = $id_membre;
        $this->notificationModel->id_type_notification = $id_type_notification;
        $this->notificationModel->titre = $titre;
        $this->notificationModel->contenu = $contenu;

        return $this->notificationModel->create();
    }
    public function editNotification($id, $id_membre, $id_type_notification, $titre, $contenu) {
        $this->notificationModel->id = $id;
        $this->notificationModel->id_membre = $id_membre;
        $this->notificationModel->id_type_notification = $id_type_notification;
        $this->notificationModel->titre = $titre;
        $this->notificationModel->contenu = $contenu;

        return $this->notificationModel->update();
    }

    /**
     * Supprime une notification.
     *
     * @param int $id L'ID de la notification.
     * @return bool True si la notification a été supprimée, sinon False.
     */
   
     public function deleteNotification($id) {
        $this->notificationModel->id = $id;
        return $this->notificationModel->delete();
    }
}
?>