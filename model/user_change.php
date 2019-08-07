<?php
/* ************************************************************************** */
/*                                                                            */
/*                                                        :::      ::::::::   */
/*   admin.php                                          :+:      :+:    :+:   */
/*                                                    +:+ +:+         +:+     */
/*   By: mayday <mayday@student.42.fr>              +#+  +:+       +#+        */
/*                                                +#+#+#+#+#+   +#+           */
/*   Created: 2019/08/01 23:10:22 by mayday            #+#    #+#             */
/*   Updated: 2019/08/01 23:10:23 by mayday           ###   ########.fr       */
/*                                                                            */
/* ************************************************************************** */

function checkMailChange($mail)
{
	$error = [];

	if (checkMailIsValid($mail) != 0)
		$error[] = ['send_mail', 'Please enter a valid mail'];
	else if (checkMailAlreadyExists($mail) == 1)
		$error[] = ['send_mail', 'Mail already exists !'];
	return ($error);
}

function changeMail($mail)
{
	global $database;

	if (checkToken() != 0)
		return (sendResponse("User not logged", 400));
	$error = checkMailChange($mail);
	if (!empty($error))
		return (sendResponse($error, 400));

	$user_id = json_decode($_COOKIE['token'])->user_id;
	$query = $database->prepare("UPDATE user SET user_mail = :new_mail WHERE user_id = :user_id");
	$query->execute(['new_mail' => $mail, 'user_id' => $user_id]);
	$query->closeCursor();
	deleteToken();
	return (sendResponse("Mail well changed ! Now deconnecting...", 200));
}

function checkUserNameChange($username)
{
	$error = [];

	if (checkUserNameIsValid($username) == 1)
		$error[] = ['send_username', 'Please enter a valid username'];
	else if (checkUserNameAlreadyExists($username) == 1)
		$error[] = ['send_username', 'Username already used !'];
	return ($error);
}

function changeUserName($username)
{
	global $database;

	if (checkToken() != 0)
		return (sendResponse("User not logged", 400));
	$error = checkUserNameChange($username);
	if (!empty($error))
		return (sendResponse($error, 400));

	$user_id = json_decode($_COOKIE['token'])->user_id;
	$query = $database->prepare("UPDATE user SET user_name = :new_username WHERE user_id = :user_id");
	$query->execute(['new_username' => $username, 'user_id' => $user_id]);
	$query->closeCursor();
	deleteToken();
	return (sendResponse("Username well changed ! Now deconnecting...", 200));
}

function checkPasswordChange($password, $password_confirm)
{
	$error = [];

	if (checkPasswordIsValid($password, $password_confirm) == 1)
		$error[] = ['send_password', 'Please enter a password with at least 8 characters'];
	if (checkPasswordIsValid($password, $password_confirm) == 2)
		$error[] = ['send_password', 'Please enter the same password'];
	return ($error);
}

function changePassword($password, $password_confirm)
{
	global $database;

	if (checkToken() != 0)
		return (sendResponse("User not logged", 400));
	$error = checkPasswordChange($password, $password_confirm);
	if (!empty($error))
		return (sendResponse($error, 400));

	$user_id = json_decode($_COOKIE['token'])->user_id;
	$query = $database->prepare("UPDATE user SET user_password = :new_password WHERE user_id = :user_id");
	$query->execute(['new_password' => md5($password), 'user_id' => $user_id]);
	$query->closeCursor();
	deleteToken();
	return (sendResponse("Password well changed ! Now deconnecting...", 200));
}

function changeNotification()
{
	global $database;

	if (checkToken() != 0)
		return (sendResponse("User not logged", 400));

	$user_id = json_decode($_COOKIE['token'])->user_id;
	/*$query = $database->prepare("SELECT notification FROM user WHERE user_id = :user_id");
	$query->execute(['user_id' => $user_id]);
	$query->setFetchMode(PDO::FETCH_ASSOC);
	$notif = $query->fetch()['notification'];
	$query->closeCursor();*/

	$query = $database->prepare("UPDATE user SET notification = CASE notification WHEN 1 THEN 0 WHEN 0 THEN 1 END WHERE user_id = :user_id");
	$query->execute(['user_id' => $user_id]);
	$query->closeCursor();
	return (sendResponse("Notification preference changed !", 200));
}

function getUserValuesFromDB()
{
	global $database;

	if (checkToken() != 0)
		return (sendResponse("User not logged", 400));

	$user_id = json_decode($_COOKIE['token'])->user_id;
	$query = $database->prepare("SELECT user_id, user_mail, user_name, notification FROM user WHERE user_id = :user_id");
	$query->execute(['user_id' => $user_id]);
	$query->setFetchMode(PDO::FETCH_ASSOC);
	$res = $query->fetch();
	$query->closeCursor();
	if (empty($res))
		return (sendResponse("Cant fetch values !", 400));
	return (sendResponse($res, 200));
}

?>