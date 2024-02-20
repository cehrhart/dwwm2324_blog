Ces fichiers sont à destination des élèves préparant le diplôme de DWWM, l'accès sera supprimé en juillet 2024

Ajout du rôle des utilisateurs : 
ALTER TABLE `users` ADD `user_role` ENUM('user','admin','modo','') NOT NULL DEFAULT 'user' AFTER `user_pwd`;
