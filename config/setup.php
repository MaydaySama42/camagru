<?php
/* ************************************************************************** */
/*                                                                            */
/*                                                        :::      ::::::::   */
/*   setup.php                                          :+:      :+:    :+:   */
/*                                                    +:+ +:+         +:+     */
/*   By: mayday <mayday@student.42.fr>              +#+  +:+       +#+        */
/*                                                +#+#+#+#+#+   +#+           */
/*   Created: 2019/08/06 19:01:16 by mayday            #+#    #+#             */
/*   Updated: 2019/08/06 19:01:17 by mayday           ###   ########.fr       */
/*                                                                            */
/* ************************************************************************** */

function createDatabase()
{
	global $database;

	$query = $database->prepare("SHOW DATABASES LIKE 'camagru';");
	$query->execute();
	$query->setFetchMode(PDO::FETCH_ASSOC);
	$res = $query->fetch();
	$query->closeCursor();
	if (!empty($res))
	{
		$database->query("USE camagru;");
		return (0);
	}
	if (isset($_COOKIE['token']))
		setcookie('token', "", time() - 10, '/');
	$database->query("CREATE DATABASE IF NOT EXISTS camagru");
	$database->query("USE camagru;");
	$database->query("CREATE TABLE user (
		user_id int(11) PRIMARY KEY NOT NULL AUTO_INCREMENT,
		user_name text,
		user_password varchar(99) DEFAULT NULL,
		user_mail varchar(99) DEFAULT NULL,
		user_crea_date timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
		user_confirm varchar(64) DEFAULT NULL,
		`notification` tinyint(1) NOT NULL
	  )");

	$database->query("CREATE TABLE `picture` (
		`pic_id` int(11) PRIMARY KEY NOT NULL AUTO_INCREMENT,
		`pic_date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
		`pic_path` text,
		`user_id` int(11) DEFAULT NULL,
		FOREIGN KEY (user_id) REFERENCES user(user_id)
	  )");

	$database->query("CREATE TABLE comment (
		comment_id int(11) PRIMARY KEY NOT NULL AUTO_INCREMENT,
		comment_text text,
		user_id int(11) DEFAULT NULL,
		pic_id int(11) DEFAULT NULL,
		comment_date timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
		FOREIGN KEY (user_id) REFERENCES user(user_id),
		FOREIGN KEY (pic_id) REFERENCES picture(pic_id)
	  )");

	$database->query("CREATE TABLE `reactions` (
		`reaction_id` int(11) PRIMARY KEY NOT NULL AUTO_INCREMENT,
		`reaction_type` int(11) NOT NULL,
		`user_id` int(11) NOT NULL,
		`pic_id` int(11) NOT NULL,
		FOREIGN KEY (user_id) REFERENCES user(user_id),
		FOREIGN KEY (pic_id) REFERENCES picture(pic_id)
	)");
	$database->query("CREATE TABLE `filter` (
		`filter_id` int(11) PRIMARY KEY NOT NULL NOT NULL,
		`filter_path` varchar(64) DEFAULT NULL
	  )");
	$database->query("INSERT INTO `filter` (`filter_id`, `filter_path`) VALUES
		(1, '../resources/img/filter/filter0.png'),
		(2, '../resources/img/filter/filter1.png'),
		(3, '../resources/img/filter/filter2.png'),
		(4, '../resources/img/filter/filter3.png'),
		(5, '../resources/img/filter/filter4.png'),
		(6, '../resources/img/filter/filter5.png'),
		(7, '../resources/img/filter/filter6.png'),
		(8, '../resources/img/filter/filter7.png');");
}

?>