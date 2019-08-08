<?php
/* ************************************************************************** */
/*                                                                            */
/*                                                        :::      ::::::::   */
/*   user_recuperation.php                              :+:      :+:    :+:   */
/*                                                    +:+ +:+         +:+     */
/*   By: mayday <mayday@student.42.fr>              +#+  +:+       +#+        */
/*                                                +#+#+#+#+#+   +#+           */
/*   Created: 2019/08/03 15:18:31 by mayday            #+#    #+#             */
/*   Updated: 2019/08/03 15:18:32 by mayday           ###   ########.fr       */
/*                                                                            */
/* ************************************************************************** */

require_once("../config/database.php");
require_once("user_check.php");

function sendRecuperationLink($mail, $user_id, $confirm)
{
	mail($mail,
		'Get a new password',
		"Hi, welcome to Camagru !\n
		\nIf you want to get a new password, please click the following link:\n
		\nhttp://10.11.200.226/camagru/view/?view=pass&user_id=" . $user_id . "&confirm=" . $confirm . "\n
		\nHope we'll see you soon !\n
		\nCamagru Team",
		'From: team@camagru.com' . "\r\n" . 'Reply-To: team@camagru.com' . "\r\n");
}

function prepareRecuperationLink($mail)
{
	global $database;

	$query = $database->prepare("SELECT user_id FROM user WHERE user_mail = :user_mail");
	$query->execute(['user_mail' => $mail]);
	$query->setFetchMode(PDO::FETCH_ASSOC);
	$user_id = $query->fetch()['user_id'];
	$query->closeCursor();

	$confirm = bin2hex(random_bytes(32));
	$query = $database->prepare("UPDATE user SET user_confirm = :confirm WHERE user_mail = :user_mail");
	$query->execute(['confirm' => $confirm, 'user_mail' => $mail]);
	$query->closeCursor();
	sendRecuperationLink($mail, $user_id, $confirm);
}

function sendRecuperationMail($mail)
{
	$error = checkRecuperationMail($mail);
	if (!empty($error))
		return (sendResponse($error, 400));
	prepareRecuperationLink($mail);
	return (sendResponse("Link sent by mail ! Follow the instructions to recover your account !", 200));
}

function checkRecoveryPassword($user_id, $confirm, $password, $password_confirm)
{
	$error = [];

	if (checkPasswordIsValid($password, $password_confirm) == 1)
		$error[] = ['send_password', 'Please enter a password with at least 8 characters'];
	else if (checkPasswordIsValid($password, $password_confirm) == 2)
		$error[] = ['send_password', 'Please enter the same password'];
	else if (checkConfirmAssociatedUserId($user_id, $confirm) == 1)
		$error[] = ['send_password', 'The user id or the confirm key is not good. Please click the link in your mail'];
	return ($error);
}

function checkConfirmAssociatedUserId($user_id, $confirm)
{
	global $database;

	$query = $database->prepare("SELECT user_id FROM user WHERE user_id = :user_id AND user_confirm = :confirm");
	$query->execute(['user_id' => $user_id, 'confirm' => $confirm]);
	$query->setFetchMode(PDO::FETCH_ASSOC);
	$res = $query->fetch()['user_id'];
	if (empty($res))
		return (1);
	$query->closeCursor();

	return (0);
}

function sendNewPassword($user_id, $confirm, $password, $password_confirm)
{
	global $database;

	$error = checkRecoveryPassword($user_id, $confirm, $password, $password_confirm);
	if (!empty($error))
		return (sendResponse($error, 400));

	$query = $database->prepare("UPDATE user SET user_confirm = '', user_password = :password WHERE user_id = :user_id");
	$query->execute(['user_id' => $user_id, 'password' => md5($password)]);
	$query->closeCursor();
	return (sendResponse("Password changed ! Please log in now !", 200));
}

?>