<?php
/* ************************************************************************** */
/*                                                                            */
/*                                                        :::      ::::::::   */
/*   user.php                                           :+:      :+:    :+:   */
/*                                                    +:+ +:+         +:+     */
/*   By: mayday <mayday@student.42.fr>              +#+  +:+       +#+        */
/*                                                +#+#+#+#+#+   +#+           */
/*   Created: 2019/08/01 22:58:06 by mayday            #+#    #+#             */
/*   Updated: 2019/08/01 22:58:06 by mayday           ###   ########.fr       */
/*                                                                            */
/* ************************************************************************** */

require_once("../config/database.php");
require_once("user_check.php");

if(session_status() == PHP_SESSION_NONE)
	session_start();

function sendAccountConfirmationLink($mail, $user_id, $confirm)
{
	mail($mail,
		'confirm account creation',
		"hi, welcome to camagru !\n\n
		please confirm your account by clicking this link:\n\n 
		http://localhost/camagru/view/?view=confirm&user_id=" . $user_id . "&confirm=" . $confirm . "\n\n
		hope we'll see you soon !\n\n
		camagru team",
		'From: team@camagru.com' . "\r\n" . 'Reply-To: team@camagru.com' . "\r\n");
}

function addUserInDB($mail, $user_name, $password)
{
	global $database;

	$data = [
		'mail' => $mail,
		'user_name' => $user_name,
		'password' => md5($password),
		'confirm' => bin2hex(random_bytes(32))
	];
	$query = $database->prepare("INSERT INTO user (user_mail, user_name, user_password, user_confirm, notification) VALUES (:mail, :user_name, :password, :confirm, 1)");
	$query->execute($data);
	$query->closeCursor();
	$user_id = $database->lastInsertId();

	sendAccountConfirmationLink($mail, $user_id, $data['confirm']);
}

function createUser($mail, $user_name, $password, $password_confirm)
{
	$error = checkCreateForm($mail, $user_name, $password, $password_confirm);
	if (!empty($error))
		return (sendResponse($error, 400));
	addUserInDB($mail, $user_name, $password);
	return (sendResponse("User well added ! Please confirm the link in your mail !", 200));
}

function fillToken($mail)
{
	global $database;

	$query = $database->prepare("SELECT user_id, user_name FROM user WHERE user_mail = :mail");
	$query->execute(['mail' => $mail]);
	$query->setFetchMode(PDO::FETCH_ASSOC);
	$data = $query->fetch();
	$query->closeCursor();

	$token = [
		'user_id' => $data['user_id'],
		'user_name' => $data['user_name'],
		'user_mail' => $mail
	];
	return (json_encode($token));
}

function loginUser($mail, $password)
{
	if (checkToken() == 0)
		return (sendResponse("User already logged", 400));
	$error = checkUserInformation($mail, $password);
	if (!empty($error))
		return (sendResponse($error, 400));
	setcookie('token', fillToken($mail), time() + 1200, '/');
	return (sendResponse("User well logged in", 200));
}

function delogUser()
{
	if (checkToken() != 0)
		return (sendResponse("User not logged", 400));
	setcookie('token', "", time() - 10, '/');
	return (sendResponse("User well disconnected", 200));
}

function confirmUser($user_id, $confirm)
{
	global $database;

	if (checkConfirmAssociatedUserId($user_id, $confirm) != 0)
		return (sendResponse("Wrong informations. Please click the link in your mail !", 400));
	$query = $database->prepare("UPDATE user SET user_confirm = '' WHERE user_id = :user_id");
	$query->execute(['user_id' => $user_id]);
	$query->closeCursor();
	return (sendResponse("User confirmed ! Please login now !", 200));
}

function getUserName($user_id)
{
	global $database;

	$query = $database->prepare("SELECT user_name FROM user WHERE user_id = :user_id");
	$query->execute(['user_id' => $user_id]);
	$query->setFetchMode(PDO::FETCH_ASSOC);
	$res = $query->fetch();
	if (empty($res))
		return (1);
	return ($res['user_name']);
}

?>