<?php

    class Notification extends dbh
    {
        public function getNotificationWithId($notif_id)
        {
            $connection = $this->connection();
            $sql = "SELECT * FROM notifications WHERE notif_id = ?";
            $stmt = $connection->prepare($sql);
            $notification = $stmt->execute([$notif_id]);
            return $notification;
        }

        public function addNotification($ownerId,$id,$type)
        {
            $connection = $this->connection();
            $sql = '';
            if($type == 1)
            {
                echo 'Working 1';
                $sql = 'INSERT INTO notifications VALUES(0,?,?,7,28,1,NOW(),"N")';
                $stmt = $connection->prepare($sql);
                $stmt->execute([$ownerId,$id]);
            }
            else if($type == 2)
            {
                echo 'Working 2';
                $sql = 'INSERT INTO notifications VALUES(0,?,9,?,28,2,NOW(),"N")';
                $stmt = $connection->prepare($sql);
                $stmt->execute([$ownerId,$id]);
            }
            else if($type == 3)
            {
                echo 'Working 3';
                $sql = 'INSERT INTO notifications VALUES(0,?,9,7,?,3,NOW(),"N")';
                $stmt = $connection->prepare($sql);
                $stmt->execute([$ownerId,$id]);
            }
        }

        public function getAllUserNotifications($user_id)
        {
            $connection = $this->connection();
            $sql = "SELECT * FROM notifications WHERE owner_id = ? ORDER BY created_at DESC";
            $stmt = $connection->prepare($sql);
            $stmt->execute([$user_id]);
            $notifications = $stmt->fetchAll();
            return $notifications;
        }

        public function changeStatus($notifId)
        {
            $connection = $this->connection();
            $sql = "UPDATE notifications SET view = 'Y' WHERE notif_id = ?";
            $stmt = $connection->prepare($sql);
            $stmt->execute([$notifId]);
        }

        public function getNewNotificationCount($owner_id)
        {
            $connection = $this->connection();
            $sql = "SELECT notif_id FROM notifications WHERE owner_id = ? AND view = 'N'";
            $stmt = $connection->prepare($sql);
            $stmt->execute([$owner_id]);
            $count = $stmt->rowCount();
            return $count;
        }
    }
?>