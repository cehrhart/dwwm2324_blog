Ces fichiers sont à destination des élèves préparant le diplôme de DWWM, l'accès sera supprimé en juillet 2024

Ajout du rôle des utilisateurs : 
ALTER TABLE `users` ADD `user_role` ENUM('user','admin','modo','') NOT NULL DEFAULT 'user' AFTER `user_pwd`;

Modération:
ALTER TABLE `articles` ADD `article_valid` BOOLEAN NOT NULL DEFAULT FALSE AFTER `article_creator`, ADD `article_comment` TEXT NULL AFTER `article_valid`, ADD `article_modo` INT NULL AFTER `article_comment`;

Mot de passe oublié :
ALTER TABLE `users` ADD `user_recocode` VARCHAR(255) NULL AFTER `user_role`, ADD `user_recodate` DATETIME NULL AFTER `user_recocode`, ADD `user_recoexp` DATETIME NULL AFTER `user_recodate`, ADD UNIQUE (`user_recocode`);